<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin dashboard') }}
        </h2>
    </x-slot>
    <div class="container" style="width: 50%; margin-left:20%">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form action="/admin/products/{{ $product->id }}/edit" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                    value="{{ $product->name }}">
                @error('name')
                    <p class="text-red-500 text-xs mt-1"> {{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="score_multiplier">Multiplier</label>
                <input type="number" class="form-control" id="score_multiplier" name="score_multiplier"
                    placeholder="Enter Multiplier" value="{{ $product->score_multiplier }}">
                @error('score_multiplier')
                    <p class="text-red-500 text-xs mt-1"> {{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px">Submit</button>
        </form>
    </div>
</x-app-layout>
