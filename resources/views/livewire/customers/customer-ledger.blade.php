<div class="dashboard-main-body">
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-body p-24">
                    <div class="tw-flex tw-items-center tw-gap-4 tw-py-2">
                        <div class="tw-size-14 dark:tw-bg-white tw-bg-neutral-300 tw-rounded-full"></div>
                        <div class="tw-flex tw-flex-col">
                            <h6 class="mb-0 mt-16">{{$customer->name}}</h6>
                            <span class="text-secondary-light mb-16">{{$customer->email}}</span>
                        </div>
                    </div>
                    <div class="tw-p-0">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table sm-table mb-0">
                                <thead>
                                    <tr>
                                        <th class=" ">{{ $lang->data['date'] ?? 'Date' }}</th>
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
                                            {{ $lang->data['balance'] ?? 'Balance' }}</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $debits = 0;
                                    $credits = 0;
                                @endphp
                                 @foreach ($data as $item)
                                 <tr>
                                     <td>
                                         <p class=" px-2" >{{\Carbon\Carbon::parse($item['date'])->format('d/m/Y')}}</p>
                                     </td>
                                     <td>
                                         <p class="">
                                             @if($item['type'] == 'debit')
                                                 {{$lang->data['order'] ?? 'Order'}}
                                             @else
                                                 {{$lang->data['payment'] ?? 'Payment'}}
                                             @endif
                                         </p>
                                     </td>
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
                                         <p class="  px-4">
                                             @if($item['type'] == 'debit')
                                             {{getFormattedCurrency($item['total'])}}
                                             @else
                                             {{getFormattedCurrency(0)}}
                                             @endif
                                         </p>
                                     </td>
                                     <td>
                                         <p class=" px-4">
                                             @if($item['type'] == 'credit')
                                             {{getFormattedCurrency($item['received_amount'])}}
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
                                             {{getFormattedCurrency($balance * -1)}}Cr
                                             @else
                                             {{getFormattedCurrency($balance )}}Dr
                                             @endif
                                         </p>
                                     </td>
                                 </tr>
                                 @endforeach
                               <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <p class="tw-font-bold">
                                        {{$lang->data['total'] ?? 'Total'}}
                                    </p>
                                </td>
                                <td>
                                    <p class="tw-font-bold  px-4">
                                        @if($debits)
                                       {{getFormattedCurrency($debits )}}
                                    @else
                                       {{getFormattedCurrency(0 )}} Cr
                                       @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="tw-font-bold  px-4">
                                        @if($credits)
                                       {{getFormattedCurrency($credits )}}

                                    @else
                                       {{getFormattedCurrency(0 )}}Cr
                                       @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="tw-font-bold">
                                        @if(isset($balance))
                                            @if($balance < 0)
                                                {{getFormattedCurrency($balance * -1 )}} Cr
                                            @else
                                                {{getFormattedCurrency($balance  )}} Dr
                                            @endif
                                        @else
                                        {{getFormattedCurrency(0 )}}Cr
                                        @endif
                                    </p>
                                </td>
                               </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>