<?php
$baseUrl=Yii::app()->request->baseUrl; 
?>

<div class="limiter">
    <div class="container-login100" style="background-image: url('<?php echo $baseUrl;?>/Login_v3/images/bg-01.jpg');">
      <div class="wrap-login100">
        <form class="login100-form validate-form" method="post" action="<?php echo $this->createUrl("Sign/In"); ?>">
          <span class="login100-form-logo">
            
            <img src="<?php echo $baseUrl;?>/images/jib-login.png" style="width: 200px;">

          </span>

          <span class="login100-form-title p-b-34 p-t-27" >
           <br>
          </span>

          <div class="wrap-input100 validate-input" data-validate = "Enter username">
            <input class="input100" type="text" name="user_id" placeholder="Username">
            <span class="focus-input100" data-placeholder="&#xf207;"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Enter password">
            <input class="input100" type="password" name="user_password" placeholder="Password">
            <span class="focus-input100" data-placeholder="&#xf191;"></span>
          </div>

          <div class="contact100-form-checkbox">
            <input class="input-checkbox100" id="chkaccess" name="chkaccess"  type="checkbox" value="28">
            <label class="label-checkbox100" for="chkaccess">
              Remember me
            </label>
          </div>

          <div class="container-login100-form-btn">
            <button class="login100-form-btn" type="submit">
              Login
            </button>
          </div>

          <div class="text-center p-t-90">
            <k style='color: #49ff00'><?php echo $msg; ?></k> <br>
           
           
            
          </div>
        </form>
      </div>
    </div>
  </div>