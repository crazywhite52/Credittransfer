<?php
class CreditmachineController extends CController
{
  public function actionIndex()
  {


    $this->render("index");
  }
  public function actionBank()
  {
    $this->renderPartial("bank");
  }
  public function actionHowto()
  {
    $this->renderPartial("howto");
  }
  public function actionHowto2()
  {
    $this->renderPartial("howto2");
  }

  public function actionUpload()
  {
          // if(!empty($_POST["save"])){
   $sql = "SELECT MAX(jobno) as lastid FROM terminaldata ";
   $result = Yii::app()->datablue->createCommand($sql)->queryRow();
   $jlastid = substr(iconv("utf-8", "windows-874", $result['lastid']), 4, 6) + 0;
   $jlastid++;
   $jobid = 'JB'.sprintf("%05d", $jlastid);


   $branchid =Yii::app()->request->cookies['cookie_user_branch']->value;
   $branchname =Yii::app()->request->cookies['cookie_user_branchname']->value;
   $bank = $_POST["bankname"];
   $bankname = 1;
   $tidcode = $_POST["tidcode"];
   $brand = $_POST["brand1"];
   $generation = $_POST["generation"];
   $serial = $_POST["serail"];
   $vender = $_POST["vender1"];
   $number = $_POST["number"];
   $user = "(".Yii::app()->request->cookies['cookie_user_id']->value.")".Yii::app()->request->cookies['cookie_user_prosonal']->value;
     // $qrp1 = "INSERT INTO terminaldata SET branch='$branchid',branchname='$branchname',bank='$bank',bankname=' $bankname',tidcode=' $tidcode',brand='$brand',generation=' $generation',serial='$serial',vender='$vender',user='$user'   ";
     // Yii::app()->datablue->createCommand($qrp1)->execute();

   $url = 'http://172.18.0.135:8503/postdata';

   $context = stream_context_create(array(
    'http' => array(
      'method' => 'POST',
      'header' => 'Content-type: application/x-www-form-urlencoded',
      'content' => http_build_query(
        array(
          'jobno' => $jobid,
          'branch' => $branchid,
          'branchname' => $branchname,
          'bank' => $bank,
          'bankname' => $bankname,
          'tidcode' => $tidcode,
          'brand'=>$brand,
          'generation'=>$generation,
          'serial' => $serial,
          'vender' => $vender,
          'number' => $number,
          'user' => $user


        )
      ),
      'timeout' => 60
    )


  ));
   $resp = file_get_contents($url, FALSE, $context);
             // print_r($resp);
     // echo $resp;

   // }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   for($i=0;$i<count($_FILES["filUpload"]["name"]);$i++)
   {
    if($_FILES["filUpload"]["name"][$i] != "")
    {



      $name=$_FILES["filUpload"]["name"][$i];
      $target_path = $_SERVER['DOCUMENT_ROOT'] . "/creditmachine_file/";
      $exp = explode(".", $name);
      $c = count($exp) - 1;
      $lastname = strtolower($exp[$c]);
      $filename = $jobid."-".$i . "." . $lastname;
      if(move_uploaded_file($_FILES["filUpload"]["tmp_name"][$i],$target_path.$filename))
      {

       $qrp = "INSERT INTO picterminal SET jobno='$jobid' ,pic='$filename'";
       Yii::app()->datablue->createCommand($qrp)->execute();
       echo "<script>alert('JOBSUCCESS');window.location.href = '" . $this->createUrl('creditmachine/index') . "'</script>" ;
     }
   }
 }

}
public function actionView()
{
  if (empty(Yii::app()->request->cookies['cookie_user_id']->value)) {
    $this->redirect(array("Login/in"));
  }
  $this->render("view");
}

public function actionShow(){
  $br_user = Yii::app()->request->cookies['cookie_user_branch']->value;

  if ($br_user==1000) {
   $qry = "SELECT terminaldata.jobno,terminaldata.branchname,terminaldata.branch,terminaldata.tidcode,terminaldata.brand,terminaldata.serial,terminaldata.generation,
   terminaldata.serial,terminaldata.vender,terminaldata.`user`,bank.bankname FROM terminaldata LEFT JOIN bank ON bank.bankcode = terminaldata.bank
   WHERE status=0 ORDER BY jobno DESC" ;

 }else {
  $qry = "SELECT terminaldata.jobno,terminaldata.branchname,terminaldata.tidcode,terminaldata.branch,terminaldata.brand,terminaldata.serial,terminaldata.generation,
  terminaldata.serial,terminaldata.vender,terminaldata.`user`,bank.bankname FROM terminaldata LEFT JOIN bank ON bank.bankcode = terminaldata.bank WHERE branch='$br_user' AND status=0  ORDER BY jobno DESC";

}



$result=Yii::app()->datablue->createCommand($qry)->queryAll();


$data=array();
foreach ($result as $r ) {
  $data[]=array(
    'jobno'=>$r['jobno'],
    'branchname'=> '['.$r['branch'].'] '.$r['branchname'],
    'bankname'=>$r['bankname'],
    'tidcode'=>$r['tidcode'],
    'generation'=>$r['generation'],
    'serial'=>$r['serial'],
    'brand'=>$r['brand'],
    'vender'=>$r['vender'],
    'user'=>$r['user']



  );

}
echo json_encode($data);

}
public function actionEditjob()
{
 $jobno= $_GET["jobno"];
 $str="SELECT
 terminaldata.jobno,
 terminaldata.branchname,
 terminaldata.bank,

 terminaldata.tidcode,
 terminaldata.brand,
 terminaldata.generation,
 terminaldata.serial,
 terminaldata.vender,
 terminaldata.`user`,
 bank.bankname
 FROM
 terminaldata
 LEFT JOIN bank ON bank.bankcode = terminaldata.bank
 WHERE jobno='$jobno'";
 $data=Yii::app()->datablue->createCommand($str)->queryRow();

 $ss="SELECT picterminal.jobno,picterminal.pic FROM picterminal WHERE jobno='$jobno'";
 $pic=Yii::app()->datablue->createCommand($ss)->queryAll();

 $this->renderPartial('edit',array('data'=>$data,'pic'=>$pic));

}

public function actionEdit2()
{
  $jobno= $_POST["jobno"];
  $branchname= $_POST["branchname"];
  $bankname= $_POST["bankname"];
  $tidcode= $_POST["tidcode"];
  $generation= $_POST["generation"];
  $brand= $_POST["brand1"];
  $serial= $_POST["serial"];
  $vender= $_POST["vender"];


  $str="UPDATE terminaldata SET branchname='$branchname',bank='$bankname',tidcode='$tidcode',generation='$generation',brand='$brand',serial='$serial',vender='$vender'WHERE jobno='$jobno' ";

  $result=Yii::app()->datablue->createCommand($str)->execute();

  if (!empty($_FILES["filUpload"]))
  {
   $sql = "SELECT jobno,MAX(pic) as lastid FROM picterminal WHERE jobno='$jobno'";
   $result = Yii::app()->datablue->createCommand($sql)->queryRow();

   if($result["lastid"] == "")
   {

    for($i=0;$i<count($_FILES["filUpload"]["name"]);$i++)
    {
      if($_FILES["filUpload"]["name"][$i] != "")
      {
        $name=$_FILES["filUpload"]["name"][$i];
        $target_path = $_SERVER['DOCUMENT_ROOT'] . "/creditmachine_file/";
        $exp = explode(".", $name);
        $c = count($exp) - 1;
        $lastname = strtolower($exp[$c]);
        $filename = $jobno."-".$i ."." . $lastname;
        if(move_uploaded_file($_FILES["filUpload"]["tmp_name"][$i],$target_path.$filename))
        {
         $qrp = "INSERT INTO picterminal SET jobno='$jobno' ,pic='$filename'";
         Yii::app()->datablue->createCommand($qrp)->execute();
         echo "<script>alert('JOBSUCCESS')</script>" ;
         $str="SELECT
         terminaldata.jobno,
         terminaldata.branchname,
         terminaldata.bank,

         terminaldata.tidcode,
         terminaldata.brand,
         terminaldata.generation,
         terminaldata.serial,
         terminaldata.vender,
         terminaldata.`user`,
         bank.bankname
         FROM
         terminaldata
         LEFT JOIN bank ON bank.bankcode = terminaldata.bank
         WHERE jobno='$jobno'";
         $data=Yii::app()->datablue->createCommand($str)->queryRow();

         $ss="SELECT picterminal.jobno,picterminal.pic FROM picterminal WHERE jobno='$jobno'";
         $pic=Yii::app()->datablue->createCommand($ss)->queryAll();

         $this->renderPartial('edit',array('data'=>$data,'pic'=>$pic));

       }
     }
   }

 }
 else
 {
  $cut1= explode("-",$result["lastid"]);
  $cut2= explode(".",$cut1[1]);
  $cut3=number_format($cut2[0]+1);
  $cut4= $cut3+1;
  for($i=0;$i<count($_FILES["filUpload"]["name"]);$i++)
  {
    if($_FILES["filUpload"]["name"][$i] != "")
    {
      $name=$_FILES["filUpload"]["name"][$i];
      $target_path = $_SERVER['DOCUMENT_ROOT'] . "/creditmachine_file/";
      $exp = explode(".", $name);
      $c = count($exp) - 1;
      $lastname = strtolower($exp[$c]);
      $filename = $cut1[0]."-".$cut3 ."." . $lastname;
      if(move_uploaded_file($_FILES["filUpload"]["tmp_name"][$i],$target_path.$filename))
      {
       $qrp = "INSERT INTO picterminal SET jobno='$jobno' ,pic='$filename'";
       Yii::app()->datablue->createCommand($qrp)->execute();
       echo "<script>alert('JOBSUCCESS');</script>" ;
       $str="SELECT
       terminaldata.jobno,
       terminaldata.branchname,
       terminaldata.bank,

       terminaldata.tidcode,
       terminaldata.brand,
       terminaldata.generation,
       terminaldata.serial,
       terminaldata.vender,
       terminaldata.`user`,
       bank.bankname
       FROM
       terminaldata
       LEFT JOIN bank ON bank.bankcode = terminaldata.bank
       WHERE jobno='$jobno'";
       $data=Yii::app()->datablue->createCommand($str)->queryRow();

       $ss="SELECT picterminal.jobno,picterminal.pic FROM picterminal WHERE jobno='$jobno'";
       $pic=Yii::app()->datablue->createCommand($ss)->queryAll();

       $this->renderPartial('edit',array('data'=>$data,'pic'=>$pic));

     }
   }
 }

}


}
else
{
  echo "<script>alert('JOBSUCCESS');</script>" ;
  $str="SELECT
  terminaldata.jobno,
  terminaldata.branchname,
  terminaldata.bank,

  terminaldata.tidcode,
  terminaldata.brand,
  terminaldata.generation,
  terminaldata.serial,
  terminaldata.vender,
  terminaldata.`user`,
  bank.bankname
  FROM
  terminaldata
  LEFT JOIN bank ON bank.bankcode = terminaldata.bank
  WHERE jobno='$jobno'";
  $data=Yii::app()->datablue->createCommand($str)->queryRow();

  $ss="SELECT picterminal.jobno,picterminal.pic FROM picterminal WHERE jobno='$jobno'";
  $pic=Yii::app()->datablue->createCommand($ss)->queryAll();

  $this->renderPartial('edit',array('data'=>$data,'pic'=>$pic));
}




}

public function actionDelete()
{
  $jobno=$_POST['jobno'];

  echo Yii::app()->datablue->createCommand("UPDATE terminaldata SET status=1 WHERE jobno='$jobno' ")->execute();


}
public function actionDeleteupload()
{
  $c = 1;
  if ($c==1) {
   $del=$_GET['ids'];
   echo Yii::app()->datablue->createCommand("DELETE FROM picterminal   WHERE pic='$del' ")->execute();
   unlink($_GET['file']);
   echo "<script>alert('Deleteสำเร็จ');window.reload(); </script>" ;
 }


}
public function actionExportexcel()
{
  $br_user = Yii::app()->request->cookies['cookie_user_branch']->value;
  if ($br_user==1000) {
   $qry = "SELECT terminaldata.jobno,terminaldata.branchname,terminaldata.branch,terminaldata.tidcode,terminaldata.brand,terminaldata.serial,terminaldata.generation,
   terminaldata.serial,terminaldata.vender,terminaldata.`user`,bank.bankname FROM terminaldata LEFT JOIN bank ON bank.bankcode = terminaldata.bank
   WHERE status=0 ORDER BY jobno DESC" ;

 }else {
  $qry = "SELECT terminaldata.jobno,terminaldata.branchname,terminaldata.tidcode,terminaldata.branch,terminaldata.brand,terminaldata.serial,terminaldata.generation,
  terminaldata.serial,terminaldata.vender,terminaldata.`user`,bank.bankname FROM terminaldata LEFT JOIN bank ON bank.bankcode = terminaldata.bank WHERE branch='$br_user' AND status=0  ORDER BY jobno DESC";

}



$result=Yii::app()->datablue->createCommand($qry)->queryAll();

$this->renderPartial("export",array(
  'result'=>$result
  

)); 

}

}
?>