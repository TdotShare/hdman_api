<?php

namespace App\Http\Controllers;

use App\Account;
use App\Market;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function actionList($id)
    {
        $model = Product::where('id_market' , "=" , $id )->get();
        return $this->responseRequest($model);
    }

    public function actionCreate(Request $request)
    {


        if (Product::create($request->all())) {

            $data =  Product::where('id_market' , "=" ,  $request->id_market )->get();
            return $this->responseRequest($data);


        } else {
            
            return $this->responseRequest(null, false, 'error', 'สร้างร้านไม่สำเร็จ');

        }

    }

    public function actionDelete(Request $request)
    {
        try {
            if (Product::where('id' , "=", $request->id )->delete()) {

                $data =  Product::where('id_market' , "=" ,  $request->id_market )->get();

                return $this->responseRequest($data);
            } else {
                return $this->responseRequest(null, 'error');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest($th, false, 'catch');
        }
    }

    protected function responseRequest($data, $bypass = true,  $status = "success", $message = "")
    {
        return response()->json(['bypass' => $bypass,  'status' => $status, 'data' => $data, 'message' => $message], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header("Access-Control-Allow-Headers", "Authorization, Content-Type")
            ->header('Access-Control-Allow-Credentials', ' true');
    }
}
