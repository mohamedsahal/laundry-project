<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use File;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Translation;
use Livewire\Attributes\Title;

class FileTools extends Component
{
    use WithFileUploads;
    public $icons,$photo,$allowupload = false,$i=0,$lang;
    #[Title('File Tools')]
    public function render()
    {
        return view('livewire.settings.file-tools');
    }
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('setting_file_tools')){
            abort(404);
        }
        if(session()->has('selected_language'))
        {   /*if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
        $this->getFiles();
    }
    public function updatedPhoto()
    {
        $this->dispatch('removelocalError');
        $this->allowupload = false;
        $this->validate([
            'photo' => 'image|max:1024', 
        ]);
        $this->allowupload = true;
    }
 
    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', 
        ]);
        Storage::disk('public')->put('/assets/img/service-icons/',$this->photo);
        $this->getFiles();
        $this->i++;
        $this->allowupload = false;
    }
    public function getFiles()
    {
        
        $files = File::files(public_path('assets/img/service-icons'));
        $myfiles = collect($files)->sortByDesc(function ($file) {
            return $file->getCTime();
        });
        $tempicons = [];
        $i = 0;
        foreach ($myfiles as $value) {
            // dd(Carbon::parse(File::lastModified($value)));
            $i++;
            $tempicons[$i]['path'] = $value->getfilename();
        }
        $this->icons = collect($tempicons)->toArray();
    }
    public function reesetErrors()
    {
        $this->resetErrorBag();
    }
}
