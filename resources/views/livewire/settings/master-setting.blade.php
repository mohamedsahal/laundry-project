<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $lang->data['application_details'] ?? 'Application Details' }}</h5>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="application_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['application_name'] ?? 'Application Name' }} <span
                                class="text-danger">*</span>
                        </label>
                        <input type="text" required autofocus class="form-control radius-8" id="application_name"
                            wire:model="default_application_name">
                        @error('default_application_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="app_logo" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['app_logo'] ?? 'App Logo' }}
                        </label>
                        <input type="file" class="form-control radius-8" id="app_logo" wire:model="default_logo">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="favicon" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['favicon'] ?? 'Favicon' }}
                        </label>
                        <input type="file" class="form-control radius-8" id="favicon" wire:model="default_favicon">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="phone_number" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['phone_number'] ?? 'Phone Number' }} <span class="text-danger">*</span>
                        </label>
                        <input type="number" required class="form-control radius-8" id="phone_number"
                            placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}"
                            wire:model="default_phone_number">
                        @error('default_phone_number')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['email'] ?? 'Email' }} <span class="text-danger">*</span>
                        </label>
                        <input type="email" required class="form-control radius-8" id="email"
                            placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}" wire:model="email">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['password'] ?? 'Password' }}
                        </label>
                        <input type="password" required class="form-control radius-8" id="password"
                            placeholder="{{ $lang->data['password'] ?? 'Password' }}" wire:model="password">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="default_delivery_day" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['default_delivery_date'] ?? 'Delivery In Day' }}
                        </label>
                        <input type="number" required class="form-control radius-8" id="default_delivery_day"
                            placeholder="{{ $lang->data['delivery_date_placeholder'] ?? 'Enter the no of days the items will be delivered. Use 0 for same day.' }}" wire:model="default_delivery_day">
                            @error('default_delivery_day')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="service_image_upload" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['service_image_upload'] ?? 'Service Image Upload' }}
                        </label>
                        <select id="service_image_upload" class="form-select radius-8" wire:model="service_image_upload_type">
                            <option value="1">{{ $lang->data['file_tools'] ?? 'File Tools' }}</option>
                            <option value="2">{{ $lang->data['from_service_image_upload'] ?? 'From Service Image Upload' }}</option>
                        </select>
                        @error('service_image_upload')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header border-top">
            <h5 class="card-title mb-0">{{ $lang->data['finance_settings'] ?? 'Finance Settings' }}</h5>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="currency_symbol" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['currency_symbol'] ?? 'Currency Symbol' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control radius-8" id="currency_symbol"
                            wire:model="default_currency">
                        @error('default_currency')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="tax_percentage" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['tax_percentage'] ?? 'Tax Percentage' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control radius-8" id="tax_percentage"
                            wire:model="default_tax_percentage">
                        @error('default_tax_percentage')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="financial_year" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['select_financial_year'] ?? 'Financial Year' }} <span class="text-danger">*</span>
                        </label>
                        @php
                        $inline_financial_year = App\Models\FinancialYear::latest()->get();
                        @endphp
                        <select id="financial_year" class="form-select radius-8" wire:model="default_financial_year">
                            <option value="">
                                {{ $lang->data['select_financial_year'] ?? 'Select A Financial Year' }}
                            </option>
                            @foreach ($inline_financial_year as $row)
                            <option value="{{ $row->id }}">{{ $row->year }} @if ($row->starting_date)
                                [ {{ \Carbon\Carbon::parse($row->starting_date)->format('d/m/Y') }} to
                                {{ \Carbon\Carbon::parse($row->ending_date)->format('d/m/Y') }} ]
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('default_financial_year')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="currency_alignment"
                            class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['currency_alignment'] ?? 'Currency Alignment' }}
                        </label>
                        <select id="currency_alignment" class="form-select radius-8" wire:model="default_currency_alignment">
                            <option value="1">{{ $lang->data['left'] ?? 'Left' }}</option>
                            <option value="2">{{ $lang->data['right'] ?? 'Right' }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="tax_type" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['tax_type'] ?? 'Tax Type' }}
                        </label>
                        <select id="tax_type" class="form-select radius-8" wire:model="default_tax_mode">
                            <option value="1">{{ $lang->data['excluding_tax'] ?? 'Excluding Tax' }}</option>
                            <option value="2">{{ $lang->data['including_tax'] ?? 'Including Tax' }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header border-top">
            <h5 class="card-title mb-0">{{ $lang->data['firm_address'] ?? 'Firm Address' }}</h5>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="country" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['country'] ?? 'Country' }} <span class="text-danger">*</span>
                        </label> 
                        @php
                        $inline_countries = App\Models\Country::latest()->get();
                        @endphp
                        <select id="country" class="form-select radius-8" wire:model="default_country">
                            @foreach ($inline_countries as $row)
                            <option value="{{ $row->country_code }}">{{ $row->country_name }} [{{ $row->country_code }}]</option>
                            @endforeach
                        </select>
                        @error('default_country')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="state" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['state'] ?? 'State' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control radius-8" id="state" wire:model="default_state">
                        @error('default_state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="city" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['city'] ?? 'City' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control radius-8" id="city" wire:model="default_city">
                        @error('default_city')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="district" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['district'] ?? 'District' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control radius-8" id="district" wire:model="default_district">
                        @error('default_district')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="zip_code" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['zip_code'] ?? 'Zip Code' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control radius-8" id="zip_code" wire:model="default_zip_code">
                        @error('default_zip_code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="store_email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['store_email'] ?? 'Store Email' }} <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control radius-8" id="store_email" wire:model="store_email">
                        @error('store_email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="store_tax" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['store_tax_number'] ?? 'Store Tax Number' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control radius-8" id="store_tax" wire:model="store_tax">
                        @error('store_tax')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="country_code" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['country_code'] ?? 'Country Code' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control radius-8" id="country_code" placeholder="{{ $lang->data['country_code'] ?? 'Country Code' }} (+91)" wire:model="country_code">
                        @error('country_code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="mb-20">
                        <label for="default_address" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['address'] ?? 'Address' }}
                        </label>
                        <textarea id="default_address" class="form-control radius-8 tw-resize-none" wire:model="default_address"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header border-top">
            <h5 class="card-title mb-0">{{ $lang->data['other_settings'] ?? 'Other Settings' }}</h5>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="printer_pos" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['printer_pos'] ?? 'Printer POS' }}
                        </label>
                        <select id="printer_pos" class="form-select radius-8" wire:model="default_printer">
                            <option value="1">{{ $lang->data['a4'] ?? 'A4' }}</option>
                            <option value="2">{{ $lang->data['thermal'] ?? 'Thermal' }}</option>
                            <option value="3">{{ $lang->data['thermal_80mm'] ?? 'Thermal 80mm' }}</option>
                            <option value="4">{{ $lang->data['thermal_50mm'] ?? 'Thermal 50mm' }}</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <button type="reset"
                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="initialValue()">
                        {{ $lang->data['reset'] ?? 'Reset' }}
                    </button>
                    <button type="submit"
                        class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="save()">
                        {{ $lang->data['save'] ?? 'Save' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>