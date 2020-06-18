<?php
$baseUrl=Yii::app()->request->baseUrl;
$br=Yii::app()->request->cookies['cookie_user_branch']->value;

?>
<?php

$str="SELECT * FROM b_jibpay WHERE `status`='1' GROUP BY bankcode";
$result=Yii::app()->datablue->createCommand($str)->queryAll();


$str2="SELECT * FROM b_cuspay WHERE `status`='1' GROUP BY bankcode";
$result2=Yii::app()->datablue->createCommand($str2)->queryAll();

$str3="SELECT * FROM b_subpay WHERE `status`='1' GROUP BY bankcode";
$result3=Yii::app()->datablue->createCommand($str3)->queryAll();
?>



<style>
input[type=radio] {
	height: 22px;
	width: 22px;
	background-color: red;

}


</style>
<script>
	$(document).ready(function(){
		//$("#cidcustomer").inputmask({"mask": "9999 9999 9999 9999"});
		$("#telcustomer").inputmask({"mask": "9999999999"});

		var getDatamanage = function () {
			var source =
			{
				datatype: "json",
				datafields: [
				//{name: 'id', type: 'int'},
				{name: 'serial', type: 'string'},
				{name: 'Name', type: 'string'},
				{name: 'CATEGORYID', type: 'string'},
				{name: 'classname', type: 'string'},
				{name: 'price1', type: 'string'},
				{name: 'product', type: 'string'}
				],
				url: '<?php echo $this->createUrl("Credittype/Apiserial"); ?>',
				cache: false,
				records: 'content',
			};
			var dataAdapter = new $.jqx.dataAdapter(source, {
				formatData: function (data) {
					data.serial = $("#inputSerail").val();
					return data;
				}
			});
			return dataAdapter;
		}
		

		$("#grid1").jqxGrid(
		{
			source: getDatamanage(),
			theme: 'darkblue',
			width: '100%',
			height: '60px',
			enablebrowserselection: true,
			enabletooltips: true,
			columns: [
			{text: 'Serail',datafield: 'serial', width: '20%', align: 'center',cellsalign: 'center'},
			{text: 'Product Id',datafield: 'product', width: '15%', align: 'center',cellsalign: 'center'},
			{text: 'Product Name',datafield: 'Name', width: '35%', align: 'center',cellsalign: 'center'},
			{text: 'CATEGORY ID',datafield: 'CATEGORYID', width: '15%',hidden: true, align: 'center',cellsalign: 'center'},
			{text: 'Category Name',datafield: 'classname', width: '15%', align: 'center',cellsalign: 'center'},
			{text: 'Price',datafield: 'price1', width: '10%', align: 'center',cellsalign: 'right',cellsformat: 'n' ,cellsformat: 'F2'},
			]
		});
		$("#grid2").jqxGrid(
		{
			
			theme: 'darkblue',
			width: '100%',
			height: '250px',
			enabletooltips: true,
			editable: true,
			showstatusbar: true,
			statusbarheight: 25,
			showaggregates: true,
			columns: [
			{text: 'Serail',datafield: 'serial', width: '20%',hidden: true, align: 'center',cellsalign: 'center',editable: false,},
			{text: 'Product Code',datafield: 'product', width: '20%', align: 'center',cellsalign: 'center',editable: false,},
			{text: 'Product Name',datafield: 'Name', width: '25%', align: 'center',cellsalign: 'center',editable: false,},
			{text: 'CATEGORY ID',datafield: 'CATEGORYID',hidden: true, align: 'center',cellsalign: 'center',editable: false,},
			{text: 'Category Name',datafield: 'classname', width: '15%', align: 'center',cellsalign: 'center',editable: false,},
			{text: 'Price',datafield: 'price1', width: '10%', align: 'center',cellsalign: 'right',cellsformat: 'n' ,cellsformat: 'F2',aggregates: ['sum']},
			{text: 'Delete', datafield: 'Delete', columntype:'button',width: '10%',cellsalign: 'center',align: 'center',cellsrenderer:function () {
				return 'delete';
			}, buttonclick: function (row) {
                     // open the popup window when the user clicks a button.
                     var id = $("#grid2").jqxGrid('getrowid', row);
                     //alert(id);
                     
                     var r = confirm("ต้องการลบ serial นี้ใช่/หรือไม่!");
                     if (r == true) {
                     	var commit = $("#grid2").jqxGrid('deleterow', id);
                     } else {
                     	
                     }
                 }
             },
             ]
         });


		$('#inputSerail').keypress(function (e) {
			if (e.which == 13) {
				e.preventDefault();

				$("#inputSerail").val($("#inputSerail").val());
				$("#grid1").jqxGrid({source: getDatamanage()});
				$('#grid1').jqxGrid('selectrow', 0);


				setTimeout(function(){

					var rowindex=$('#grid1').jqxGrid('getselectedrowindexes');
					var rowscount=rowindex.length;
					
					//swal("ไม่พบข้อมูล!", "You clicked the button!", "error");

					
					for(var i=0; i<rowscount; i++){

						if(rowindex[i]!=-1){
							var dataread=$('#grid1').jqxGrid('getrowdata',rowindex[i]);
							if(dataread.product==null || dataread.product==''){
								swal("ไม่พบข้อมูล!", "You clicked the button!", "error");
								return false;
							}else{
								var rows={};
								rows['serial']=dataread.serial;
								rows['product']=dataread.product;
								rows['Name']=dataread.Name;
								rows['CATEGORYID']=dataread.CATEGORYID;
								rows['classname']=dataread.classname;
								rows['price1']=dataread.price1;
								$("#grid2").jqxGrid('addrow', null, rows);
							}
							
						}
					}

				}, 1200);

				$("#inputSerail").val('');
			}
		});
		// $('#addRow').click(function(event) {
		// 	var rowindex=$('#grid1').jqxGrid('getselectedrowindexes');
		// 	var rowscount=rowindex.length;
		// 	if(rowscount==0){
		// 		swal("ไม่พบข้อมูล!", "You clicked the button!", "error");
		// 		return false;
		// 	}
		// 	for(var i=0; i<rowscount; i++){
		// 		if(rowindex[i]!=-1){
		// 			var dataread=$('#grid1').jqxGrid('getrowdata',rowindex[i]);
		// 			var rows={};

		// 			rows['serial']=dataread.serial;
		// 			rows['product']=dataread.product;
		// 			rows['Name']=dataread.Name;
		// 			rows['classname']=dataread.classname;
		// 			rows['price1']=dataread.price1;
		// 			$("#grid2").jqxGrid('addrow', null, rows);
		// 		}
		// 	}

		// 	//alert(rowscount);
		// });
		

		

//$("#fm01").css("display", "none");
$("#fm01").css("display", "none");
$("#fm02").css("display", "none");
$("#fm03").css("display", "none");
document.getElementById("fiel1").disabled = true;
document.getElementById("fiel2").disabled = true;

$('#myForm input').on('change', function() {
	//alert($('input[name=r1]:checked', '#myForm').val()); 
	var fmrd = $('input[name=r1]:checked', '#myForm').val();
	if(fmrd==1){
		$("#fm01").css("display", "block");
		$("#fm02").css("display", "none");
		$("#fm03").css("display", "none");
	}else if (fmrd==2) {
		$("#fm02").css("display", "block");
		$("#fm01").css("display", "none");
		$("#fm03").css("display", "none");

	}else if (fmrd==3) {
		$("#fm03").css("display", "block");
		$("#fm01").css("display", "none");
		$("#fm02").css("display", "none");
	}
});

$("#Save").click(function(){
	//alert('1234');
	var tabledata=$('#grid2').jqxGrid("getdatainformation");
	var rowcout=tabledata.rowscount;
	if(rowcout==0){
		swal("ไม่พบข้อมูล!", "You clicked the button!", "error");
		return false;
	}
	if ($("#customer").val()=='') {
		swal("กรุณากรอกข้อมูล ชื่อลูกค้า!", "You clicked the button!", "error");
		return false;
	}if ($("#cidcustomer1").val()=='') {
		swal("กรุณากรอกข้อมูล เลขบัตร!", "You clicked the button!", "error");
		return false;
	}if ($("#cidcustomer4").val()=='') {
		swal("กรุณากรอกข้อมูล เลขบัตร!", "You clicked the button!", "error");
		return false;
	}if ($("#telcustomer").val()=='') {
		swal("กรุณากรอกข้อมูล เบอร์โทร!", "You clicked the button!", "error");
		return false;
	}

	var fmrd = $('input[name=r1]:checked', '#myForm').val();
	if(fmrd==1){
		var ctxtsum = $("#txtsum").val();
	}else if (fmrd==2) {
		var ctxtsum = $("#txtsum_fm02").val();
	}else if (fmrd==3) {
		var ctxtsum = $("#txtsum_fm03").val();
	}
	
	var sum = 0;
	for(var i=0;i<rowcout;i++){
		var rowdata={};
		var getData=$("#grid2").jqxGrid("getrowdata",i);

		sum += parseInt(getData.price1);
	}
	if (ctxtsum!=sum) {
		swal("ยอดไม่ตรงกัน!", "You clicked the button!", "error");
		return false;
	}
	



	swal({
		title: "ยืนยันการบันทึกข้อมูล",
		text: "Submit to run save!",
		type: "info",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}, function () {

		//var fmrd = $('input[name=r1]:checked', '#myForm').val();
		if(fmrd==1){
			var txt1 = $("#txt1").val();
			var txt2 = $("#txt2").val();
			var txtsum = $("#txtsum").val();
			var customer=$("#customer").val();
			var cidcustomer1=$("#cidcustomer1").val();
			var cidcustomer2=$("#cidcustomer2").val();
			var telcustomer=$("#telcustomer").val();
			var fmr2 = $('input[name=r2]:checked', '#myForm1').val();
			var fmr3 = $('input[name=r3'+fmr2+']:checked', '#myForm1').val();
			//swal(txtsum);
			var rows={};
			rows['update']='false';
			rows['id']='';
			rows['type']=fmrd;
			rows['fmr2']=fmr2;
			rows['fmr3']=fmr3;
			rows['txt1']=txt1;
			rows['txt2']=txt2;
			rows['txtsum']=txtsum;
			rows['customer']=customer;
			rows['cidcustomer1']=cidcustomer1;
			rows['cidcustomer2']=cidcustomer2;
			rows['telcustomer']=telcustomer;
			rows['br']='<?php echo $br ?>';


			// var sum = 0;
			// for(var i=0;i<rowcout;i++){
			// 	var rowdata={};
			// 	var getData=$("#grid2").jqxGrid("getrowdata",i);

			// 	sum += parseInt(getData.price1);
			// }
			//alert(sum);
			// if(sum>txtsum){
			// 	swal("ยอดไม่ตรงกัน");
			// 	return false;
			// }

		}else if (fmrd==2) {

			var txt1 = $("#txt1_fm02").val();
			var txt2 = $("#txt2_fm02").val();
			var txtsum = $("#txtsum_fm02").val();
			var customer=$("#customer").val();
			var cidcustomer1=$("#cidcustomer1").val();
			var cidcustomer2=$("#cidcustomer2").val();
			var telcustomer=$("#telcustomer").val();
			var fmr2 = $('input[name=r2]:checked', '#myForm2').val();
			var fmr3 = $('input[name=r3'+fmr2+']:checked', '#myForm2').val();
			//swal(fmr2+fmr3);
			var rows={};
			rows['update']='false';
			rows['id']='';
			rows['type']=fmrd;
			rows['fmr2']=fmr2;
			rows['fmr3']=fmr3;
			rows['txt1']=txt1;
			rows['txt2']=txt2;
			rows['txtsum']=txtsum;
			rows['customer']=customer;
			rows['cidcustomer1']=cidcustomer1;
			rows['cidcustomer2']=cidcustomer2;
			rows['telcustomer']=telcustomer;
			rows['br']='<?php echo $br ?>';
		}else if (fmrd==3) {
			var txt1 = $("#txt1_fm03").val();
			var txt2 = $("#txt2_fm03").val();
			var txtsum = $("#txtsum_fm03").val();
			var customer=$("#customer").val();
			var cidcustomer1=$("#cidcustomer1").val();
			var cidcustomer2=$("#cidcustomer2").val();
			var telcustomer=$("#telcustomer").val();
			var fmr2 = $('input[name=r2]:checked', '#myForm3').val();
			var fmr3 = $('input[name=r3'+fmr2+']:checked', '#myForm3').val();
			//swal(fmr2+fmr3);
			var rows={};
			rows['update']='false';
			rows['id']='';
			rows['type']=fmrd;
			rows['fmr2']=fmr2;
			rows['fmr3']=fmr3;
			rows['txt1']=txt1;
			rows['txt2']=txt2;
			rows['txtsum']=txtsum;
			rows['customer']=customer;
			rows['cidcustomer1']=cidcustomer1;
			rows['cidcustomer2']=cidcustomer2;
			rows['telcustomer']=telcustomer;
			rows['br']='<?php echo $br ?>';
		}
//alert($.param(rows));

//alert(rowcout);

$.post("<?php echo $this->createUrl("Credittype/Paysave"); ?>", $.param(rows))
.done(function( data,status ) {
	if(data!=''){
		setTimeout(function () {

			if(rowcout>0){
				for(var i=0;i<rowcout;i++){
					var rowdata={};
					var getData=$("#grid2").jqxGrid("getrowdata",i);
					rowdata['serial']=getData.serial;
					rowdata['product']=getData.product;
					rowdata['Name']=getData.Name;
					rowdata['CATEGORYID']=getData.CATEGORYID;
					rowdata['classname']=getData.classname;
					rowdata['price1']=getData.price1;
					rowdata['edit']='';
					rowdata['orderid']=data;
					rowdata['update']='false';
					$.ajax({
						type: "POST",
						url: "<?php echo $this->createUrl("Credittype/Savelist"); ?>",
						data: $.param(rowdata),
						success: function(data, status, xhr) {
											//alert(data);	
											commit(true);
										}
									});

				}
			}
			swal({
				title: "CODE :"+data,
				text: "",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-info",
				confirmButtonText: "Yes, Success it!",
				//closeOnConfirm: false
			},
			function(){
				swal("Deleted!", "บันทึกข้อมูลสำเร็จ", "success");
				location.reload();
			});
			//swal("บันทึกข้อมูลสำเร็จ!", data, "success");
            	//window.location.href = "http://172.18.0.30/admin2018/index.php/site/index";
            	//location.reload();
            }, 3000);
	}else{
		swal(data, "You clicked the button!", "error");
         	//return false;
         	location.reload();
         }
     });
});


});

});
function checkedisable(value){

	jQuery("input:radio").attr('checked',false);
	jQuery("input:radio").attr('disabled','disabled');

	jQuery("input:radio[name=r2]").attr('disabled',false);
	jQuery("input:radio[name=r1]").attr('disabled',false);
	var radio=document.getElementsByName("r3"+value);
	var len=radio.length;
	for(var i=0;i<len;i++)
	{
		radio[i].disabled=false;
	}


}


function check(val)
{
	if(val == "2"){
		document.getElementById("fiel1").disabled = false;
		document.getElementById("fiel2").disabled = true;
		$("#fiel2").hide();
		$("#fiel1").show();



	}else if(val == "3"){
		document.getElementById("fiel1").disabled = true;
		document.getElementById("fiel2").disabled = false;
		$("#fiel1").hide();
		$("#fiel2").show();


	}else{
		document.getElementById("fiel1").disabled = true;
		document.getElementById("fiel2").disabled = true;
		$("#fiel2").hide();
		$("#fiel1").hide();
	}

}
function sum() {
	var result=0;
	var txtFirstNumberValue = document.getElementById('txt1').value;
	var txtSecondNumberValue = document.getElementById('txt2').value;
	if (txtFirstNumberValue !="" && txtSecondNumberValue ==""){
		result = parseInt(txtFirstNumberValue);
	}else if(txtFirstNumberValue == "" && txtSecondNumberValue != ""){
		result= parseInt(txtSecondNumberValue);
	}else if (txtSecondNumberValue != "" && txtFirstNumberValue != ""){
		result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
	}
	if (!isNaN(result)) {
		document.getElementById('txtsum').value = result;
	}
}
function sum2() {
	var result=0;
	var txtFirstNumberValue = document.getElementById('txt1_fm02').value;
	var txtSecondNumberValue = document.getElementById('txt2_fm02').value;
	if (txtFirstNumberValue !="" && txtSecondNumberValue ==""){
		result = parseInt(txtFirstNumberValue);
	}else if(txtFirstNumberValue == "" && txtSecondNumberValue != ""){
		result= parseInt(txtSecondNumberValue);
	}else if (txtSecondNumberValue != "" && txtFirstNumberValue != ""){
		result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
	}
	if (!isNaN(result)) {
		document.getElementById('txtsum_fm02').value = result;
	}
}

function sum3() {
	var result=0;
	var txtFirstNumberValue = document.getElementById('txt1_fm03').value;
	var txtSecondNumberValue = document.getElementById('txt2_fm03').value;
	if (txtFirstNumberValue !="" && txtSecondNumberValue ==""){
		result = parseInt(txtFirstNumberValue);
	}else if(txtFirstNumberValue == "" && txtSecondNumberValue != ""){
		result= parseInt(txtSecondNumberValue);
	}else if (txtSecondNumberValue != "" && txtFirstNumberValue != ""){
		result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
	}
	if (!isNaN(result)) {
		document.getElementById('txtsum_fm03').value = result;
	}
}


</script>
<div class="content-wrapper" style="background-color: #d2d0d0;">
	<section class="content-header">
		<h1>
			ประเภทสินเชื่อ / ธนาคาร
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"> ประเภทสินเชื่อ / ธนาคาร</li>
		</ol>
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-4" style="padding-right: 15px; padding-left: 0px;">
						<div class="box box-primary" style="border-radius: 10px;">
							<div class="box-header with-border" style="border-radius: 10px;">
								<div class="form-group">
									<h4><label>ชื่อลูกค้า <a class="fa fa-user"></a>&nbsp;&nbsp;<i style="color:red;">*</i></label></h4>
									<input type="text" class="form-control" id="customer" placeholder=" ..." autofocus="true" style="border-radius: 5px; border-color: #00c0ef;">
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="box box-primary" style="border-radius: 10px;">
							<div class="box-header with-border" style="border-radius: 10px;">
								<div class="form-group">
									<h4><label>Card Number <a class="fa fa-credit-card"></a>&nbsp;&nbsp;<i style="color:red;"> *</i></label></h4>
									<div class="col-sm-3" style="padding-left: 10px;padding-right: 10px;">
										<input type="text" style="border-radius: 5px; border-color: #00c0ef;" class="form-control" id="cidcustomer1" autocomplete="off" maxlength="4" pattern="\d{4}" title="First four digits" onKeyUp="if(isNaN(this.value)){ alert('ตัวเลขเท่านั้น'); this.value='';}">
									</div>
									<div class="col-sm-3" style="padding-left: 10px;padding-right: 10px;">
										<input type="text" style="border-radius: 5px; border-color: #00c0ef;" class="form-control" id="" autocomplete="off" maxlength="4" pattern="\d{4}" title="Second four digits" disabled="true" placeholder="XXXX">
									</div>
									<div class="col-sm-3" style="padding-left: 10px;padding-right: 10px;">
										<input type="text" style="border-radius: 5px; border-color: #00c0ef;" class="form-control" id="" autocomplete="off" maxlength="4" pattern="\d{4}" title="Third four digits" disabled="true" placeholder="XXXX">
									</div>
									<div class="col-sm-3" style="padding-left: 10px;padding-right: 10px;">
										<input type="text" style="border-radius: 5px; border-color: #00c0ef;" class="form-control" id="cidcustomer2" autocomplete="off" maxlength="4" pattern="\d{4}" title="Fourth four digits" onKeyUp="if(isNaN(this.value)){ alert('ตัวเลขเท่านั้น'); this.value='';}">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4" style="padding-right: 0px; padding-left: 15px;">
						<div class="box box-primary" style="border-radius: 10px;">
							<div class="box-header with-border" style="border-radius: 10px;">
								<div class="form-group">
									<h4><label>เบอร์โทร <a class="fa fa-phone-square"></a>&nbsp;&nbsp;<i style="color:red;"> *</i></label></h4>
									<input type="text" style="border-radius: 5px; border-color: #00c0ef;" class="form-control" id="telcustomer" placeholder="เบอร์โทร 10 หลัก" >
								</div>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">
					<div class="box box-warning" style="border-radius: 10px;">
						<div class="box-header with-border" style="border-radius: 10px;">
							<h4><label>เลือกรายการ <i style="color:red;"> *</i></label></h4>
							<form id="myForm">
								<div class="col-md-12">
									<div class="col-md-4">
										<div class="form-group">
											<label>
												<div class="col-md-1"><input type="radio" name="r1" id="r1" onclick="check(this.value)" value = "1" 
													>
												</div>
												<div class="col-md-10" style="margin-top: 5px;">1. SUPPLIER จ่ายดอกเบี้ย (0%)</div>
											</label>

										</div>

									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>
												<div class="col-md-1"><input type="radio" name="r1" id="r1"  onclick="check(this.value)"  value = "2" ></div>
												<div class="col-md-10" style="margin-top: 5px;">2. J.I.B จ่ายดอกเบี้ย (0%)</div>
											</label>
										</div>

									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>
												<div class="col-md-1" style="padding-right: 0px;"><input type="radio" name="r1" id="r1"  onclick="check(this.value)"  value = "3" ></div>
												<div class="col-md-11" style="margin-top: 5px;">3. ลูกค้าจ่ายดอกเบี้ย(อัตราดอกเบี้ยปกติ)</div>
											</label>
										</div>
									</div>

								</div>
							</form>
							<div class="col-md-12">
								<div class="col-md-4">


								</div>
								<div id="fm02">

									<div class="col-md-7">
										<fieldset id= "fiel1">
											<form id="myForm2">
												<table class="table table-striped">
													<tbody>
														<?php foreach ($result as $key => $r) { ?>
															<tr>
																<td style="width: 160px">
																	<label for="">
																		<input type="radio" name="r2" onclick="checkedisable(this.value)" value="<?php echo $r['bankcode']; ?>" > <?php echo $r['bankcode']; ?></label>
																	</td>
																	<?php
																	$xx = $r['bankcode'];
																	$qr1="SELECT * FROM b_jibpay where bankcode = '$xx' AND `status`='1' ";
																	$datachk1=Yii::app()->datablue->createCommand($qr1)->queryAll();
																	?>
																	<td>
																		<?php foreach ($datachk1 as $key => $v1) { ?>
																			<label for="">
																				<input type="radio" name="r3<?php echo $v1['bankcode']; ?>" value="<?php echo $v1['paymonth']; ?>" ><?php echo $v1['detail']; ?>
																			</label>

																		<?php } ?>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</form>
											</fieldset>
										</div>
										<form class="form-horizontal">
											<div class="box-body">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">เงินดาวน์</label>

														<div class="col-sm-9">
															<input type="text" class="form-control" id="txt1_fm02" placeholder="เงินดาวน์" onkeyup="sum2();" >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">สินเชื่อ</label>

														<div class="col-sm-9">
															<input type="text" class="form-control" id="txt2_fm02" placeholder="สินเชื่อ" onkeyup="sum2();" >
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-2 control-label">รวม</label>

														<div class="col-sm-10">
															<input type="text" name="txtsum" class="form-control" id="txtsum_fm02" placeholder="0" disabled="true" >
														</div>
													</div>

												</div>
											</div>
										</form>
									</div>
									<div id="fm03">
										<div class="col-md-6 col-md-offset-6">
											<fieldset id= "fiel2">
												<form id="myForm3">
													<table class="table table-striped">
														<tbody>
															<?php foreach ($result2 as $k => $r2) { ?>
																<tr>
																	<td style="width: 120px">
																		<label for="">
																			<input type="radio" name="r2" id="r2" onclick="checkedisable(this.value)" value="<?php echo $r2['bankcode']; ?>">
																			<?php echo $r2['bankcode']; ?>
																		</label>

																	</td>
																	<?php
																	$xx2 = $r2['bankcode'];
																	$qr2="SELECT * FROM b_cuspay where bankcode = '$xx2' AND `status`='1'";
																	$datachk2=Yii::app()->datablue->createCommand($qr2)->queryAll();
																	?>
																	<td>


																		<?php foreach ($datachk2 as $j => $v2) { ?>
																			<label for="">
																				<input type="radio" name="r3<?php echo $v2['bankcode']; ?>"  value="<?php echo $v2['paymonth']; ?>" ><?php echo $v2['detail']; ?>
																			</label>
																		<?php } ?>

																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</form>
											</fieldset>
										</div>
										<form class="form-horizontal">
											<div class="box-body">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">เงินดาวน์</label>

														<div class="col-sm-9">
															<input type="text" class="form-control" id="txt1_fm03" placeholder="เงินดาวน์" onkeyup="sum3();" >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">สินเชื่อ</label>

														<div class="col-sm-9">
															<input type="text" class="form-control" id="txt2_fm03" placeholder="สินเชื่อ" onkeyup="sum3();" >
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-2 control-label">รวม</label>

														<div class="col-sm-10">
															<input type="text" name="txtsum" class="form-control" id="txtsum_fm03" placeholder="0" disabled="true" >
														</div>
													</div>

												</div>
											</div>
										</form>
									</div>

								</div>
								<!-- /.box-header -->
								<!-- form start -->
								<div id="fm01">
									<div class="col-md-6 col-md-offset-0">
											<fieldset id= "fiel2">
												<form id="myForm1">
													<table class="table table-striped">
														<tbody>
															<?php foreach ($result3 as $k => $r3) { ?>
																<tr>
																	<td style="width: 120px">
																		<label for="">
																			<input type="radio" name="r2" id="r2" onclick="checkedisable(this.value)" value="<?php echo $r3['bankcode']; ?>">
																			<?php echo $r3['bankcode']; ?>
																		</label>

																	</td>
																	<?php
																	$xx3 = $r3['bankcode'];
																	$qr4="SELECT * FROM b_subpay where bankcode = '$xx3' AND `status`='1'";
																	$datachk4=Yii::app()->datablue->createCommand($qr4)->queryAll();
																	?>
																	<td>


																		<?php foreach ($datachk4 as $j => $v4) { ?>
																			<label for="">
																				<input type="radio" name="r3<?php echo $v4['bankcode']; ?>"  value="<?php echo $v4['paymonth']; ?>" ><?php echo $v4['detail']; ?>
																			</label>
																		<?php } ?>

																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</form>
											</fieldset>
										</div>
									<form class="form-horizontal">
										<div class="box-body">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-sm-3 control-label">เงินดาวน์</label>

													<div class="col-sm-9">
														<input type="text" class="form-control" id="txt1" placeholder="เงินดาวน์" onkeyup="sum();" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">สินเชื่อ</label>

													<div class="col-sm-9">
														<input type="text" class="form-control" id="txt2" placeholder="สินเชื่อ" onkeyup="sum();" >
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-sm-2 control-label">รวม</label>

													<div class="col-sm-10">
														<input type="text" name="txtsum" class="form-control" id="txtsum" placeholder="0" disabled="true" >
													</div>
												</div>

											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="box box-danger" style="border-radius: 10px;">
							<div class="box-header with-border" style="border-radius: 10px;">
								<div class="form-group">
									<h4><label class="control-label" for="inputSerail">ยิง Product <i style="color:red;"> * (ยิงเฉพาะ Product เท่านั้น)</i></label></h4>
									<input type="text" style="border-radius: 5px; border-color: #dd4b39;" class="form-control" id="inputSerail" placeholder="Enter Product...">
								</div>
								<div style="display: none">
									<div id="grid1"></div>
								</div>
							</div>

							<!-- /.box-header -->
							<div class="box-body">

						<!-- <button id="addRow" class="btn btn-info btn-sm">
							<i class="glyphicon glyphicon-chevron-down"></i> Add รายการ</button> -->
							<div id="grid2"></div>
							<div class="box-footer" align="center">
								<a class="btn btn-app bg-olive" id="Save">
									<i class="fa fa-save"></i> Save
								</a>
								<a class="btn btn-app bg-maroon">
									<i class="fa fa-close"></i> ยกเลิก
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</section>
</div>






