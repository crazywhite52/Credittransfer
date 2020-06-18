<?php
$baseUrl=Yii::app()->request->baseUrl; 
?>
<!-- start Login box -->
<div class="container" id="login-block" >
  <div class="row">
    <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">

     <div class="login-box clearfix animated flipInY">

      <div class="login-logo">
        <a href="#"><img style="width: 120px;" src="<?php echo $baseUrl;?>/images/jib-login.png" alt="Company Logo" /></a>
      </div> 
      <hr />
      <div class="login-form">
        <form method="post"  >
         <input type="text" name="user_id" placeholder="User name" class="input-field" required/> 
         <input type="password" name="user_password" placeholder="Password" class="input-field" required/> 
         <button type="submit" class="btn btn-login">Login</button> 
       </form> 
       <div class="login-links"> 
         <a href="#"><?php echo $msg; ?></a>
       </div>
     </div>
   </div>

   <!-- Start Social connect buttons box --> 

             <!-- <div class="social-login row">
                  <div class="fb-login col-lg-6 col-md-12 animated flipInX">
                    <a href="#" class="btn btn-facebook btn-block">Connect with <strong>Facebook</strong></a>
                  </div>
                  <div class="twit-login col-lg-6 col-md-12 animated flipInX">
                    <a href="#" class="btn btn-twitter btn-block">Connect with <strong>Twitter</strong></a>
                  </div>
                </div> -->

                <!-- End Social connect buttons box -->

              </div>
            </div>
          </div>
