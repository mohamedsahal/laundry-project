<?php

namespace App\Livewire\Expense;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Translation;

class ExpenseList extends Component
{
    #[Title('Expenses')]
    public $expense_category_id,$expense_amount,$expense_date,$payment_mode,$tax_included=0,$expenses,$tax_percentage,$note,$search,$lang,$expense;
    public $editMode = false;
    /* validation rules */
    protected $rules = [
        'expense_category_id' => 'required',
        'expense_date' => 'required',
        'expense_amount' => 'required',
        'tax_included' => 'required',
        'payment_mode'  => 'required'
    ];
    /* called before render */
    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('expense_list')){
            abort(404);
        }
        if(Auth::user()->user_type==1)
        {
            $this->expenses = Expense::latest()->get();
        } else {
            $this->expenses = Expense::latest()->where('created_by',Auth::user()->id)->get();
        }

        $this->tax_included = 0;
        $this->expense_date = \Carbon\Carbon::today()->toDateString();
        if(session()->has('selected_language'))
        {  /* if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
    }
    /* render the page */
    public function render()
    {
        return view('livewire.expense.expense-list');
    }
    /* reset fields */
    public function resetInputFields(){
        $this->expense_category_id = '';
        $this->expense_amount = '';
        $this->expense_date = '';
        $this->payment_mode = "";
        $this->tax_included = 0;
        $this->tax_percentage = "";
        $this->note= "";
        $this->expense_date = Carbon::today()->toDateString()   ;
        $this->resetErrorBag();
    }
    /* store the expense details */
    public function store()
    {
        /* if edit mode is false */
        $this->validate();
        $expense = new Expense();
        if($this->tax_included == 1)
        {
            /* if tax is included */
            $this->validate([
                'tax_percentage' => 'required|numeric',
            ]);
            $expense->tax_percentage = $this->tax_percentage ?? 0.00;
        }
        $expense->expense_category_id = $this->expense_category_id;
        $expense->expense_amount = $this->expense_amount;
        $expense->expense_date = $this->expense_date;
        $expense->payment_mode = $this->payment_mode;
        $expense->tax_included = ($this->tax_included);
        $expense->financial_year_id = getFinancialYearId();
        $expense->note = $this->note;
        $expense->created_by = Auth::user()->id;
        $expense->save();
        if(Auth::user()->user_type==1)
        {
            $this->expenses = Expense::latest()->get();
        } else {
            $this->expenses = Expense::latest()->where('created_by',Auth::user()->id)->get();
        }
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert', ['type' => 'success',  'message' => 'Expense Category has been created!']);
        
    }
    /* process when update the element */
    public function updated($name,$value)
    {
        //Set data to null if value is an empty string
        if ( $value == '' ) data_set($this, $name, null);
         /* if updated element is search */
        if($name == 'search' && $value != '')
        {
            $this->expenses = Expense::where(function($query) use ($value) { 
                        $query->where('expense_amount',$value);
            })->get();       

            if(Auth::user()->user_type==1)
            {
                $this->expenses = Expense::where(function($query) use ($value) { 
                    $query->where('expense_amount',$value);
                })->get(); 
            } else {
                $this->expenses = Expense::where('created_by',Auth::user()->id)->where(function($query) use ($value) { 
                    $query->where('expense_amount',$value);
                })->get(); 
            }

        } else {
            if(Auth::user()->user_type==1)
            {
                $this->expenses = Expense::latest()->get();
            } else {
                $this->expenses = Expense::latest()->where('created_by',Auth::user()->id)->get();
            }
        }
        /* if updated element is tax_included */
        if($name == 'tax_included' && $value != '')
        {
                     $this->tax_included = $value;
        }
    }
    /* set the content to edit */
    public function edit($id)
    {
        $this->editMode = true;
        $this->expense = Expense::where('id',$id)->first();
        $this->expense_amount = $this->expense->expense_amount ;
        $this->expense_date = $this->expense->expense_date;
        $this->payment_mode = ($this->expense->payment_mode)?$this->expense->payment_mode:0;
        $this->tax_included = $this->expense->tax_included;
        $this->tax_percentage = ($this->expense->tax_percentage)? $this->expense->tax_percentage : 0;
        $this->expense_category_id = $this->expense->expense_category_id;
        $this->note = $this->expense->note;
    }
    /* update expense */
    public function update()
    {
        $this->validate();
        if($this->tax_included == 1)
        { /* if tax is included */
            $this->validate([
                'tax_percentage' => 'required|numeric',
            ]);
        }

        $this->expense->expense_category_id = $this->expense_category_id;
        $this->expense->expense_amount = $this->expense_amount;
        $this->expense->expense_date = $this->expense_date;
        $this->expense->payment_mode = $this->payment_mode;
        $this->expense->tax_included = ($this->tax_included);
            if($this->tax_included==1) {
                /* if tax is included */
            $this->expense->tax_percentage = $this->tax_percentage;
            } else {
                /* if tax is not included */
            $this->expense->tax_percentage = 0;
            }
        $this->expense->note = $this->note;
        $this->expense->save();
        if(Auth::user()->user_type==1)
        {
            $this->expenses = Expense::latest()->get();
        } else {
            $this->expenses = Expense::latest()->where('created_by',Auth::user()->id)->get();
        }

        $this->resetInputFields();
        $this->editMode = false;
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert', ['type' => 'success',  'message' => 'Expense Updated has been updated!']);
        
    }
    /* expense delete */
    public function delete($id)
    {
            $this->expense = Expense::where('id',$id)->delete();
            $this->dispatch(
            'alert', ['type' => 'success',  'message' => 'Expense deleted Successfully!']);
            if(Auth::user()->user_type==1)
            {
                $this->expenses = Expense::latest()->get();
            } else {
                $this->expenses = Expense::latest()->where('created_by',Auth::user()->id)->get();
            }
    }
}
