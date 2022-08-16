<?php

namespace App\Http\Traits;

use App\Models\Bill;
use App\Models\billsCollection;
use App\Models\Student;
use Throwable;
use Illuminate\Support\Facades\Auth;

trait BillTrait {
    public function createBill($item_data, $price, $shipping, $shippingData = null, $address_id = null, $product_id = null) {
        try{

            Bill::create([
                'item_data'         => json_encode($item_data),
                'item_price'        => $price,
                'shipping'          => $shipping,
                'total_price'       => $price + $shipping,
                'client_id'         => Auth::guard('clients')->user()->id,
                'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'. date('d-m'),
                'shipping_data'     => ($shippingData != null ? json_encode($shippingData) : null),
                'address_id'        => $address_id,
                'product_id'        => $product_id,
            ]);

            return true;

        } catch(Throwable $e){

            $this->createBill($item_data, 10, 0);

            return true;
        }
    }
    public function createBillCollection($item_data, $price, $shipping, $shippingData = null, $address_id = null, $product_id = null) {
        try{

            billsCollection::create([
                'item_data'         => json_encode($item_data),
                'item_price'        => $price,
                'shipping'          => $shipping,
                'total_price'       => $price + $shipping,
                'client_id'         => Auth::guard('clients')->user()->id,
                'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'. date('d-m'),
                'shipping_data'     => ($shippingData != null ? json_encode($shippingData) : null),
                'address_id'        => $address_id,
                'product_id'        => $product_id,
            ]);

            return true;

        } catch(Throwable $e){

            $this->createBill($item_data, 10, 0);

            return true;
        }
    }
}
