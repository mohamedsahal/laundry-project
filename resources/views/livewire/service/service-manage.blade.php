<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $lang->data['add_service'] ?? 'Add Service' }}</h5>
        </div>
        <div class="card-body ">
            <div class="row mb-20">
                <div class="col-sm-6">
                    <div class="tw-flex tw-items-center tw-gap-4">
                        @if($icon_type == 1)
                        <label
                            class="upload-file h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1"
                            for="upload-file" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <iconify-icon icon="solar:camera-outline"
                                class="text-xl text-secondary-light"></iconify-icon>
                            <span class="fw-semibold text-secondary-light">{{ $lang->data['upload'] ?? 'Upload' }}</span>
                        </label>
                        @else
                        <label x-data=""
                            class="upload-file h-120-px w-120-px border input-form-light tw-relative radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1"
                            for="upload-file" @click="$refs.fileInput.click()">
                            <div class="tw-absolute tw-h-full tw-w-full t">
                                @if($file)
                                <img src="{{ $file->temporaryUrl() }}"
                                    class="rounded bg-light tw-h-full tw-w-full tw-object-cover">
                                @endif
                            </div>
                            <div class="tw-flex tw-flex-col tw-items-center">
                                <iconify-icon   icon="solar:camera-outline"
                                class="text-xl text-secondary-light"></iconify-icon>
                            <span class="fw-semibold text-secondary-light">{{ $lang->data['upload'] ?? 'Upload' }}</span>
                            </div>
                            
                            <input type="file" x-ref="fileInput" class="tw-hidden" wire:model="file" accept="image/png, jpeg, jpg, svg, webp, gif, ico, bmp"/>
                        </label>
                        @endif
                        <div class="">
                            <label for="application_name"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">
                                {{ $lang->data['service_name'] ?? 'Service Name' }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" required autofocus class="form-control radius-8" id="application_name"
                                placeholder="{{ $lang->data['enter_service_name'] ?? 'Enter Service Name' }}"
                                wire:model="service_name">
                            @error('service_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3 text-right ">
                            <div class="avatar avatar-xl">
                                @if ($imageicon)
                                <img src="{{ asset('assets/img/service-icons/' . $imageicon['path']) }}"
                                    class="rounded bg-light p-2">
                                @endif
                            </div>
                        </div>
                    </div>
                    @error('icon')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 tw-mt-6">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ $lang->data['service_type'] ?? 'Service Type' }}</th>
                                    <th scope="col">{{ $lang->data['service_price'] ?? 'Service Price' }}</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inputs as $key => $value)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="text-lg text-secondary-light fw-semibold flex-grow-1">{{ $loop->index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <select name="#0" class="form-select form-select-sm" wire:model="servicetypes.{{ $value }}">
                                            <option value="">{{ $lang->data['select_service_type'] ?? 'Select A Service Type' }}</option>
                                            @foreach ($service_types as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->service_type_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('servicetypes.' . $value)
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" name="#0" class="form-control form-control-sm" placeholder="" wire:model="prices.{{ $value }}" value="100">
                                        @error('prices.' . $value)
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn rounded-pill btn-outline-danger-600 radius-8 tw-h-10 tw-w-10 d-flex align-items-center justify-content-center gap-2" wire:click.prevent="remove({{ $key }},{{ $value }})">
                                            <iconify-icon icon="mdi:trash-outline" class="text-xl"></iconify-icon>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button type="button" class="tw-rounded-full radius-8 tw-h-6 tw-w-6 d-flex align-items-center justify-content-center gap-2 tw-animate-pulse tw-bg-emerald-500" wire:click="add({{ $inputi }})">
                                            <iconify-icon icon="material-symbols:add" class="text-xl tw-text-white"></iconify-icon>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <button type="reset"
                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8">
                        {{ $lang->data['reset'] ?? 'Reset' }}
                    </button>
                    <button type="submit"
                        class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="save">{{ $lang->data['submit'] ?? 'Submit' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $lang->data['select_icon'] ?? 'Select Icon' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" x-data="">
                    <div class="row">
                        @foreach ($files as $key => $value)
                        <div class="col-1 customwidth m-2 customhover1" wire:click="selectIcon({{ $key }})">
                            <img src="{{ asset('assets/img/service-icons/' . $value['path']) }}"
                                class="img-fluid">
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ $lang->data['close'] ?? 'Close' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>