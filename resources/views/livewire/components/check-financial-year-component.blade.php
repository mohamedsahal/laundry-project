<div>
    <div class="modal fade " id="check-financial-year" tabindex="-1" role="dialog" aria-labelledby="payment"
        aria-hidden="true" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16  border border-top-0 border-start-0 border-end-0">
                    <iconify-icon icon="material-symbols:error-outline" class="text-danger tw-pr-2 tw-text-xl"></iconify-icon>
                    <h6 class="modal-title  text-danger tw-font-bold" id="payment">
                        {{ $lang->data['error'] ?? 'Error' }}</h6>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            <div class="text-primary tw-font-bold">{{ $lang->data['financial_year_not_created'] ?? 'Financial year not created' }}.</div>
                            <p class="text-md">{{ $lang->data['financial_year_line_1'] ?? 'It looks like you have not yet created a financial year or has not set it as active.' }}
                            </p>
                            <li class="text-md">{{ $lang->data['financial_year_line_2'] ?? 'Create a financial year from the tools section' }}
                            </li>
                            <li class="text-md">{{ $lang->data['financial_year_line_3'] ?? 'Set the created financial year in master settings' }}
                            </li>
                        </div>
                    </div>
                    @can('setting_financial_year')
                    <div class="modal-footer">
                        <a href="{{ route('settings.financial-year') }}"
                            class="btn btn-primary">{{ $lang->data['add_financial_year'] ?? 'Add financial year' }}</a>
                    </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>

    @push('js')
        @if ($no_financial_year)
            <script>
                var myModal = new bootstrap.Modal(document.getElementById('check-financial-year'))
                myModal.show()

                console.log('hey there')
            </script>
        @endif
    @endpush

</div>
