<?php 
class WhiteController extends CController
{
	public function actionIndex()
	{
		if(!empty($_FILES)){
			for($i=0;$i<count($_FILES["filUpload"]["name"]);$i++)
			{
				if($_FILES["filUpload"]["name"][$i] != "")
				{
					$target_path = $_SERVER['DOCUMENT_ROOT'] . "/filetest_white/";

					if(move_uploaded_file($_FILES["filUpload"]["tmp_name"][$i],$target_path.$_FILES["filUpload"]["name"][$i]))
					{


					}
				}
			}
		}
		$this->render("index");
	}

} ?>