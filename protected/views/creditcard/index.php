 <!-- Content Header (Page header) -->
 <?php $baseUrl=Yii::app()->request->baseUrl;
 $id=Yii::app()->request->cookies['cookie_user_id']->value;
 $str="SELECT * FROM sysuser WHERE `name`='$id' ";
 $model=Yii::app()->msystem->createCommand($str)->queryRow();
 $fullname=$model['fullname'];
 $lastname=$model['surname'];
 //-------------------HR PIC-----------------------/
 $sqlhr="SELECT
 a.surname,
 a.nickname,
 a.fullname,
 a.`name`,
 a.depast,
 b.personal_image,
 b.eng_firstname,
 b.eng_lastname,
 b.eng_nickname,
 b.cur_city,
 b.cur_post
 FROM
 msystem.sysuser AS a INNER JOIN personal_profile b ON b.personal_id=a.`name`
 WHERE
 a.`name` = '$id' LIMIT 1";
 $result=Yii::app()->jibhr->createCommand($sqlhr)->queryRow();
 $urlhr='http://172.18.0.30/JIBHR/img_hr/'.$result['personal_image'];
 ?>
 <?php   header ('Content-type: text/html; charset=utf-8');

//<!-- API ธนาคาร -->
 $json = file_get_contents('http://jibbaba.com:9090/api_app/index.php/apifinance/Bankpayment/payment_cid/1');
 $decode = json_decode($json, true);
 $ckdecode= count($decode);
//<!-- API สาขา -->
 $json2 = file_get_contents('http://jibbaba.com:9090/api_app/index.php/apimain/apibranch');
 $decode2 = json_decode($json2, true);
 $brn= count($decode2);

 ?>
 <script src="<?php echo $baseUrl; ?>/dropdown-master/js/jquery/jquery-1.9.0.min.js"></script>
 <div class="content-wrapper">
 <section class="content-header">
  <h1>
    Credit Card
    <small>รูดบัตรเครดิต</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Credit Card</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">ส่วนของพนักงาน </h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <form class="form-horizontal">
      <div class="box-body">
        <!--  <<<<->>>> -->
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">ชื่อ - นามสกุล :</label>

            <div class="col-sm-8">
             <input type="text" class="form-control" id="username" value="<?php echo Yii::app()->request->cookies['cookie_user_prosonal']->value; ?>" Disabled>
           </div>
         </div>
         <div class="form-group">
          <label class="col-sm-3 control-label">สาขา :</label>

          <div class="col-sm-8">
            <div class="row">
              <div class="col-xs-4">
                <input type="text" class="form-control" id="branchid" value="<?php echo Yii::app()->request->cookies['cookie_user_branch']->value; ?>" onKeyUp="if(isNaN(this.value)){ alert('ตัวเลขเท่านั้น'); this.value='';}">
              </div>
              <div class="col-xs-8">
                <select class="form-control" id="branchname">
                  <option><?php echo Yii::app()->request->cookies['cookie_user_branchname']->value; ?></option>

                  <?php  for ($i=0; $i < $brn; $i++) { ?>
                  <option  value="<?php echo $decode2[$i]['branch']; ?>"><?php echo $decode2[$i]['branchname']; ?></option>

                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">


          <label  class="col-sm-3 control-label">USER (ITEC) :</label>

          <div class="col-sm-8">
            <input type="text" class="form-control" id="order_user_id" onKeyUp="if(isNaN(this.value)){ alert('ตัวเลขเท่านั้น'); this.value='';}">
          </div>
        </div>
        <!--  <div class="form-group">


          <label  class="col-sm-3 control-label">ธนาคาร(รับโอน) :</label>

          <div class="col-sm-8">
           <select class="form-control">
            <option>------ เลือกธนาคาร ------</option>

            <?php  for ($i=0; $i < $ckdecode; $i++) { ?>
            <option id="bk1" value="<?php echo $decode[$i]['payment_id']; ?>"><?php echo $decode[$i]['payment_name']; ?></option>

            <?php } ?>
          </select>
        </div>
      </div> -->
    </div>


    <div class="col-md-6">

      <div class="form-group">
        <label class="col-sm-3 control-label">รายละเอียดเพิ่มเติม :</label>

        <div class="col-sm-8">
          <textarea class="form-control" rows="3" id="order_comment" placeholder=""></textarea>
        </div>
      </div>
    </div>


    <!--  <<<<->>>> -->
  </div>

  <!-- /.box-body -->

  <!-- /.box-footer -->
</form>

</div>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">ส่วนของลูกค้า(บัตรเครดิต)</h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label for="input1" class="col-sm-2 control-label">Credit Card :</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" id="input1" placeholder="" autocomplete="off" >
          <input type="hidden" class="form-control" id="input2" placeholder="" autocomplete="off" >
        </div>
      </div>

      <div class="form-group">
        <label for="payment_id" class="col-sm-2 control-label">ธนาคาร :</label>
        <div class="col-sm-5">
          <div id="response"></div>
          <!-- <select class="form-control select2" style="width: 100%;">
            <option>------ เลือกธนาคาร ------</option>
            <?php  for ($i=0; $i < $ckdecode; $i++) { ?>
            <option title="" id="payment_id" value="<?php echo $decode[$i]['payment_id']; ?>"><?php echo $decode[$i]['payment_name']; ?></option>
            <?php } ?>
          </select> -->
        </div>
      </div>

      <!-- <div class="form-group">
        <label for="payment_id" class="col-sm-2 control-label">ธนาคาร :</label>
        <div class="col-sm-5">
         <select class="form-control">
           <option>------ เลือกธนาคาร ------</option>
           <?php  for ($i=0; $i < $ckdecode; $i++) { ?>
           <option id="payment_id" value="<?php echo $decode[$i]['payment_id']; ?>"><?php echo $decode[$i]['payment_name']; ?></option>

           <?php } ?>
         </select>
       </div>
     </div> -->
     <div class="form-group">
      <label for="price_total" class="col-sm-2 control-label">จำนวนเงิน :</label>

      <div class="col-sm-2">
        <div class="input-group">
          <span class="input-group-addon">฿</span>
          <input type="text" class="form-control" id="price_total" autocomplete="off">
          <span class="input-group-addon">บาท</span>
        </div>
      </div>
    </div>




    <div class="form-group">
      <label for="datacard" class="col-sm-2 control-label">ประเภทบัตร :</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="datacard" placeholder="" autocomplete="off" readonly="true">
      </div>
    </div>
    <div class="form-group">
      <label for="cardno" class="col-sm-2 control-label">เลขบัตร :</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="cardno" placeholder="" autocomplete="off" readonly="true">
      </div>
    </div>
    <div class="form-group">
      <label for="cardname" class="col-sm-2 control-label">ชื่อบัตร :</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" id="cardname" placeholder="" autocomplete="off" readonly="true">
      </div>
    </div>
    <div class="form-group">
      <label for="cardexp" class="col-sm-2 control-label">วันหมดอายุ(ด/ป) :</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="cardexp" placeholder="" autocomplete="off" readonly="true">
      </div>
    </div>

  </div>
  <!-- /.box-body -->
  <div class="box-footer" align="center" >
    <button type="button"  class="btn btn-default" onClick="history.go(0)"><i class="fa fa-fw fa-refresh"></i> CLEAR</button>
    <button type="button" id="save" class="btn btn-info"><i class="fa fa-fw fa-save"></i> SAVE</button>
  </div>
  <!-- /.box-footer -->
</form>
</div>

</section>
<div class="content-wrapper">
<!-- /.content -->
<script language="JavaScript">
  function handleData(data) {
   //alert(data);
   var text = '{"employees":['+data+']}';
   obj = JSON.parse(text);
   var type =obj.employees[0].d1;
   var number =obj.employees[0].d2;
   var valid =obj.employees[0].d3;
   var cardexp=obj.employees[0].d4;
   var cardname =obj.employees[0].d5;
   var cardnumber =obj.employees[0].d6;
   $('#cardno').val(number);
   $('#datacard').val(type);
   $('#cardname').val(cardname);
   $('#cardexp').val(cardexp);
   $('#input2').val(cardnumber);
   //alert(cardnumber);
   document.getElementById('input1').value = "";
 }

 $(document).ready(function () {
  $("#branchname").change(function() {
    $("#branchid").val($("#branchname").val());
  });
  $("#branchid").keyup(function() {
    $("#branchname").val($("#branchid").val());
  });
  
  $.post('<?php echo $this->createUrl("Creditcard/Index2"); ?>', function(response) {
    $('#response').html(response);
  })


  $('#input1').focus();
  $('#input1').keypress(function(e) {
    if(e.which == 13) {
      var apiurl = "http://172.18.0.10:9090/MainApi/index.php/Apidata/Credit";
      var inputValue=$('#input1').val();
      $.ajax({
        url: apiurl,
        type: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        //dataType: 'json',
        data: {cardno:inputValue},
        success: handleData,
        error: function () {
          alert("Error please try again");
        }
      });
    }
  });

  $("#save").click(function(){
    
    if($('#order_user_id').val()==''){
      swal("กรุณากรอก user itec!", "You clicked the button!", "error")
      return false;
    }
    if($('#price_total').val()==''){
      swal("กรุณาใส่จำนวนเงิน!", "You clicked the button!", "error")
      return false;
    }
    if($('#input2').val()==''){
      swal("กรุณารูดบัตร!", "You clicked the button!", "error")
      return false;
    }
    if($('#payments').val()==''){
      swal("กรุณาเลือกธนาคาร!", "You clicked the button!", "error")
      return false;
    }
    var rowed ={};
    rowed['branchid'] = $('#branchid').val();
    rowed['branchname'] = $('#branchname').val();
    rowed['order_user_bill'] = $('#order_user_id').val();
    rowed['order_user_id'] = '<?php echo $id; ?>';
    rowed['order_user_name'] = '<?php echo $fullname; ?>';
    rowed['order_user_lastname'] = '<?php echo $lastname; ?>';
    rowed['order_user_image'] = '<?php echo $urlhr; ?>';
    rowed['order_price_total'] = $('#price_total').val();
    rowed['payment_cid'] = 3; //บัตรเครดิต
    rowed['payment_id'] = $('#payments').val();
    rowed['create_user'] = '<?php echo $id; ?>';
    rowed['order_comment'] = $('#order_comment').val();
    rowed['typecard']=$('#datacard').val();
    rowed['cardno']=$('#input2').val();
    rowed['cardname']=$('#cardname').val();
    rowed['cardexp']=$('#cardexp').val();
    //alert($.param(rowed));
    var apiurls = "http://172.18.0.10:9090/api_app/index.php/apifinance/creditsave";

    var settings = {
      async: true,
      crossDomain: true,
      url: apiurls,
      method: "POST",
      headers: {
        "content-type": "application/x-www-form-urlencoded",
      },
      data:$.param(rowed)
    }

    $.ajax(settings).done(function (response) {
      if(response=="TRUE"){
        swal("Good job!", "You clicked the button!", "success");
        setTimeout(function () {
          location.reload();
        }, 1500);
      }else{
        swal("NOT SAVE!", "You clicked the button!", "error");
        return false;
      }
    });

  });
});
</script>