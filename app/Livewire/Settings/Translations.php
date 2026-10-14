<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Translation;
use Livewire\Attributes\Title;

class Translations extends Component
{
    public $translations,$search_query,$lang;
    #[Title('Translations')]
    /* render the content */
    public function render()
    {
        return view('livewire.settings.translations');
    }
    /* process before render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('translation_list')){
            abort(404);
        }
        $this->translations = \App\Models\Translation::latest()->get();
        if(session()->has('selected_language'))
        {
            /* if the session has selected language */
            $this->lang = \App\Models\Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if the session has no selected language */
            $this->lang = \App\Models\Translation::where('default',1)->first();
        }
    }
    /* process while edit the content */
    public function updated($name,$value)
    {   /* if the updated element is search_query */
        if($name == 'search_query' && $value != '')
        {
            $this->translations = \App\Models\Translation::where('name','like','%'.$value.'%')->latest()->get();

        }
        elseif($name == 'search_query' && $value == '')
        {
            $this->translations = \App\Models\Translation::latest()->get();
        }
    }
}
