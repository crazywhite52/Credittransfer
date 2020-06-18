<?php $baseUrl=Yii::app()->request->baseUrl;
$id=Yii::app()->request->cookies['cookie_user_id']->value;
$str="SELECT * FROM sysuser WHERE `name`='$id' ";
$model=Yii::app()->msystem->createCommand($str)->queryRow();
$fullname=$model['fullname'];
$lastname=$model['surname'];
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
<?php    header ('Content-type: text/html; charset=utf-8');
//<!-- API ธนาคาร -->
$json = file_get_contents('http://172.18.0.10:9090/api_app/index.php/apifinance/Bankpayment/payment_cid/1');
$decode = json_decode($json, true);
$ckdecode= count($decode);
//<!-- API สาขา -->
$json2 = file_get_contents('http://172.18.0.10:9090/api_app/index.php/apimain/apibranch');
$decode2 = json_decode($json2, true);
$brn= count($decode2);


?>
<!-- Content Wrapper. Contains page content -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Content Header (Page header) -->
<div class="content-wrapper" style="background-color: #d2d0d0;">
  <section class="content-header">
    <h1>
      Create ( การโอนเงิน)
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Create JOB ( การโอนเงิน )</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
   <div class="row">
     <div class="col-md-12">


      <div class="box box-info" style="border-radius: 10px;">
        <div class="box-header with-border" style="border-radius: 10px;">
          <h3 class="box-title">ส่วนของพนักงาน </h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <form class="form-horizontal" action="#">
          <div class="box-body">
            <!--  <<<<->>>> -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">ชื่อ - นามสกุล :</label>

                <div class="col-sm-8">
                 <input type="text" class="form-control" style="border-radius: 5px;" id="username" value="<?php echo Yii::app()->request->cookies['cookie_user_prosonal']->value; ?>" Disabled>
               </div>
             </div>
             <div class="form-group">
              <label class="col-sm-3 control-label">สาขา :</label>

              <div class="col-sm-8">
                <div class="row">
                  <div class="col-xs-4">
                    <input type="text" class="form-control" style="border-radius: 5px;" id="branchid" value="<?php echo Yii::app()->request->cookies['cookie_user_branch']->value; ?>" onKeyUp="if(isNaN(this.value)){ alert('ตัวเลขเท่านั้น'); this.value='';}">
                  </div>
                  <div class="col-xs-8">
                    <select class="form-control" style="border-radius: 5px;" id="branchname">
                      <?php $brId= Yii::app()->request->cookies['cookie_user_branch']->value; ?>
                      <option><?php echo MyClass::chkbranck($brId); ?></option>

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
                <input type="text" class="form-control" style="border-radius: 5px;" id="order_user_id" onKeyUp="if(isNaN(this.value)){ alert('ตัวเลขเท่านั้น'); this.value='';}">
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
          <textarea class="form-control" style="border-radius: 5px;" rows="3" id="order_comment" placeholder=""></textarea>
        </div>
      </div>
    </div>


    <!--  <<<<->>>> -->
  </div>

  <!-- /.box-body -->

  <!-- /.box-footer -->
</form>

</div>


</div>
</div>

 <div class="row">
   <div class="col-md-12">


    <div class="box box-info" style="border-radius: 10px;">
      <div class="box-header with-border" style="border-radius: 10px;">
        <h3 class="box-title">ส่วนของลูกค้า ( โอนเงิน )</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->

      <form class="form-horizontal" action="#" id="form2">
        <div class="box-body">
          <!--  <<<<->>>> -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="col-sm-3 control-label">ชื่อ :</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" style="border-radius: 5px;" id="cus_name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">นามสกุล :</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" style="border-radius: 5px;" id="cus_surname">
              </div>
            </div>
            <div class="form-group" style="margin-bottom: 0px;">
              <label class="col-sm-3 control-label">ธนาคาร(ที่รับโอน) :</label>

              <div class="col-sm-8">
                <div id="response"></div>
               <!-- <select class="form-control" >
                 <option>------ เลือกธนาคาร ------</option>
                 <?php  #for ($i=0; $i < $ckdecode; $i++) { ?>
                 <option id="payment_id" value="<?php #echo $decode[$i]['payment_id']; ?>"><?php #echo $decode[$i]['payment_name']; ?></option>

                 <?php #} ?>
               </select> -->
             </div>
           </div>
           <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">จำนวนเงิน :</label>

            <div class="col-sm-8">
              <div class="input-group" style="border-radius: 5px;">
                <span class="input-group-addon" style="border-radius: 5px;">฿</span>
                <input type="text" class="form-control" style="border-radius: 5px;" id="order_price_total" onKeyUp="if(isNaN(this.value)){ alert('ตัวเลขเท่านั้น'); this.value='';}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">วันที่โอน :</label>

            <div class="col-sm-8">
              <div class="input-group date"style="border-radius: 5px;">
                <div class="input-group-addon"style="border-radius: 5px;">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" style="border-radius: 5px;" id="paydate" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" value="<?php echo date("d/m/Y");?>">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">เวลา :</label>

            <div class="col-sm-8">
              <div class="input-group" style="border-radius: 5px;">
                <div class="input-group-addon" style="border-radius: 5px;">
                  <i class="fa fa-clock-o"></i>
                </div>
                <input type="text" class="form-control"  style="border-radius: 5px;" id="paytime" data-inputmask="&quot;mask&quot;: &quot;99:99&quot;" data-mask="" value="<?php echo date(" H:i");?>" >
              </div>

            </div>
          </div>

          <div class="form-group" >
            <label  class="col-sm-3 control-label">สลิปการโอน :</label>

            <div class="col-sm-6"><input type="file" id="order_file" name="order_file" onchange="fileSelected();">
            </div>
            <div class="col-sm-8">
              <div id="fileName">
              </div>
              <div id="fileSize">
              </div>
              <div id="fileType">
              </div>
            </div>

          </div>

        </div>
        <div class="col-md-6">
        </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer" align="center"  style="border-radius: 10px;">
        <button type="button" class="btn btn-default">CLEAR</button>
        <button type="submit" id="save" class="btn btn-info">SAVE</button>
      </div>
      <!-- /.box-footer -->
    </form>

  </div>


</div>
</div>
</section>
</div>
<script type="text/javascript" charset="utf-8" async defer>
  function fileSelected() {
    var file = document.getElementById('order_file').files[0];
    if (file) {
      var fileSize = 0;
      if (file.size > 1024 * 1024)
        fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
      else
        fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

      document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
      document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
      document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
    }
  }
  $(document).ready(function(){
    $("#branchname").change(function() {
      $("#branchid").val($("#branchname").val());
    });
    $("#branchid").keyup(function() {
      $("#branchname").val($("#branchid").val());
    });
    
    $.post('<?php echo $this->createUrl("Creditcard/Index2"); ?>', function(response) {
      $('#response').html(response);
    });
       //form Submit
      /* $("#form2").submit(function(evt){
        evt.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
         url: '<?php #echo $this->createUrl("job/upload"); ?>',
         type: 'POST',
         data: formData,
         async: false,
         cache: false,
         contentType: false,
         enctype: 'multipart/form-data',
         processData: false,
         success: function (response) {
           //alert(response);
           //location.reload();
         }
       });
        return false;
      });*/

      // if(document.getElementById("type_search").checked==false){
        //   swal("Click เลือกประเภทการทำรายการ!", "การโอนเงิน หรือ บัตรเครดิต?")
        // }
        //$("#save").click(function(){
          $("form").submit(function(evt){
            evt.preventDefault();

            var username = $("#username").val();
            var order_user_name = '<?php echo $fullname; ?>';
            var order_user_lastname = '<?php echo $lastname; ?>';
            var order_user_image = '<?php echo $urlhr; ?>';
            var branchid = $("#branchid").val();
            var branchname = $("#branchname").val();
            var order_user_bill = $("#order_user_id").val();
            var order_comment = $("#order_comment").val();
            var payment_id = $("#payments").val();
            var order_price_total = $("#order_price_total").val();
            var paydate = $("#paydate").val();
            var paytime = $("#paytime").val();
            var order_file = $("#order_file").val();
            if(order_file==""){
              var or_file = 0;
              var ftype = "";
            }else{
              var or_file = 1;
              var file = document.getElementById('order_file').files[0];
              var ftype = file.name;
            }
            if($('#payments').val()==''){
              swal("กรุณาเลือกธนาคาร!", "You clicked the button!", "error")
              return false;
            }
            if($('#order_user_id').val()==''){
              swal("กรุณากรอก user itec!", "You clicked the button!", "error")
              return false;
            }
            if($('#order_price_total').val()==''){
              swal("กรุณาใส่จำนวนเงิน!", "You clicked the button!", "error")
              return false;
            }



            swal({
              title: "ยืนยันการบันทึกข้อมูล",
              // text: "Submit to run save and send email",
              type: "info",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            }, function () {
              var rowed ={};
              rowed['branchid'] = branchid;
              rowed['branchname'] = branchname;
              rowed['order_user_bill'] = order_user_bill;
              rowed['order_user_id'] = '<?php echo $id; ?>';
              rowed['order_user_name'] = '<?php echo $fullname; ?>';
              rowed['order_user_lastname'] = '<?php echo $lastname; ?>';
              rowed['order_user_image'] = '<?php echo $urlhr; ?>';
              rowed['order_price_total'] = order_price_total;
              rowed['payment_cid'] = 1; //เงินโอน
              rowed['payment_id'] = $('#payments').val();
              rowed['create_user'] = '<?php echo $id; ?>';
              rowed['order_comment'] = $('#order_comment').val();
              rowed['paydate'] = paydate;
              rowed['paytime'] = paytime;
              rowed['order_file'] = or_file;
              rowed['file_type'] = ftype;
              //alert($.param(rowed));

              var apiurls = "http://172.18.0.10:9090/api_app/index.php/apifinance/testinsert";

              var settings = {
                async: true,
                crossDomain: true,
                url: apiurls,
                method: "POST",
                enctype: 'multipart/form-data',
                headers: {
                  "content-type": "application/x-www-form-urlencoded",
                },
                data:$.param(rowed)
              }

              $.ajax(settings).done(function (response) {
                if(response=="FALSE"){
                  swal("NOT SAVE!", "You clicked the button!", "error");
                  return false;
                }else{
                  var file = document.getElementById('order_file').files[0];
                  var fd = new FormData();
                  fd.append('order_file', file);
                  fd.append('file_name', response);
                  //alert(fd);
                  $.ajax({
                   url: '<?php echo $this->createUrl("job/upload"); ?>',
                   type: 'POST',
                   data: fd,
                   async: false,
                   cache: false,
                   contentType: false,
                   enctype: 'multipart/form-data',
                   processData: false,
                   success: function (response) {
                     //alert(response);
                     //location.reload();
                   }
                 });

                  swal("Good job!", "You clicked the button!", "success");
                  setTimeout(function () {
                    location.reload();
                  }, 1500);
                }
              });

            });

          });

function clearThis(target){
  if(target.value!=''){
    target.value= "";}
  }
  function chkNumber(ele)
  {
    var vchar = String.fromCharCode(event.keyCode);
    if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
    ele.onKeyPress=vchar;
  }
  var _validFileExtensions = [".jpg", ".jpeg", ".gif", ".png"];
  function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {

      var sFileName = oInput.value;

      var sFsize = oInput.files[0].size;
      if (sFileName.length > 0) {
        var blnValid = false;
        for (var j = 0; j < _validFileExtensions.length; j++) {
          var sCurExtension = _validFileExtensions[j];
          if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {

            if (sFsize < 1024*1024*5) {
              blnValid = true;
              break;
            }else{
              alert("ไฟล์ขนาดห้ามเกิน 5 MB");
              blnValid = true;
              oInput.value = "";
              return false;
            }
          }
        }

        if (!blnValid) {
          alert("อัพไฟล์ไม่ได้, " + sFileName + " อัพได้เฉพาะ : " + _validFileExtensions.join(", "));
          oInput.value = "";
          return false;
        }
      }
    }
    return true;
  }


});



</script>
