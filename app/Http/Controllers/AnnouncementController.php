<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Messages;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    //
    public function index()
    {
        $events = Events::where('admin_id','=',auth()->user()->id)->get();
        $announcements = Messages::where('admin_id','=',auth()->user()->id)->get();
        return view('announce',['events'=>$events, 'announcements'=>$announcements]);

    }
    public function sendMessage(Request $request) {

        $request->validate([
            'message' => 'required',
            'title' => 'required',
            'event_id' => 'required'
        ]);
        $announcement = $request->message;
        $title  = $request->title;

        // $author = Auth::user()->name;

//        DB::insert('insert into messages values(?, ?, ?)',[$event, $author, $announcement]);
        $messages = new Messages();
        $messages->title = $title;
        $messages->content= $announcement;
        $messages->admin_id=auth()->user()->id;
        $messages->event_id = $request->event_id;
        $messages->save();
        // return view('sendMessage', compact('announcement','event', 'author'));
        return redirect()->back()->with('success', 'Announcement sent successfully.');
    }
    public function delete(Request $request)
    {
        try {
            // Get the announcement ID from the request
            $id = $request->id;

            // Find the announcement
            $announcement = Messages::findOrFail($id);

            // Delete the announcement
            $announcement->delete();

            // Redirect with success message
            return redirect()->route('admin.announcements')
                ->with('success', 'Announcement deleted successfully!');

        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->back()
                ->with('error', 'Error deleting announcement: ' . $e->getMessage());
        }
    }
}
