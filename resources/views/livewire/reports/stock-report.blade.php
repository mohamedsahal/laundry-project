<div class="dashboard-main-body">
    <div class="p-0 card h-100 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="flex-wrap gap-3 d-flex align-items-center">
                <div class="gap-1 d-flex tw-flex-col tw-relative">
                    <span class="fw-medium">{{ $lang->data['search_product'] ?? 'Search Product' }}</span>
                    <form class="navbar-search">
                        <input type="text" class="w-auto bg-base h-40-px" name="search"
                            placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </form>
                </div>
            </div>
        </div>
        <div class="p-0 card-body">
            <div class="table-responsive scroll-sm tw-min-h-[calc(100vh-16rem)]">
                <table class="table mb-0 bordered-table sm-table">
                    <thead>
                        <tr>
                            <th scope="col" class="">{{ $lang->data['#'] ?? '#' }}</th>
                            <th scope="col" class="">{{ $lang->data['product_name'] ?? 'Product' }}</th>
                            <th scope="col" class="">{{ $lang->data['available_stock'] ?? 'Available Stock' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $row)
                            <tr>
                                <td>
                                    <p class=""> {{ $loop->index + 1 }}
                                    </p>
                                </td>
                                <td>
                                    <p class="tw-text-black">
                                        <span class="font-weight-bold">{{ $row->name }}</span>
                                    </p>
                                </td>
                                <td>
                                    <p class="tw-text-black">{{ $row->current_stock }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tw-flex tw-items-center tw-justify-between tw-w-full tw-p-2 tw-gap-2">
                <div class="tw-flex tw-items-center tw-gap-4">
                    <div class="">{{ $lang->data['total_products'] ?? 'Total Products' }}: <span
                            class="tw-font-bold">{{ count($products) }}</span></div>
                    <div class="">{{ $lang->data['total_stock'] ?? 'Total Stock' }} : <span class="tw-font-bold">
                        {{ ($products->sum('current_stock'))}}</span></div>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2">
                    @can('report_download')
                        <button type="button" wire:click="downloadFile()"
                            class="px-16 btn btn-warning-100 text-warning-600 radius-8 py-9">{{ $lang->data['download_report'] ?? 'Download Report' }}</button>
                    @endcan

                    <a href="{{ url('admin/reports/print-report/stock-print') }}" target="_blank">
                        <button type="button"
                            class="px-16 btn btn-success-100 text-success-600 radius-8 py-9">{{ $lang->data['print_report'] ?? 'Print Report' }}</button>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
