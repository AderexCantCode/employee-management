<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Activity;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        return view('absence.index');
    }

    public function create()
    {
        return view('absence.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_category' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required|string',
            'has_laptop' => 'boolean',
            'can_contact' => 'boolean',
        ]);

        $absence = Absence::create([
            'user_id' => auth()->id(),
            'leave_category' => $request->leave_category,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'has_laptop' => $request->has('has_laptop'),
            'can_contact' => $request->has('can_contact'),
        ]);

        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'submitted_absence',
            'description' => 'Submitted absence request for ' . $request->leave_category,
            'model_type' => 'Absence',
            'model_id' => $absence->id,
        ]);

        return redirect()->route('administration.absence.index')->with('success', 'Absence request submitted successfully!');
    }

    public function approvalList()
    {
        $absences = \App\Models\Absence::with('user')->orderBy('created_at', 'desc')->get();
        return view('absence.approval', compact('absences'));
    }

    public function approve($id)
    {
        $absence = \App\Models\Absence::findOrFail($id);
        $absence->status = 'approved';
        $absence->save();
        // Update user status to absent
        $user = $absence->user;
        if ($user) {
            $user->status = 'absent';
            $user->save();
        }
        // Log activity
        \App\Models\Activity::create([
            'user_id' => auth()->id(),
            'action' => 'approved_absence',
            'description' => 'Approved absence for ' . $absence->user->name,
            'model_type' => 'Absence',
            'model_id' => $absence->id,
        ]);
        return back()->with('success', 'Absence approved!');
    }

    public function reject($id)
    {
        $absence = \App\Models\Absence::findOrFail($id);
        $absence->status = 'rejected';
        $absence->save();
        // Log activity
        \App\Models\Activity::create([
            'user_id' => auth()->id(),
            'action' => 'rejected_absence',
            'description' => 'Rejected absence for ' . $absence->user->name,
            'model_type' => 'Absence',
            'model_id' => $absence->id,
        ]);
        return back()->with('success', 'Absence rejected!');
    }

    public function show($id)
    {
        $absence = \App\Models\Absence::with('user')->findOrFail($id);
        return view('absence.show', compact('absence'));
    }
}
