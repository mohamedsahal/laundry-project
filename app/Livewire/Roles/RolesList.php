<?php

namespace App\Livewire\Roles;

use App\Models\Permission;
use Livewire\Component;
use App\Models\Translation;
use App\Models\UserRole;
use App\Models\UserRolePermission;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;



class RolesList extends Component
{
    public $requiredItems = [
        'Order' => ['order_list'],
        'Customer' => ['customer_list'],
        'Service' => ['service_list'],
        'Addon' => ['addon_list'],
        'Expense' => ['expense_list'],
        'Payment' => ['payment_list'],
        'Setting' => ['setting_view'],
        'Supplier' => ['supplier_list'],
        'Inventory' => ['inventory_list'],
        'Purchase' => ['purchase_list'],
        'Purchase Return' => ['purchase_return_list'],
        'User' => ['user_list'],
        'Role' => ['role_list'],
        'Report' => null,
        'Translation' => ['translation_list'],
        'Service Type' => ['service_type_list'],
        'Expense Category' => ['expense_category_list'],
    ];

    public $roles, $role, $editRole, $search_query, $lang ,$permissions,$selected_permissions = [],$name;
    #[Title('Roles')]
    public function render()
    {
        $roles = UserRole::latest();
        if($this->search_query != ''){
            $roles->where('name', 'like', '%'.$this->search_query.'%');
        }
        $this->roles = $roles->get();
        return view('livewire.roles.roles-list');
    }

    /* process before render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('role_list')){
            abort(404);
        }
        if (session()->has('selected_language')) {  /*if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
        //get permissions and order by category
        $permissions = Permission::get();
        $finalPermissions = [];
        foreach($permissions as $permission){
            if(!isset($finalPermissions[$permission->category]))
            {
                $finalPermissions[$permission['category']] = [];
            }
            array_push($finalPermissions[$permission['category']],$permission->toArray());
            $this->selected_permissions[$permission->name] = true;
        }
        $this->permissions = $finalPermissions;
    }

    /* create user role */
    public function create()
    {
        $this->validate([
            'name' => 'required',
        ]);
        
        $userRole = new UserRole();
        $userRole->name = $this->name;
        $userRole->save();

        foreach($this->selected_permissions as $permission => $value){
            if($value === true){
                $rolePermission  = new UserRolePermission();
                $rolePermission->role_id = $userRole->id;
                $rolePermission->permission_id = Permission::where('name', $permission)->first()->id;
                $rolePermission->permission_name = $permission;
                $rolePermission->name = $this->name;
                $rolePermission->save();
            }
        }
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Role created successfully!'
        ]);
        $this->dispatch('closemodal');
    }

    /* set the content for edit */
    public function edit($id)
    {
        $this->editRole = UserRole::where('id',$id)->first();
        $permissions = UserRolePermission::where('role_id',$id)->get();
        $this->selected_permissions = [];
        foreach($permissions as $permission){
            $this->selected_permissions[$permission->permission_name] = true;
        }
        $this->name = $this->editRole->name;
        $this->resetErrorBag();
    }
    /* update user role */
    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);
        $this->editRole->name = $this->name;
        $this->editRole->save();

        UserRolePermission::whereRoleId($this->editRole->id)->delete();
        foreach($this->selected_permissions as $permission => $value){
            if($value === true){
                $rolePermission  = new UserRolePermission();
                $rolePermission->role_id = $this->editRole->id;
                $rolePermission->permission_id = Permission::where('name', $permission)->first()->id;
                $rolePermission->permission_name = $permission;
                $rolePermission->name = $this->name;
                $rolePermission->save();
            }
        }
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Role updated successfully!'
        ]);
        $this->dispatch('closemodal');
    }

    
    /* process while change the content*/
    public function updated($name, $value)
    {
    }
    /* reset input fields */
    public function resetFields()
    {   
        $this->resetErrorBag();
        $this->name = '';
        $this->editRole = null;
        $permissions = Permission::get();
        foreach($permissions as $permission){
            $this->selected_permissions[$permission->name] = true;
        }
    }

    //delete role
    public function delete($id)
    {
        UserRole::where('id',$id)->delete();
        UserRolePermission::where('role_id',$id)->delete();
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Role deleted successfully!'
        ]);
    }

    //handle checkbox change
    public function handleCheckChange($categoryName,$permissionName,$targetValue){
        if($targetValue == false){

            $currentCategoryPermissions = $this->permissions[$categoryName];
            foreach($currentCategoryPermissions as $categoryPermission){
                if(isset($this->selected_permissions[$categoryPermission['name']])){
                    $this->selected_permissions[$categoryPermission['name']] = false;
                }
            }
        }
    }
}
