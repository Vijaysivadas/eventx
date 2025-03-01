<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    //
    public function index()
    {
        $events = Events::where('admin_id', auth()->id())
            ->orderBy('start', 'desc')->get();

        return view('events', compact('events'));
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'venue' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:10',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Create a new event instance
            $event = new Events();
            $event->name = $request->name;
            $event->description = $request->description;
            $event->start = $request->start;
            $event->end = $request->end;
            $event->venue = $request->venue;
            $event->contact_email = $request->contact_email;
            $event->contact_phone = $request->contact_phone;
            $event->admin_id = auth()->id();
            $event->status = "upcoming";


            // Save the event to the database
            $event->save();

            // Redirect with success message
            return redirect()->route('admin.events')
                ->with('success', 'Event created successfully!');

        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->back()
                ->with('error', 'Error creating event: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function delete(Request $request){
        try {
            // Find the event by ID
            $event = Events::findOrFail($request->id);

            // Delete the event
            $event->delete();

            // Redirect with success message
            return redirect()->route('admin.events')
                ->with('success', 'Event deleted successfully!');

        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->back()
                ->with('error', 'Error deleting event: ' . $e->getMessage());
        }
    }
}
