<?php

namespace App\Http\Controllers;

class BarboraAPI
{
    public static function QueryBarbora($list)
    {
        $priceList = [];
        foreach ($list as $product) {
            $price = rand(1, 10);
            $priceList[$product] = $price;
        }
        return $priceList;
    }

    public static function ProccessCreateQuery($order)
    {
        return true;
    }

    public static function CheckOrderStatus($orders)
    {
        //For each order assgin with 10% chance status finished
        foreach ($orders as $order) {
            $random = rand(1, 100);
            if ($random <= 10 && $order->status != 'Canceled' && $order->status != 'Completed') {
                $order->status = 'Finished';
                $order->save();
            }
        }

        return true;
    }

    public static function CancelOrder($order)
    {
        $order->status = 'Canceled';
        $order->save();
        return true;
    }
}
