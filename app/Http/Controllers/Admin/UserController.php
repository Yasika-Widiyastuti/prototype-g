<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        // Filter status aktif/nonaktif
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status == 'active');
        }

        // Filter status verifikasi
        if ($request->has('verification') && $request->verification != '') {
            $query->where('verification_status', $request->verification);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->withCount('orders')->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Pastikan hanya customer yang bisa diakses
        if ($user->role !== 'customer') {
            abort(404, 'User tidak ditemukan');
        }

        // Load relasi yang diperlukan dengan eager loading
        try {
            $user->load([
                'orders' => function($query) {
                    $query->latest()->limit(5);
                },
                'verifier' 
            ]);
        } catch (\Exception $e) {
            Log::warning('Error loading user relations: ' . $e->getMessage());
        }

        // Statistik user
        $stats = [
            'total_orders' => $user->orders()->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'cancelled_orders' => $user->orders()->where('status', 'cancelled')->count(),
            'total_spent' => $user->orders()->where('status', 'completed')->sum('total_amount'),
        ];

        // Recent orders (sudah di-load di atas, ambil dari relasi)
        $recent_orders = $user->orders;

        // Info dokumen
        $documents = [
            'ktp' => [
                'exists' => !empty($user->ktp_path) && Storage::exists($user->ktp_path),
                'path' => $user->ktp_path,
                'url' => $user->ktp_url,
                'is_pdf' => $user->ktp_path ? str_ends_with($user->ktp_path, '.pdf') : false,
            ],
            'kk' => [
                'exists' => !empty($user->kk_path) && Storage::exists($user->kk_path),
                'path' => $user->kk_path,
                'url' => $user->kk_url,
                'is_pdf' => $user->kk_path ? str_ends_with($user->kk_path, '.pdf') : false,
            ],
        ];

        // Status verifikasi lengkap
        $verification = [
            'status' => $user->verification_status,
            'is_pending' => $user->isPending(),
            'is_approved' => $user->isVerified(),
            'is_rejected' => $user->isRejected(),
            'verified_at' => $user->verified_at,
            'verified_by' => $user->verifier ? $user->verifier->name : null,
            'notes' => $user->verification_notes,
            'can_be_verified' => $user->hasUploadedDocuments() && $user->isPending(),
        ];

        return view('admin.users.show', compact('user', 'stats', 'recent_orders', 'documents', 'verification'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->role !== 'customer') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak valid');
        }

        $user->update(['is_active' => !$user->is_active]);

        $this->logActivity(
            'user_status_change',
            $user->is_active ? 'Mengaktifkan user ' . $user->name : 'Menonaktifkan user ' . $user->name,
            'User',
            $user->id
        );

        // Kirim notifikasi status akun
        //$this->notificationService->sendAccountStatusChange($user, $user->is_active);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()->with('success', "User {$user->name} berhasil {$status}");
    }

    public function verify(Request $request, User $user)
    {
        // Validasi role
        if ($user->role !== 'customer') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak valid');
        }

        // Validasi input
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'required_if:action,reject|nullable|string|max:500',
        ], [
            'notes.required_if' => 'Alasan penolakan wajib diisi jika menolak verifikasi',
        ]);

        // Cek apakah dokumen sudah diupload
        if (!$user->ktp_path || !$user->kk_path) {
            return redirect()->back()->with('error', 'User belum mengupload dokumen lengkap (KTP dan KK)');
        }

        DB::beginTransaction();
        
        try {
            $action = $request->action;
            $status = $action === 'approve' ? 'approved' : 'rejected';

            // Update status verifikasi
            $user->update([
                'verification_status' => $status,
                'verified_at' => $status === 'approved' ? now() : null,
                'verified_by' => Auth::id(),
                'verification_notes' => $request->notes,
            ]);

            // Log activity
            $this->logActivity(
                'user_verification_' . $status,
                $status === 'approved' 
                    ? 'Menyetujui verifikasi user ' . $user->name 
                    : 'Menolak verifikasi user ' . $user->name . ' dengan alasan: ' . $request->notes,
                'User',
                $user->id
            );

            // ✅ PERBAIKAN: Kirim notifikasi langsung tanpa service
            try {
                $title = $status === 'approved' ? 'Verifikasi Disetujui' : 'Verifikasi Ditolak';
                
                $message = $status === 'approved'
                    ? 'Selamat! Akun Anda telah diverifikasi dan disetujui. Anda sekarang dapat melakukan pemesanan.'
                    : 'Mohon maaf, verifikasi akun Anda ditolak. Alasan: ' . $request->notes;
                
                $user->notify(new \App\Notifications\GeneralNotification($title, $message));
            } catch (\Exception $e) {
                Log::warning('Failed to send verification notification: ' . $e->getMessage());
            }

            DB::commit();

            $message = $status === 'approved' 
                ? "User {$user->name} berhasil diverifikasi" 
                : "Verifikasi user {$user->name} ditolak";

            return redirect()->route('admin.users.show', $user->id)->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Verification failed: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Gagal memverifikasi user: ' . $e->getMessage());
        }
    }

    public function viewDocument(User $user, $type)
    {
        // Validasi user
        if ($user->role !== 'customer') {
            abort(404, 'User tidak ditemukan');
        }

        // Validasi tipe dokumen
        if (!in_array($type, ['ktp', 'kk'])) {
            abort(404, 'Tipe dokumen tidak valid');
        }

        // Ambil path dokumen
        $path = $type === 'ktp' ? $user->ktp_path : $user->kk_path;

        if (!$path) {
            abort(404, 'Dokumen belum diupload');
        }

        // ✅ PERBAIKAN: Cek file existence dengan benar
        if (!Storage::disk('public')->exists($path)) {
            Log::error("Document not found: {$path}");
            abort(404, 'File dokumen tidak ditemukan di storage');
        }

        try {
            // Ambil full path
            $fullPath = Storage::disk('public')->path($path);
            
            // Cek apakah file benar-benar ada di filesystem
            if (!file_exists($fullPath)) {
                Log::error("File does not exist in filesystem: {$fullPath}");
                abort(404, 'File tidak ditemukan');
            }

            // Ambil mime type
            $mimeType = Storage::disk('public')->mimeType($path);
            $fileName = basename($path);

            // Log untuk debugging
            Log::info("Viewing document", [
                'user_id' => $user->id,
                'type' => $type,
                'path' => $path,
                'mime_type' => $mimeType
            ]);

            // Return file response
            return response()->file($fullPath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $fileName . '"',
                'Cache-Control' => 'no-cache, must-revalidate'
            ]);

        } catch (\Exception $e) {
            Log::error("Error viewing document: " . $e->getMessage(), [
                'user_id' => $user->id,
                'type' => $type,
                'path' => $path
            ]);
            
            abort(500, 'Gagal menampilkan dokumen: ' . $e->getMessage());
        }
    }

    public function resetPassword(Request $request, User $user)
    {
        if ($user->role !== 'customer') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak valid');
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user->password = bcrypt($request->password);
        $user->save();

        $this->logActivity(
            'user_password_reset',
            'Mereset password user ' . $user->name,
            'User',
            $user->id
        );

        // Kirim notifikasi password reset
        try {
            $this->notificationService->sendPasswordResetByAdmin($user);
        } catch (\Exception $e) {
            Log::warning('Failed to send password reset notification: ' . $e->getMessage());
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Password {$user->name} berhasil direset");
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'customer') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak valid');
        }

        if ($user->hasActiveOrders()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus user yang memiliki order aktif');
        }

        // Delete documents
        if ($user->ktp_path && Storage::exists($user->ktp_path)) {
            Storage::delete($user->ktp_path);
        }
        if ($user->kk_path && Storage::exists($user->kk_path)) {
            Storage::delete($user->kk_path);
        }

        $userName = $user->name;

        $this->logActivity(
            'user_deletion',
            'Menghapus user ' . $userName,
            'User',
            $user->id
        );

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }

    private function logActivity($action, $description, $relatedModel = null, $relatedId = null)
    {
        try {
            \DB::table('activity_logs')->insert([
                'admin_id' => auth()->id(),
                'action' => $action,
                'description' => $description,
                'related_model' => $relatedModel,
                'related_id' => $relatedId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}