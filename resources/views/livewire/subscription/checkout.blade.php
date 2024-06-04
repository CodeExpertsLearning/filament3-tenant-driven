<div class="flex justify-center items-center w-full h-full absolute">

    <div class="checkoutForm w-96 p-10 bg-gray-900 border border-gray-400 rounded">

        <div id="message"
            class="my-5 p-4 hidden w-full border border-red-600 bg-red-200 text-red-600 rounded flex gap-4 items-center">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>

            <span id="message-feedback"></span>
        </div>

        <h2 class="pb-2 border-b border-gray-300 text-white font-bold text-xl mb-10">Dados Pagamento Assinatura</h2>

        <input id="card-holder-name" type="text" placeholder="Nome no Cartão"
            class="w-full mb-10 rounded px-6 py-3 border border-gray-600">

        <!-- Stripe Elements Placeholder -->
        <div id="card-element" class="border border-gray-500 px-8 py-4 rounded bg-white"></div>

        <button id="card-button"
            class="px-4 py-2 border border-green-800 bg-green-600 rounded text-white font-bold mt-10"
            data-secret="{{ $intent->client_secret }}">
            Realizar Assinatura
        </button>

    </div>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            window.addEventListener('livewire:init', event => {
                const stripe = Stripe(
                    '{{ config('cashier.key') }}'
                );
                const elements = stripe.elements();
                const cardElement = elements.create('card');
                cardElement.mount('#card-element');

                const cardHolderName = document.getElementById('card-holder-name');
                const cardButton = document.getElementById('card-button');
                const clientSecret = cardButton.dataset.secret;

                cardButton.addEventListener('click', async (e) => {

                    const {
                        setupIntent,
                        error
                    } = await stripe.confirmCardSetup(
                        clientSecret, {
                            payment_method: {
                                card: cardElement,
                                billing_details: {
                                    name: cardHolderName.value
                                }
                            }
                        }
                    );
                    if (error) {
                        document.querySelector('div#message').classList.remove('hidden')
                        document.querySelector('span#message-feedback').textContent = error.message
                    } else {
                        Livewire.dispatch('charge', {
                            paymentMethod: setupIntent.payment_method
                        })
                    }
                });
            });
        </script>
    @endpush
</div>
