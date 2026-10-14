<?php

namespace App\Livewire\Inventory\Categories;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class CategoriesList extends Component
{
    #[Title('Categories')]
    public $name, $is_active = 1, $category, $categories, $search = '',$lang;
    public function render()
    {
        
        $query = Category::latest();
        if ($this->search != '') {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $this->categories = $query->get();
        return view('livewire.inventory.categories.categories-list');
    }
    public function resetInputFields()
    {
        $this->name = '';
        $this->is_active = true;
        $this->resetErrorBag();
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
    public function save()
    {
        $this->validate([
            "name" => "required",
        ]);

        $category = new Category();
        $category->name = $this->name;
        $category->is_active = $this->is_active;
        $category->save();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Category  has been created!']
        );
    }
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        $this->name = $category->name;
        $this->is_active = $category->is_active == 1 ? true : false;
        $this->category = $category;
        $this->resetErrorBag();
    }

    public function update()
    {
        $this->validate([
            "name" => "required",
        ]);

        $category = Category::where('id', $this->category->id)->first();
        $category->name = $this->name;
        $category->is_active = $this->is_active;
        $category->save();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Category  has been updated!']
        );
    }
    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        if (!$category) {
            return;
        }

        $has_products = Product::where('category_id', $id)->exists();
        if ($has_products) {
            $this->dispatch(
                'alert',
                ['type' => 'error',  'message' => 'Cannot be deleted because it is already in use!']
            );
            return;
        }
        $category->delete();
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Category  has been deleted!']
        );
    }
}
