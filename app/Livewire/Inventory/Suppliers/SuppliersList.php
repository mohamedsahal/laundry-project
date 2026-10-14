<?php

namespace App\Livewire\Inventory\Suppliers;

use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;

class SuppliersList extends Component
{
    #[Title('Suppliers')]
    public $suppliers, $name, $email, $phone, $opening_balance, $tax_number, $address, $is_active = true, $supplier, $search = '',$lang;

    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('supplier_list')){
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

    public function render()
    {
        $query = Supplier::latest();
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');

                if (is_numeric($this->search)) {
                    $q->orWhere('tax_number', $this->search);
                }

                $q->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        $this->suppliers = $query->get();
        return view('livewire.inventory.suppliers.suppliers-list');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->address = '';
        $this->phone = '';
        $this->opening_balance = '';
        $this->tax_number = '';
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $supplier = new Supplier();
        $supplier->name = $this->name;
        $supplier->address = $this->address;
        $supplier->phone = $this->phone;
        $supplier->opening_balance = $this->opening_balance !== '' ? $this->opening_balance : 0;
        $supplier->tax_number = $this->tax_number;
        $supplier->email = $this->email;
        $supplier->is_active = $this->is_active;
        $supplier->save();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Supplier  has been created!']
        );
    }

    public function delete($id)
    {
        $delete = Supplier::where('id', $id)->first();
        $delete->delete();
    }

    public function edit($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        $this->resetInputFields();
        $this->name = $supplier->name;
        $this->email = $supplier->email;
        $this->address = $supplier->address;
        $this->phone = $supplier->phone;
        $this->opening_balance = $supplier->opening_balance;
        $this->tax_number = $supplier->tax_number;
        $this->is_active = $supplier->is_active == 1 ? true : false;
        $this->supplier = $supplier;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        $supplier = Supplier::where('id', $this->supplier->id)->first();
        $supplier->name = $this->name;
        $supplier->address = $this->address;
        $supplier->phone = $this->phone;
        $supplier->opening_balance = $this->opening_balance !== '' ? $this->opening_balance : 0;
        $supplier->tax_number = $this->tax_number;
        $supplier->email = $this->email;
        $supplier->is_active = $this->is_active;
        $supplier->save();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Supplier  has been Updated!']
        );
    }
}
