<div>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{ $lang->data['stock_report'] ?? 'Stock Report' }}</title>
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
            $products = \App\Models\Product::latest()->get();

            foreach ($products as $product) {
                $product->current_stock = $product->calculateStock();
            }
            $lang = null;
            if (session()->has('selected_language')) {
                $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
            } else {
                $lang = \App\Models\Translation::where('default', 1)->first();
            }

        @endphp
        <h3 class="fw-500 text-dark">{{ $lang->data['stock_report'] ?? 'Stock Report' }}</h3>
        <br /> <br />
        <table id="main" width="100%" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="table-dark">

                    <th class="text-xs text-uppercase text-secondary opacity-7">
                        {{ $lang->data['purchase'] ?? '#' }} </th>
                    <th class="text-xs text-uppercase text-secondary opacity-7">
                        {{ $lang->data['product'] ?? 'Product' }}</th>
                    <th class="text-xs text-uppercase text-secondary opacity-7">
                        {{ $lang->data['available_stock'] ?? 'Available Stock' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $row)
                    <tr>
                        <td>
                            <p class="px-3 mb-0 text-xs">
                                {{ $loop->index + 1 }}
                            </p>
                        </td>
                        <td>
                            <p class="px-3 mb-0 text-xs">
                                <span class="font-weight-bold">{{ $row->name }}</span>
                            </p>
                        </td>
                        <td>
                            <p class="px-3 mb-0 text-xs font-weight-bold">
                                {{ $row->current_stock }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br> <br>
        <table cellspacing="15">
            <tr>
                <td class="col">
                    <span class="mb-0 text-sm fw-500">{{ $lang->data['total_products'] ?? 'Total Products' }}:</span>
                    <span class="mb-0 text-sm text-dark ms-2 fw-600">{{ count($products) }}</span>
                </td>
                <td class="col"> <span
                        class="mb-0 text-sm fw-500">{{ $lang->data['available_stock'] ?? 'Available Stock' }}:</span>
                    <span class="mb-0 text-sm text-dark ms-2 fw-600">{{ $products->sum('current_stock') }}</span>
                </td>

            </tr>
        </table>
    </body>

    </html>
</div>
