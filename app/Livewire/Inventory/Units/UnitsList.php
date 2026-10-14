<?php

namespace App\Livewire\Inventory\Units;

use App\Models\Product;
use App\Models\Unit;
use Livewire\Attributes\Title;
use Livewire\Component;

class UnitsList extends Component
{
    #[Title('Units')]
    public $name, $short_form, $description, $is_active = 1;
    public $units, $unit, $search = '',$lang;
    public function render()
    {
        $query = Unit::latest();
        if ($this->search != '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('short_form', 'like', '%' . $this->search . '%');
            });
        }
        $this->units = $query->get();
        return view('livewire.inventory.units.units-list');
    }

    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('inventory_list')){
            abort(404);
        }
        if(session()->has('selected_language'))
        {   /* if session has selected language */
            $this->lang = \App\Models\Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = \App\Models\Translation::where('default',1)->first();
        }
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->short_form = '';
        $this->description = '';
        $this->is_active = true;
        $this->resetErrorBag();
    }
    public function save()
    {
        $this->validate([
            "name" => "required",
            "short_form" => "required",
        ]);

        $unit = new Unit();
        $unit->name = $this->name;
        $unit->short_form = $this->short_form;
        $unit->description = $this->description;
        $unit->is_active = $this->is_active;
        $unit->save();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Unit  has been created!']
        );
    }

    public function delete($id)
    {
        $unit = Unit::where('id', $id)->first();
        if (!$unit) {
            return;
        }
        $has_products = Product::where('unit_id', $id)->exists();
        if ($has_products) {
            $this->dispatch(
                'alert',
                ['type' => 'error',  'message' => 'Cannot be deleted because it is already in use!']
            );
            return;
        }
        $unit->delete();
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Unit  has been deleted!']
        );
    }

    public function edit($id)
    {
        $unit = Unit::where('id', $id)->first();
        $this->name = $unit->name;
        $this->short_form = $unit->short_form;
        $this->description = $unit->description;
        $this->is_active = $unit->is_active == 1 ? true : false;
        $this->unit = $unit;
        $this->resetErrorBag();
    }

    public function update()
    {
        $this->validate([
            "name" => "required",
            "short_form" => "required",
        ]);

        $unit = Unit::where('id', $this->unit->id)->first();
        $unit->name = $this->name;
        $unit->short_form = $this->short_form;
        $unit->description = $this->description;
        $unit->is_active = $this->is_active;
        $unit->save();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Unit  has been updated!']
        );
    }
}
