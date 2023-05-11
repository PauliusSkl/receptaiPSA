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
    <div class="container">
<<<<<<< HEAD
        <a href="/user/create_recipe" class="d-block btn btn-primary">Create</a>
        <a href="/user/show_recipes" class="d-block btn btn-primary">Recipes</a>
        <a href="/user/carts" class="d-block btn btn-primary">Carts</a>
=======
        <a href="/user/create_recipe" class="btn btn-primary">Create</a>
        <a href="/user/show_recipes" class="btn btn-primary">Recipes</a>
        <a href="/user/cart" class="btn btn-primary">Cart</a>
>>>>>>> main
    </div>
</x-app-layout>
