<?php

namespace App\Livewire\Expense;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpenseCategory;
use App\Models\Translation;

class ExpenseCategoryList extends Component
{
    #[Title('Expense Category')]
    public $expense_category_name,$expense_category_type,$categories,$search,$lang,$category;
    public $editMode = false;
     /* validation rules */
    protected $rules = [
        'expense_category_name' => 'required',
        'expense_category_type' => 'required',
    ];
    /* called before render */
    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('expense_category_list')){
            abort(404);
        }
        if(Auth::user()->user_type==1)
        {
            $this->categories = ExpenseCategory::latest()->get();
        } else {
            $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
        }

        if(session()->has('selected_language'))
        { /* if session has selected_language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
    }
    /* render the page */
    public function render()
    {
        return view('livewire.expense.expense-category-list');
    }
    /* reset input fields */
    public function resetInputFields(){
        $this->expense_category_name = '';
        $this->expense_category_type = '';
        $this->resetErrorBag();
    }
    /* store expense category details */
    public function store()
    {
        /* if editmode is false */
        if($this->editMode == false)
        {
            $this->validate();
            $category = new ExpenseCategory();
            $category->expense_category_name = $this->expense_category_name;
            $category->expense_category_type = $this->expense_category_type;
            $category->created_by = Auth::user()->id;
            $category->save();
            if(Auth::user()->user_type==1)
            {
                $this->categories = ExpenseCategory::latest()->get();
            } else {
                $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
            }
            $this->resetInputFields();
            $this->dispatch('closemodal');
            $this->dispatch(
                'alert', ['type' => 'success',  'message' => 'Expense Category has been created!']);
        }
    }
    /* set category type value while change the category type */
    public function changeCategoryType() {
        $this->expense_category_type = $this->expense_category_type;
    }
    /* process when update the element */
    public function updated($name,$value)
    {
        /* if the updated element is search */
        if($name == 'search' && $value != '')
        {
            if(Auth::user()->user_type==1)
        {
            
            $this->categories = ExpenseCategory::where(function($query) use ($value) { 
                $query->where('expense_category_name', 'like', '%' . $value . '%');
            })->get();   
        } else {
            $this->categories = ExpenseCategory::where('created_by',Auth::user()->id)->where(function($query) use ($value) { 
                $query->where('expense_category_name', 'like', '%' . $value . '%');
            })->get();   
        }
            
        } else {
            if(Auth::user()->user_type==1)
            {
                $this->categories = ExpenseCategory::latest()->get();
            } else {
                $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
            }
        }
    }
      /* set the content to edit */
    public function edit($id)
    {
        $this->resetErrorBag();
        $this->editMode = true;
        $this->category = ExpenseCategory::where('id',$id)->first();
        $this->expense_category_name = $this->category->expense_category_name;
        $this->expense_category_type = $this->category->expense_category_type;
    }
    /* update expense category*/
    public function update()
    {
        $this->validate();
        if($this->editMode == true)
        {
            $this->category->expense_category_name = $this->expense_category_name;
            $this->category->expense_category_type = $this->expense_category_type;
            $this->category->save();
            if(Auth::user()->user_type==1)
            {
                $this->categories = ExpenseCategory::latest()->get();
            } else {
                $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
            }
            $this->resetInputFields();
            $this->editMode = false;
            $this->dispatch('closemodal');
            $this->dispatch(
                'alert', ['type' => 'success',  'message' => 'Expense Category has been updated!']);
        }
    }
    /* expense category delete */
    public function delete($id)
    {   
        if (\App\Models\Expense::where('expense_category_id', $id)->doesntExist()) {
            /* if expense category has any children */
            $this->category = ExpenseCategory::where('id',$id)->delete();
            $this->dispatch(
                'alert', ['type' => 'success',  'message' => 'Expense Category deleted Successfully!']);
        } else {
            /* if expense category has no child */
                $this->dispatch(
                'alert', ['type' => 'error',  'message' => 'Expense Category deletion restricted!']);
        }
        if(Auth::user()->user_type==1)
        {
            $this->categories = ExpenseCategory::latest()->get();
        } else {
            $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
        }
    }
}
