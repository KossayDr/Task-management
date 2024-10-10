<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use GeneralTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show all task
    public function index()
    {
       
    $user = Auth::user(); 
    // تحقق من دور المستخدم
    if ($user->hasRole('editor') || $user->hasRole('admin')) {
        // إذا كان المستخدم لديه دور "Editor" أو "Admin"، إرجاع جميع المهام
        $tasks = Task::all();
        return $this->buildResponse($tasks, 'Success', 'Show all tasks by editor or admin successfully', 200);
    } else {
        // إذا لم يكن لدى المستخدم دور "Editor" أو "Admin"، إرجاع المهام الخاصة بالمستخدم فقط
        $tasks = Task::where('user_id', $user->id)->get();
        return $this->buildResponse($tasks, 'Success', 'Show tasks by owner successfully', 200);
    }

    }

//  create Task
    public function store(TaskRequest $request){
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        $task->makeHidden('updated_at');
        return $this->buildResponse($task,'Success','Done Create task successfully',201);

    }
// update Task
    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
        ]);

        $task->update($request->only('title', 'description'));

        return $this->buildResponse($task,'Success','Done update task successfully',201);
    }
// show one task
    public function show(Task $task)
{
    // التحقق من الأذونات
    $this->authorize('view', $task);
    
    return $this->buildResponse($task, 'Success', 'Task retrieved successfully', 200);

}
    public function destroy(Task $task)
    {
        $user = Auth::user(); 
        // تحقق من دور المستخدم
        if ($user->hasRole('editor') || $user->hasRole('admin')) {
        
        $task->delete();
        return $this->buildResponse([], 'Success', 'Delete  task by editor or admin successfully', 200);
    } else {
        // إذا لم يكن لدى المستخدم دور "Editor" أو "Admin"، إرجاع المهام الخاصة بالمستخدم فقط
        $tasks = Task::where('user_id', $user->id)->delete();
        return $this->buildResponse([], 'Success', 'Delete task by owner successfully', 200);
    }

    }


}
