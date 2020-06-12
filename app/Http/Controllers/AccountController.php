<?php

namespace App\Http\Controllers;

use App\Account;
use App\Market;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';

class AccountController extends Controller
{
    public function actionAll()
    {
        $model = Account::all();
        return $this->responseRequest($model);
    }

    public function actionAll_Backend()
    {
        return $this->responseRequest(Account::all());
    }

    public function actionView($id)
    {
        $model = Account::find($id);

        if ($model) {
            return $this->responseRequest($model);
        } else {
            return $this->responseRequest(null, false, 'error');
        }
    }

    public function actionCreate(Request $request)
    {
        try {


            $usrname_count = Account::where('username' , $request->username)->get();

            if (count($usrname_count) > 0) {

                return $this->responseRequest(null, false, 'failed', 'มีชื่อ username นี้อยู่ในระบบแล้ว !');

            } else {

                $email_count = Account::where('email', $request->email)->get();

                if (count($email_count) > 0) {
                    return $this->responseRequest(null, false, 'failed', 'มีชื่อ email นี้อยู่ในระบบแล้ว !');
                } else {

                    //create start


                    $verify_number = $this->RandomString(7);


                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.hostinger.in.th';
                    $mail->Port = 587;
                    $mail->SMTPAuth = true;
                    $mail->Username = 'hdman@servicestdot.com';
                    $mail->Password = 'hdman2539';

                    $mail->setFrom('hdman@servicestdot.com', 'Hdman');
                    $mail->addAddress($request->email, $request->username);
                    $mail->Subject = 'HdMan Application';
                    $mail->Body = 'ชื่อผู้ใช้ของคุณคือ : ' . $request->username . ' และรหัสยืนยันตัวตนของคุณคือ ' . $verify_number;

                    if (!$mail->send()) {

                        return $this->responseRequest(null, false, 'error');

                    } else {

                        $account = new Account();
                        $account->username = $request->username;
                        $account->password = $request->password;
                        $account->email = $request->email;
                        $account->nickname = $request->username;
                        $account->status = 0; //0  = ยังไม่ยืนยัน
                        $account->verify_code = $verify_number;

                        if ($account->save()) {

                            return $this->responseRequest($account);
                        }
                    }

                    // $account = new Account();
                    // $account->username = $request->username;
                    // $account->password = $request->password;
                    // $account->email = $request->email;
                    // $account->nickname = $request->username;
                    // $account->status = 0; //0  = ยังไม่ยืนยัน
                    // $account->verify_code = $verify_number;

                    // if($account->save()){
                    //     return $this->responseRequest($account);
                    // }

                }
            }
        } catch (\PDOException $th) {
            return $this->responseRequest($th, false, 'catch');
        }
    }

    public function actionDelete($id)
    {
        try {
            if (Account::destroy($id)) {
                return $this->responseRequest(Account::all());
            } else {
                return $this->responseRequest(null, 'error');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest($th, false, 'catch');
        }
    }

    public function actionUpdate(Request $request)
    {
        try {
            $model = Account::find($request->id);

            if($model->password == $request->password){

                $model->nickname = $request->nickname;
                $model->save();

                return $this->responseRequest($model);

            }else{
                return $this->responseRequest(null, false, "error");
            }

          
        } catch (\Throwable $th) {
            return $this->responseRequest($th, false, "catch");
        }
    }

    public function actionLogin(Request $request)
    {
        //authenticate
        //return $request->all();

        try {

            $model = Account::where('password', '=', $request->password)->where('username', '=', $request->username)->first();

            if ($model) {

                $market = Market::where('id_account', '=', $model->id)->first();

                $model->market = $market ?  $market->status  :  0;

                if ($model->status == 0) { //ยังไม่ยืนยัน ID
                    return $this->responseRequest($model, true, 'verify');
                } else {
                    return $this->responseRequest($model);
                }
            } else {
                return $this->responseRequest(null, false, 'error');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest($th, false,  'catch');
        }
    }

    public function actionVerify(Request $request)
    {

        try {

            $model = Account::where('email', '=', $request->email)->first();

            if ($model->verify_code == $request->verify_code) {
                $model->status =  1; // ยืนยันแล้ว
                if ($model->save()) {
                    return $this->responseRequest($model);
                }
            } else {
                return $this->responseRequest(null, false, 'error', 'verify ไม่ถูกต้อง !');
            }
        } catch (\PDOException $th) {

            return $this->responseRequest($th, false,  'catch');
        }
    }

    public function RandomString($number)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $number; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
