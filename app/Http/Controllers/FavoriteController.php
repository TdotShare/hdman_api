<?php

namespace App\Http\Controllers;


use App\Favorite;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    public function actionIndex($id)
    {
        $model =  Favorite::where("account_id" , $id)->get();
        return $this->responseRequest($model, "แสดงรายการโปรดทั้งหมดของ account นั้น");
    }

    public function actionCreate(Request $request)
    {
        try {

            $model =  new Favorite();

            $model->account_id = $request->account_id;
            $model->market_id = $request->market_id;

            if($model->save()){
                return $this->responseRequest(null, "สร้างรายการโปรดสำเร็จ");
            }else{
                return $this->responseRequest(null, "สร้างรายการโปรดไม่สำเร็จ", false, "error");
            }

        } catch (\PDOException $th) {
            return $this->responseRequest(null, "สร้างรายการโปรดไม่สำเร็จ", false, "error");
        }
    }
    
    public function actionDelete($id)
    {
        $model = Favorite::find($id);

        if ($model->delete()) {
            return $this->responseRequest(null, "ลบข้อมูลรายการโปรด");
        } else {
            return $this->responseRequest(null, "ลบรายการไม่สำเร็จ", false, "error");
        }
    }

    protected function responseRequest($data,  $message = "", $bypass = true,  $status = "success")
    {
        return response()->json(['bypass' => $bypass,  'status' => $status, 'data' => $data, 'message' => $message], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header("Access-Control-Allow-Headers", "Authorization, Content-Type")
            ->header('Access-Control-Allow-Credentials', ' true');
    }
}
