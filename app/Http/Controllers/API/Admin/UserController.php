<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditUserRequest;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use GeneralTrait;
  
    // Show all users
    public function index()
    {
        //$users = User::orderBy('id','DESC')->paginate(5);
        $users = User::get();
        if(!$users){
            return $this->buildResponse([],'Warning' , 'No users found' ,404);
        }
        return $this->buildResponse([$users],'Success' , 'Users found' ,200);
    }

   
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

  
    public function show($id)
    {
        //
    }

    public function update(EditUserRequest $request, User $user)
{
    // 
    $user->update([
        'status' => $request->status,
        'role' =>$request->role
    ]);
    $user->syncRoles([$request->role]);
    
    return $this->buildResponse($user, 'Success', 'Done updated successfully', 200);
}




    public function edit(Request $request, $id)
    {
        //
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return $this->buildResponse([], 'Success', 'User deleted successfully', 200);
        } else {
            return $this->buildResponse([], 'Error', 'Failed to delete user', 500);
        }
    }
    
    
}
