<?php $baseUrl=Yii::app()->request->baseUrl; ?>

<script>
	$(document).ready(function () {
		$("#ref").click(function(){
			setTimeout(function(){ 
				$("#idg").jqxGrid('refresh');
			}, 1500);
			
		});
		var refreshInterval = setInterval(function () {
			$("#idg").jqxGrid("updatebounddata");
		}, 150000);

		if(screen.height>=1920){
			var resolutionsHeight="780";
		}else if(screen.height==1080){
			var resolutionsHeight="620";
		}else if(screen.height==900){
			var resolutionsHeight="500";
		}else if(screen.height==768){
			var resolutionsHeight="450";
		}else  if(screen.height==720){
			var resolutionsHeight="350";
		}else{
			var resolutionsHeight="450";
		}
		var photodelete = function (row, columnfield, value, defaulthtml, columnproperties, datafield) {
			var imgurl = '<?php echo Yii::app()->request->baseUrl;?>/images/klist/Delete-icon.png';
			var img = '<a href="javascript:deleteList(\''+datafield['order_number']+'\')" onclick="return confirm(\'คุณต้องการยกเลิกรายการนี้หรือไม่\');"><div align="center" style="background: ;"><img style="margin-top: 7px;" width="20" height="20"   src="' + imgurl + '" ></div></a>';
			if (datafield['order_status']=='ยกเลิก') {
				return null;
			}if (datafield['order_status']=='การเงินรับทราบ') {
				return null;
			}else{
				return img;
			}
		}

		var cellsrenderer = function (row, column, value, defaultHtml) {
			if (value=='กำลังดำเนินการ') {
				var element = $(defaultHtml);
				element.css({ 'color':'#FFCC00','font-weight':'bold' });
				return element[0].outerHTML;
			}
			if (value=='การเงินรับทราบ') {
				var element = $(defaultHtml);
				element.css({ 'color':'green','font-weight':'bold' });
				return element[0].outerHTML;
			}
			if (value=='ยกเลิก') {
				var element = $(defaultHtml);
				element.css({ 'color':'red','font-weight':'bold' });
				return element[0].outerHTML;
			}
			return defaultHtml;
		}


		$("#idg").jqxGrid(
		{
			theme: 'darkblue',
			width: '100%',
			height: resolutionsHeight,
			source: getAdapter(),
			rowsheight: 32,
			pageable: false,
			/*autoheight: true,*/
			// showfilterrow: true,
			showfilterrow: true,
			filterable: true,
			sortable: true,
			altrows: true,
			pageable: true,
			pagermode: 'simple',
			pagesize: 20,

                //enabletooltips: true,
                // editable: true,
                columns: [
                { text: 'ยกเลิก', cellsrenderer: photodelete,align: 'center',width: '7%',filterable: false},

                // { text: 'ลำดับที่', datafield: 'id',  width: '5%',align: 'center',cellsalign:'center' },
                { text: 'JobID', datafield: 'order_number',  width: '10%',align: 'center',cellsalign:'center' },
                { text: 'วิธีการชำระเงิน' , datafield: 'payment_cid',align: 'center' ,cellsalign:'center',width: '10%',},
                { text: 'ธนาคาร', datafield: 'payment_id',align: 'center',cellsalign:'center',width:'18%' },
                { text: 'ยอดเงิน', datafield: 'order_price_total',align: 'center',cellsalign:'right',width:'10%',cellsformat:'f2' },
                { text: 'TR-CODE', datafield: 'order_tr_code',align: 'center',width:'10%', cellsalign:'center'},
                { text: 'ชื่อผู้ทำรายการ', datafield: 'order_user_name',align: 'center',width:'20%' ,cellsalign:'center'},
                { text: 'สถานะ', datafield: 'order_status',align: 'center', width:'15%',cellsalign:'center',cellsrenderer:cellsrenderer}
                ]
            });
		$('#btsearch').click(function(event) {
			$("#idg").jqxGrid({source: getAdapter()});
		});
	});

	function getAdapter(){
		var source =
		{
			datatype: "json",
			datafields: [
			// { name: 'id', type: 'int'},
			{ name: 'order_number', type: 'string' },
			{ name: 'payment_cid', type: 'string' },
			{ name: 'order_price_total', type: 'int' },
			{ name: 'order_user_name', type: 'string' },
			{ name: 'order_tr_code', type: 'string' },
			{ name: 'order_status', type: 'int' },
			{ name: 'payment_id', type: 'int' },
			],
			cache: false,
			url: '<?php echo $this->createUrl("set/list"); ?>',
		};
		var dataAdapter = new $.jqx.dataAdapter(source,
		{
			formatData: function (data) {
				data.program_name = $("#program_name").val();
				return data;
			}
		});
		return dataAdapter;
	};

	function deleteList(id) {

		$.post('<?php echo $this->createUrl("set/Cjob"); ?>', { id: id }, function(response) {
			$("#idg").jqxGrid({source: getAdapter()});
		});

	}


</script>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<div class="content-wrapper" style="background-color: #d2d0d0;">
		<section class="content">

			<div class="row">
				<div class="col-xs-12">


					<div class="box box-primary"  style="border-radius: 10px;">
						<div class="box-header with-border"  style="border-radius: 10px;">

							<h3 class="box-title">รายการที่แจ้งโอนเงิน / บัตรเครดิต</h3>
						</div>
						<div class="box-body">
							<div id="idg"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</body>
</html>