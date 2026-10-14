<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12 overflow-hidden" x-data="initz()" x-init="start()">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $lang->data['twilio_sms_settings'] ?? 'Twilio SMS Settings' }}</h5>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label for="mail_host" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['account_sid'] ?? 'Account SID' }} <span
                                class="text-danger">*</span>
                        </label>
                        <input type="text" required autofocus class="form-control radius-8"
                            wire:model="accountsid">
                        @error('accountsid') <span class="text-danger">{{$message}}</span>  @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['auth_token'] ?? 'Auth Token' }} <span
                                class="text-danger">*</span>
                        </label>
                        <input type="text" required autofocus class="form-control radius-8"
                            wire:model="auth_token">
                        @error('auth_token') <span class="text-danger">{{$message}}</span>  @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{ $lang->data['twilio_number'] ?? 'Twilio Number' }} <span
                                class="text-danger">*</span>
                        </label>
                        <input type="text" required autofocus class="form-control radius-8" id="mail_username"
                            wire:model="twilio_number">
                        @error('twilio_number') <span class="text-danger">{{$message}}</span>  @enderror
                    </div>
                </div>
                <div class="col-sm-12 row mb-20 tw-pl-6 ">
                    <div class="form-switch switch-primary d-flex align-items-center gap-3 col-sm-4 lg:pt-0 pt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch1" checked  wire:model="enabled">
                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch1">{{ $lang->data['sms_enabled'] ?? 'SMS Enabled' }}</label>
                    </div>
                    <div class="form-switch switch-primary d-flex align-items-center gap-3 col-sm-4 lg:pt-0 pt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch11" checked="" wire:model="delivered_only">
                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch11">{{ $lang->data['delivered_sms_only'] ?? 'Delivered Status SMS only' }}</label>
                    </div>
                    <div class="form-switch switch-primary d-flex align-items-center gap-3 col-sm-4 lg:pt-0 pt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch12" checked="" wire:model="ready_to_deliver_only">
                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch12">{{ $lang->data['ready_to_deliver_sms_only'] ?? 'Ready to Deliver Status SMS only' }}</label>
                    </div>
                </div>
                <div class="col-12 ">
                    <hr>
                    <div class="tw-w-full tw-flex tw-gap-2 tw-mt-4 tw-mb-8">
                        <div class="tw-w-full tw-h-full tw-flex tw-flex-col">
                            <label class="form-label">{{ $lang->data['create_order'] ?? 'Create Order' }}</label>
                            <textarea name="#0" class="form-control tw-h-full" rows="10" x-ref="create" placeholder="" x-model="myCreateSMS"></textarea>
                        </div>
                        <div class="tw-grid tw-grid-cols-2 tw-w-[20rem] tw-gap-2 tw-pt-6">
                            <template x-for="(replace,index) in replacers">
                                <button class="btn  btn-outline-lilac-600 radius-8 " x-text="replace" type="button" @click="addText(index,1)"></button>
                            </template>
                        </div>
                    </div>
                    <hr>
                    <div class="tw-w-full tw-flex tw-gap-2 tw-mt-4">
                        <div class="tw-w-full tw-h-full tw-flex tw-flex-col">
                            <label class="form-label">{{$lang->data['status_change']??'Status Change'}}</label>
                            <textarea name="#0" class="form-control tw-h-full" rows="10" placeholder="" x-model="myStatusChange" x-ref="status" ></textarea>
                        </div>
                        <div class="tw-grid tw-grid-cols-2 tw-w-[20rem] tw-gap-2 tw-pt-6">
                            <template x-for="(replace,index) in replacers">
                                <button class="btn  btn-outline-lilac-600 radius-8 " x-text="replace" type="button" @click="addText(index,2)"></button>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <button type="submit"
                        class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="save()">{{ $lang->data['save'] ?? 'Save' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script>
        function initz() {
            return {
                replacers: @entangle('replacer'),
                myCreateSMS: '',
                myStatusChange: '',
                readyToDelivered: '',
                start() {
                    let myloadData = @js(trim(preg_replace('/\s+/', ' ', $create_order)));
                    let smyloadData = @js(trim(preg_replace('/\s+/', ' ', $status_change)));
                    this.myCreateSMS = myloadData;
                    this.myStatusChange = smyloadData;
                    this.readyToDelivered = rmyloadData;
                    this.$watch('myCreateSMS', value => @this.create_order = value);
                    this.$watch('myStatusChange', value => @this.status_change = value);
                },
                addText(replace, index) {
                    if (index == 1) {
                        var cursorPos = this.$refs.create.selectionStart;
                        v = this.myCreateSMS;
                        var textBefore = v.substring(0, cursorPos);
                        var textAfter = v.substring(cursorPos, v.length);
                        this.myCreateSMS = textBefore + replace + textAfter;
                        this.$refs.create.focus()
                    }
                    if (index == 2) {
                        var cursorPos = this.$refs.status.selectionStart;
                        v = this.myStatusChange;
                        var textBefore = v.substring(0, cursorPos);
                        var textAfter = v.substring(cursorPos, v.length);
                        this.myStatusChange = textBefore + replace + textAfter;
                        this.$refs.status.focus()
                    }
                    @this.addTextToItem(replace, index)
                },
            }
        }
    </script>
    @endpush
</div>