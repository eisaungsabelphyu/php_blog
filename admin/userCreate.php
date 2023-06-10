<?php 
session_start();
require "../config/config.php";

if(empty($_SESSION['id']) || empty($_SESSION['logged_in']) || $_SESSION['role'] != 1){
  header("Location: login.php");
}

if($_POST){
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password'])< 4){
        if(empty($_POST['name'])){
            $nameErr = "Name field cannot be null";
        }
        if(empty($_POST['email'])){
            $mailErr = "Email field cannot be null";
        }
        if(empty($_POST['password'])){
            $passErr = "Password field cannot be null";
        }
        if(strlen($_POST['password'])< 4){
            $passErr = "Password must be at least 4 character";
        }
    }else{
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = $_POST['password'];
       

        $stm = $pdo->prepare("INSERT INTO users(user_name,email,password,role) VALUES(:user_name,:email,:password,:role)");
        $result = $stm->execute(
            array(
                ':user_name' => $name,
                ':email' => $email,
                ':password' => $password,
                ':role' => $role
             )
            );
        if($result){
            echo "<script>alert('Successfully added');window.location.href='user.php'</script>";

        }
    }
    }

?>
<?php include ("layouts\header.php"); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Create Page</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label>Name</label><p class="text-danger"><?php echo empty($nameErr) ? '' :'*'.$nameErr; ?></p> 
                    <input type="text" class="form-control" name="name"  >
                </div>
                <div class="form-group">
                    <label>Email</label><p class="text-danger"><?php echo empty($mailErr) ? '' :'*'.$mailErr; ?></p>
                    <input type="email" class="form-control" name="email"  >
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" name="role" value="1" type="radio"  id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Admin
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" name="role" value="0" type="radio" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            User
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label><p class="text-danger"><?php echo empty($passErr) ? '' :'*'.$passErr; ?></p>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="user.php" class="btn btn-default">Back</a>
                </div>
            </form>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
   
<?php include ("layouts/footer.php"); ?>
 