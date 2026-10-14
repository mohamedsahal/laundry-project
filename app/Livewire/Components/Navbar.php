<?php

namespace App\Livewire\Components;

use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Navbar extends Component
{
    public $title,$lang;
    public $languages;
    public function render()
    {
        return view('livewire.components.navbar');
    }

 
    public function mount($title)
    {
        $this->languages = Translation::where('is_active',1)->pluck('name','id');
        if(session()->has('selected_language'))
        { /* if session has selected laugage*/
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
        $this->title = $title;
    }

    /* change the language */
    public function changeLanguage($id)
    {
        $language = Translation::where('id',$id)->first();
        session()->put('selected_language',$language->id);
        $this->dispatch('reloadpage');
    }

    //Perform Logout
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
