<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\MasterSettings;
use App\Models\Translation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Attributes\Title;

class MasterSetting extends Component
{
    public $default_currency, $default_application_name, $default_phone_number, $default_financial_year, $default_tax_percentage;
    public $default_state, $default_city, $default_district, $default_zip_code, $default_address, $user, $email, $password, $default_logo, $default_favicon, $default_currency_alignment = 1;
    public $old_favicon, $old_logo, $default_printer = 1, $lang, $country_code, $default_country, $store_tax, $store_email,$default_tax_mode,$default_delivery_day,$service_image_upload_type = 1;
    use WithFileUploads;
    /* render the page */
    #[Title('Master Settings')]
    public function render()
    {
        return view('livewire.settings.master-setting');
    }
    /* set the rules */
  
    /* set value at the time of render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('setting_master')){
            abort(404);
        }
       $this->initialValue();
    }
    public function initialValue(){
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $this->default_currency = (isset($site['default_currency']) && !empty($site['default_currency'])) ? $site['default_currency'] : '';
        $this->default_application_name = (isset($site['default_application_name']) && !empty($site['default_application_name'])) ? $site['default_application_name'] : '';
        $this->default_phone_number = (isset($site['default_phone_number']) && !empty($site['default_phone_number'])) ? $site['default_phone_number'] : '';
        $this->default_financial_year = (isset($site['default_financial_year']) && !empty($site['default_financial_year'])) ? $site['default_financial_year'] : '';
        $this->default_tax_percentage = (isset($site['default_tax_percentage']) && !empty($site['default_tax_percentage'])) ? $site['default_tax_percentage'] : '';
        $this->default_state = (isset($site['default_state']) && !empty($site['default_state'])) ? $site['default_state'] : '';
        $this->default_city = (isset($site['default_city']) && !empty($site['default_city'])) ? $site['default_city'] : '';
        $this->default_district = (isset($site['default_district']) && !empty($site['default_district'])) ? $site['default_district'] : '';
        $this->default_zip_code = (isset($site['default_zip_code']) && !empty($site['default_zip_code'])) ? $site['default_zip_code'] : '';
        $this->default_address = (isset($site['default_address']) && !empty($site['default_address'])) ? $site['default_address'] : '';
        $this->default_country = (isset($site['default_country']) && !empty($site['default_country'])) ? $site['default_country'] : '';
        $this->old_logo = (isset($site['default_logo']) && !empty($site['default_logo'])) ? $site['default_logo'] : '';
        $this->old_favicon = (isset($site['default_favicon']) && !empty($site['default_favicon'])) ? $site['default_favicon'] : '';
        $this->country_code = (isset($site['country_code']) && !empty($site['country_code'])) ? $site['country_code'] : '+91';
        $this->store_tax = (isset($site['store_tax_number']) && !empty($site['store_tax_number'])) ? $site['store_tax_number'] : '';
        $this->default_tax_mode = (isset($site['default_tax_mode']) && !empty($site['default_tax_mode'])) ? $site['default_tax_mode'] : 1;
        $this->store_email = (isset($site['store_email']) && !empty($site['store_email'])) ? $site['store_email'] : '';
        $this->default_printer = (isset($site['default_printer']) && !empty($site['default_printer'])) ? $site['default_printer'] : '';
        $this->default_currency_alignment = (isset($site['default_currency_alignment']) && !empty($site['default_currency_alignment'])) ? $site['default_currency_alignment'] : 1;
        $this->default_delivery_day = (isset($site['default_delivery_day']) && !empty($site['default_delivery_day'])) ? $site['default_delivery_day'] : 0;
        $this->service_image_upload_type = (isset($site['service_image_upload_type']) && !empty($site['service_image_upload_type'])) ? $site['service_image_upload_type'] : 1;
        if (session()->has('selected_language')) {   /*if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
        $user = User::findOrFail(1);
        $this->email = $user->email;
        $this->user = $user;
    }
    /* save the master settings data */
    public function save()
    {
        $this->validate([
            'default_currency' => 'required',
            'default_currency_alignment' => 'required',
            'default_application_name' => 'required',
            'default_phone_number' => 'required',
            'default_financial_year' => 'required',
            'default_tax_percentage' => 'required',
            'default_state' => 'required',
            'default_city' => 'required',
            'default_district' => 'required',
            'default_zip_code' => 'required',
            'default_delivery_day' => 'integer|max:30',
            'default_address' => 'required',
            'default_country' => 'required',
            'store_email'   => 'required',
            'store_tax' => 'required',
            'email' => 'required|email|unique:users',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
            'default_printer' => 'required',
            'country_code'  => 'required'
        ]);

        $settings = new MasterSettings();
        $site = $settings->siteData();
        $site['default_application_name'] = $this->default_application_name;
        $site['default_currency'] = $this->default_currency;
        $site['default_phone_number'] = $this->default_phone_number;
        $site['default_financial_year'] = $this->default_financial_year;
        $site['default_tax_percentage'] = $this->default_tax_percentage;
        $site['default_state'] = $this->default_state;
        $site['default_city'] = $this->default_city;
        $site['default_country'] = $this->default_country;
        $site['default_district'] = $this->default_district;
        $site['default_zip_code'] = $this->default_zip_code;
        $site['default_address'] = $this->default_address;
        $site['default_tax_mode'] = $this->default_tax_mode;
        $site['store_tax_number'] = $this->store_tax;
        $site['store_email'] = $this->store_email;
        $site['default_printer'] = $this->default_printer;
        $site['country_code'] = $this->country_code;
        $site['default_currency_alignment'] = $this->default_currency_alignment;
        $site['default_delivery_day'] = $this->default_delivery_day ?? 0;
        $site['service_image_upload_type'] = $this->service_image_upload_type ?? 1;
        if ($this->default_logo) {
            $default_logo = $this->default_logo;
            $input['file'] = time() . '.' . $default_logo->getClientOriginalExtension();
            $destinationPath = public_path('/logo');
            
            // Check if the logo file already exists and delete it
            if (isset($site['default_logo']) && file_exists(public_path($site['default_logo']))) {
                unlink(public_path($site['default_logo']));
            }
        
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
        
            $imgFile = Image::read($this->default_logo->getRealPath());
        
            $imgFile->save($destinationPath . '/' . $input['file']);
        
            $site['default_logo'] = '/logo/' . $input['file'];
        }
        
        /* if default_favicon exists */
        if ($this->default_favicon) {
            $default_favicon = $this->default_favicon;
            $input['file'] = time() . '.' . $default_favicon->getClientOriginalExtension();
            $destinationPath = public_path('/favicon');
            
            // Check if the favicon file already exists and delete it
            if (isset($site['default_favicon']) && file_exists(public_path($site['default_favicon']))) {
                unlink(public_path($site['default_favicon']));
            }
        
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
        
            $imgFile = Image::read($this->default_favicon->getRealPath());
        
            $imgFile->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['file']);
        
            $site['default_favicon'] = '/favicon/' . $input['file'];
        }
        foreach ($site as $key => $value) {
            MasterSettings::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
        }
        $user = User::findOrFail($this->user->id);
        $user->email = $this->email;
        if ($this->password) {
            $password = Hash::make($this->password);
            $user->password = $password;
        }
        $user->save();
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Master Settings Updated Successfully!']
        );
    }
}
