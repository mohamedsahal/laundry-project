<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;


class Logout extends Component
{
    public function render()
    {
        return view('livewire.auth.logout');
    }
     //Perform Logout
     public function mount()
     {
         Auth::logout();
         Session::flush();
         return redirect('/');
     }
       
}
