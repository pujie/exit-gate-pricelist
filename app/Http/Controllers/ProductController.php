<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    function gets(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://odoo.padi.net.id/api/product.product?query={id%2Ccode%2Cname%2Cprice}',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: session_id='.session('odoo_session_id')
        ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        //echo $response;
        //return view("product");



        /*$localDiscounts = Discount::all()->keyBy('odoo_product_id');
        $data = collect($odooProducts)->map(function($product) use ($localDiscounts) {
            $discount = $localDiscounts->get($product['id']);
            $basePrice = $product['price'];
            
            // Hitung harga akhir
            $finalPrice = $basePrice;
            if ($discount) {
                $finalPrice = ($discount->type == 'percentage') 
                    ? $basePrice - ($basePrice * ($discount->amount / 100)) 
                    : $basePrice - $discount->amount;
            }
    
            return [
                'code' => $product['code'],
                'name' => $product['name'],
                'price' => "Rp " . number_format($basePrice, 0, ',', '.'),
                'final_price' => "Rp " . number_format($finalPrice, 0, ',', '.'),
                'status' => $discount ? '<span class="badge badge-success">Promo</span>' : '-',
                'action' => '<button class="btn btn-sm btn-primary">Detail</button>'
            ];
        });*/

        $jsonoutput = response()->json(['data' => $response]);
        $obj = json_decode($jsonoutput);
//$x = $obj->result;
        //return response()->json(['data' => explode(",",$response)]);

        //$arr = explode(",",$response);
        //return $arr;
//return $response;
        $data_array = json_decode($response,true);
        return $data_array["result"];
        //$result = $data_array['data'][0]['result'];
        //return $result;
    }

    function index(){
        return view('product');
    }

}
