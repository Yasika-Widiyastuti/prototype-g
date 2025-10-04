<?php

// =============================================================================
// AdminAuditController.php - app/Http/Controllers/Admin/AdminAuditController.php
// =============================================================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAuditController extends Controller
{
    /**
     * Tampilkan halaman audit logs untuk admin
     */
    public function index(Request $request)
    {
        // Pastikan user adalah admin
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $query = DB::table('audit_logs')
                    ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
                    ->select(
                        'audit_logs.*',
                        'users.name as user_name',
                        'users.email as user_email'
                    );

        // Filter berdasarkan event type
        if ($request->filled('event_type') && $request->event_type !== 'all') {
            $query->where('audit_logs.event_type', $request->event_type);
        }

        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $query->where('audit_logs.user_id', $request->user_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('audit_logs.created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('audit_logs.created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('audit_logs.description', 'like', "%{$search}%")
                  ->orWhere('audit_logs.ip_address', 'like', "%{$search}%");
            });
        }

        // Pagination
        $logs = $query->orderBy('audit_logs.created_at', 'desc')
                     ->paginate(20)
                     ->withQueryString();

        // Get event types untuk filter
        $eventTypes = DB::table('audit_logs')
                       ->select('event_type')
                       ->distinct()
                       ->pluck('event_type');

        // Get users untuk filter
        $users = DB::table('users')
                  ->select('id', 'name', 'email')
                  ->orderBy('name')
                  ->get();

        // Statistik
        $stats = [
            'total_logs' => DB::table('audit_logs')->count(),
            'today_logs' => DB::table('audit_logs')->whereDate('created_at', today())->count(),
            'password_resets_today' => DB::table('audit_logs')
                                        ->where('event_type', 'password_reset')
                                        ->whereDate('created_at', today())
                                        ->count(),
            'unique_users_today' => DB::table('audit_logs')
                                     ->whereDate('created_at', today())
                                     ->distinct('user_id')
                                     ->count('user_id'),
        ];

        return view('admin.audit-logs.index', compact('logs', 'eventTypes', 'users', 'stats'));
    }

    /**
     * Export audit logs ke CSV
     */
    public function export(Request $request)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $query = DB::table('audit_logs')
                    ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
                    ->select(
                        'audit_logs.*',
                        'users.name as user_name',
                        'users.email as user_email'
                    );

        // Apply same filters as index
        if ($request->filled('event_type') && $request->event_type !== 'all') {
            $query->where('audit_logs.event_type', $request->event_type);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('audit_logs.created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('audit_logs.created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('audit_logs.created_at', 'desc')->get();

        $filename = 'audit_logs_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, ['ID', 'User', 'Email', 'Event Type', 'Description', 'IP Address', 'User Agent', 'Date Time']);
            
            // Data rows
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user_name ?? 'N/A',
                    $log->user_email ?? 'N/A',
                    $log->event_type,
                    $log->description,
                    $log->ip_address ?? 'N/A',
                    $log->user_agent ?? 'N/A',
                    $log->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Hapus audit logs lama (untuk maintenance)
     */
    public function cleanup(Request $request)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $days = $request->input('days', 90); // Default 90 hari
        
        $deleted = DB::table('audit_logs')
                    ->where('created_at', '<', now()->subDays($days))
                    ->delete();

        return back()->with('success', "Berhasil menghapus {$deleted} audit logs yang lebih lama dari {$days} hari.");
    }
}