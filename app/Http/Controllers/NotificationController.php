<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($notification) {
                return [
                    'id'        => $notification->id,
                    'data'      => $notification->data,
                    'read_at'   => $notification->read_at,
                    'time_ago'  => $notification->created_at->diffForHumans(),
                ];
            });

        $unreadCount = Auth::user()->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    public function markAsRead(string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }
}
