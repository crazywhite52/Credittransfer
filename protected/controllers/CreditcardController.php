<?php
class CreditcardController extends CController
{
    public function actionIndex()
    {
    	if (empty(Yii::app()->request->cookies['cookie_user_no']->value)) {
            $this->redirect(array("Login/in"));
        }if (empty(Yii::app()->request->cookies['cookie_user_prosonal']->value)) {
            $this->redirect(array("Login/in"));
        }if (empty(Yii::app()->request->cookies['cookie_user_branchname']->value)) {
            $this->redirect(array("Login/in"));
        }

        $this->render("index");
    }
    public function actionIndex2()
    {
        $this->renderPartial("index2");
    }
	
} ?>