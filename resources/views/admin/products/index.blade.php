<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div style="display: flex; justify-content: center; margin-top:1rem;">
            <h3>Welcome to the Product page</h3>
        </div>
        @unless (count($products) == 0)
            <table class="table">
                <thead>
                <tbody>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Multiplier</th>
                        <th scope="col">Creator</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    @foreach ($products as $product)
                        <tr>
                            <td scope="row">{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->score_multiplier }}</td>
                            <td>{{ $product->user->name }}</td>
                            <td>
                                <a href="/admin/products/{{ $product->id }}/edit"
                                    class="btn btn-primary btn-sm mr-2">Edit</a>
                                <a href="/admin/products/{{ $product->id }}/delete"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No listings found</p>
        @endunless

        <a href="/admin/products/create" class="btn btn-success">Create</a>
    </div>
</x-app-layout>
