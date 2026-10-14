<?php

namespace App\Livewire\Service;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
use App\Models\ServiceDetail;
use App\Models\ServiceType as ModelsServiceType;
use App\Models\Translation;
use Livewire\Attributes\Title;

class ServiceTypesList extends Component
{
    public $service_types,$name,$is_active=1,$service_type,$inputs,$search_query,$lang;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;
    /* reder the page */
    #[Title('Service Types')]
    public function render()
    {
        return view('livewire.service.service-types-list');
    }
    /* process before render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('service_type_list')){
            abort(404);
        }
        $this->service_types = new EloquentCollection();
        $this->loadServiceTypes();

        //$this->service_types = ModelsServiceType::latest()->get();
        if(session()->has('selected_language'))
        {  /* if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
    }
    /* create the service type */
    public function create()
    {
        $this->validate([
            'name'  => 'required'
        ]);
        ModelsServiceType::create([
            'service_type_name'  => $this->name,
            'is_active' => $this->is_active,
        ]);
        $this->name = null;
        $this->is_active = 1;
        $this->service_types = ModelsServiceType::latest()->get();
        $this->dispatch(
            'alert', ['type' => 'success',  'message' => 'Service Type has been created!']);
        $this->dispatch('closemodal');
        $this->service_types = ModelsServiceType::latest()->get();
    }
    /* set content to edit */   
    public function edit($id)
    {
        $this->resetErrorBag();
        $this->service_type = ModelsServiceType::where('id',$id)->first();
        $this->is_active = $this->service_type->is_active;
        $this->name = $this->service_type->service_type_name;
        $this->service_types = ModelsServiceType::latest()->get();
    }
    /* update the servicetype */
    public function update()
    {   /* if service type is exist */
        $this->validate([
            'name'  => 'required'
        ]);
        if($this->service_type)
        {
            $this->service_type->service_type_name = $this->name;
            $this->service_type->is_active = $this->is_active;
            $this->service_type->save();
        }
        $this->name = null;
        $this->is_active = 1;
        $this->service_types = ModelsServiceType::latest()->get();
        $this->dispatch(
            'alert', ['type' => 'success',  'message' => 'Service Type has been updated!']);
        $this->dispatch('closemodal');
        $this->service_types = ModelsServiceType::latest()->get();
    }
    /* service type delete */
    public function delete($id)
    {
        $this->service_type = ModelsServiceType::where('id',$id)->first();
        $getcount = ServiceDetail::where('service_type_id',$this->service_type->id)->count();
         /* if no.of.services > 0 */
        if($getcount > 0)
        {
            $this->dispatch(
                'alert', ['type' => 'error',  'message' => 'Failed to delete!']);
                return 0;
        }
        /* if service type is exists */
        if($this->service_type)
        {
            $this->service_type->delete();
            $this->dispatch(
                'alert', ['type' => 'success',  'message' => 'Service Type has been deleted!']);
        }
        $this->service_types = ModelsServiceType::latest()->get();
    }
    /* process while update the element */
    public function updated($name,$value)
    {   /* if updated element is search query */
        if($name == 'search_query' && $value != '')
        {
            $this->service_types = ModelsServiceType::where('service_type_name', 'like' , '%'.$value.'%')->get();
        }
        elseif($name == 'search_query' && $value == ''){
            $this->service_types = ModelsServiceType::latest()->get();
        }
    }

      /* refresh the page */
      public function refresh()
      {
          /* if search query or order filter is empty */
          if( $this->search_query == '')
          {
              $this->service_types->fresh();
  
          }
      }
      public function loadServiceTypes()
      {
          if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
              return;
          }
          $myservicetype = $this->filterdata();
          //dd($myservicetype);
          $this->service_types->push(...$myservicetype->items());
          if ($this->hasMorePages = $myservicetype->hasMorePages()) {
              $this->nextCursor = $myservicetype->nextCursor()->encode();
          }
          $this->currentCursor = $myservicetype->cursor();
      }
      public function reloadOrders()
      {
          $this->service_types = new EloquentCollection();
          $this->nextCursor = null;
          $this->hasMorePages = null;
          if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
              return;
          }
          $service_types = $this->filterdata();
          $this->service_types->push(...$service_types->items());
          if ($this->hasMorePages = $service_types->hasMorePages()) {
              $this->nextCursor = $service_types->nextCursor()->encode();
          }
          $this->currentCursor = $service_types->cursor();
      }
      public function filterdata()
      {
          if($this->search_query || $this->search_query != '')
          {
            $service_types = ModelsServiceType::where('service_type_name', 'like' , '%'.$this->search_query.'%')
            ->latest()
            ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
            return $service_types;
          }
          else{
            $service_types = ModelsServiceType::latest()
            ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
            return $service_types;
          }
      }

    public function resetInputFields(){
        $this->name='';
        $this->is_active = 1;
        $this->resetErrorBag();
    }
}
