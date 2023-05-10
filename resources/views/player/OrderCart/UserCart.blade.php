<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My rating: {{ Auth::user()->rating }}
        </h2>
    </x-slot>
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Display  cart info --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Cart</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $cartItem)
                            <tr>
                                <th scope="row">{{ $cartItem->name }}</th>
                                <td>{{ $cartItem->pivot->quantity }}</td>
                                <td>{{ $cartItem->pivot->price }}</td>
                                <td>
                                    <form action="{{ url('/user/cart', $cartItem->pivot->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Delete product</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3>Total Price: {{ $totalPrice }}</h3>
                <a href="{{ url('/user/cart/order') }}" class="btn btn-primary">Checkout</a>
                {{-- <form action="{{ url('/user/cart/order') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Order</button>
                </form> --}}
            </div>
        </div>
</x-app-layout>
