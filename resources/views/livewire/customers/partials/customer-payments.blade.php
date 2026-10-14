<div class="tab-pane fade" id="pills-change-passwork" role="tabpanel" aria-labelledby="pills-change-passwork-tab"
    tabindex="0" wire:ignore.self>
    <div class="tw-p-0">
        <div class="table-responsive scroll-sm">
            <table class="table bordered-table sm-table mb-0">
                <thead>
                    <tr>
                        <th scope="col" class="">{{ $lang->data['date'] ?? 'Date' }}</th>
                        <th scope="col" class="">{{ $lang->data['invoice'] ?? 'Invoice' }}</th>
                        <th scope="col" class=""> {{ $lang->data['payment_type'] ?? 'Payment Type' }}</th>
                        <th scope="col" class="">{{ $lang->data['amount'] ?? 'Amount' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $item)
                        <tr class="tw-text-xs">
                            <td class="">
                                {{ \Carbon\Carbon::parse($item->order_date)->format('d/m/y') }}
                            </td>
                            <td>
                                <div class="tw-flex tw-flex-col">
                                    <div class="text-neutral-600">
                                        ID : <span class="tw-font-medium text-primary-light">{{ $item->order_number }}</span>
                                    </div>
                                    <div class="text-neutral-600">
                                        Date : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($item->order->order_date)->format('d/m/y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="badge text-sm fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4 text-white">
                                    {{ getpaymentMode($item->payment_type) }}
                                </span>
                            </td>
                            <td class="text-primary">
                                {{ getFormattedCurrency($item->received_amount) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($hasMorePages)
                <div x-data="{
                    init() {
                        let observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    @this.call('loadPayments')
                                    console.log('loading...')
                                }
                            })
                        }, {
                            root: null
                        });
                        observer.observe(this.$el);
                    }
                }" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4">
                    <div class="text-center pb-2 d-flex justify-content-center align-items-center">
                        {{ $lang->data['loading'] ?? 'Loading...' }}
                        <div class="spinner-grow d-inline-flex mx-2 text-primary" role="status">
                            <span class="visually-hidden"> {{ $lang->data['loading'] ?? 'Loading...' }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>