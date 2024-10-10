<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use GeneralTrait;
   
    // Show all roles and permissions
    public function index()
{
    $roles = Role::with('permissions')->get();
    $roles->makeHidden(['guard_name', 'created_at', 'updated_at']);
    
    if ($roles->isEmpty()) {
        return $this->buildResponse([], 'Error', 'not found roles', 200);
    }
  
    $roles->each(function($role){
        $role->permissions->each(function($permission){
            $permission->makeHidden(['guard_name', 'created_at', 'updated_at', 'pivot']);
        });
    });
    
    return $this->buildResponse($roles, 'Success', 'get all roles', 200);
}


    // return view form  for enter data using in MVC
    public function create(Role $role)
    {
       
    }

    // create a new role and add permissions to it
    public function store(RoleStoreRequest $request)
    {
        $data = $request->validated();
        $role = Role::create([
            'name' => $request->role,
            'guard_name'=> 'web'
        ])->givePermissionTo($request->permission);
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // load for show permission with role
        $role->load('permissions');

        return $this->buildResponse($role,'Success','roles created successfully',200);

    }

   
  
    // Show one role and add permissions to it
    public function show(Role $role)
    {
       
        $role->makeHidden(['guard_name', 'created_at', 'updated_at']); 
    
        $permissions = $role->permissions->each(function ($permission) {
            $permission->makeHidden(['guard_name', 'created_at', 'updated_at', 'pivot']);
        });
    
        return $this->buildResponse($role->setRelation('permissions', $permissions), 'Success', 'Show roles successfully', 200);
    }

    // for edit form, it used at MVC like create method
    public function edit(Request $request, $id)
    {
        //
    }
    
    // update role and permissions
    public function update(RoleUpdateRequest $request,Role $role)
    {
        $role->update([
            'permission' => $request->permission
        ]);
        // syncPermissions don't forget it
        $role->syncPermissions($request->permission);

        $role->makeHidden(['guard_name', 'created_at', 'updated_at']); 
    
        $permissions = $role->permissions->each(function ($permission) {
            $permission->makeHidden(['guard_name', 'created_at', 'updated_at', 'pivot']);
        });
        
        return $this->buildResponse($role->setRelation('permissions', $permissions), 'Success', 'permissions updated successfully', 200);
    }

    

    
    public function destroy(Role $role)
    {
      if(!$role->delete()){
        return $this->buildResponse([], 'Error', 'Not Found Role', 200);

      }
      
       return $this->buildResponse([], 'Success', 'role deleted successfully', 200);
    }
}
