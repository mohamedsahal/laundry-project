<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $lang->data['theme'] ?? 'Theme' }}</h5>
        </div>
        <div class="card-body ">
            <div class="">
                <h6 class="text-xl mb-16">Theme Colors</h6>
                <div class="row gy-4">
                    <div class="col-xxl-2 col-md-4 col-sm-6">
                        <input class="form-check-input payment-gateway-input" name="payment-gateway" type="radio"
                            id="blue" hidden="" wire:model="selected_theme" value="default">
                        <label for="blue" class="payment-gateway-label border radius-8 p-8 w-100">
                            <span class="d-flex align-items-center gap-2">
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 tw-bg-[#0283FF] radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Blue</span>
                                </span>
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 tw-bg-[#BFDCFF] radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Focus</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-xxl-2 col-md-4 col-sm-6">
                        <input class="form-check-input payment-gateway-input" name="payment-gateway" type="radio"
                            id="magenta" hidden="" wire:model="selected_theme" value="magenta">
                        <label for="magenta" class="payment-gateway-label border radius-8 p-8 w-100">
                            <span class="d-flex align-items-center gap-2">
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-lilac-600 radius-4"></span>
                                    <span class="text-lilac-light text-md fw-semibold mt-8">Magenta</span>
                                </span>
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-lilac-100 radius-4"></span>
                                    <span class="text-lilac-light text-md fw-semibold mt-8">Focus</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-xxl-2 col-md-4 col-sm-6">
                        <input class="form-check-input payment-gateway-input" name="payment-gateway" type="radio"
                            id="orange" hidden="" wire:model="selected_theme" value="orange">
                        <label for="orange" class="payment-gateway-label border radius-8 p-8 w-100">
                            <span class="d-flex align-items-center gap-2">
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-warning-600 radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Orange</span>
                                </span>
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-warning-100 radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Focus</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-xxl-2 col-md-4 col-sm-6">
                        <input class="form-check-input payment-gateway-input" name="payment-gateway" type="radio"
                            id="green" hidden=""  wire:model="selected_theme" value="green">
                        <label for="green" class="payment-gateway-label border radius-8 p-8 w-100">
                            <span class="d-flex align-items-center gap-2">
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-success-600 radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Green</span>
                                </span>
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-success-100 radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Focus</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-xxl-2 col-md-4 col-sm-6">
                        <input class="form-check-input payment-gateway-input" name="payment-gateway" type="radio"
                            id="red" hidden=""  wire:model="selected_theme" value="red">
                        <label for="red" class="payment-gateway-label border radius-8 p-8 w-100">
                            <span class="d-flex align-items-center gap-2">
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-danger-600 radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Red</span>
                                </span>
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-danger-100 radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Focus</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-xxl-2 col-md-4 col-sm-6">
                        <input class="form-check-input payment-gateway-input" name="payment-gateway" type="radio"
                            id="blueDark" hidden=""  wire:model="selected_theme" value="blueDark">
                        <label for="blueDark" class="payment-gateway-label border radius-8 p-8 w-100">
                            <span class="d-flex align-items-center gap-2">
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-info-600 radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Blue Dark</span>
                                </span>
                                <span class="w-50 text-center">
                                    <span class="h-72-px w-100 bg-info-100 radius-4"></span>
                                    <span class="text-secondary-light text-md fw-semibold mt-8">Focus</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                        <button type="submit" wire:click.prevent="save"
                            class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8">
                            Save Change
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
