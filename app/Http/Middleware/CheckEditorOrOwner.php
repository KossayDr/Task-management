<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;

class CheckEditorOrOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
 
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        // تحقق إذا كانت هناك مهمة في المسار
        $taskId = $request->route('tasks');
        if ($taskId) {
            $task = Task::findOrFail($taskId);

            // تحقق إذا كان المستخدم هو المالك أو لديه دور المحرر
            if (!$user->hasRole('editor') && $user->id !== $task->user_id) {
                return response()->json([
                    'message' => 'Unauthorized: You must be an editor or the owner of the task.'
                ], 403);
            }
            
        }


        return $next($request);
    }
}
