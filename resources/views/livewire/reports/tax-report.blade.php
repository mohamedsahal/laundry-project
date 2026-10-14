<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="tw-flex  tw-items-center gap-4">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="d-flex  gap-1 tw-flex-col">
                        <span class="fw-medium">{{ $lang->data['start_date'] ?? 'Start Date' }}</span>
                        <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="from_date">
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="d-flex  gap-1 tw-flex-col">
                        <span class="fw-medium">{{ $lang->data['end_date'] ?? 'End Date' }}</span>
                        <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="to_date">
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="d-flex  gap-1 tw-flex-col">
                        <span class="fw-medium">{{ $lang->data['filter'] ?? 'Filter' }}</span>
                        <select class="form-select form-select-sm bg-base h-40-px w-auto" wire:model.live="category">
                            <option class="select-box" value="1">{{ $lang->data['sales'] ?? 'Sales' }}</option>
                            <option class="select-box" value="2">{{ $lang->data['expense'] ?? 'Expense' }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm tw-min-h-[calc(100vh-16rem)]">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="">{{ $lang->data['date'] ?? 'Date' }}</th>
                            <th class="">{{ $lang->data['particulars'] ?? 'Particulars' }} #</th>
                            <th class="">{{ $lang->data['before_tax'] ?? 'Before Tax' }}</th>
                            <th class="">{{ $lang->data['tax_amount'] ?? 'Tax Amount' }}</th>
                            <th class="">{{ $lang->data['total_amount'] ?? 'Total Amount' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                            $tax_amount_total_expense = 0;
                            $tax_amount_total_sales = 0;
                            $tax_amount_sales =0;
                            $tax_amount_expense = 0;
                            $i=1;
                            @endphp
                            @foreach($reports as $row)
                        <tr>
                            <td >
                                <p class="">
                                {{$i++}}
                                </p>
                            </td>
                            <td >
                                <p class="">
                                {{-- sales --}}
                                        @if($category ==1 )
                                        {{\Carbon\Carbon::parse($row->order_date)->format('d/m/Y')}}
                                        @endif
                                        {{-- expense --}}
                                        @if($category == 2) 
                                        {{\Carbon\Carbon::parse($row->expense_date)->format('d/m/Y')}}
                                        @endif
                                </p>
                            </td>
                            {{-- sales --}}
                                @if($category==1)
                                @php
                                $tax_amount_sales = $row->total * ($row->tax_percentage/100); 
                                $tax_amount_total_sales +=$tax_amount_sales;
                                @endphp
                                @endif
                                {{-- expense --}}
                                @if($category==2)
                                @php
                                $tax_amount_expense = $row->expense_amount * ($row->tax_percentage/100); 
                                $tax_amount_total_expense +=$tax_amount_expense;
                               @endphp
                               @endif
                            <td >
                                <p class="">
                                    <span class="font-weight-bold">
                                    {{-- sales --}}
                                            @if($category ==1 )
                                               {{$row->order_number}}
                                            @endif
                                            {{-- expense --}}
                                            @if($category == 2) 
                                               {{$row->expenseCategory->expense_category_name ?? ""}}
                                            @endif
                                    </span>
                                </p>
                            </td>
                            <td >
                                <p class="">
                                {{-- sales --}}
                                        @if($category ==1 )
                                        {{getFormattedCurrency($row->total-$tax_amount_sales)}}
                                     @endif
                                     {{-- expense --}}
                                     @if($category == 2) 
                                     {{getFormattedCurrency($row->expense_amount-$tax_amount_expense)}}
                                     @endif
                                </p>
                            </td>
                            <td >
                                <p class="">
                                {{-- sales --}}
                                        @if($category ==1 )
                                        {{getFormattedCurrency($tax_amount_sales)}}
                                     @endif
                                     {{-- expense --}}
                                     @if($category == 2) 
                                     {{getFormattedCurrency($tax_amount_expense)}}
                                     @endif
                                </p>
                            </td>
                            <td >
                                <p class="">
                                {{-- sales --}}
                                        @if($category ==1 )
                                        {{getFormattedCurrency($row->total)}}
                                     @endif
                                     {{-- expense --}}
                                     @if($category == 2) 
                                     {{getFormattedCurrency($row->expense_amount)}}
                                     @endif
                                </p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tw-flex tw-items-center tw-justify-between tw-w-full tw-p-2 tw-gap-2">
                <div class="tw-flex tw-items-center  tw-gap-4">
                    <div class="">{{$lang->data['total_amount'] ?? 'Total Amount'}}: <span class="tw-font-bold">  {{-- sales --}}
                         @if($category ==1 )
                            {{getFormattedCurrency($reports->sum('total'))}}
                         @endif
                         {{-- expense --}}
                         @if($category == 2) 
                         {{getFormattedCurrency($reports->sum('expense_amount'))}}
                         @endif</span></div>
                    <div class="">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}}: <span class="tw-font-bold">  {{-- sales --}}
                        @if($category ==1 )
                        {{getFormattedCurrency($tax_amount_total_sales)}}
                         @endif
                         {{-- expense --}}
                         @if($category == 2) 
                         {{getFormattedCurrency($tax_amount_total_expense)}}
                         @endif</span></div>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2">
                    @can('report_download')
                    <button type="button"
                        class="btn btn-warning-100 text-warning-600 radius-8 px-16 py-9" wire:click="downloadFile()">{{$lang->data['download_report'] ?? 'Download Report'}}</button>
                        @endcan
                        @can('report_print')
                        <a href="{{url('admin/reports/print-report/tax/'.$from_date.'/'.$to_date.'/'.$category)}}" target="_blank">
                           
                            <button type="button"
                            class="btn btn-success-100 text-success-600 radius-8 px-16 py-9">{{$lang->data['print_report'] ?? 'Print Report'}}</button>
                        </a>
                        @endcan
                    </div>
            </div>
        </div>
    </div>
</div>