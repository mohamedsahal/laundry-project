<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\MasterSettings;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Title;
use App\Models\Translation;

class MailSettings extends Component
{
    public $mail_host,$mail_password,$mail_username,$mail_port,$enable_forget,$mail_from_address,$mail_from_name, $lang;
    //Render Page
    #[Title('Mail Settings')]
    public function render()
    { 
        return view('livewire.settings.mail-settings');
    }
    //Read Settings from .env file
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('setting_mail')){
            abort(404);
        }
        $env =  DotenvEditor::getKeys(['MAIL_HOST', 'MAIL_PORT','MAIL_USERNAME','MAIL_PASSWORD','MAIL_FROM_ADDRESS','MAIL_FROM_NAME']);
        if(isset($env['MAIL_HOST']['value']))
        {
            $this->mail_host = $env['MAIL_HOST']['value'];
        }
        if(isset($env['MAIL_PORT']['value']))
        {
            $this->mail_port = $env['MAIL_PORT']['value'];
        }
        if(isset($env['MAIL_USERNAME']['value']))
        {
            $this->mail_username = $env['MAIL_USERNAME']['value'];
        }
        if(isset($env['MAIL_PASSWORD']['value']))
        {
            $this->mail_password = $env['MAIL_PASSWORD']['value'];
        }
        if(isset($env['MAIL_FROM_ADDRESS']['value']))
        {
            $this->mail_from_address = $env['MAIL_FROM_ADDRESS']['value'];
        }
        if(isset($env['MAIL_FROM_NAME']['value']))
        {
            $this->mail_from_name = $env['MAIL_FROM_NAME']['value'];
        }
        $settings = new MasterSettings();
        $site = $settings->siteData();
        if(isset($site['forget_password_enable']))
        {
            if($site['forget_password_enable'] == 0)
            {
                $this->enable_forget = null;

            }
            else{
                $this->enable_forget = 1;
            }
        }
        if (session()->has('selected_language')) {  /*if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
    }
    //Save Settings to ENV
    public function save()
    {
        $this->validate([
            'mail_host'  => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ]);
        $file = DotenvEditor::setKeys([
            'MAIL_HOST' => $this->mail_host,
            'MAIL_PORT' => $this->mail_port,
            'MAIL_USERNAME' => $this->mail_username,
            'MAIL_PASSWORD' => $this->mail_password,
            'MAIL_FROM_ADDRESS' => $this->mail_from_address,
            'MAIL_FROM_NAME' => $this->mail_from_name,
        ]);
         $site['forget_password_enable'] = $this->enable_forget ?? 0;
        foreach ($site as $key => $value) {
            MasterSettings::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
        }
       $file = DotenvEditor::save();
        $this->dispatch(
            'alert', ['type' => 'success',  'message' => 'Mail Settings were updated successfully!']);
    }
}
