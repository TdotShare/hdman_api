<?php

namespace App\Http\Controllers;

use App\Account;
use App\History;
use App\Market;
use App\Product;
use Illuminate\Http\Request;

class HistoryController extends Controller
{

    /*        
        
        status = 0 รอทางร้านรับเรื่อง
        status = 1 ร้านค้ารับเรื่องแล้ว ( ทางร้านจะติดต่อไปหาลูกค้า คุยรายละเอียดงาน )
        status = 2 ตกลงขั้นตอนการทำงานและกำลังเดินทางไปหาลูกค้า
        status = 3 ช่างถึงที่หมายและลงมือปฏิบัติงาน
        status = 4 ปฏิบัติงานเสร็จสิน
        status = 5 ยกเลิกรายการ - เหตุผล
    */

    public function actionHistory($id)
    {
        $model = History::where("account_id",  "=", $id)->whereIn("status", [4, 5])->get();

        foreach ($model as $key => $item) {

            $product = Product::find($item["product_id"]);
            $item["product_name"] = $product->name;
            $item["product_price"] = $product->price;
            $item["product_service"] = $product->service;

            $market = Market::find($item["market_id"]);
            $item["market_name"] = $market->name;

            if ($item["status"] == 4) {
                $item["status_name"] = "ปฏิบัติงานเสร็จสิน";
            } else {
                $item["status_name"] = "ยกเลิกรายการ";
            }
        }

        return $this->responseRequest($model, "ดึงข้อมูลประวัติย้อนหลังที่ดำเนินรายการเสร็จสิน");
    }

    public function actionOrderMt($id)
    {

        $market = Market::find($id);

        if ($market) {

            $model = History::where("market_id",  "=", $id)->orderBy('status')->get();

            foreach ($model as $key => $item) {

                $product = Product::find($item["product_id"]);
                $item["product_name"] = $product->name;
                $item["product_price"] = $product->price;
                $item["product_service"] = $product->service;

                $market = Market::find($item["market_id"]);
                $item["market_name"] = $market->name;

                if ($item["status"] == 0) {

                    $item["status_name"] = "รอทางร้านรับเรื่อง";
                    $item["status_next"] = "ร้านค้ารับเรื่องแล้ว ( ทางร้านจะติดต่อไปหาลูกค้า คุยรายละเอียดงาน )";
                    $item["status_next_number"] = 1;

                } else if ($item["status"] == 1) {

                    $item["status_name"] = "ร้านค้ารับเรื่องแล้ว";
                    $item["status_name_sub"] = "( ทางร้านจะติดต่อไปหาลูกค้า คุยรายละเอียดงาน )";

                    $item["status_next"] = "ตกลงขั้นตอนการทำงานเรียบร้อยและกำลังเดินทางไปหาคุณ";
                    $item["status_next_number"] = 2;

                } else if ($item["status"] == 2) {
                    $item["status_name"] = "ตกลงขั้นตอนการทำงานเรียบร้อยและ";
                    $item["status_name_sub"] = "กำลังเดินทางไปหาคุณ";

                    $item["status_next"] = "ช่างถึงที่หมายและลงมือปฏิบัติงาน";
                    $item["status_next_number"] = 3;

                } else if ($item["status"] == 3) {

                    $item["status_name"] = "ช่างถึงที่หมายและลงมือปฏิบัติงาน";
                    $item["status_next"] = "ปฏิบัติงานเสร็จสิน";

                    $item["status_next_number"] = 4;
                    
                } else if ($item["status"] == 4) {
                    $item["status_name"] = "ปฏิบัติงานเสร็จสิน";
                } else {
                    $item["status_name"] = "ยกเลิกรายการ";
                }
            }
            return $this->responseRequest($model, "ดึงข้อมูลออเดอร์");
        } else {
            return $this->responseRequest(null, "ไม่พบร้านค้า", false, "error");
        }
    }

    public function actionDoProcess($id)
    {
        $model = History::where("account_id",  "=", $id)->whereIn("status", [0, 1, 2, 3])->get();

        foreach ($model as $key => $item) {

            $product = Product::find($item["product_id"]);
            $item["product_name"] = $product->name;
            $item["product_price"] = $product->price;
            $item["product_service"] = $product->service;

            $market = Market::find($item["market_id"]);
            $item["market_name"] = $market->name;


            if ($item["status"] == 0) {
                $item["status_name"] = "รอทางร้านรับเรื่อง";
            } else if ($item["status"] == 1) {
                $item["status_name"] = "ร้านค้ารับเรื่องแล้ว";
                $item["status_name_sub"] = "( ทางร้านจะติดต่อไปหาลูกค้า คุยรายละเอียดงาน )";
            } else if ($item["status"] == 2) {
                $item["status_name"] = "ตกลงขั้นตอนการทำงานเรียบร้อยและ";
                $item["status_name_sub"] = "กำลังเดินทางไปหาคุณ";
            } else if ($item["status"] == 3) {
                $item["status_name"] = "ช่างถึงที่หมายและลงมือปฏิบัติงาน";
            }
        }


        return $this->responseRequest($model, "ดึงข้อมูลรายการที่กำลัง อยู่ในขั้นตอนใช้บริการช่าง");
    }

    public function actionDelete($id)
    {
        $model = History::find($id);

        if ($model->delete()) {
            return $this->responseRequest(null, "ลบข้อมูลประวัติ ที่เลือก");
        } else {
            return $this->responseRequest(null, "ลบรายการไม่สำเร็จ", false, "error");
        }
    }

    public function actionUpdate(Request $request)
    {
        $model = History::find($request->id);

        try {

            if ($model) {

                $model->status = $request->status;
                $model->comment = isset($request->comment) ? $request->comment : "-";

                if ($model->save()) {
                    return $this->responseRequest(null, "แก้ไขรายการเรียบร้อย");
                } else {
                    return $this->responseRequest(null, "แก้ไขรายการไม่สำเร็จ", false, "error");
                }
            } else {
                return $this->responseRequest(null, "แก้ไขรายการไม่สำเร็จ , ไม่พบข้อมูลที่จะแก้ไข", false, "error");
            }
        } catch (\PDOException $th) {
            return $this->responseRequest(null, "แก้ไขรายการไม่สำเร็จ", false, "error");
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
