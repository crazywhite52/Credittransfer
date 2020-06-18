<?php $baseUrl=Yii::app()->request->baseUrl; ?>
<section class="content-header">
  <h1>
   WHITE TEST

  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"> test</li>
  </ol>
</section>
<form name="form1" method="post" action="<?php echo $this->createUrl("white/index"); ?>" enctype="multipart/form-data">
	<input type="file" name="filUpload[]"><br>
	<input type="file" name="filUpload[]"><br>
	<input type="file" name="filUpload[]"><br>
	<input name="btnSubmit" type="submit" value="Submit">
</form>