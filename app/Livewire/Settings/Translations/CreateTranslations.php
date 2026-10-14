<?php

namespace App\Livewire\Settings\Translations;

use Livewire\Component;
use App\Models\Translation;
use Livewire\Attributes\Title;

class CreateTranslations extends Component
{
    public $data=[],$default,$name,$is_active=1,$is_rtl = 0,$lang;
    /* render the page */
    #[Title('Create Translations')]
    public function render()
    {
        return view('livewire.settings.translations.create-translations');
    }
    /* process before render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('translation_create')){
            abort(404);
        }
        if(session()->has('selected_language'))
        {
            /* if the session has selected language */
            $this->lang = \App\Models\Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if the session has no selected language */
            $this->lang = \App\Models\Translation::where('default',1)->first();
        }
        $this->initialData();
    }
    /* initial data fetch */
    public function initialData(){
        $this->name = '';
        $this->is_active = 1;
        $this->is_rtl = 0;
        $this->data=[];
        foreach(config('global.translation.section') as $value)
        {
            foreach($value['values'] as $key => $default)
            {
                $this->data[$key] = $default;
            }
        }
    }
    /* save the content */
    public function save()
    {
        $this->validate([
            'name'  => 'required',
            'data.*' => 'required'
        ]);
        if($this->default)
        {
            Translation::where('default',1)->update([
                'default'=> 0]
            );
        }
        if($this->is_rtl == null || !$this->is_rtl)
        {
            $this->is_rtl = 0;
        }
        Translation::create([
            'name'  => $this->name,
            'is_active' => $this->is_active,
            'default'   => $this->default,
            'data'  => $this->data,
            'is_rtl'    => $this->is_rtl,
        ]);
        return redirect('/admin/settings/translations');
    }
}
