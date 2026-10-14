<div class="dashboard-main-body">
    <div class="p-0 card h-100 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="flex-wrap gap-3 d-flex align-items-center">
                <form class="navbar-search">
                    <input type="text" class="w-auto bg-base h-40-px" name="search"
                        placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
        </div>
        <div class="p-0 card-body">
            <div class="table-responsive scroll-sm">
                <table class="table mb-0 bordered-table sm-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{ $lang->data['date'] ?? 'Date' }}</th>
                            <th scope="col" class="">{{ $lang->data['purchase'] ?? 'Purchase' }}</th>
                            <th scope="col" class="">{{ $lang->data['supplier'] ?? 'Supplier' }}</th>
                            <th scope="col" class="">{{ $lang->data['amount'] ?? 'Amount' }}</th>
                            <th scope="col" class="">{{ $lang->data['payment_mode'] ?? 'Payment Mode' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase_payments as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="">
                                    <p>{{ $item->created_at->format('Y-m-d') }}</p>
                                    <p>
                                        {{ $item->user->name ?? '' }}
                                    </p>
                                </td>
                                <td class="">
                                    <p>#{{ $item->purchase?->purchase_number }}</p>
                                </td>
                                <td class="">
                                    <p>{{ $item->supplier->name }}</p>
                                </td>
                                <td class="">
                                    <p>{{ getCurrency() }} {{ number_format($item->paid_amount, 2) }}</p>
                                </td>
                                <td class="">
                                    <p>
                                        {{ getpaymentMode($item->payment_method) }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($purchase_payments) == 0)
                    <x-empty-item />
                @endif
            </div>
        </div>
    </div>
</div>
