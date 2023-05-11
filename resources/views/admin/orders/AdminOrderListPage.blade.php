<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin dashboard') }}
        </h2>
    </x-slot>
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    {{-- List with orders data, each has button to end --}}
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Address</th>
                    <th scope="col">Additional info</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->user_id }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->additional_info }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if ($order->status == 'Finished')
                                <form action="{{ url('/admin/orders/complete', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Complete</button>
                                </form>
                            @elseif ($order->status != 'Completed' && $order->status != 'Canceled')
                                <form action="{{ url('/admin/orders/cancel', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


</x-app-layout>
