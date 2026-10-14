<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\MasterSettings;

class ThemeSettings extends Component
{
    public $selected_theme = 'default';
    #[Title('SMS Settings')]
    public function render()
    {
        return view('livewire.settings.theme-settings');
    }

    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('setting_theme')){
            abort(404);
        }
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $this->selected_theme = (isset($site['admin_panel_theme']) && !empty($site['admin_panel_theme'])) ? $site['admin_panel_theme'] : 'default';
    }

    /* save the master settings data */
    public function save()
    {
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $site['admin_panel_theme'] = $this->selected_theme;
        foreach ($site as $key => $value) {
            MasterSettings::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
        }
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Theme Updated Successfully!']
        );
        $this->dispatch('reloadpage',true);
    }
}
