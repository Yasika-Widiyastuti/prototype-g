<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $notificationService;
    protected $activityLogService;

    public function __construct(NotificationService $notificationService, ActivityLogService $activityLogService)
    {
        $this->notificationService = $notificationService;
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status == 'active');
        }

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
        if ($user->role !== 'customer') {
            abort(404);
        }

        $user->load(['orders.orderItems.product', 'payments']);

        $stats = [
            'total_orders' => $user->orders->count(),
            'completed_orders' => $user->orders->where('status', 'completed')->count(),
            'total_spent' => $user->orders->where('status', 'completed')->sum('total_amount'),
            'pending_orders' => $user->orders->where('status', 'pending')->count(),
        ];

        $recent_orders = $user->orders()->with(['orderItems.product'])->latest()->limit(5)->get();

        return view('admin.users.show', compact('user', 'stats', 'recent_orders'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->role !== 'customer') {
            return redirect()->route('admin.users.index')->with('error', 'User tidak valid');
        }

        $user->update(['is_active' => !$user->is_active]);

        $this->activityLogService->logUserStatusChange($user, $user->is_active);
        $this->notificationService->notifyAccountStatusChange($user, $user->is_active);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.users.index')->with('success', "User {$user->name} berhasil {$status}");
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

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}