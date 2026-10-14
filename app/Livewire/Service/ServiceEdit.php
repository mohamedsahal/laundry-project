<?php

namespace App\Livewire\Service;

use App\Models\MasterSettings;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Service;
use App\Models\ServiceDetail;
use File;
use App\Models\ServiceType;
use App\Models\Translation;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ServiceEdit extends Component
{
    use WithFileUploads;
    #[Title('Service Edit')]
    public $services,$files,$imageicon,$inputs=[],$service_types,$prices = [],$servicetypes =[],$inputi=1,$service_name,$is_active=1,$service,$lang,$icon_type = 1,$file;
    /* render the page */
    public function render()
    {
        return view('livewire.service.service-edit');
    }
    /* process before render */
    public function mount($id)
    {
        if(!\Illuminate\Support\Facades\Gate::allows('service_edit')){
            abort(404);
        }
        $files = File::files(public_path('assets/img/service-icons'));
        $i = 0;
        $this->service_types = ServiceType::latest()->get();
        foreach($files as $value)
        {
            $i++;
            $this->files[$i]['path'] = $value->getfilename();
        }
        $this->service = Service::where('id',$id)->first();
        /* if service is not exist */
        if(!$this->service)
        {
            abort(404);
        }
        $details = ServiceDetail::where('service_id',$this->service->id)->get();
        
        foreach($details as $row)
        {
            $this->add($this->inputi);
            $this->servicetypes[$this->inputi] = $row->service_type_id;
            $this->prices[$this->inputi] = $row->service_price;
        }
        $this->service_name = $this->service->service_name;
        $this->is_active = $this->service->is_active;
        
        $this->imageicon['path'] = $this->service->icon;
        if(session()->has('selected_language'))
        {   /* if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
        $setting = new MasterSettings();
        $siteData = $setting->siteData();
        $this->icon_type = isset($siteData['service_image_upload_type']) && !empty($siteData['service_image_upload_type']) ? $siteData['service_image_upload_type'] : 1;

    }
    /* select the icon */
    public function selectIcon($data)
    {
        $this->imageicon = $this->files[$data];
        $this->dispatch('closemodal');
    }
    /* add the content for upcoming process */
    public function add($i)
    {
        $i = $i + 1;
        $this->inputi = $i;
        array_push($this->inputs ,$i);
        $this->prices[$i]    = 100;
        $this->servicetypes[$i] = '';
    }
    /* save the service */
    public function save()
    {
        $this->validate([
            'servicetypes.*' => 'required',
            'prices.*'  => 'numeric|required',
            'service_name'  => 'required',
        ]);
        if (!$this->imageicon && $this->icon_type == 1) {
            $this->addError('icon', "Please select an icon");
            return 1;
        }
        if(count($this->inputs) <= 0)
        {
            $this->addError('inputerror',"You must add atleast one service type");
            return 1;
        }
        if ($this->file && $this->icon_type == 2) {
            $this->service->icon = $this->file->store('/uploads/service-icons','public');
        }
        else{
            $this->service->icon = $this->imageicon['path'];
        }
        $this->service->icon_type = $this->icon_type;
        $this->service->service_name = $this->service_name;
        $this->service->is_active = $this->is_active ?? 0;
        $this->service->save();
        $details = ServiceDetail::where('service_id',$this->service->id)->delete();
        foreach($this->inputs as $key => $value)
        {
           $servicetype = ServiceType::where('id',$this->servicetypes[$value])->first();
           /* if service type is exist */
           if($servicetype)
           {
               ServiceDetail::create([
                   'service_id' => $this->service->id,
                   'service_type_id'    => $servicetype->id,
                   'service_price'  => $this->prices[$value],
               ]);
           }
        }
        $this->dispatch(
            'alert', ['type' => 'success',  'message' => 'Service has been updated!']);
        return redirect('/admin/service');
    }
    /* remove the service */
    public function remove($id,$value)
    {   /* if the service input is exist */
        if(isset($this->inputs[$id]))
        {
            unset($this->inputs[$id]);
            unset($this->servicetypes[$value]);
            unset($this->prices[$value]);
        }
    }
}
