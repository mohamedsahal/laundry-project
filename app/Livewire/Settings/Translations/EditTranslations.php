<?php

namespace App\Livewire\Settings\Translations;

use Livewire\Component;
use App\Models\Translation;
use Livewire\Attributes\Title;

class EditTranslations extends Component
{
    public $data =[],$name,$is_active=1,$default,$translation,$is_rtl,$lang,$current_id;
    /* render the content */
    #[Title('Edit Translations')]
    public function render()
    {
        return view('livewire.settings.translations.edit-translations');
    }
    /* process before mount */
    public function mount($id)
    {
        $this->current_id = $id;
        $translation = Translation::where('id',$id)->first();
        if(!\Illuminate\Support\Facades\Gate::allows('translation_edit')){
            abort(404);
        }
        /* if translation is not empty */
        if(!$translation)
        {
            abort(404);
        }
       $this->initialData();
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
    /* set initial Data */
    public function initialData(){
        $translation = Translation::where('id',$this->current_id)->first();
        $this->data = $translation->data;
        $this->name = $translation->name;
        $this->is_active = $translation->is_active;
        $this->default = $translation->default ? true : false;
        $this->translation = $translation;
        $this->is_rtl = $translation->is_rtl ? true : false;
    }
    /* save the content */
    public function save()
    {
        $this->validate([
            'name'  => 'required',
            'data.*' => 'required'
        ]);
        if($this->default && $this->translation->default == 0)
        {
            Translation::where('default',1)->update([
                'default'=> 0]
            );
        }
        /* if active is 0 */
        if(!$this->is_active)
        {
            $this->default = 0;
        }
        if($this->is_rtl == null || !$this->is_rtl)
        {
            $this->is_rtl = 0;
        }
        $this->translation->name = $this->name;
        $this->translation->data = $this->data;
        $this->translation->is_active = $this->is_active;
        $this->translation->default = $this->default;
        $this->translation->is_rtl = $this->is_rtl;
        $this->translation->save();
        return redirect('/admin/settings/translations');
    }
}
