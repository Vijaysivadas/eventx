<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Events;
use Illuminate\Http\Request;

class UserEventController extends Controller
{
    //
    public function index()
    {
        $events = Events::all();
        $appliedEventIds = Application::where('user_id', auth()->id())
            ->pluck('event_id')
            ->toArray();

        return view('user.events', compact('events', 'appliedEventIds'));
    }
    public function apply(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'event_id' => 'required|exists:events,id',
                'type' => 'required|string'
            ]);

            // Get authenticated user
            $user = auth()->user();

            // Check if user already applied for this event
            $existingApplication = Application::where('user_id', $user->id)
                ->where('event_id', $request->event_id)
                ->where('type', $request->type)
                ->first();

            if ($existingApplication) {
                return redirect()->back()->with('error', 'You have already applied for this event.');
            }

            // Create new application
            Application::create([
                'user_id' => $user->id,
                'event_id' => $request->event_id,
                'job_id' => $request->job_id ?? null, // Default to 0 if not provided
                'type' => $request->type,
                'status' => 'approved' // Default status (0 = pending)
            ]);

            return redirect()->back()->with('success', 'Your application has been submitted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error submitting application: ' . $e->getMessage()]);
        }
    }
}
