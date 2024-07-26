@extends('layouts.app')

@section('content')
    <h1>Produtos</h1>
    <ul>
        @foreach ($products as $product)
            <li>
                <strong>{{ $product->name }}</strong> - {{ $product->price }}
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit">Adicionar ao carrinho</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
