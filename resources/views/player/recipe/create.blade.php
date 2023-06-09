<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User dashboard') }}
        </h2>
    </x-slot>
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ url('/user/create_recipe') }}">
        @csrf

        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
        </div>

        <div>
            <label for="preparation">Text:</label>
            <textarea name="preparation" id="preparation"></textarea>
        </div>

        <div>
            <label for="products[]">Products:</label>
            <select name="products[]" id="products" multiple>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="quantities">Quantities</label>
            @foreach ($products as $product)
                <input type="text" name="quantities[{{ $product->id }}]" id="quantities">
            @endforeach
        </div>


        <label for="tools">Tools:</label>
        <select name="tools[]" class="form-control" multiple>
            @foreach ($tools as $tool)
                <option value="{{ $tool->id }}">{{ $tool->name }}</option>
            @endforeach
        </select>


        <div class="form-group">
            <label for="tools">Kitchen Categories:</label>
            <select name="categories[]" class="form-control" multiple>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Create Recipe</button>
    </form>

</x-app-layout>
