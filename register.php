<?php 
require "config/config.php";

if($_POST){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stm = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stm->bindValue(':email',$email);
    $stm->execute();
    $user = $stm->fetch(PDO::FETCH_ASSOC);

    if($user){
        echo "<script>alert('Email duplicated!');</script>";
    }else{
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stm = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(:name,:email,:password,:role)");
        $result = $stm->execute(
            array(
                ':name' => $name,
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
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
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
