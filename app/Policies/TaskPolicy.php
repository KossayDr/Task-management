<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manageUser(User $user){
        return $user->hasPermissionTo('manage users');
    }
    public function view(User $user, Task $task)
    {
        return $user->id === $task->user_id || $user->hasRole('editor') || $user->hasRole('admin');
    }

    // this is function validation if the user is not authenticated for create task
    // not focas on owner task
    // Allow users with Create Task permission to create a new task.
    public function create(User $user)
    {
        return $user->hasPermissionTo('create tasks');
    }

    // Allow users to update only their own tasks, while editors can edit all users' tasks.
    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id || $user->hasRole('editor');
    }

    // Allow users to delete their own tasks, while administrators can delete all tasks.
    public function delete(User $user, Task $task)
    {
        return $user->id === $task->user_id || $user->hasRole('admin');
    }

    // Give editors and admin full access to view all tasks.
    public function viewAllTasks(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('editor');
    }
}
