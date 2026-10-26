@props([
    'id' => 'phone',
    'name' => 'phone',
    'label' => null,
    'value' => '',
    'required' => false,
    'class' => 'form-control',
])

@if ($label)
    <label for="{{ $id }}">{{ $label }}</label>
@endif
<input
    id="{{ $id }}"
    name="{{ $name }}"
    type="tel"
    class="{{ $class }} js-international-phone"
    value="{{ \App\Support\PhoneNumber::forInput($value) }}"
    {{ $required ? 'required' : '' }}
>
<input type="hidden" name="{{ $name }}_region" value="">

@once
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.6/dist/css/intlTelInput.css">
    <style>
        .iti {
            display: block;
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.6/dist/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInputs = Array.from(document.querySelectorAll('.js-international-phone'));

            phoneInputs.forEach(function (phoneInput) {
                if (phoneInput.dataset.phoneInputReady) return;

                phoneInput.dataset.phoneInputReady = 'true';
                window.intlTelInput(phoneInput, {
                    initialCountry: 'id',
                    separateDialCode: true,
                    countrySelectorMode: 'DROPDOWN',
                    countrySearch: true,
                });
            });

            const forms = new Set(phoneInputs.map(input => input.closest('form')).filter(Boolean));
            forms.forEach(function (form) {
                form.addEventListener('submit', async function (event) {
                    if (form.dataset.internationalPhoneSubmitting) return;

                    event.preventDefault();
                    try {
                        window.phoneUtilsPromise = window.phoneUtilsPromise ||
                            window.intlTelInput.attachUtils(() =>
                                import('https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.6/dist/js/utils.js')
                            );
                        await window.phoneUtilsPromise;
                    } catch (error) {
                        window.alert('Phone validation is temporarily unavailable. Please try again.');
                        return;
                    }

                    for (const phoneInput of form.querySelectorAll('.js-international-phone')) {
                        const iti = window.intlTelInput.getInstance(phoneInput);
                        if (!iti.isValidNumber()) {
                            phoneInput.setCustomValidity('Enter a valid phone number for the selected country.');
                            phoneInput.reportValidity();
                            phoneInput.setCustomValidity('');
                            return;
                        }

                        const regionInput = form.querySelector('[name="' + phoneInput.name + '_region"]');
                        if (regionInput) {
                            regionInput.value = (iti.getSelectedCountry()?.iso2 || 'id').toUpperCase();
                        }
                        phoneInput.value = iti.getNumber();
                    }

                    form.dataset.internationalPhoneSubmitting = 'true';
                    form.requestSubmit();
                });
            });
        });
    </script>
@endonce
