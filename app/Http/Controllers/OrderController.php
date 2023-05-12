<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\BarboraAPI;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function SubmitAndValidate(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'additional_info' => 'required',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        $cartItems = $cart->products;

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        //Create new order with cart 
        $order = new Order();
        $order->user_id = Auth::id();
        $order->address = $request->input('address');
        $order->text = $request->input('additional_info');
        $order->save();

        //Attach products to order
        foreach ($cartItems as $item) {
            $order->products()->attach($item->id, ['quantity' => $item->pivot->quantity, 'price' => $item->pivot->price]);
        }
        BarboraAPI::ProccessCreateQuery($order);
        //Updae order status
        $order->status = 'In progress';
        $order->save();
        //Delete cart
        $cart->products()->detach();

        return redirect('/redirect')->with('error', 'Order submitted!');
    }

    public function OpenOrderPage()
    {
        return view('player.OrderCart.OrderPage');
    }

    public function OpenAdminOrderPage()
    {
        //Get all orders
        $orders = Order::all();
        BarboraAPI::CheckOrderStatus($orders);
        $orders = Order::all();
        return view('admin.Orders.AdminOrderListPage', compact('orders'));
    }

    public function FinishOrder($id)
    {
        $order = Order::find($id);
        $order->status = 'Completed';
        $order->save();
        return redirect()->back()->with('error', 'Order completed!');
    }

    public function CancelOrder($id)
    {
        $order = Order::find($id);
        BarboraAPI::CancelOrder($order);
        return redirect()->back()->with('error', 'Order canceled!');
    }
}
