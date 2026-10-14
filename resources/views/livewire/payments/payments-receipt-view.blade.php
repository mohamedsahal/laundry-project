<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder=" {{ $lang->data['search_here'] ?? 'Search here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col" class=""> {{ $lang->data['date'] ?? 'Date' }}</th>
                      <th scope="col" class="">{{ $lang->data['order'] ?? 'Order' }}#</th>
                      <th scope="col" class=""> {{ $lang->data['customer'] ?? 'Customer' }}</th>
                      <th scope="col" class="">{{ $lang->data['amount'] ?? 'Amount' }}</th>
                      <th scope="col" class=""> {{ $lang->data['payment_type'] ?? 'Payment Type' }}</th>
                      <th scope="col" class=""> {{ $lang->data['note'] ?? 'Note' }}</th>  
                    </tr>
                  </thead>
                  <tbody>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($payments as $row)
                        <tr>
                            <td>
                                <p class="">{{ $i++ }}</p>
                            </td>
                            <td>
                                <p class="">{{ \Carbon\Carbon::parse($row->payment_date)->format('d/m/Y') }}</p>
                            </td>
                            <td>
                                <p class="">#{{ $row->order ? $row->order->order_number : ''}}</p>
                            </td>
                            <td>
                            <p class="">{{ $row->customer ? $row->customer->name : ($lang->data['walk_in_customer'] ?? 'Walk In Customer')}}</p>
                                <p class="">{{$row->customer ? getCountryCode() : ''}} {{ $row->customer ? $row->customer->phone : '' }}</p>
                            </td>
                            <td>
                                <p class="text-primary">{{ getFormattedCurrency($row->received_amount) }}</p>
                            </td>
                            <td>
                                <span class="badge text-sm fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4 text-white">
                                    {{ getpaymentMode($row->payment_type) }}
                                </span>
                            </td>
                            <td>
                                <p class="">{{ $row->payment_note ? $row->payment_note : '-'}}</p>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                  </tbody>
                </table>

                @if(count($payments) == 0)
                    <x-empty-item/>
                @endif

                @if($hasMorePages)
                <div x-data="{
                        init () {
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
                        Loading...
                        <div class="spinner-grow d-inline-flex mx-2 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{ $lang->data['add_new_customer'] ?? 'Add New Customer' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">   
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['customer_name'] ?? 'Customer Name' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_customer_name'] ?? 'Enter Customer Name' }}" wire:model="name" >
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['phone_number'] ?? 'Phone Number' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}" wire:model="name" >
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['email'] ?? 'Email' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}" wire:model="name" >
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['tax_number'] ?? 'Tax Number' }}</label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_tax_number'] ?? 'Enter Tax Number' }}" wire:model="name" >
                            </div>
                            <div class="col-12 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['address'] ?? 'Address' }}</label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_address'] ?? 'Enter Address' }}" wire:model="name" ></textarea>
                            </div>
                            <div class="col-12 tw-mt-6">
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch1" checked="">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch1">Active</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8"> 
                                {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8"> 
                                {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>