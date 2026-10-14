<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgotPassword extends Component
{
    public $email,$password,$password_confirm;
    #[Layout('components.layouts.base'),Title('Reset Password')]
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }

    //Initialize Variables and Checks
    public function mount($token)
    {
        $email = DB::table('password_resets')->where('token',$token)->where('created_at', '>=' ,Carbon::now()->subHour(1))->first();
        if(!$email)
        {
            DB::table('password_resets')->where('token',$token)->delete();
            abort(404);
        }
        $this->email = $email->email ?? 'he;;p';
    }
    //Reset and login user.
    public function login()
    {
        $this->validate([
            'password'  => "required",
            'password_confirm'  => "required|same:password"
        ]);
        if(!$this->email)
        {
            abort(404);
        }
        $user = User::where('email',$this->email)->first();
        if(!$user)
        {
            abort(404);
        }
        $user->password = Hash::make($this->password);
        $user->save();
        DB::table('password_resets')->where('email',$this->email)->delete();
        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }
}
