<?php

namespace App\Http\Controllers;

use App\Market;
use Illuminate\Http\Request;

//require 'vendor/autoload.php';

class MarketController extends Controller
{
    public function actionAll()
    {
        $model = Market::all();
        return $this->responseRequest($model);
    }

    public function actionView($id)
    {
        $model = Market::where('id_account', '=', $id)->first();
        return $this->responseRequest($model);
    }

    public function actionCreate(Request $request)
    {
        try {

            $model = Market::where('id_account', '=', $request->id_account)->first();

            if ($model) {

                if ($model->update($request->all())) {
                    return $this->responseRequest($model);
                } else {
                    return $this->responseRequest(null, false, "error");
                }
            } else {

                if (Market::create($request->all())) {
                    return $this->responseRequest(null);
                } else {
                    return $this->responseRequest(null, false, 'error', 'สร้างร้านไม่สำเร็จ');
                }

            }
        } catch (\Throwable $th) {
            return $this->responseRequest($th, false, 'error');
        }
    }

    public function actionUpdate(Request $request)
    {
        try {

            $model = Market::where('id_account', '=', $request->account_id)->first();

            if ($model->update($request->all())) {
                return $this->responseRequest($model);
            } else {
                return $this->responseRequest(null, false, "error");
            }
        } catch (\Throwable $th) {
            return $this->responseRequest($th, false, "catch");
        }
    }

    public function actionOpenMt(Request $request)
    {
        $model = Market::where('id_account', '=', $request->id_account)->first();

        // 0 = เปิดใช้งาน , 1 = ไม่เปิดร้าน
        try {

            if ($model) {
                $model->status = $request->status;
                $model->save();

                return $this->responseRequest($model);
            } else {

                return $this->responseRequest(null, 'false', 'NullMarket');
            }
        } catch (\Throwable $th) {
            return $this->responseRequest($th, false, "catch");
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
