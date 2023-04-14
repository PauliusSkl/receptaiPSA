<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin dashboard') }}
        </h2>
    </x-slot>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="container" style="width: 50%; margin-left:40%; margin-top: 2%">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Delete product</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $product->name }}</h6>
                    <p class="card-text">Are you sure you want to delete this product?</p>
                    <form action="/admin/products/{{ $product->id }}/delete" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fa-solid fa-trash"></i>
                            Delete</button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
