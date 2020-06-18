<?php $baseUrl = Yii::app()->request->baseUrl; 
$id=Yii::app()->request->cookies['cookie_user_id']->value;
$str="SELECT 
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

$result=Yii::app()->jibhr->createCommand($str)->queryRow();

?>
<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <?php if($result['personal_image'] != '' || $result['personal_image'] != null){ ?>
          <img src="/JIBHR/img_hr/<?php echo $result['personal_image']; ?>" class="img-circle" alt="User Image">
        <?php }else{ ?>
          <img src="<?php echo $baseUrl; ?>/adminLTE/dist/img/avatar5.png" class="img-circle" alt="User Image">
        <?php } ?>
      </div>
      <div class="pull-left info">
        <p><?php echo Yii::app()->request->cookies['cookie_user_nickname']->value; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <!-- <li><a href="<?php echo $this->createUrl("sticker/price"); ?>"><i class="fa fa-book"></i> <span>ปริ้นราคาสินค้า</span></a></li> -->
     <!--  <li><a href="<?php echo $this->createUrl("site/index"); ?>"><i class="fa fa-book"></i> <span>รายการโอนเงิน</span></a></li>
      <li><a href="<?php echo $this->createUrl("job/index"); ?>"><i class="fa fa-fw fa-money"></i> <span>แจ้งโอนเงิน</span></a></li>
      <li><a href="<?php echo $this->createUrl("creditmachine/view"); ?>"><i class="fa fa-fw fa-fax"></i> <span>เครื่องรูดบัตร</span></a></li>
      <li><a href="<?php echo $this->createUrl("credittype/index"); ?>"><i class="fa fa-fw fa-money"></i> <span>รายการทำสินเชื่อ</span></a></li> -->
      <!-- <li><a href="<?php echo $this->createUrl("creditcard/index"); ?>"><i class="fa fa-fw fa-credit-card"></i> <span>รูดบัตรเครดิต</span></a></li> -->
        <!-- <li class="header">ABOUT</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
      <li class="treeview menu-open">
          <a href="#">
            <i class="fa fa-fw fa-money" style="color: green; font-size: 20px;" ></i> &nbsp;&nbsp;<span>เมนูโอนเงิน</span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li class="treeview">
              <ul class="treeview-menu" style="display: block;">
                <li><a href="<?php echo $this->createUrl("job/index"); ?>"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;แจ้งโอนเงิน</a></li>
              </ul>
              <ul class="treeview-menu" style="display: block;">
                <li><a href="<?php echo $this->createUrl("site/home"); ?>"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;รายการโอนเงิน</a></li>
              </ul>
            </li>
          </ul>
        </li>

        <li class="treeview menu-open">
          <a href="#">
            <i class="fa fa-credit-card" style="color: #dd4b39; font-size: 20px;"></i>&nbsp;&nbsp; <span>เมนูสินเชื่อ</span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li class="treeview">
              <ul class="treeview-menu" style="display: block;">
                <li><a href="<?php echo $this->createUrl("credittype/insertcredit"); ?>"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;เพิ่มรายการสินเชื่อ</a></li>
              </ul>
              <ul class="treeview-menu" style="display: block;">
                <li><a href="<?php echo $this->createUrl("credittype/index"); ?>"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;รายการสินเชื่อ</a></li>
              </ul>
            </li>
          </ul>
        </li>

        <li class="treeview menu-open">
          <a href="#">
            <i class="fa fa-fax" style="color: #f39c12; font-size: 20px;"></i>&nbsp;&nbsp; <span>เมนูเครื่องรูดบัตร</span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li class="treeview">
              <ul class="treeview-menu" style="display: block;">
                <li><a href="<?php echo $this->createUrl("creditmachine/index"); ?>"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;เพิ่มข้อมูลเครื่องรูดบัตร</a></li>
              </ul>
              <ul class="treeview-menu" style="display: block;">
                <li><a href="<?php echo $this->createUrl("creditmachine/view"); ?>"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;รายการเครื่องรูดบัตร</a></li>
              </ul>
            </li>
          </ul>
        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>