<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;

use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    function gets(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => '',
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
        $jsonoutput = response()->json(['data' => $response]);
        $obj = json_decode($jsonoutput);
        $data_array = json_decode($response,true);
        return response()->json(['data' => $data_array["result"]]);
    }

    function index(){
        return view('product');
    }
    function getsession(){
        echo session('odoo_session_id');
    }
    public function import(Request $request) 
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        Excel::import(new ProductsImport, $request->file('file'));
        return response()->json(['message' => 'Success']);
    }
    public function importx(Request $request) 
    {
        $file = $request->file('file');
        
        // Test: Coba ambil data mentahnya dulu tanpa masuk ke Database
        $data = \Excel::toArray(new ProductsImport, $file);
        
        // Ini akan menampilkan isi array dari Excel di console/network tab browser
        return response()->json([
            'debug_data' => $data,
            'message' => 'Cek tab Network di Inspect Element untuk melihat data ini'
        ]);
    }
}
