<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = AuditLog::orderBy('id', 'desc')->paginate(10);
        return Inertia::render('AuditLog/Index', [
            'logs' => $logs
        ]);
    }

}
