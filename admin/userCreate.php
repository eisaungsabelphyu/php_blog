<?php 
session_start();
require "../config/config.php";

if(empty($_SESSION['id']) || empty($_SESSION['logged_in']) || $_SESSION['role'] != 1){
  header("Location: login.php");
}

if($_POST){

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
                    <label>Name</label><br>
                    <input type="text" class="form-control" name="name"  required>
                </div>
                <div class="form-group">
                    <label>Email</label><br>
                    <input type="email" class="form-control" name="email"  required>
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
                    <label>Password</label><br>
                    <input type="password" class="form-control" name="password"  required>
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
 