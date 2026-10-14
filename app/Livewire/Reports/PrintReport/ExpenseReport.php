<?php
namespace App\Livewire\Reports\PrintReport;
use Livewire\Component;
use Livewire\Attributes\Layout;
class ExpenseReport extends Component
{
    public $expenses, $from_date, $to_date;
    /* render the page*/
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.print-report.expense-report');
    }
    /* process before render */
    public function mount($from_date = null,$to_date = null) {

        if(!\Illuminate\Support\Facades\Gate::allows('report_print')){
            abort(404);
        }
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->expenses = \App\Models\Expense::whereDate('expense_date','>=',$this->from_date)->whereDate('expense_date','<=',$this->to_date)->latest()->get();
    }
}