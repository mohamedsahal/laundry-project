<div>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$lang->data['tax_report'] ?? 'Tax Report'}}</title>
        <style>
            #main {
                border-collapse: collapse;
                line-height: 1rem;
                text-align: center;
            }
            th {
                background-color: rgb(101, 104, 101);
                Color: white;
                font-size: 0.75rem;
                line-height: 1rem;
                font-weight: bold;
                text-transform: uppercase;
                text-align: center;
                padding: 10px;
            }
            td {
                text-align: center;
                border: 1px solid;
                font-size: 0.75rem;
                line-height: 1rem;
            }
            .col {
                border: none;
                text-align: left;
                padding: 10px;
                font-size: 0.75rem;
                line-height: 1rem;
            }
        </style>
    </head>
    <body onload="">
        @php
            /* sales */
            if ($category == 1) {
                $reports = \App\Models\Order::whereDate('order_date', '>=', $from_date)
                    ->whereDate('order_date', '<=', $to_date)
                    ->where('status', 3)
                    ->latest()
                    ->get();
            }
            /* expense */
            if ($category == 2) {
                $reports = \App\Models\Expense::whereDate('expense_date', '>=', $from_date)
                    ->whereDate('expense_date', '<=', $to_date)
                    ->latest()
                    ->get();
            }
            $lang = null;
        if (session()->has('selected_language')) {
        $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $lang = \App\Models\Translation::where('default', 1)->first();
        }
        @endphp
        <h3 class="fw-500 text-dark">
            @if ($category == 1)
                {{ 'Sales Tax Report' }}
            @else
                {{ 'Expense Tax Report' }}
            @endif
        </h3>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="col"> <label>{{$lang->data['start_date'] ?? 'Start Date'}}: </label>
                    {{ \Carbon\Carbon::parse($from_date)->format('d/m/Y') }}</td>
                <td class="col"> <label>{{$lang->data['end_date'] ?? 'End Date'}}: </label>
                    {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }} </td>
            </tr>
        </table>
        <table id="main" width="100%" cellpadding="0" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                    <th  class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['date'] ?? 'Date'}}</th>
                    <th  class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['particulars'] ?? 'Particulars'}} #</th>
                    <th  class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['before_tax'] ?? 'Before Tax'}}</th>
                    <th  class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['tax_amount'] ?? 'Tax Amount'}}</th>
                    <th  class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['total_amount'] ?? 'Total Amount'}}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tax_amount_total_expense = 0;
                    $tax_amount_total_sales = 0;
                    $tax_amount_sales = 0;
                    $tax_amount_expense = 0;
                    $i = 1;
                @endphp
                @foreach ($reports as $row)
                    <tr>
                        <td>
                            <p class="text-xs px-3  mb-0">
                                {{ $i++ }}
                            </p>
                        </td>
                        <td>
                            <p class="text-xs px-3  mb-0">
                                {{--  sales  --}}
                                @if ($category == 1)
                                    {{ \Carbon\Carbon::parse($row->order_date)->format('d/m/Y') }}
                                @endif
                                {{--  expense  --}}
                                @if ($category == 2)
                                    {{ \Carbon\Carbon::parse($row->expense_date)->format('d/m/Y') }}
                                @endif
                            </p>
                        </td>
                        {{--  sales  --}}
                        @if ($category == 1)
                            @php
                                $tax_amount_sales = $row->total * ($row->tax_percentage / 100);
                                $tax_amount_total_sales += $tax_amount_sales;
                            @endphp
                        @endif
                        {{--  expense  --}}
                        @if ($category == 2)
                            @php
                                $tax_amount_expense = $row->expense_amount * ($row->tax_percentage / 100);
                                $tax_amount_total_expense += $tax_amount_expense;
                            @endphp
                        @endif
                        <td>
                            <p class="text-xs px-3 mb-0">
                                <span class="font-weight-bold">
                                    {{--  sales  --}}
                                    @if ($category == 1)
                                        {{ $row->order_number }}
                                    @endif
                                    {{--  expense  --}}
                                    @if ($category == 2)
                                        {{ $row->expenseCategory->expense_category_name ?? '' }}
                                    @endif
                                </span>
                            </p>
                        </td>
                        <td>
                            <p class="text-xs px-3 font-weight-bold mb-0">
                                {{--  sales  --}}
                                @if ($category == 1)
                                    {{getFormattedCurrency($row->total - $tax_amount_sales)}}
                                @endif
                                {{--  expense  --}}
                                @if ($category == 2)
                                    {{getFormattedCurrency($row->expense_amount - $tax_amount_expense)}}
                                @endif
                        </td>
                        <td>
                            <p class="text-xs px-3 font-weight-bold mb-0">
                                {{--  sales  --}}
                                @if ($category == 1)
                                    {{getFormattedCurrency($tax_amount_sales)}}
                                @endif
                                {{--  expense  --}}
                                @if ($category == 2)
                                    {{getFormattedCurrency($tax_amount_expense)}}
                                @endif
                            </p>
                        </td>
                        <td>
                            <p class="text-xs px-3 font-weight-bold mb-0">
                                {{--  sales  --}}
                                @if ($category == 1)
                                    {{getFormattedCurrency($row->total)}}
                                @endif
                                {{--  expense  --}}
                                @if ($category == 2)
                                    {{getFormattedCurrency($row->expense_amount)}}
                                @endif
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table cellspacing="15">
            <tr>
                <td class="col">
                    <span class="text-sm mb-0 fw-500">{{$lang->data['total_amount'] ?? 'Total Amount'}}:</span>
                    <span class="text-sm text-dark ms-2 fw-600 mb-0">
                        {{--  sales  --}}
                        @if ($category == 1)
                            {{getFormattedCurrency($reports->sum('total'))}}
                        @endif
                        {{--  expense  --}}
                        @if ($category == 2)
                            {{getFormattedCurrency($reports->sum('expense_amount'))}}
                        @endif
                    </span>
                </td>
                <td class="col"> <span class="text-sm mb-0 fw-500"></span>
                    <span class="text-sm mb-0 fw-500">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}}:</span>
                    <span class="text-sm text-dark ms-2 fw-600 mb-0">
                        {{--  sales  --}}
                        @if ($category == 1)
                            {{getFormattedCurrency($tax_amount_total_sales)}}
                        @endif
                        {{--  expense  --}}
                        @if ($category == 2)
                            {{getFormattedCurrency($tax_amount_total_expense)}}
                        @endif
                    </span>
                </td>
            </tr>
        </table>
    </body>
    </html>
</div>