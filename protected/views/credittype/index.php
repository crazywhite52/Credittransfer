
<script>
	$(document).ready(function(){

		$("#date_befor").jqxDateTimeInput({ width: '150px',height:'25px',  formatString: 'dd-MM-yyyy' });
		$("#date_after").jqxDateTimeInput({ width: '150px',height:'25px',  formatString: 'dd-MM-yyyy' });

		$("#btex_group").on("click",function(){

			$("#grid1").jqxGrid({source: getAdapter()});
		});

		$("#ref").click(function(){
			setTimeout(function(){
				$("#grid1").jqxGrid('refresh');
			}, 1500);

		});
		var getAdapter=function(){
			var source =
			{
				datatype: "json",
				datafields: [
				{name: 'no', type: 'int'},
				{name: 'cancel', type: 'string'},
				{name: 'edit', type: 'string'},
				{name: 'orderdate', type: 'date'},
				{name: 'orderid', type: 'string'},
				{name: 'customer', type: 'string'},
				{name: 'user', type: 'string'},
				{name: 'status', type: 'string'},
				{name: 'jobtype', type: 'string'},
				{name: 'downpayment', type: 'number'},
				{name: 'creditpayment', type: 'number'},
				{name: 'sumpayment', type: 'number'},
				{name: 'cidcustomer', type: 'string'},

				],
				url: '<?php echo $this->createUrl("credittype/listdata"); ?>',
				cache: false,
			}
		// var dataAdapter = new $.jqx.dataAdapter(source);
		var dataAdapter = new $.jqx.dataAdapter(source,{
			formatData: function (data) {
				data.date_befor = $("#date_befor").val();
				data.date_after = $("#date_after").val();
				data.stat1 = $("#stat1").val();

				return data;
			}
		});
		return dataAdapter;
	};
	var workstat = function (row, columnfield, value, defaulthtml, columnproperties, datafield) {
			//alert(value);
			if(value=='รอ Approved'){
				return "color3";
			}else if(value=='Approved'){
				return "color1";
			}else if(value=='Cancel'){
				return "color2";
			}
			return "";
		}
		$("#grid1").jqxGrid(
		{
			source: getAdapter(),
			theme: 'darkblue',
			width: '100%',
			height: 400,
			enablebrowserselection: true,
			enabletooltips: true,
			columnsresize: true,
			columnsreorder: true,
			sortable: true,
			pageable: true,
			showfilterrow: true,
			showstatusbar: true,
			statusbarheight: 0,
			pagesize: 20,
			pagesizeoptions: ['20', '50', '100'],
			filterable: true,
			filtermode: 'simple',
			columns: [

			{text: 'สถานะ',datafield: 'status', width: '120px', align: 'center',filtertype: 'checkedlist',cellsalign: 'center',cellclassname:workstat},
			{ text: '#',datafield: 'cancel', editable: false, align: 'center', width: '60px',cellsalign:'center',columntype: 'button',
			buttonclick: function (row) {
				var dataread = $('#grid1').jqxGrid('getrowdata',row);
				var id = dataread.no;
				//alert(id);
				var data = "&jobid="+id;
				swal({
					title: "ต้องการยกเลิกใช่หรือไม่?",
					text: "",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, delete it!",
					closeOnConfirm: false
				},
				function(){
					$.ajax({
						type: "POST",
						url: "<?php echo $this->createUrl("Credittype/Cancel"); ?>",
						data: data,
						success: function(data, status, xhr) {
							location.reload();
							//$("#grid1").jqxGrid({source: dataAdapter});
											//alert(data);
											commit(true);
										}
									});
					swal("Deleted!", "Your imaginary file has been deleted.", "success");
				});
			}},
			{ text: '#',datafield: 'edit', editable: false, align: 'center', width: '60px',cellsalign:'center',columntype: 'button',
			buttonclick: function (row) {
				var dataread = $('#grid1').jqxGrid('getrowdata',row);
				var id = dataread.no;
				window.location.href = "<?php echo $this->createUrl("credittype/insertcredit2"); ?>"+'?order='+id;
			}},
			{ text: 'JobNo',datafield: 'no', width: '80px',align: 'center',cellsalign: 'center' },
			{text: 'วันที่ทำรายการ',datafield: 'orderdate', width: '200px', align: 'center',filterable: false,cellsalign: 'center', cellsformat: 'dd-MM-yyyy [HH:mm]'},
			{text: 'code',datafield: 'orderid', width: '10%', align: 'center',cellsalign: 'center'},
			// {text: 'cid',datafield: 'cidcustomer', width: '10%', align: 'center',cellsalign: 'center'},
			{text: 'ชื่อลูกค้า',datafield: 'customer', width: '15%', align: 'center',cellsalign: 'center'},
			// {text: 'ประเภท',datafield: 'jobtype', width: '15%', align: 'center',filtertype: 'checkedlist',cellsalign: 'left'},
			{text: 'จำนวนเงินดาวน์',datafield: 'downpayment', width: '10%', align: 'center',cellsalign: 'right',cellsformat: 'n' ,cellsformat: 'F2'},
			{text: 'จำนวนเงินสินเชื่อ',datafield: 'creditpayment', width: '10%', align: 'center',cellsalign: 'right',cellsformat: 'n' ,cellsformat: 'F2'},
			{text: 'จำนวนเงินรวม',datafield: 'sumpayment', width: '10%', align: 'center',cellsalign: 'right',cellsformat: 'n' ,cellsformat: 'F2'},
			{text: 'ผู้บันทึก',datafield: 'user', width: '15%', align: 'center',cellsalign: 'left'},


			]
		});

	});
</script>
<style type="text/css" media="screen">
.color1, .jqx-widget .color1 {
	color: #FFFFFF;
	background-color: #33cc33;
}
.color2, .jqx-widget .color2 {
	color: #FFFFFF;
	background-color: #ff5050;
}
.color3, .jqx-widget .color3 {
	color: #000000;
	background-color: #ffffcc;
}

</style>
<div class="content-wrapper" style="background-color: #d2d0d0;">
	<section class="content-header">
		<h1>
			ประเภทสินเชื่อ / ธนาคาร
		<!-- <a class="btn bg-orange btn-app" href="<?php echo $this->createUrl("credittype/insertcredit"); ?>">
			<i class="fa  fa-plus-square"></i> เพิ่มข้อมูล
		</a> -->
	</h1>

	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"> ประเภทสินเชื่อ / ธนาคาร</li>
	</ol>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">ค้นหา</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<form class="form-horizontal">
			<div class="box-body">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-1 control-label">ค้นหา</label>

					<div class="col-sm-3" >
						<div id='date_befor'style="border-color: #20B2AA; border-radius: 5px"></div>

					</div>
					<div class="col-sm-1">
						<label style="color: #20B2AA">ถึง	</label>
					</div>

					<div class="col-sm-3 ">
						<div id='date_after' style="border-color: #20B2AA; border-radius: 5px"></div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-1 control-label">สถานะ</label>

					<div class="col-sm-3">
						<select style="border-color: #FF6347; border-radius: 5px;width: 150px;height: 25px" id="stat1">
							<option value="0" style="background-color: #f9f211">ยังไม่ Approve</option>
							<option value="9">ทั้งหมด</option>

							<option value="1"style="background-color: #ff5050">Cancel</option>
							<option value="2"style="background-color: #06d60c">Approve</option>
						</select>
					</div>
					<div class="col-sm-3">
						<div class="control-label">
							<button type="button" class="btn btn-block btn-success" id="btex_group">ค้นหา</button>
						</div>
					</div>
				</div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">

			</div>
			<!-- /.box-footer -->
		</form>
	</div>
	<section class="content">

		<div id="grid1"></div>

	</section>
</section>
</div>

