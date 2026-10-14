    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$lang->data['expense_report'] ?? 'Expense Report'}}</title>
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
    <h3 class="fw-500 text-dark">{{$lang->data['expense_report'] ?? 'Expense Report'}}</h3>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="col"> <label>{{$lang->data['start_date'] ?? 'Start Date'}}: </label>
                {{ \Carbon\Carbon::parse($from_date)->format('d/m/Y') }}</td>
            <td class="col"> <label>{{$lang->data['end_date'] ?? 'End Date'}}: </label>
                {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }} </td>
        </tr>
    </table>
    <br />
    @php
        $expenses = \App\Models\Expense::whereDate('expense_date', '>=', $from_date)
            ->whereDate('expense_date', '<=', $to_date)
            ->latest()
            ->get();
    @endphp
    <table id="main" width="100%" cellpadding="0" cellspacing="0">
        <thead class="table-dark">
            <tr>
                <th class="text-uppercase text-white text-xs ">{{$lang->data['date'] ?? 'Date'}}</th>
                <th class="text-uppercase text-white text-xs ">{{$lang->data['towards'] ?? 'Towards'}}</th>
                <th class="text-uppercase text-white text-xs ">{{$lang->data['expense_amount'] ?? 'Expense Amount'}}</th>
                <th class="text-uppercase text-white text-xs ">{{$lang->data['tax'] ?? 'Tax'}}%</th>
                <th class="text-uppercase text-white text-xs">{{$lang->data['tax_amount'] ?? 'Tax Amount'}}</th>
                <th class="text-uppercase text-white text-xs">{{$lang->data['payment_mode'] ?? 'Payment Mode'}}</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tax_amount_total = 0;
            @endphp
            @foreach ($expenses as $row)
                <tr>
                    <td>
                        <p class="text-xs   mb-0 text-center">
                            {{ \Carbon\Carbon::parse($row->expense_date)->format('d/m/Y') }}
                        </p>
                    </td>
                    <td>
                        <p class="text-xs px-3 mb-0">
                            <span
                                class="font-weight-bold">{{ $row->expenseCategory->expense_category_name ?? '' }}</span>
                        </p>
                    </td>
                    <td style="text-align: center">
                        <p class="text-xs  font-weight-bold mb-0">
                            {{getFormattedCurrency($row->expense_amount)}}</p>
                    </td>
                    <td style="text-align: center">
                        <p class="text-xs font-weight-bold mb-0">{{ $row->tax_percentage }}</p>
                    </td>
                    <td style="text-align: center">
                        <p class="text-xs font-weight-bold mb-0">
                            @php
                                $tax_amount = $row->expense_amount * ($row->tax_percentage / 100);
                                $tax_amount_total += $tax_amount;
                            @endphp
                            {{getFormattedCurrency($tax_amount)}}
                        </p>
                    </td>
                    <td style="text-align: center">
                        <p class="text-xs  text-uppercase mb-0">{{ getpaymentMode($row->payment_mode) }}</p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br /> <br />
    <table cellspacing="15">
        <tr>
            <td class="col">
                <span class="text-sm mb-0 fw-500">{{$lang->data['total_expenses'] ?? 'Total Expenses'}}:</span>
                <span class="text-sm text-dark ms-2 fw-600 mb-0">{{ count($expenses) }}</span>
            </td>
            <td class="col"> <span class="text-sm mb-0 fw-500">{{$lang->data['total_expense_amount'] ?? 'Total Expense Amount'}}:</span>
                <span
                    class="text-sm text-dark ms-2 fw-600 mb-0">{{getFormattedCurrency($expenses->sum('expense_amount'))}}</span>
            </td>
            <td class="col">
                <span class="text-sm mb-0 fw-500">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}}:</span>
                <span
                    class="text-sm text-dark ms-2 fw-600 mb-0">{{getFormattedCurrency($tax_amount_total)}}</span>
            </td>
        </tr>
    </table>
</body>
</html>