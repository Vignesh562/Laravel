<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Return empty notifications collection
        // In the future, you can implement a proper notification system
        $notifications = collect([]);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        return back()->with('success', 'Notification marked as read');
    }
}
