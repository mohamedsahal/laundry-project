<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Translation;

class Sidebar extends Component
{
    public $lang;
    /* render the page */
    public function render()
    {
        return view('livewire.components.sidebar');
    }
     //Perform Logout
     public function logout()
     {
         Auth::logout();
         Session::flush();
         return redirect('/');
     }
       /* process before render */
    public function mount()
    {
        if(session()->has('selected_language'))
        { /* if session has selected laugage*/
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
    }
}
