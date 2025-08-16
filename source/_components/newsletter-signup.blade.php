<div class="flex justify-center items-center bg-black/70 border-4 border-[var(--color-trans-light-blue)] p-4 md:p-8 md:px-12 my-12 shadow-search lg:-mx-12">
    <form id="newsletter-form" class="w-full max-w-3xl">
        <div class="flex flex-col items-center w-full gap-3 md:gap-4">
            <div class="text-xl md:text-2xl font-bold text-[var(--color-trans-pink)] text-center">Sign up for our newsletter</div>
            <div class="flex w-full max-w-lg">
                <input type="email" required name="email" placeholder="Email address" class="text-sm flex-1 rounded-none px-3 py-3 border-2 border-[var(--color-trans-pink)] focus:ring-2 focus:ring-[var(--color-trans-light-blue)] focus:outline-none bg-gray-800 text-[var(--color-trans-white)] placeholder-[var(--color-trans-light-blue)]">
                <button type="submit" class="text-sm rounded-none px-4 md:px-8 py-3 font-medium bg-[var(--color-trans-pink)] text-[var(--color-trans-white)] hover:bg-[var(--color-trans-light-blue)] transition-colors duration-150 border-2 border-[var(--color-trans-pink)] hover:border-[var(--color-trans-light-blue)]" style="box-shadow: 0 0 10px var(--color-trans-pink);">Subscribe</button>
            </div>
            <div id="newsletter-message" class="text-sm text-[var(--color-trans-white)]"></div>
        </div>
    </form>

    <script>
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[name="email"]').value;
            const messageDiv = document.getElementById('newsletter-message');
            const apiKey = '{{ $page->brevo_api_key }}';
            const listId = '{{ $page->brevo_list_id }}';

            if (!email) {
                messageDiv.textContent = 'Please enter your email address.';
                return;
            }

            fetch('https://api.brevo.com/v3/contacts', {
                method: 'POST',
                headers: {
                    'accept': 'application/json',
                    'api-key': apiKey,
                    'content-type': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    listIds: [parseInt(listId)]
                })
            })
            .then(response => {
                if (response.ok) {
                    messageDiv.textContent = 'Thank you for subscribing!';
                    messageDiv.classList.add('text-[var(--color-retro-green)]');
                } else {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Subscription failed.');
                    });
                }
            })
            .catch(error => {
                messageDiv.textContent = error.message || 'An error occurred. Please try again.';
                messageDiv.classList.add('text-[var(--color-retro-red)]');
            });
        });
    </script>
</div>
