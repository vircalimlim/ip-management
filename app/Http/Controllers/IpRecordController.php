<?php

namespace App\Http\Controllers;

use App\Models\IpRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IpRecordController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $records = IpRecord::orderBy('id', 'desc')->paginate(10);
        return Inertia::render('IpRecord/Index', [
            'records' => $records,
            'user' => auth()->user()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ip_address'    => 'required|ip|unique:ip_records',
            'label'         => 'required|string|max:255',
            'comment'       => 'nullable|string|max:500',
        ]);

        $ip_address = $request->user()->ip_records()->create($data);

        $request->user()->audit_logs()->create([
            'event_type'    => 'create_ip',
            'ip_address_id' => $ip_address->id,
            'description'   => 'IP= ' . $request->ip_address
        ]);

        return redirect()->route('ip-record.index')->with('success', 'IP record added successfully.');
    }

    public function update(Request $request, $id)
    {
        $record = IpRecord::findOrFail($id);

        $data = $request->validate([
            // 'ip_address'    => 'required|ip|unique:ip_records,ip_address,' . $record->id,
            'label'         => 'required|string|max:255',
            // 'comment'       => 'nullable|string|max:500',
        ]);

        $record->update($data);
        $request->user()->audit_logs()->create([
            'event_type'    => 'update_label',
            'ip_address_id' => $record->id
        ]);

        return redirect()->route('ip-record.index')->with('success', 'IP record updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $record = IpRecord::findOrFail($id);
        $this->authorize('delete', $record); 

        $record->delete();
        $request->user()->audit_logs()->create([
            'event_type'    => 'delete_ip',
            'ip_address_id' => $record->id
        ]);

        return redirect()->route('ip-record.index')->with('success', 'IP record deleted successfully.');
    }
}
