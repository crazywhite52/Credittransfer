<?php
$baseUrl=Yii::app()->request->baseUrl; 
?>
<!DOCTYPE html>
<html>
<head>    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <meta name="description" content="Bootstrap 3.0 Responsive Theme "/>
  <meta name="keywords" content="jib" />
  <meta name="author" content="jib"/>
  <link rel="shortcut icon" href="<?php echo $baseUrl?>/images/jib-login.png"> 

  <title>Login</title>
  <!-- Bootstrap core CSS -->
  <link href="<?php echo $baseUrl?>/login4/css/bootstrap.css" rel="stylesheet">
  <!-- Demo CSS -->
  <link href="<?php echo $baseUrl?>/login4/css/demo.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo $baseUrl?>/login4/css/login-theme-1.css" rel="stylesheet" id="fordemo">
    <!-- 
      <link href="css/login-theme-1.css" rel="stylesheet">
      <link href="css/login-theme-2.css" rel="stylesheet">
      <link href="css/login-theme-3.css" rel="stylesheet">
      <link href="css/login-theme-4.css" rel="stylesheet">
      <link href="css/login-theme-5.css" rel="stylesheet">
      <link href="css/login-theme-6.css" rel="stylesheet">
      <link href="css/login-theme-7.css" rel="stylesheet">
      <link href="css/login-theme-8.css" rel="stylesheet">
      <link href="css/login-theme-9.css" rel="stylesheet">
      <link href="css/login-theme-10.css" rel="stylesheet">
      <link href="css/login-theme-11.css" rel="stylesheet">
      <link href="css/login-theme-12.css" rel="stylesheet">
      <link href="css/login-theme-13.css" rel="stylesheet">
      <link href="css/login-theme-14.css" rel="stylesheet">
      <link href="css/login-theme-15.css" rel="stylesheet">  
    -->
    
    
    
    
    <link href="<?php echo $baseUrl?>/login4/css/animate-custom.css" rel="stylesheet"> 
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    


  </head>
  <style>
  body {
    background-image: url('<?php echo $baseUrl;?>/Login_v3/images/bg-03.jpg');
    background-repeat: no-repeat;
    background-size: cover;
  }
</style>
<body class="fade-in" >

 <?php echo $content;?>

 <!-- End Login box -->
 <footer class="container">
  <p id="footer-text"><small>Copyright &copy; 2018 <a href="#">MIS</a></small></p>
</footer>

</body>
</html>