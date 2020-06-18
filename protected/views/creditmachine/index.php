<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


  <!-- <msdropdown> -->
    <link rel="stylesheet" type="text/css" href="../../../Credittransfer/dropdown-master/css/msdropdown/dd.css" />
    <script src="../../../Credittransfer/dropdown-master/js/msdropdown/jquery.dd.js"></script>
    <!-- </msdropdown> -->


  </head>
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
        บันทึกข้อมูลเครื่องรูดบัตรเครดิต
      </h1>
      <br><ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> บันทึกข้อมูลเครื่องรูดบัตรเครดิต</li>
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

          <form class="form-horizontal" method="post" action="<?php echo $this->createUrl("/creditmachine/upload"); ?>" id="form" enctype="multipart/form-data">
            <div class="box-body">
              <!--  <<<<->>>> -->
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-3 control-label">ชื่อ - นามสกุล :</label>

                  <div class="col-sm-8">
                   <input type="text" class="form-control" id="user" value="<?php echo Yii::app()->request->cookies['cookie_user_prosonal']->value; ?>" Disabled>
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
                          <option  value="<?php echo $decode2[$i]['branch']; ?>"><img src="../../dist/img/credit/visa.png" alt="Visa"><?php echo $decode2[$i]['branchname']; ?></option>

                        <?php } ?>
                      </select>
                    </div>
                  </div>
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
</section>
<section class="content">
 <div class="row">
   <div class="col-md-12">
    <div class="box box-info" style="border-radius: 10px;">
      <div class="box-header with-border" style="border-radius: 10px;">
        <h3 class="box-title">รายละเอียดเครื่องรูดบัตร</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->

      <form class="form-horizontal" method="post" action="<?php echo $this->createUrl("/creditmachine/upload"); ?>" onSubmit="JavaScript:return fncSubmit();" id="form2" enctype="multipart/form-data">
        <div class="box-body">
          <!--  <<<<->>>> -->
          <div class="col-md-12">
           <?php
           $str="SELECT bank.bankcode,bank.bankname FROM bank";
           $result=Yii::app()->datablue->createCommand($str)->queryAll();
           ?>

           <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">หมายเลขเครื่อง :</label>

            <div class="col-sm-8">
              <div class="col-sm-4">
               <select id="number" name="number" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                <option selected="selected">--เลือก--</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>


              </select>

            </div>

          </div>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">

          <label class="col-sm-3 control-label">ธนาคาร :</label>

          <div class="col-sm-8">
           <div class="col-sm-4">
            <select id="bankname" name="bankname" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
              <option selected="selected">เลือกธนาคาร</option>
              <?php foreach ($result as $r){ ?>
                <option value="<?php echo $r['bankcode']; ?>"><?php echo $r['bankname']; ?></option>


              <?php } ?>


            </select>

          </div>
          <a href="" onclick="window.open('<?php echo $this->createUrl("/creditmachine/howto"); ?>',
           'newwindow',
           'width=800,height=600');
           return false;">วิธีดูข้อมูลธนาคาร</a>
         </div>
         <!--  <input type="hidden" class="form-control" name="bankname" id="bankname" > -->
       </div>
       <div class="form-group">



       </div>
       <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">หมายเลขTID :</label>

        <div class="col-sm-8">
          <div class="col-sm-4">
            <!--   <span class="-addon">No.</span> -->
            <input type="text" class="form-control" name="tidcode" id="tidcode" >

          </div>
          <a href="" onclick="window.open('<?php echo $this->createUrl("/creditmachine/howto2"); ?>',
           'newwindow',
           'width=800,height=600');
           return false;">วิธีดูข้อมูลTID</a>
         </div>
       </div>

       <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">ยี่ห้อเครื่อง :</label>

        <div class="col-sm-8">

          <div class="col-sm-4">
            <select id="brandmac" name="brandmac" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
              <option selected="selected">--เลือก--</option>
              <option value="VeriFone">VeriFone</option>
              <option value="Hypercom">Hypercom</option>
              <option value="CASTLES">CASTLES</option>
              <option value="">อื่นๆระบุ</option>
            </select>

          </div>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="brand1" id="brand1" placeholder="อื่นๆระบุ" >
            <a href="" onclick="window.open('<?php echo $this->createUrl("/creditmachine/howto2"); ?>',
             'newwindow',
             'width=800,height=600');
             return false;">วิธีดูยี่ห้อเครื่อง</a>
           </div>
         </div>
       </div>

       <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">รุ่นเครื่อง :</label>

        <div class="col-sm-8">
         <div class="col-sm-4">
           <select id="serailmac" name="serailmac" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
            <option selected="selected">--เลือก--</option>
            <option value="VX510">VX510</option>
            <option value="VX520">VX520</option>
            <option value="iCT220">iCT220</option>
            <option value="">อื่นๆระบุ</option>
          </select>

        </div>
        <div class="col-sm-4">

          <input type="text" class="form-control" name="generation" id="generation" placeholder="อื่นๆระบุ" >
          <a href="" onclick="window.open('<?php echo $this->createUrl("/creditmachine/howto2"); ?>',
           'newwindow',
           'width=800,height=600');
           return false;">วิธีดูรุ่นเครื่อง</a>
         </div>
       </div>
     </div>

     <div class="form-group">
      <label for="inputPassword3" class="col-sm-3 control-label">Serial Number :</label>

      <div class="col-sm-8">
       <div class="col-sm-4">

        <input type="text" class="form-control"  name="serail" id="serail" >

      </div>
      <a href="" onclick="window.open('<?php echo $this->createUrl("/creditmachine/howto"); ?>',
       'newwindow',
       'width=800,height=600');
       return false;">วิธีดูserial</a>
     </div>
   </div>
   <div class="form-group">
    <label for="inputPassword3" class="col-sm-3 control-label">Vender :</label>
    <div class="col-sm-8">
      <div class="col-sm-4">
       <select id="vender" name="vender" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
        <option selected="selected">--เลือก--</option>
        <option value="EAK&W">EAK&W</option>
        <option value="NERA">NERA</option>
        <option value="POSNET">POSNET</option>
        <option value="LOXBIT">LOXBIT</option>
        <option value="ingenico">ingenico</option>
        <option value="GHL">GHL</option>
        <option value="STA">STA</option>
        <option value="">อื่นๆระบุ</option>
      </select>

    </div>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="vender1" id="vender1" placeholder="อื่นๆระบุ" >
      <a href="" onclick="window.open('<?php echo $this->createUrl("/creditmachine/howto2"); ?>',
       'newwindow',
       'width=800,height=600');
       return false;">วิธีดูข้อมูลVender</a>
     </div>
   </div>
 </div>
</div>
<div class="form-group">
  <label for="inputPassword3" class="col-sm-3 control-label">ตัวอย่าง :</label>
  <div class="col-sm-8">


    <!-- /.user-block -->
    <div class="row margin-bottom">


      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-3">
            <a href="" onclick="window.open('/creditmachine_file/1.JPG',
             'newwindow',
             'width=800,height=600');
             return false;"><img class="img-responsive" src="/creditmachine_file/1.JPG" alt="Photo"></a>
           </div>

           <div class="col-sm-3">
             <a href="" onclick="window.open('/creditmachine_file/2.JPG',
               'newwindow',
               'width=800,height=600');
               return false;"><img class="img-responsive" src="/creditmachine_file/2.JPG" alt="Photo"></a>
             </div>
             <div class="col-sm-3">
               <a href="" onclick="window.open('/creditmachine_file/3.JPG',
                 'newwindow',
                 'width=800,height=600');
                 return false;"><img class="img-responsive" src="/creditmachine_file/3.JPG" alt="Photo"></a>
               </div>
               <div class="col-sm-3">
                <a href="" onclick="window.open('/creditmachine_file/4.JPG',
                 'newwindow',
                 'width=800,height=600');
                 return false;"><img class="img-responsive" src="/creditmachine_file/4.JPG" alt="Photo"></a>
               </div>

             </div>
           </div>

         </div>
       </div>
       <div class="col-sm-12">
        <div class="row">
         <label  class="col-sm-3 control-label">แนบไฟล์รูปภาพ :</label>

         <div class="col-sm-4">
           <div class="profile-info-row">

            <div class="profile-info-value">
              <span class="">
                <button id="id-add-attachment" type="button" class="btn btn-sm btn-danger" value="เพิ่มไฟล">
                  <i class="ace-icon fa fa-paperclip bigger-50"></i>
                  แนบไฟล์เพิ่ม
                </button>

                <span>
                  <label style="font-size:12px;">ขนาดไฟลไม่เกืน 1 MB. ต่อไฟล์ <br>
                    อัพได้เฉพาะไฟล์ => . jpg jpeg png
                  </label>
                </span>
              </span>
            </div>
          </div>

          <div class="profile-info-row">
            <div class="profile-info-name"></div>
            <div  class="profile-info-value" id="form-attachments">
              <span class="">
                <div id="form-attachments" >
                  <input type="file" id="fff" name="filUpload[]" onChange="ValidateSingleInput(this);" >

                </div>
              </span>
            </div>
          </div>
        </div>
       <!--  <div class="col-sm-4">
          <input type="file" name="filUpload[]"><br>
          <input type="file" name="filUpload[]"><br>
          <input type="file" name="filUpload[]"><br>
        </div> -->
      </div>
    </div>
  </div>
  <div class="col-sm-12">
    <div class="box-footer" align="center"  style="border-radius: 10px;">
      <button type="button" id="clear" onclick="check()" class="btn btn-default">CLEAR</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <button type="submit" id="save"class="btn btn-success "><i class="fa fa-credit-card"></i> SAVE
      </button>
    </div>
  </div>
</div>
</div>
</section>



<script type="text/javascript" charset="utf-8" async defer>
  function fileSelected() {
    var file = document.getElementById('order_file').files[0];
    if (file) {
      var fileSize = 0;
      if (file.size > 1024 * 1024)
        fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
      else{
        fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
      }

      document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
      document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
      document.getElementById('fileType').innerHTML = 'Type: ' + file.type;



    }
  }
  function fncSubmit()
  {
    if(document.getElementById('bankname').value == "")
    {
      alert('กรุณากรอกข้อมูล bankname');
      return false;
    }
    else if(document.getElementById('tidcode').value == ""){
      alert('กรุณากรอกข้อมูล tidcode');
      return false;
    }
    else if(document.getElementById('brand1').value == ""){
      alert('กรุณากรอกข้อมูล brand1');
      return false;
    }
    else if(document.getElementById('generation').value == ""){
      alert('กรุณากรอกข้อมูล generation');
      return false;
    }
    else if(document.getElementById('serail').value == ""){
      alert('กรุณากรอกข้อมูล serail');
      return false;
    }
    else if(document.getElementById('vender1').value == ""){
      alert('กรุณากรอกข้อมูล vender');
      return false;
    }
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

            if (sFsize < 1024*1024*1) {
              blnValid = true;
              break;
            }else{
              alert("ไฟล์ขนาดห้ามเกิน 1 MB");
              blnValid = true;
              oInput.value = "";
              return false;
            }
          }
        }

        if (!blnValid) {
          alert("อัพไฟล์ไม่ได้, " + sFileName + " อัพได้เฉพาะ : " + _validFileExtensions.join(".,"));
          oInput.value = "";
          return false;
        }
      }
    }
    return true;
  }
  $(document).ready(function(){
   $('#banknam').select2();
   $("#vender1").hide();
   $("#generation").hide();
   $("#brand1").hide();

    ///--------------------เช็คไฟล์ถ้ามีค่าว่าง อัพโหลดไม่ได้ -------------------\\\

    $('form').submit(function(){
      if ($(':file').val() ==""){
        alert('กรุณาอัพไฟลรูปภาพด้วยครับ'); return false;
      }
      return true;
    });
           ///---------------------------------------------------------------\\\
           $('#id-add-attachment')
           .on('click', function(){
            var file = $('<input type="file" id="fff" name="filUpload[]" onChange="ValidateSingleInput(this);" >').appendTo('#form-attachments');
            file.ace_file_input();

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






            $("#brandmac").change(function() {
              $("#brand1").val($("#brandmac").val());

              var bra =$("#brandmac").val();
              if (bra=="") {
                $("#brand1").show();
              }else{
                $("#brand1").hide();
              }
            });

            $("#serailmac").change(function() {
              $("#generation").val($("#serailmac").val());

              var bra =$("#serailmac").val();
              if (bra=="") {
                $("#generation").show();
              }else{
                $("#generation").hide();
              }
            });


            $("#vender").change(function() {
              $("#vender1").val($("#vender").val());

              var bra =$("#vender").val();
              if(bra == "")
              {
                $("#vender1").show();
              }else{
                $("#vender1").hide();
              }


            });



            $("#branchname").change(function() {
              $("#branchid").val($("#branchname").val());
            });
            $("#branchid").keyup(function() {
              $("#branchname").val($("#branchid").val());
            });


          });



        </script>
        <style>
        .col-sm-4{
          position: relative;
          min-height: 1px;
          padding-right: 15px;
          padding-left: 0px;
        }
        .content {
          min-height: 10px;
          padding: 1px;
          margin-right: auto;
          margin-left: auto;
          padding-left: 15px;
          padding-right: 15px;
        </style>