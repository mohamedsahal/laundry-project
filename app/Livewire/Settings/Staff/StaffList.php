<?php

namespace App\Livewire\Settings\Staff;

use Livewire\Component;
use App\Models\User;
use App\Models\Translation;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;

class StaffList extends Component
{

    public $name, $phone, $email, $password, $address, $is_active = 1, $staffs, $staff, $search = '', $lang, $is_active_edit=true,$roles,$user_role;
    #[Title('Staff')]
    public function render()
    {
        $query = User::where('user_type', 2)->latest();
        if ($this->search != '') {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        if (session()->has('selected_language')) {   /*if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
        $this->staffs = $query->get();
        return view('livewire.settings.staff.staff-list');
    }

    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('user_list')){
            abort(404);
        }
        $this->roles = UserRole::latest()->get();
        if(count($this->roles) > 0){
            $this->user_role = $this->roles->first()->id;
        }
    }
    public function resetFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->password = '';
        $this->address = '';
        $this->is_active = 1;
        $this->staff = null;
        if(count($this->roles) > 0){
            $this->user_role = $this->roles->first()->id;
        }
        $this->resetErrorBag();
    }
    public function save()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'user_role' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required'
        ]);
        User::create([
            'name'  => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password'  => Hash::make($this->password),
            'user_type' => 2,
            'role_id' => $this->user_role,
            'is_active' => $this->is_active ?? 0
        ]);
        $this->dispatch('closemodal');
        $this->resetFields();
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Staff was created!']
        );
    }

    public function toggle($id)
    {
        $staff = User::find($id);
        if ($staff->is_active == 1) {
            $staff->is_active = 0;
        } elseif ($staff->is_active == 0) {
            $staff->is_active = 1;
        }
        $staff->save();
    }

    public function updatedIsActiveEdit($value)
    {
        // Handle the updated state if needed
        // dd($value);
    }

    public function edit($id)
    {
        $this->resetErrorBag();
        $this->staff = User::find($id);
        $this->name = $this->staff->name;
        $this->email = $this->staff->email;
        $this->phone = $this->staff->phone;
        $this->user_role = $this->staff->role_id ?? count($this->roles) > 0 ? $this->roles->first()->id : null;
        $this->is_active_edit = $this->staff->is_active==1 ? true: false;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'user_role' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->staff->id,
        ]);
        $this->staff->name = $this->name;
        $this->staff->email = $this->email;
        $this->staff->phone = $this->phone;
        $this->staff->role_id = $this->user_role;
        $this->staff->is_active = $this->is_active_edit ?? 0;
        if ($this->password != '') {
            $this->staff->password = Hash::make($this->password);
        }
        $this->staff->save();
        $this->resetFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Staff was updated!']
        );
    }

    public function delete($id)
    {
        $staff = User::find($id);
        $staff->delete();
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Staff was deleted!']
        );
    }
}
