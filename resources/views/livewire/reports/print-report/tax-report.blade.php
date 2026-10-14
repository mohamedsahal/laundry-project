<div>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$lang->data['tax_report'] ?? 'Tax Report'}}</title>
        <link href="https://fonts.googleapis.com/css?family=Calibri:400,700,400italic,700italic">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
            rel="stylesheet">
        <script src="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" crossorigin="anonymous"></script>
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
        <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.min28b5.css?v=2.0.0') }}" rel="stylesheet" />
        <link id="pagestyle" href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    </head>
    <body onload="">
        <div class="row align-items-center justify-content-between mb-4">
        </div>
        <div class="row">
            <div class="col-12">
                <h5 class="fw-500">
                    @if ($category == 1)
                    {{-- sales --}}
                        {{ 'Sales Tax Report' }}
                    @else
                        {{ 'Expense Tax Report' }}
                    @endif
                </h5>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>{{$lang->data['start_date'] ?? 'Start Date'}}: </label>
                    {{ \Carbon\Carbon::parse($from_date)->format('d/m/Y') }}
                </div>
                <div class="col-md-4">
                    <label>{{$lang->data['end_date'] ?? 'End Date'}}: </label>
                    {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4 shadow-none">
                    <div class="card-header p-4">
                    </div>
                    <div class="card-body p-0">
                        <div class="">
                            <table class="table  align-items-center mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-uppercase  text-xs ">#</th>
                                        <th class="text-uppercase  text-xs ">{{$lang->data['date'] ??'Date'}}</th>
                                        <th class="text-uppercase  text-xs ">{{$lang->data['particulars'] ?? 'Particulars'}}</th>
                                        <th class="text-uppercase  text-xs ">{{$lang->data['sub_total'] ?? 'Sub Total'}}</th>
                                        <th class="text-uppercase  text-xs ">{{$lang->data['tax_amount'] ?? 'Tax Amount'}}</th>
                                        <th class="text-uppercase  text-xs ">{{$lang->data['total_amount'] ?? 'Total Amount'}}</th>
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
                                                    {{-- sales --}}
                                                    @if ($category == 1)
                                                        {{ \Carbon\Carbon::parse($row->order_date)->format('d/m/Y') }}
                                                    @endif
                                                    {{-- expense --}}
                                                    @if ($category == 2)
                                                        {{ \Carbon\Carbon::parse($row->expense_date)->format('d/m/Y') }}
                                                    @endif
                                                </p>
                                            </td>
                                            {{-- sales --}}
                                            @if ($category == 1)
                                                @php
                                                    $tax_amount_sales = $row->total * ($row->tax_percentage / 100);
                                                    $tax_amount_total_sales += $tax_amount_sales;
                                                @endphp
                                            @endif
                                            {{-- expense --}}
                                            @if ($category == 2)
                                                @php
                                                    $tax_amount_expense = $row->expense_amount * ($row->tax_percentage / 100);
                                                    $tax_amount_total_expense += $tax_amount_expense;
                                                @endphp
                                            @endif
                                            <td>
                                                <p class="text-xs px-3 mb-0">
                                                    <span class="font-weight-bold">
                                                        {{-- sales --}}
                                                        @if ($category == 1)
                                                            {{ $row->order_number }}
                                                        @endif
                                                        {{-- expense --}}
                                                        @if ($category == 2)
                                                            {{ $row->expenseCategory->expense_category_name ?? '' }}
                                                        @endif
                                                    </span>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs px-3 font-weight-bold mb-0">
                                                    {{-- sales --}}
                                                    @if ($category == 1)
                                                        {{getFormattedCurrency($row->total - $tax_amount_sales )}}
                                                    @endif
                                                    {{-- expense --}}
                                                    @if ($category == 2)
                                                        {{getFormattedCurrency($row->expense_amount - $tax_amount_expense)}}
                                                    @endif
                                            </td>
                                            <td>
                                                <p class="text-xs px-3 font-weight-bold mb-0">
                                                    {{-- sales --}}
                                                    @if ($category == 1)
                                                        {{getFormattedCurrency($tax_amount_sales)}}
                                                    @endif
                                                    {{-- expense --}}
                                                    @if ($category == 2)
                                                        {{getFormattedCurrency($tax_amount_expense)}}
                                                    @endif
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs px-3 font-weight-bold mb-0">
                                                    {{-- sales --}}
                                                    @if ($category == 1)
                                                        {{getFormattedCurrency($row->total)}}
                                                    @endif
                                                    {{-- expense --}}
                                                    @if ($category == 2)
                                                        {{getFormattedCurrency($row->expense_amount)}}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center px-4 mb-3 pt-5">
                            <div class="col">
                                <span class="text-sm mb-0 fw-500">{{$lang->data['total_amount'] ?? 'Total Amount'}}:</span>
                                <span class="text-sm text-dark ms-2 fw-600 mb-0">
                                    {{-- sales --}}
                                    @if ($category == 1)
                                        {{getFormattedCurrency($reports->sum('total'))}}
                                    @endif
                                    {{-- expense --}}
                                    @if ($category == 2)
                                        {{getFormattedCurrency($reports->sum('expense_amount'))}}
                                    @endif
                                </span>
                            </div>
                            <div class="col">
                                <span class="text-sm mb-0 fw-500">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}}:</span>
                                <span class="text-sm text-dark ms-2 fw-600 mb-0">
                                    {{-- sales --}}
                                    @if ($category == 1)
                                        {{getFormattedCurrency($tax_amount_total_sales)}}
                                    @endif
                                    {{-- expense --}}
                                    @if ($category == 2)
                                        {{getFormattedCurrency($tax_amount_total_expense)}}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
</div>
<script type="text/javascript">
 "use strict";
    window.onload = function() {
        window.print();
        setTimeout(function() {
            window.close();
        }, 1);
    }
</script>