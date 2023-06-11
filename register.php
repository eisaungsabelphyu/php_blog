<?php 
session_start();
require "config/config.php";
require "config/common.php";

if($_POST){
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
      if(empty($_POST['name'])){
        $nameErr = "Name field cannot be null";
      }
      if(empty($_POST['email'])){
        $mailErr = "Mail field cannot be null";
      }
      if(empty($_POST['password'])){
        $passwordErr = "Password field cannot be null";
      }
    }else{
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password =  password_hash($_POST['password'],PASSWORD_DEFAULT);

    $stm = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stm->bindValue(':email',$email);
    $stm->execute();
    $user = $stm->fetch(PDO::FETCH_ASSOC);

    if($user){
        echo "<script>alert('Email duplicated!');</script>";
    }else{
        $stm = $pdo->prepare("INSERT INTO users(user_name,email,password,role) VALUES(:user_name,:email,:password,:role)");
        $result = $stm->execute(
            array(
                ':user_name' => $name,
                ':email' => $email,
                ':password' => $password,
                ':role' => 0
             )
            );
        if($result){
            echo "<script>alert('Successfully Register.Now you can login');window.location.href='login.php'</script>";

        }
    }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog | Sing up</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html"><b>Blog</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Create Account</p>

      <form action="register.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <p class="text-danger"><?php echo empty($nameErr) ? '' :'*'.$nameErr; ?></p>
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <p class="text-danger"><?php echo empty($mailErr) ? '' :'*'.$mailErr; ?></p>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <p class="text-danger"><?php echo empty($passwordErr) ? '' :'*'.$passwordErr; ?></p>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          <!-- /.col -->
          <div class="">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <a href="login.php" class="btn btn-block btn-outline-primary" >login in</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
