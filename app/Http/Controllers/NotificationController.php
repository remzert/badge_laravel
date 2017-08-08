<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function redirect;

class NotificationController extends Controller
{
    public function show(string $id){
        $notification = Auth::user()->unreadNotifications()->find($id);
        if ($notification){
            $notification->markAsRead();
        }
        
        return redirect()->back();
    }
}
