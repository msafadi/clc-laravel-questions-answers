<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $notify_id = $request->query('notify_id');
        if ($notify_id && Auth::check()) {
            $user = Auth::user();
            $notifcation = $user->notifications()->find($notify_id);
            if ($notifcation && $notifcation->unread()) {
                $notifcation->markAsRead();
            }
        }

        return $next($request);
    }
}
