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

    <h1 style="text-align: center; font-size: 50px;">Recepto informacija</h1>
    <div style="width: 50%; margin: auto;">
        <div class="card">
            <div class="card-header">
                {{ $recipe->name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Preperiation:</h5>
                {{ $recipe->preparation }}
            </div>
            <div class="card-body">
                Rating: {{ $recipe->rating }}
                Calories: {{ $recipe->calories }}
                Time: {{ $recipe->preparation_time }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Ingredients:</h5>
                <ul>
                    @foreach ($recipe->products as $product)
                        <li>{{ $product->name }} - {{ $product->pivot->quantity }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="card-body">
                <h5 class="card-title">Irankiai:</h5>
                <ul>
                    @foreach ($recipe->tools as $tool)
                        <li>{{ $tool->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="card-body">
                <h5 class="card-title">Virtive:</h5>
                <ul>
                    @foreach ($recipe->kitchen_categories as $category)
                        <li>{{ $category->name }}</li>
                    @endforeach
                </ul>
            </div>

            <a href="{{ url('/user/start_making', $recipe->id) }}" class="btn btn-danger">Pradeti gaminima</a>
            <a href="{{ url('/user/manage_products', $recipe->id) }}" class="btn btn-primary">Valdyti produktus(Prideti
                i krepseli)</a>
        </div>
    </div>

</x-app-layout>
