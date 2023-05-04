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
    <h1 style="text-align: center; font-size: 50px;">Rekomendacijos</h1>
    <div class="row">
        @foreach ($recommendedRecipes as $recipe)
            <div class="col-md-4">
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
                </div>
            </div>
        @endforeach
    </div>

    {{-- @else
        <h1 style="text-align: center; font-size: 50px;">Nera rekomendaciju</h1>
    @endif --}}
    <h1 style="text-align: center; font-size: 50px;">Visi receptai</h1>
    <div class="row">
        @foreach ($recipes as $recipe)
            <div class="col-md-4">
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
                </div>
            </div>
        @endforeach
    </div>



</x-app-layout>
