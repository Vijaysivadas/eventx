<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Messages;
use Illuminate\Http\Request;

class UserAnnouncementsController extends Controller
{
    //
    public function index(){
        $userEventIds = Application::where('user_id', auth()->id())
            ->pluck('event_id')
            ->toArray();

// Get messages for those events
        $announcements = Messages::whereIn('event_id', $userEventIds)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.messages', ['announcements' => $announcements]);
    }
}
