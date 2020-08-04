<?php

namespace App\Http\Controllers;

use App\Account;
use App\History;
use App\Market;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function actionList($id)
    {
        $model = Product::where('id_market', "=", $id)->get();
        return $this->responseRequest($model);
    }

    public function actionCreate(Request $request)
    {


        if (Product::create($request->all())) {

            $data =  Product::where('id_market', "=",  $request->id_market)->get();
            return $this->responseRequest($data);
        } else {

            return $this->responseRequest(null, false, 'error', 'สร้างร้านไม่สำเร็จ');
        }
    }

    public function actionDelete(Request $request)
    {
        try {
            if (Product::where('id', "=", $request->id)->delete()) {

                $data =  Product::where('id_market', "=",  $request->id_market)->get();

                return $this->responseRequest($data);
            } else {
                return $this->responseRequest(null, 'error');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest($th, false, 'catch');
        }
    }

    public function actionBuy(Request $request)
    {
        /*
        paramater ที่ต้องรับ 
      - account_id
      - market_id
      - product_id
      - status = 0 
        
        status = 0 รอทางร้านรับเรื่อง
        status = 1 ร้านค้ารับเรื่องแล้ว ( ทางร้านจะติดต่อไปหาลูกค้า คุยรายละเอียดงาน )
        status = 2 ตกลงขั้นตอนการทำงานและกำลังเดินทางไปหาลูกค้า
        status = 3 ช่างถึงที่หมายและลงมือปฏิบัติงาน
        status = 4 ปฏิบัติงานเสร็จสิน
        status = 5 ยกเลิกรายการ - เหตุผล

      */

        try {

            $model = new History();
            $model->account_id = $request->account_id;
            $model->market_id = $request->market_id;
            $model->product_id = $request->product_id;
            $model->status = 0;
            $model->tel = $request->tel;
            $model->adr = $request->adr;
            $model->comment = "-";
            

            if($model->save()){
                return $this->responseRequest(null);
            }else{
                return $this->responseRequest(null , false , "error" , "ไม่สามารถสั้งรายการนี้ได้ กรุณาลองใหม่อีกครั้ง !");
            }

        } catch (\PDOException $th) {
            return $this->responseRequest(null , false , "error" , "เกิดข้อผิดพลาดเซิฟเวอร์ กรุณาแจ้งผู้ดูแลระบบ !");
            
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
