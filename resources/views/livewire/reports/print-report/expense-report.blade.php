<div>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Expense Report</title>
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
                <h5 class="fw-500 text-dark">{{$lang->data['expense_report'] ?? 'Expense Report'}}</h5>
            </div>
            <div class="col-12">
                <div class="row d-flex justify-content-between">
                    <div class="col-4">
                        <label>{{$lang->data['start_date'] ?? 'Start Date'}}: </label>
                        {{ \Carbon\Carbon::parse($from_date)->format('d/m/Y') }}
                    </div>
                    <div class="col-4">
                        <label>{{$lang->data['end_date'] ?? 'End Date'}}: </label>
                        {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}
                    </div>
                </div>
                <div class="card mb-4 shadow-none">
                    <div class="card-header p-4">
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered align-items-center mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-uppercase text-white text-xs ">{{$lang->data['date'] ?? 'End'}}</th>
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
                                                <p class="text-xs  text-uppercase mb-0">
                                                    {{ getpaymentMode($row->payment_mode) }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center px-4 mb-3 pt-5">
                            <div class="col-4">
                                <span class="text-sm mb-0 fw-500">{{$lang->data['total_expenses'] ?? 'Total Expenses'}}:</span>
                                <span class="text-sm text-dark ms-2 fw-600 mb-0">{{ count($expenses) }}</span>
                            </div>
                            <div class="col-4">
                                <span class="text-sm mb-0 fw-500">{{$lang->data['total_expense_amount'] ?? 'Total Expense Amount'}}:</span>
                                <span
                                    class="text-sm text-dark ms-2 fw-600 mb-0">{{getFormattedCurrency($expenses->sum('expense_amount'))}}</span>
                            </div>
                            <div class="col-4">
                                <span class="text-sm mb-0 fw-500">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}}:</span>
                                <span
                                    class="text-sm text-dark ms-2 fw-600 mb-0">{{getFormattedCurrency($tax_amount_total)}}</span>
                            </div>
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