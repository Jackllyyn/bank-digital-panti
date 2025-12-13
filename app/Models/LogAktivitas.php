
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        return view('admin.audit-log.index', compact('logs'));
    }
}