<div class="flex justify-center items-center bg-black/70 border-4 border-[var(--color-trans-light-blue)] p-4 md:p-8 md:px-12 my-12 shadow-search lg:-mx-12">
    <div class="w-full max-w-3xl">
        <div class="text-xl md:text-2xl font-bold text-[var(--color-trans-pink)] text-center">Sign up for our newsletter</div>

        <div id="error-message" class="hidden mt-4 text-sm text-[var(--color-retro-red)] bg-red-900/20 border border-red-400 rounded p-3">
            Your subscription could not be validated.
        </div>
        <div id="success-message" class="hidden mt-4 text-sm text-[var(--color-retro-green)] bg-green-900/20 border border-green-400 rounded p-3">
            Your subscription was successful.
        </div>

        <form id="sib-form" class="w-full mt-4" method="POST" action="{{ $page->brevo_form_action }}" data-type="subscription" novalidate>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="md:col-span-2">
                    <label for="EMAIL" class="block text-sm font-semibold text-[var(--color-trans-white)] mb-1">
                        Enter your email address to subscribe
                    </label>
                    <input type="email" id="EMAIL" name="EMAIL" required autocomplete="email"
                           placeholder="e.g. name@domain.com"
                           class="text-sm w-full rounded-none px-3 py-3 border-2 border-[var(--color-trans-pink)] focus:ring-2 focus:ring-[var(--color-trans-light-blue)] focus:outline-none bg-gray-800 text-[var(--color-trans-white)] placeholder-[var(--color-trans-light-blue)]">
                    <p class="mt-1 text-xs text-[var(--color-trans-light-blue)]">Provide your email address to subscribe.</p>
                </div>

                <div>
                    <label for="FIRSTNAME" class="block text-sm font-semibold text-[var(--color-trans-white)] mb-1">
                        First name
                    </label>
                    <input type="text" id="FIRSTNAME" name="FIRSTNAME" maxlength="200" required autocomplete="given-name"
                           placeholder="Your first name"
                           class="text-sm w-full rounded-none px-3 py-3 border-2 border-[var(--color-trans-pink)] focus:ring-2 focus:ring-[var(--color-trans-light-blue)] focus:outline-none bg-gray-800 text-[var(--color-trans-white)] placeholder-[var(--color-trans-light-blue)]">
                </div>

                <div>
                    <label for="LASTNAME" class="block text-sm font-semibold text-[var(--color-trans-white)] mb-1">
                        Last name
                    </label>
                    <input type="text" id="LASTNAME" name="LASTNAME" maxlength="200" required autocomplete="family-name"
                           placeholder="Your last name"
                           class="text-sm w-full rounded-none px-3 py-3 border-2 border-[var(--color-trans-pink)] focus:ring-2 focus:ring-[var(--color-trans-light-blue)] focus:outline-none bg-gray-800 text-[var(--color-trans-white)] placeholder-[var(--color-trans-light-blue)]">
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-start gap-2 text-sm text-[var(--color-trans-white)]">
                        <input type="checkbox" id="OPT_IN" name="OPT_IN" value="1" required
                               class="mt-1 h-4 w-4 border-2 border-[var(--color-trans-pink)] bg-gray-800 accent-[var(--color-trans-pink)]">
                        <span>I agree to the terms and to receive the newsletter</span>
                    </label>
                    <p class="mt-1 text-xs text-[var(--color-trans-light-blue)]">
                        You can unsubscribe at any time using the link in our newsletter.
                    </p>
                </div>

                <div class="md:col-span-2">
                    <div class="cf-turnstile g-recaptcha" id="sib-captcha"
                         data-sitekey="{{ $page->turnstile_site_key }}"
                         data-callback="handleCaptchaResponse"
                         data-language="en"></div>
                    <p class="mt-1 text-xs text-[var(--color-trans-light-blue)]">
                        Form protected by Cloudflare Turnstile
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <p class="text-xs text-[var(--color-trans-light-blue)]">
                    We will use your email only to send updates about my web development work.
                    For any inquiries, contact me at
                    <a class="underline text-[var(--color-trans-pink)] hover:text-[var(--color-trans-light-blue)]" href="https://www.sofiavicedomini.me/contact" target="_blank" rel="noopener">www.sofiavicedomini.me/contact</a>.
                </p>
            </div>

            <div class="mt-4 flex justify-start">
                <button type="submit"
                        class="text-sm rounded-none px-4 md:px-8 py-3 font-medium bg-[var(--color-trans-pink)] text-[var(--color-trans-white)] hover:bg-[var(--color-trans-light-blue)] transition-colors duration-150 border-2 border-[var(--color-trans-pink)] hover:border-[var(--color-trans-light-blue)]"
                        style="box-shadow: 0 0 10px var(--color-trans-pink);">
                    SUBSCRIBE
                </button>
            </div>

            <input type="text" name="email_address_check" value="" class="hidden" aria-hidden="true">
            <input type="hidden" name="locale" value="en">
        </form>

        <script>
            // Alias required by Brevo (grecaptcha) pointing to Cloudflare Turnstile
            function handleCaptchaResponse() {
                var event = new Event('captchaChange');
                document.getElementById('sib-captcha').dispatchEvent(event);
                window.grecaptcha = window.turnstile;
            }

            // Brevo localization/messages
            window.REQUIRED_CODE_ERROR_MESSAGE = 'Select a country code';
            window.LOCALE = 'en';
            window.EMAIL_INVALID_MESSAGE = window.SMS_INVALID_MESSAGE = "The information provided is invalid. Please check the field format and try again.";
            window.REQUIRED_ERROR_MESSAGE = "This field cannot be left blank.";
            window.GENERIC_INVALID_MESSAGE = "The information provided is invalid. Please check the field format and try again.";
            window.translation = {
                common: {
                    selectedList: '{quantity} selected list',
                    selectedLists: '{quantity} selected lists',
                    selectedOption: '{quantity} selected option',
                    selectedOptions: '{quantity} selected options',
                }
            };
            var AUTOHIDE = Boolean(0);
        </script>
        <script defer src="https://sibforms.com/forms/end-form/build/main.js"></script>
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    </div>
</div>
