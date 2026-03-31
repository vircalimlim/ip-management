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
        $records = IpRecord::orderBy('id', 'desc')->get();
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

        $request->user()->ip_records()->create($data);

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

        return redirect()->route('ip-record.index')->with('success', 'IP record updated successfully.');
    }

    public function destroy($id)
    {
        $record = IpRecord::findOrFail($id);
        $this->authorize('delete', $record); 

        $record->delete();

        return redirect()->route('ip-record.index')->with('success', 'IP record deleted successfully.');
    }
}
