<div>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$lang->data['purchase_report'] ?? 'Purchase Report'}}</title>
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
            $purchases = \App\Models\Purchase::whereDate('purchase_date', '>=', $from_date)
                ->whereDate('purchase_date', '<=', $to_date)
                ->where('status', 1)
                ->latest()
                ->get();
                $lang = null;
        if (session()->has('selected_language')) {
        $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $lang = \App\Models\Translation::where('default', 1)->first();
        }
        @endphp
        <h3 class="fw-500 text-dark">{{$lang->data['purchase_report'] ?? 'Purchase Report'}}</h3>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="col"> <label>{{$lang->data['start_date'] ?? 'Start Date'}}: </label>
                    {{ \Carbon\Carbon::parse($from_date)->format('d/m/Y') }}
                </td>
                <td class="col">
                    <label>{{$lang->data['end_date'] ?? 'End Date'}}: </label>
                    {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}
                </td>
            </tr>
        </table>
        <br /> <br />
        <table id="main" width="100%" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="table-dark">
                    <th class="text-xs text-uppercase text-secondary opacity-7">{{$lang->data['date'] ?? 'Date'}}</th>
                    <th class="text-xs text-uppercase text-secondary opacity-7">{{$lang->data['purchase'] ?? 'Purchase'}} #</th>
                    <th class="text-xs text-uppercase text-secondary opacity-7">{{$lang->data['Supplier'] ?? 'Supllier'}}</th>
                    <th class="text-xs text-uppercase text-secondary opacity-7">{{$lang->data['sub_total'] ?? 'Sub Total'}}</th>
                    <th class="text-xs text-uppercase text-secondary opacity-7">{{$lang->data['discount'] ?? 'Discount'}}</th>
                    <th class="text-xs text-uppercase text-secondary opacity-7">{{$lang->data['tax_amount'] ?? 'Tax Amount'}}</th>
                    <th class="text-xs text-uppercase text-secondary opacity-7">{{$lang->data['gross_total'] ?? 'Gross Total'}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $row)
                    <tr>
                        <td>
                            <p class="px-3 mb-0 text-xs">
                                {{ \Carbon\Carbon::parse($row->purchase_date)->format('d/m/Y') }}
                            </p>
                        </td>
                        <td>
                            <p class="px-3 mb-0 text-xs">
                                <span class="font-weight-bold">{{ $row->purchase_number }}</span>
                            </p>
                        </td>
                        <td>
                            <p class="px-3 mb-0 text-xs font-weight-bold">
                                {{ $row->supplier_name }}</p>
                        </td>
                        <td>
                            <p class="px-3 mb-0 text-xs font-weight-bold">
                                {{getFormattedCurrency($row->sub_total)}}</p>
                        </td>
                         
                        <td>
                            <p class="px-3 mb-0 text-xs font-weight-bold">
                                {{getFormattedCurrency($row->discount)}}</p>
                        </td>
                        <td>
                            <p class="px-3 mb-0 text-xs font-weight-bold">
                                {{getFormattedCurrency($row->tax_amount)}}</p>
                        </td>
                        <td>
                            <p class="px-3 mb-0 text-xs font-weight-bold">
                                {{getFormattedCurrency($row->total)}}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br> <br>
        <table cellspacing="15">
            <tr>
                <td class="col">
                    <span class="mb-0 text-sm fw-500">{{$lang->data['total_purchases'] ?? 'Total Purchases'}}:</span>
                    <span class="mb-0 text-sm text-dark ms-2 fw-600">{{ count($purchases) }}</span>
                </td>
                <td class="col"> <span class="mb-0 text-sm fw-500">{{$lang->data['total_purchase'] ?? 'Total Purchase'}}:</span>
                    <span
                        class="mb-0 text-sm text-dark ms-2 fw-600">{{getFormattedCurrency($purchases->sum('total'))}}</span>
                </td>
                <td class="col"> <span class="mb-0 text-sm fw-500">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}}:</span>
                    <span
                        class="mb-0 text-sm text-dark ms-2 fw-600">{{getFormattedCurrency($purchases->sum('tax_amount'))}}</span>
                </td>
            </tr>
        </table>
    </body>
    </html>
</div>