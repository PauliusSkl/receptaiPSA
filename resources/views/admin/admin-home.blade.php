<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin dashboard') }}
        </h2>
    </x-slot>
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <a href="/admin/products" class="btn btn-primary">Products</a>
    </div>


</x-app-layout>
