<?php
class JobController extends CController
{
    public function actionIndex()
    {
    	if (empty(Yii::app()->request->cookies['cookie_user_no']->value)) {
            $this->redirect(array("Login/in"));
        }if (empty(Yii::app()->request->cookies['cookie_user_prosonal']->value)) {
            $this->redirect(array("Login/in"));
        }if (empty(Yii::app()->request->cookies['cookie_user_branchname']->value)) {
            $this->redirect(array("Login/in"));
        }
        
        $this->render("createjob");
    }
    public function actionPrint_price()
    {
    	$this->renderPartial("print_price");

    }
    public function actionUpload()
    {

        $tmp_file = $_FILES['order_file']['tmp_name'];
        $filename = $_FILES['order_file']['name'];
        $file_name = $_POST['file_name'];

        //var_dump($tmp_file);
        //var_dump($filename);
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $tmp = explode('.', $filename);
        $file_extension = end($tmp);
        $newfile=$file_name.".".$file_extension;
        $target_path = $_SERVER['DOCUMENT_ROOT'] . "/finance_files/";
        move_uploaded_file($tmp_file, $target_path.$newfile); //'cr_files/../../'
    }
    public function actionSavedata()

    {
        if(!empty($_POST["save"])){
            $order_user_name = $_POST["order_user_name"];
            $order_user_lastname = $_POST["order_user_lastname"];
            $order_user_image = $_POST["order_user_image"];
            $branchid = $_POST["branchid"];
            $branch_name = $_POST["branch_name"];
            $order_user_id = $_POST["order_user_id"];
            $order_comment = $_POST["order_comment"];
            $payment_id = $_POST["payment_id"];
            $order_price_total = $_POST["order_price_total"];
            $paydate = $_POST["paydate"];
            $paytime = $_POST["paytime"];

            $newDate = date("Y-m-d", strtotime($paydate));
            $order_pay_date = $newDate.' '.$paytime.':00';

/////////////////////API Url\\\\\\
            $url = 'http://jibbaba.com:9090/api_app/index.php/apifinance/testinsert';
            // $url = 'http://api1.teletopiasms.no/httpbridge2/';

            $context = stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query(
                        array(
                            'branch_id' => $branchid,
                            'branch_name' => $branch_name,
                            'order_user_id' => $order_user_id,
                            'user_id' => Yii::app()->request->cookies['cookie_user_id']->value,
                            'order_user_name' => $order_user_name,
                            'order_user_lastname'=>$order_user_lastname,
                            'order_user_image'=>$order_user_image,
                            'order_comment' => $order_comment,
                            'payment_id' => $payment_id,
                            'order_price_total' => $order_price_total,
                            'order_pay_date' => $order_pay_date

                        )
                    ),
                    'timeout' => 60
                )
            ));

            $resp = file_get_contents($url, FALSE, $context);
             // print_r($resp);
            echo $resp;
        }
    }

}
?>