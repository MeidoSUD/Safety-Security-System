<?php

namespace App\Http\Controllers;

use App\Models\SystemNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = session('user');
        $notifications = SystemNotification::latest()->paginate(15);

        return view('dashboard.notifications', compact('notifications', 'user'));
    }

    public function markAsRead($id)
    {
        $notification = SystemNotification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return back()->with('success', 'تم تعيين الإشعار كمقروء.');
    }

    public function markAllAsRead()
    {
        SystemNotification::query()->update(['is_read' => true]);

        return back()->with('success', 'تم تعيين جميع الإشعارات والتذكيرات كمقروءة.');
    }
}
