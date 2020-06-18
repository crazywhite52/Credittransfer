

<!DOCTYPE html>
<script>
	$(document).ready(function () {
		$("#vender1").hide();
		$("#generation").hide();
		$("#brand1").hide();
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


</script>
<div class="content-wrapper" style="background-color: #d2d0d0;">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Config</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<div class="form-horizontal">
			<div class="box-body">
				<div class="form-group">
					<label for="jobno" class="col-sm-2 control-label">ธนาคาร:</label>

					<div class="col-sm-10">
						<div class="col-sm-3">
							<input type="text" class="form-control" id="jobno1" placeholder="">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="branchname" class="col-sm-2 control-label">รายละเอียด:</label>

					<div class="col-sm-10">
						<div class="col-sm-3">
							<input type="text" class="form-control" id="branchname" placeholder="">
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="tidcode" class="col-sm-2 control-label">จำนวนเดือน:</label>

					<div class="col-sm-10">
						<div class="col-sm-3">
							<input type="number" class="form-control" id="tidcode"   placeholder="กรอกตัวเลขเท่านั้น" required>
						</div>
					</div>
				</div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<div class="col-sm-10">
					<div class="col-sm-5">
						<button type="submit" class="btn btn-info pull-center"  id="btn_save_regis">Save</button>
					</div>
				</div>
			</div>
			<!-- /.box-footer -->
		</div>
	</div>
</div>