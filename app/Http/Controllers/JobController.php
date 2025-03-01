<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Events;
use App\Models\Jobs;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    //
    public function index()
    {
        // Get all jobs posted by the current admin
        $jobs = Jobs::where('admin_id', auth()->id())->get();


        $events = Events::where('admin_id', auth()->id())
            ->where('status', 'upcoming')->get();
        $eventIds = Events::where('admin_id', auth()->id())
            ->where('status', 'upcoming')
            ->pluck('id');
// Get pending applications with relationships
        $pendingApplications = Application::whereIn('event_id', $eventIds)
            ->where(['status'=>'pending','type'=>'volunteer'])
            ->with([
                'user',    // Load user details
                'job',     // Load job details (assuming singular relationship name)
                'event'    // Load event details (assuming singular relationship name)
            ])
            ->get();
        $jobIds = Jobs::where('admin_id', auth()->id())->pluck('id')->toArray();

// Get applications
        $applicants = Application::whereIn('job_id', $jobIds)
            ->where(['status' => 'pending'])
            ->get();

// Create array to store counts for each job
        $applicantCount = [];

// Initialize count arrays for each job ID
        foreach ($jobIds as $jobId) {
            $applicantCount[$jobId] = [
                'total' => 0,
                'participants' => 0,
                'volunteers' => 0
            ];
        }

// Count applications by job_id and type
        foreach ($applicants as $applicant) {
            $jobId = $applicant->job_id;

            // Increment total count
            $applicantCount[$jobId]['total']++;

            // Increment type-specific count
            if ($applicant->type == 'participant') {
                $applicantCount[$jobId]['participants']++;
            } elseif ($applicant->type == 'volunteer') {
                $applicantCount[$jobId]['volunteers']++;
            }
        }
// Transform the data into the structure you need
        $pendingRequests = $pendingApplications->map(function($application) {
            return [
                // User details
                'user_id' => $application->user->id,
                'name' => $application->user->name,
                'email' => $application->user->email,
                'phone' => $application->user->phone ?? 'N/A',

                // Application details
                'application_id' => $application->id,
                'status' => $application->status,
                'created_at' => $application->created_at,

                // Job details
                'job_id' => $application->job->id,
                'job_title' => $application->job->title,
                'job_description' => $application->job->description,

                // Event details
                'event_id' => $application->event->id,
                'event_name' => $application->event->name,
                'event_date' => $application->event->date,
                'event_location' => $application->event->location
            ];
        });

// Get jobs posted by current admin

        return view('jobs', [
            'volunteerJobs' => $jobs,
            'pendingRequests' => $pendingRequests,
            'events' => $events,
            'applicantCount' => $applicantCount,
        ]);
    }

    public function create(Request $request){

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_id' => 'required|exists:events,id',
        ]);

        // Create the job
        $job = new Jobs();
        $job->title = $validated['title'];
        $job->description = $validated['description'];
        $job->admin_id = auth()->id();
        $job->event_id = $validated['event_id'];
        $job->status = 'active'; // Active by default
        $job->save();

        // Redirect back with success message
        return redirect()->route('admin.jobs.index')
            ->with('success', 'Volunteer job created successfully!');

    }
    public function delete(Request $request){
        try {
            // Find the event by ID
            $event = Jobs::findOrFail($request->id);

            // Delete the event
            $event->delete();

            // Redirect with success message
            return redirect()->route('admin.jobs.index')
                ->with('success', 'Event deleted successfully!');

        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->back()
                ->with('error', 'Error deleting event: ' . $e->getMessage());
        }
    }
    public function approve(Request $request)
    {
        try {
            $application = Application::findOrFail($request->id);
            $application->status = 'approved';
            $application->save();

            return redirect()->back()->with('success', 'Application has been approved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error approving application: ' . $e->getMessage());
        }
    }

    public function decline(Request $request)
    {
        try {
            $application = Application::findOrFail($request->id);
            $application->status = 'declined';

            // If there's a decline reason provided, you can store it in a notes field or similar
            if ($request->has('decline_reason')) {
                $application->notes = $request->decline_reason;
            }

            $application->save();

            return redirect()->back()->with('success', 'Application has been declined successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error declining application: ' . $e->getMessage());
        }
    }
}
