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
    {{-- Form with address, additional info fields --}}
    <form method="POST" action="{{ url('/user/cart/order') }}">
        @csrf
        <div>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address">
            @error('address')
                <p class="text-red-500 text-xs
            mt-1"> {{ $message }}</p>
            @enderror

        </div>
        <div>
            <label for="additional_info">Additional info:</label>
            <textarea name="additional_info" id="additional_info"></textarea>
            @error('additional_info')
                <p class="text-red-500 text-xs
        mt-1"> {{ $message }}</p>
            @enderror
        </div>
        <button type="submit">Order</button>
    </form>

    {{-- <form action="{{ url('/user/cart/order') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Order</button>
                </form> --}}
</x-app-layout>
