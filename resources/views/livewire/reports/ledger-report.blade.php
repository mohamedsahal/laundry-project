<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="tw-flex  tw-items-center gap-4">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="d-flex  gap-1 tw-flex-col">
                            <span class="fw-medium">{{ $lang->data['start_date'] ?? 'Start Date' }}</span>
                            <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="start_date">
                        </div>
                    </div>

                    <div class=" d-flex align-items-center flex-wrap gap-3">
                        <div class="d-flex  gap-1 tw-flex-col">
                            <span class="fw-medium">{{ $lang->data['end_date'] ?? 'End Date' }}</span>
                            <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="end_date">
                        </div>
                    </div>

                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="d-flex  gap-1 tw-flex-col tw-relative">
                            <span class="fw-medium">{{ $lang->data['select_customer'] ?? 'Select Customer' }}</span>
                            <input type="text" name="" id="" class="form-control form-control-sm"
                                placeholder="@if($selected_customer) {{ $selected_customer->name }} @else {{ $lang->data['select_customer'] ?? 'Select Customer' }} @endif"  wire:model.live="customer_query">
                            @if ($customers && count($customers) > 0)
                            <ul class="list-group customhover tw-absolute tw-w-full tw-top-[100%] dropdown-menu p-0 tw-rounded-none">
                                @foreach ($customers as $row)
                                <button class="dropdown-item px-16 py-8  text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 tw-text-xs tw-truncate "
                                    wire:click="selectCustomer({{ $row->id }})">{{ $row->name }} - {{$row->phone}}</button>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <button type="button"
                            class="btn btn-success-100 text-success-600 radius-8 px-16 py-9 tw-mt-6" wire:click="getData()">{{ $lang->data['fetch'] ?? 'Fetch' }}</button>

                    </div>



                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive scroll-sm tw-min-h-[calc(100vh-16rem)]">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th class="">{{ $lang->data['date'] ?? 'Date' }}</th>
                                <th class="">
                                    {{ $lang->data['from'] ?? 'From' }}
                                </th>
                                <th class="">
                                    {{ $lang->data['voucher_no'] ?? 'Voucher No' }}
                                </th>
                                <th class="">
                                    {{ $lang->data['particulars'] ?? 'Particulars' }}
                                </th>
                                <th class="">
                                    {{ $lang->data['debit'] ?? 'Debit' }}
                                </th>
                                <th class="">
                                    {{ $lang->data['credit'] ?? 'Credit' }}
                                </th>
                                <th class="">
                                    {{ $lang->data['balance'] ?? 'Balance' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $debits = 0 + ($first_data != null ? $first_data['debits'] : 0);
                            $credits = 0 +($first_data != null ? $first_data['credits'] : 0);
                            $balance = $debits - $credits

                            @endphp
                      
                            @foreach ($data as $item)
                            <tr class="tw-font-bold">
                                <td>{{\Carbon\Carbon::parse($item['date'])->format('d/m/Y')}}</td>
                                <td> <p class="text-sm font-weight-bold mb-0">
                                            @if($item['type'] == 'debit')
                                                {{$lang->data['order'] ?? 'Order'}}
                                            @else
                                                {{$lang->data['payment'] ?? 'Payment'}}
                                            @endif
                                        </p></td>
                                <td></td>
                                <td>
                                    <p class="">
                                    @if($item['type'] == 'debit')
                                                #{{$item['order_number']}}
                                            @else
                                                -
                                            @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="">
                                    @if($item['type'] == 'debit')
                                               Sales - #{{$item['order_number']}}
                                            @else
                                                @php
                                                    $order = \App\Models\Order::where('id',$item['order_id'])->first();
                                                @endphp
                                               {{$lang->data['payment'] ?? 'Payment'}} - #{{$order->order_number}}
                                            @endif
                                    </p>
                                </td>
                                <td>
                                <p class="text-sm font-weight-bold mb-0">
                                @if($item['type'] == 'debit')
                                            {{getFormattedCurrency($item['total'])}}
                                            @else
                                            {{getFormattedCurrency(0)}}
                                            @endif
                                        </p>
                                </td>
                                <td>
                                    <p class="">
                                    @php
                                                if($item['type'] == 'debit')
                                                {
                                                    $debits += $item['total'];
                                                }
                                                else{
                                                    $credits += $item['received_amount'];
                                                }
                                                $balance = $debits - $credits
                                            @endphp
                                            @if($balance < 0)
                                             {{getFormattedCurrency($balance * -1)}} Cr 
                                            @else
                                           {{getFormattedCurrency($balance)}}  Dr 
                                            @endif
                                    </p>
                                </td>
                            </tr>
                            @endforeach
                            @if($first_data)
                            <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <p class="">
                                        {{$lang->data['opening_balance'] ?? 'Opening Balance'}}
                                    </p>
                                </td>
                                <td>
                                    <p class="">
                                        @if($debits)
                                        {{getFormattedCurrency($debits)}}
                                        @else
                                        {{getFormattedCurrency(0)}}
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="">
                                        @if($credits)
                                        {{getFormattedCurrency($credits)}}
                                        @else
                                        {{getFormattedCurrency(0)}}
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="">
                                        @if(isset($balance))
                                        @if($balance < 0)
                                            {{getFormattedCurrency($balance * -1)}} Cr
                                            @else
                                            {{getFormattedCurrency($balance)}} Dr
                                            @endif
                                            @else
                                            {{getFormattedCurrency(0)}} Cr
                                            @endif
                                            </p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>