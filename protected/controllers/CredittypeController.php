<?php

class CredittypeController extends CController
{
	public function actionAdmin()
	{
		if (empty(Yii::app()->request->cookies['cookie_user_id']->value)) {
			$this->redirect(array("Login/in"));
		}
		$this->render("admin");
	}
	public function actionIndex()
	{
		if (empty(Yii::app()->request->cookies['cookie_user_id']->value)) {
			$this->redirect(array("Login/in"));
		}
		$this->render("index");
	}
	public function actionInsertcredit()
	{
		if (empty(Yii::app()->request->cookies['cookie_user_no']->value)) {
			$this->redirect(array("Login/in"));
		}if (empty(Yii::app()->request->cookies['cookie_user_prosonal']->value)) {
			$this->redirect(array("Login/in"));
		}if (empty(Yii::app()->request->cookies['cookie_user_branchname']->value)) {
			$this->redirect(array("Login/in"));
		}
		

		$this->render("insert_credit");
	}
	public function actionInsertcredit2()
	{
		if (empty(Yii::app()->request->cookies['cookie_user_id']->value)) {
			$this->redirect(array("Login/in"));
		}

		$this->render("insert_credit2");
	}
	public function actionListdata()
	{
		$br=Yii::app()->request->cookies['cookie_user_branch']->value;
		$dt1=$_GET['date_befor'];
		$dt2=$_GET['date_after'];
		$stat=$_GET['stat1'];
		$dt11=date('Ymd',strtotime($dt1));
		$dt22=date('Ymd',strtotime($dt2));

		if ($stat == 9) {
			$st = '0,1,2';
		} else {
			$st = $stat;
		}



		if($br=='1000'){
			$sql="SELECT * FROM b_creditjob WHERE `status` IN($st) AND DATE(orderdate) BETWEEN '$dt11' AND '$dt22' ORDER BY orderdate DESC";
		}else{
			$sql="SELECT * FROM b_creditjob WHERE `status` IN('$st') AND br='$br' AND DATE(orderdate) BETWEEN '$dt11' AND '$dt22' ORDER BY orderdate DESC";
		}

		$result = Yii::app()->datablue->createCommand($sql)->queryAll();
		$data = array();
		foreach ($result as $r) {

			if($r["jobtype"]==1){
				$txt_ty='SUPPLIER จ่ายดอกเบี้ย (0%)';
			}elseif ($r["jobtype"]==2) {
				$txt_ty='J.I.B จ่ายดอกเบี้ย (0%)';
			}elseif ($r["jobtype"]==3) {
				$txt_ty='ลูกค้าจ่ายดอกเบี้ย (อัตราดอกเบี้ยปกติ)';
			}
			if($r["status"]==0){
				$txt_st = 'รอ Approved';
			}elseif ($r["status"]==1){
				$txt_st = 'Cancel';
			}elseif ($r["status"]==2) {
				$txt_st = 'Approved';
			}
			$data[] = array(
				'no' => $r["no"],
				'orderdate' => $r["orderdate"],
				'orderid' => $r["orderid"],
				'cidcustomer' => $r["cidcustomer"],
				'customer' => $r["customer"],
				'user' => $r["user"],
				'status' => $txt_st,
				'jobtype' => $txt_ty,
				'downpayment'=> $r['downpayment'],
				'creditpayment'=> $r['creditpayment'],
				'sumpayment'=> $r['sumpayment'],
				'edit' => 'แก้ไข',
				'cancel' => 'ยกเลิก',
			);
		}
		echo json_encode($data);

	}
	public function actionApiserial()
	{

		$serial=base64_encode($_GET['serial']);
		$url = 'http://172.18.0.135:8503/getserial/'.$serial;


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "8503",
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}


	}
	public function actionApiserial2()
	{
		$sql="SELECT *
		FROM
		b_byserailproduct WHERE orderid='".$_GET['orderid']."' ORDER BY price1 DESC";
		$result = Yii::app()->datablue->createCommand($sql)->queryAll();
		$data = array();
		foreach ($result as $r) {
			$data[] = array(
				'serial' => $r['serial'],
				'product' => $r['productid'],
				'Name' => $r['productname'],
				'CATEGORYID' => $r['categoryid'],
				'classname' => $r['categoryname'],
				'price1' => $r['price1'],
			);
		}
		echo json_encode($data);
	}
	public function actionCancel()
	{
		$jobid=$_POST['jobid'];

		$update = "UPDATE b_creditjob SET `status`=1 WHERE no='$jobid'";
		$result = Yii::app()->datablue->createCommand($update)->execute();


	}
	public function actionPaysave()
	{

		if(!empty($_POST)){
			$update=$_POST['update'];
			$id=$_POST['id'];
			$customer=$_POST['customer'];
			$cidcustomer1=$_POST['cidcustomer1'];
			$cidcustomer2=$_POST['cidcustomer2'];
			$telcustomer=$_POST['telcustomer'];
			$br=$_POST['br'];

			$cidcustomer=$cidcustomer1.' '.'XXXX'.' '.'XXXX'.' '.$cidcustomer2;

			$type=$_POST['type'];
			$user = Yii::app()->request->cookies['cookie_user_id']->value;
			$user_name = Yii::app()->request->cookies['cookie_user_prosonal']->value;
			$user_save='('.$user.')'.$user_name;

			$length = 10;
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			$gencode='LS-'.$randomString;

			// $result = Yii::app()->datablue->createCommand('SELECT MAX(orderid) lastid FROM b_creditjob')->queryRow();
			// $gen_doc = MyClass::generateCode("Y", "m", 4, $randomString, $result["lastid"], "");

			if($type==1){
				$txt1=$_POST['txt1'];
				$txt2=$_POST['txt2'];
				$txtsum=$_POST['txtsum'];
				if($update=='false'){
					$insert="INSERT INTO b_creditjob SET br='$br',orderdate=NOW(),orderid='$gencode',jobtype='$type',downpayment='$txt1',creditpayment='$txt2',sumpayment='$txtsum',bankcode='".$_POST['fmr2']."',paymonth='".$_POST['fmr3']."',user='$user_save',customer='$customer',cidcustomer='$cidcustomer',telcustomer='$telcustomer' ";
					Yii::app()->datablue->createCommand($insert)->execute();
					echo $gencode;
				}else if($update=='true'){
					$up="UPDATE b_creditjob SET jobtype='$type',downpayment='$txt1',creditpayment='$txt2',sumpayment='$txtsum',bankcode='".$_POST['fmr2']."',paymonth='".$_POST['fmr3']."',user='$user_save',customer='$customer',cidcustomer='$cidcustomer',telcustomer='$telcustomer' WHERE no='$id' ";
					Yii::app()->datablue->createCommand($up)->execute();
					echo $gencode;
				}
			}else if ($type==2) {
				$txt1=$_POST['txt1'];
				$txt2=$_POST['txt2'];
				$txtsum=$_POST['txtsum'];
				if($update=='false'){
					$insert="INSERT INTO b_creditjob SET br='$br',orderdate=NOW(),orderid='$gencode',jobtype='$type',downpayment='$txt1',creditpayment='$txt2',sumpayment='$txtsum',bankcode='".$_POST['fmr2']."',paymonth='".$_POST['fmr3']."',user='$user_save',customer='$customer',cidcustomer='$cidcustomer',telcustomer='$telcustomer' ";
					Yii::app()->datablue->createCommand($insert)->execute();
					echo $gencode;
				}else if($update=='true'){
					$up="UPDATE b_creditjob SET jobtype='$type',downpayment='$txt1',creditpayment='$txt2',sumpayment='$txtsum',bankcode='".$_POST['fmr2']."',paymonth='".$_POST['fmr3']."',user='$user_save',customer='$customer',cidcustomer='$cidcustomer',telcustomer='$telcustomer' WHERE no='$id' ";
					Yii::app()->datablue->createCommand($up)->execute();
					echo $gencode;
				}
			}else if ($type==3) {
				$txt1=$_POST['txt1'];
				$txt2=$_POST['txt2'];
				$txtsum=$_POST['txtsum'];
				if($update=='false'){
					$insert="INSERT INTO b_creditjob SET br='$br',orderdate=NOW(),orderid='$gencode',jobtype='$type',downpayment='$txt1',creditpayment='$txt2',sumpayment='$txtsum',bankcode='".$_POST['fmr2']."',paymonth='".$_POST['fmr3']."',user='$user_save',customer='$customer',cidcustomer='$cidcustomer',telcustomer='$telcustomer' ";
					Yii::app()->datablue->createCommand($insert)->execute();
					echo $gencode;
				}else if($update=='true'){
					$up="UPDATE b_creditjob SET jobtype='$type',downpayment='$txt1',creditpayment='$txt2',sumpayment='$txtsum',bankcode='".$_POST['fmr2']."',paymonth='".$_POST['fmr3']."',user='$user_save',customer='$customer',cidcustomer='$cidcustomer',telcustomer='$telcustomer' WHERE no='$id' ";
					Yii::app()->datablue->createCommand($up)->execute();
					echo $gencode;
				}
			}
			//$insert="INSERT INTO b_creditjob SET orderid='$gen_doc' ";





		}

	}
	public function actionDel_list()
	{
		
		$edit=$_POST['edit'];
		$del="DELETE FROM b_byserailproduct WHERE orderid='$edit'";
		Yii::app()->datablue->createCommand($del)->execute();
	}
	public function actionSavelist()
	{
		$update=$_POST['update'];
		$orderid=$_POST['orderid'];
		$edit=$_POST['edit'];
		$serial=$_POST['serial'];
		$product=$_POST['product'];
		$Name=$_POST['Name'];
		$classname=$_POST['classname'];
		$price1=$_POST['price1'];
		$CATEGORYID=$_POST['CATEGORYID'];



		if($update=='false'){
			$insert="INSERT INTO b_byserailproduct SET orderid='$orderid',`serial`='$serial',productid='$product',productname='$Name',categoryid='$CATEGORYID',categoryname='$classname',price1='$price1',datetimecreate=NOW() ";
			Yii::app()->datablue->createCommand($insert)->execute();
		}else if($update=='true'){
			
			$insert="INSERT INTO b_byserailproduct SET orderid='$edit',`serial`='$serial',productid='$product',productname='$Name',categoryid='$CATEGORYID',categoryname='$classname',price1='$price1',datetimecreate=NOW() ";
			Yii::app()->datablue->createCommand($insert)->execute();
		}


	}
	// -----------------------------------------------------------
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	public function actionConfig()
	{
		$this->render("config");
	}
}