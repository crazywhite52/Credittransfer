<?php
$baseUrl=Yii::app()->request->baseUrl;
?>
<link rel="stylesheet" href="<?php echo $baseUrl;?>/adminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $baseUrl;?>/adminLTE/dist/css/AdminLTE.min.css">
<script src="<?php echo $baseUrl;?>/assets/jquery-2.1.4.min.js"></script>
<!DOCTYPE html>
<script>
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
	$(document).ready(function () {
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
           $("#btn_save_regis").click(function(){


           	var rowed ={};
           	rowed['jobno'] = $('#jobno').val();
           	rowed['branchname'] = $('#branchname').val();
           	rowed['bankname'] = $('#bankname').val();
           	rowed['tidcode'] = $('#tidcode').val();
           	rowed['generation'] = $('#generation').val();
           	rowed['brand'] = $('#brand1').val();
           	rowed['serial'] = $('#serial').val();
           	rowed['vender'] = $('#vender1').val();
           	rowed['del'] = $('#del').val();
           	rowed['chkdel'] = $('#chkdel').val();


           	$.ajax({
           		dataType: 'json',
           		url: '<?php echo $this->createUrl("/Creditmachine/Edit2"); ?>',
           		data: rowed,
           		success: function(data, status, xhr) {
			                  // alert(data);
			              }
			          });
           	alert("บันทึกแก้ไขข้อมูลเรียบร้อยแล้ว");
           	window.close()


           });




       });

	function deleteImage(id){
		var r = confirm("คุณต้องการลบภาพนี้ใช่หรือไม่")
		var rowed ={};
		rowed['ids'] = id;
		rowed['file'] =  "<?php echo $_SERVER['DOCUMENT_ROOT'] . '/creditmachine_file/'?>"  + id;


		if(r == true)
		{
			$.ajax({
				url: '<?php echo $this->createUrl("/Creditmachine/Deleteupload"); ?>',
				data: rowed,
					 // $target_path = $_SERVER['DOCUMENT_ROOT'] . "/creditmachine_file/";,

					 success: function () {
					 	window.setTimeout(function(){

					 		location.reload();
					 	}, 500);
					 },
					 error: function () {
             // do something
         }
     });
		}
	};
</script>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">แก้ไข</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<form class="form-horizontal" method="post" action="<?php echo $this->createUrl("/creditmachine/edit2"); ?>" id="form2" enctype="multipart/form-data">
			<div class="form-horizontal">
				<div class="box-body">
					<div class="form-group">
						<label for="jobno" class="col-sm-2 control-label">เลขJOB</label>

						<div class="col-sm-10">
							<input type="text" class="form-control" id="jobno1" value="<?php echo $data["jobno"]; ?>" disabled>
							<input type="hidden" class="form-control"  name="jobno" id="jobno" value="<?php echo $data["jobno"]; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="branchname" class="col-sm-2 control-label">สาขา</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="branchname" id="branchname" value="<?php echo $data["branchname"]; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="bankname" class="col-sm-2 control-label">ธนาคาร</label>
						<?php
						$str="SELECT bank.bankcode,bank.bankname FROM bank";
						$result=Yii::app()->datablue->createCommand($str)->queryAll();
						?>
						<div class="col-sm-10">
							<select id="bankname" name="bankname" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
								<option value="<?php echo $data['bank']; ?>"><?php echo $data['bankname']; ?></option>

								<?php foreach ($result as $r){ ?>
									<option value="<?php echo $r['bankcode']; ?>"><?php echo $r['bankname']; ?></option>


								<?php } ?>


							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="tidcode" class="col-sm-2 control-label">หมายเลขTID</label>

						<div class="col-sm-10">
							<input type="text" class="form-control"  name="tidcode" id="tidcode" value="<?php echo $data["tidcode"]; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="brand" class="col-sm-2 control-label">ยี่ห้อเครื่อง</label>

						<div class="col-sm-10">
							<select id="brandmac" name="brandmac" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
								<option  value="<?php echo $data['brand']; ?>"><?php echo $data['brand']; ?></option>
								<option value="VeriFone">VeriFone</option>
								<option value="Hypercom">Hypercom</option>
								<option value="CASTLES">CASTLES</option>
								<option value="">อื่นๆระบุ</option>
							</select>

							<input type="text" class="form-control"  name="brand1" id="brand1" value="<?php echo $data['brand']; ?>" >
						</div>
					</div>
					<div class="form-group">
						<label for="generation" class="col-sm-2 control-label">รุ่นเครื่อง</label>

						<div class="col-sm-10">
							<select id="serailmac" name="serailmac" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
								<option value="<?php echo $data['generation']; ?>"><?php echo $data['generation']; ?></option>
								<option value="VX510">VX510</option>
								<option value="VX520">VX520</option>
								<option value="iCT220">iCT220</option>
								<option value="">อื่นๆระบุ</option>
							</select>
							<input type="text" class="form-control" name="generation" id="generation" value="<?php echo $data['generation']; ?>" >
						</div>
					</div>
					<div class="form-group">
						<label for="serial" class="col-sm-2 control-label">Serial</label>

						<div class="col-sm-10">
							<input type="text" class="form-control" name="serial" id="serial" value="<?php echo $data["serial"]; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="vender" class="col-sm-2 control-label">Vender</label>

						<div class="col-sm-10">
							<select id="vender" name="vender" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
								<option value="<?php echo $data['vender']; ?>"><?php echo $data['vender']; ?></option>
								<option value="EAK&W">EAK&W</option>
								<option value="NERA">NERA</option>
								<option value="POSNET">POSNET</option>
								<option value="LOXBIT">LOXBIT</option>
								<option value="ingenico">ingenico</option>
								<option value="GHL">GHL</option>
								<option value="STA">STA</option>
								<option value="">อื่นๆระบุ</option>
							</select>
							<input type="text" class="form-control" name="vender1" id="vender1" value="<?php echo $data['vender']; ?>" >
						</div>
					</div>
					<div class="form-group">
						<label for="vender" class="col-sm-2 control-label">แนบไฟล์ภาพ</label>

						<div class="col-sm-10">


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


										</div>
									</span>
								</div>
							</div>

						</div>
					</div>
					<div class="form-group">
						<label for="vender" class="col-sm-2 control-label">รูปภาพ</label>

						<div class="col-sm-10">
							<?php foreach($pic as $r){ ?>

								<!-- 	<input name="chkdel" id="chkdel" type="checkbox" value="1"> เลือกเพื่อลบรูปภาพ -->
								<form class="form-horizontal">
									<a href="" onclick="window.open('/creditmachine_file/<?php echo $r['pic']; ?>',
										'newwindow',
										'width=800,height=600');
										return false;"><img class="img-responsive" src="/creditmachine_file/<?php echo $r['pic']; ?>" alt="Photo" height="150" width="150"></a>

										<!-- <img class="img-responsive" src="/creditmachine_file/<?php echo $r['pic']; ?>" alt="Photo" height="150" width="150"> -->
										<div class="form-group margin-bottom-none">

											<div class="col-sm-5">
												<input type="text" id="del" name="del" class="form-control" align="center" value="<?php echo $r['pic']; ?>" disabled>
											</div>
											<div class="col-sm-3">
												<button type="button" class="btn btn-info pull-center" onclick="deleteImage('<?php echo $r['pic']; ?>')"  id="btn">ลบ</button>
											</div>
										</div>
									</form>
									<br>
								<?php } ?>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer" align="center">

						<button type="submit" class="btn btn-info pull-center" >Save</button>
					</div>
					<!-- /.box-footer -->
				</div>
			</div>
		</form>
	</body>
	</html>