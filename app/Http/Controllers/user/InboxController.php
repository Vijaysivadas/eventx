<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Jobs;
use Illuminate\Http\Request;
use PHPUnit\Util\PHP\Job;

class InboxController extends Controller
{
    //
    public function index()
    {
        // Get all jobs with their related event data
        $jobs = Jobs::with('event')->get();

        return view('user.inbox', ['jobs' => $jobs]);
    }

    public function apply(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required|exists:events,id',
                'job_id' => 'required',
                'type' => 'required|string',
            ]);

            $user = auth()->user();

            // Check if user already applied for this job/event combination
            $existingApplication = Application::where('user_id', $user->id)
                ->where('event_id', $request->event_id)
                ->where(function ($query) use ($request) {
                    $query->where('job_id', $request->job_id)
                        ->orWhereNull('job_id');
                })
                ->where('type', $request->type)
                ->first();

            if ($existingApplication) {
                return redirect()->back()->with('error', 'You have already applied for this position.');
            }

            $application = Application::create([
                'user_id' => $user->id,
                'event_id' => $request->event_id,
                'job_id' => $request->job_id,
                'type' => $request->type,
                'status' => 'pending'
            ]);

            // Store experience in a separate user_details table or as metadata
            // You could use a JSON column or a separate table for this

            $application->save();

            return redirect()->back()->with('success', 'Your volunteer application has been submitted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error submitting application: ' . $e->getMessage()]);
        }
    }
}
