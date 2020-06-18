<?php

class SetController extends CController
{
	public function actionList()
	{

		$br_user = Yii::app()->request->cookies['cookie_user_branch']->value;
		$qry = file_get_contents("http://jibbaba.com:9090/api_app/index.php/apifinance/Listpayment?branchid=".$br_user);
		$decode = json_decode($qry, true);



		foreach ($decode as $key => $r) {
			if ($r['order_status'] == '1') {$order_status = 'กำลังดำเนินการ';}
			if ($r['order_status'] == '3') {$order_status = 'การเงินรับทราบ';}
			if ($r['order_status'] == '5') {$order_status = 'ยกเลิก';}
			if ($r['payment_cid'] == '1') {$payment_cid = 'โอนเงินผ่านธนคาร';}
			if ($r['payment_cid'] == '2') {$payment_cid = 'อินเทอร์เน็ตแบงค์กิ้ง';}
			if ($r['payment_cid'] == '3') {$payment_cid = 'บัตรเครดิต';}
			if ($r['payment_cid'] == '4') {$payment_cid = 'ชำระเงินปลายทาง';}
//////////////////////////////PAYMENT NAME ///////////////////////
			$json = file_get_contents('http://jibbaba.com:9090/api_app/index.php/apifinance/Bankname/payment_id/'.$r['payment_id']);
			$decode2 = json_decode($json, true);
//////////////////////////////////////////////////////////////////
			$data[]=array(
				// 'id'=>$key  +1,
				'order_number'=>$r['order_number'],
				'order_user_name'=>$r['order_user_name'],
				'payment_cid'=>$payment_cid,
				'order_price_total'=>$r['order_price_total'],
				'payment_id'=>$decode2[0]['payment_name'],
				'order_tr_code'=>$r['order_tr_code'],
				'order_status'=> $order_status,
			);
			# code...
		}
		echo json_encode($data);
	}
	public function actionCjob()
	{
		if (!empty($_POST["id"])) {

			$order_number = $_POST["id"];
			$url = 'http://172.18.0.10:9090/api_app/index.php/apifinance/Canceljob';
            // $url = 'http://api1.teletopiasms.no/httpbridge2/';

			$context = stream_context_create(array(
				'http' => array(
					'method' => 'POST',
					'header' => 'Content-type: application/x-www-form-urlencoded',
					'content' => http_build_query(
						array(
							'order_number' => $order_number
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