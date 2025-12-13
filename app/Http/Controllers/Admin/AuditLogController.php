<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class AuditLogController extends Controller
{
    public function index()
    {
        $query = Activity::with('causer')->latest();

        if (request('search')) {
            $query->whereHas('causer', fn($q) => $q->where('name', 'like', '%'.request('search').'%'))
                  ->orWhere('description', 'like', '%'.request('search').'%');
        }
        if (request('dari')) {
            $query->whereDate('created_at', '>=', request('dari'));
        }
        if (request('sampai')) {
            $query->whereDate('created_at', '<=', request('sampai'));
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('admin.audit-log.index', compact('logs'));
    }
}