@extends('layouts.app')

@section('content')
    <h1>Carrinho de Compras</h1>
    <ul>
        @foreach ($cart as $productId => $details)
            <li>
                <strong>{{ $details['name'] }}</strong> - {{ $details['price'] }} - Quantidade: {{ $details['quantity'] }}
                <form action="{{ route('cart.remove', $productId) }}" method="POST">
                    @csrf
                    <button type="submit">Remover</button>
                </form>
            </li>
        @endforeach
    </ul>
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <input type="text" name="customer_name" placeholder="Seu nome">
        <input type="email" name="customer_email" placeholder="Seu email">
        <button type="submit">Finalizar Pedido</button>
    </form>
    <form action="{{ route('payment.pay') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="amount" value="{{ array_sum(array_column($cart, 'price')) }}">
        <div class="form-row">
            <label for="card-element">
                Cartão de Crédito ou Débito
            </label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>
        <button type="submit">Pagar</button>
    </form>
@endsection

@section('scripts')
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });
        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
@endsection
