<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\FinancialYear;
use App\Models\Translation;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;

class FinancialYearSettings extends Component
{
    public $years, $name, $start_date, $end_date, $year, $edityear, $search_query, $lang;
    /* render the page */
    #[Title('Financial Year Settings')]
    public function render()
    {
        return view('livewire.settings.financial-year-settings');
    }
    /* process before render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('setting_financial_year')){
            abort(404);
        }
        $this->years = FinancialYear::orderBy('year', 'DESC')->get();
        $this->start_date = Carbon::today()->month(4)->startOfMonth()->toDateString();
        $this->end_date = Carbon::today()->month(3)->endOfMonth()->addYear(1)->toDateString();
        $this->year = Carbon::today()->format('Y');
        if (session()->has('selected_language')) {  /*if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
    }
    /* create financial year */
    public function create()
    {
        $this->validate([
            'year' => 'required',
            'start_date'    => 'required',
            'end_date'  => 'required',
        ]);
        FinancialYear::create([
            'year'  => $this->year,
            'starting_date'    => $this->start_date,
            'ending_date'  => $this->end_date
        ]);
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Financial Year has been created!']
        );
        $this->years = FinancialYear::orderBy('year', 'DESC')->get();
        $this->start_date = Carbon::today()->month(4)->startOfMonth()->toDateString();
        $this->end_date = Carbon::today()->month(3)->endOfMonth()->addYear(1)->toDateString();
        $this->year = Carbon::today()->format('Y');
    }
    /* set the content for edit */
    public function edit($id)
    {
        $this->resetErrorBag();
        $this->edityear = FinancialYear::where('id', $id)->first();
        $this->start_date = $this->edityear->starting_date;
        $this->end_date = $this->edityear->ending_date;
        $this->year = $this->edityear->year;
    }
    /* update financial year */
    public function update()
    {
        /* if edityear is exists */
        if ($this->edityear) {
            $this->edityear->starting_date = $this->start_date;
            $this->edityear->ending_date = $this->end_date;
            $this->edityear->year = $this->year;
            $this->edityear->save();
            $this->dispatch('closemodal');
            $this->dispatch(
                'alert',
                ['type' => 'success',  'message' => 'Financial Year has been updated!']
            );
            $this->years = FinancialYear::orderBy('year', 'DESC')->get();
            $this->start_date = Carbon::today()->month(4)->startOfMonth()->toDateString();
            $this->end_date = Carbon::today()->month(3)->endOfMonth()->addYear(1)->toDateString();
            $this->year = '';
        }
    }
    /* process while change the content*/
    public function updated($name, $value)
    {
        /* if the updated element is search_query */
        if ($name == 'search_query' && $value != '') {
            $this->years = FinancialYear::where('year', 'like', '%' . $value . '%')->get();
        } elseif ($name == 'search_query' && $value == '') {
            $this->years = FinancialYear::latest()->get();
        }
    }
    /* reset input fields */
    public function resetFields()
    {$this->resetErrorBag();
        $this->start_date = Carbon::today()->month(4)->startOfMonth()->toDateString();
        $this->end_date = Carbon::today()->month(3)->endOfMonth()->addYear(1)->toDateString();
        $this->year = Carbon::today()->format('Y');
    }
}
