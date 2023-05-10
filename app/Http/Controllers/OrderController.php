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

        //Create new order with cart 
        $order = new Order();
        $order->user_id = Auth::id();
        $order->address = $request->input('address');
        $order->text = $request->input('additional_info');
        $order->save();

        $cart = Cart::where('user_id', Auth::id())->first();

        $cartItems = $cart->products;
        //if empty return back with error
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }
        // //Calculate total price
        // $totalPrice = 0;
        // foreach ($cartItems as $item) {
        //     $totalPrice += $item->pivot->price;
        // }
        // // $order->total_price = $totalPrice;

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
        //Get order by id
        $order = Order::find($id);
        //Update order status to completed
        $order->status = 'Completed';
        $order->save();
        return redirect()->back()->with('error', 'Order completed!');
    }

    public function CancelOrder($id)
    {
        //Get order by id
        $order = Order::find($id);
        //Update order status to completed
        BarboraAPI::CancelOrder($order);
        return redirect()->back()->with('error', 'Order canceled!');
    }
}
