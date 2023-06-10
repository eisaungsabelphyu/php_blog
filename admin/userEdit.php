<?php 
session_start();
require "../config/config.php";
require "../config/common.php";

if(empty($_SESSION['id']) || empty($_SESSION['logged_in']) || $_SESSION['role'] != 1){
  header("Location: login.php");
}

  
if($_POST){
    if(empty($_POST['name']) || empty($_POST['email'])){
      if(empty($_POST['name'])){
              $nameErr = "Name field cannot be null";
          }
          if(empty($_POST['email'])){
              $mailErr = "Email field cannot be null";
          }
          
    }else if(!empty($_POST['password']) && strlen($_POST['password']) < 4){
      $passErr = "Password must be at least 4 character";
    }
    else{
      $name = $_POST['name'];
      $email = $_POST['email'];
      $role = $_POST['role'];
      $password = $_POST['password'];
      $id = $_POST['id'];
      
      if(empty($_POST['password'])){
        $stm = $pdo->prepare("UPDATE users SET user_name='$name',email='$email',role='$role' WHERE id='$id'");
      }else{
        $stm = $pdo->prepare("UPDATE users SET user_name='$name',email='$email',password='$password',role='$role' WHERE id='$id'");
      }
      $result = $stm->execute();
      if($result){
          echo "<script>alert('Successfully Updated');window.location.href='user.php';</script>";
      }
    }   
}
//for show data
 
    $id = $_GET['id'];
    $stm = $pdo->prepare("SELECT * FROM users WHERE id=".$id);
    $stm->execute();
    $post = $stm->fetchAll();





?>
<?php include ("layouts\header.php"); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Edit Page</h1>
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
                     <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="id" value="<?= $post[0]['id'] ?>">
                <div class="form-group">
                    <label>Name</label><p class="text-danger"><?php echo empty($nameErr) ? '' :'*'.$nameErr; ?></p>
                    <input type="text" class="form-control" name="name" value="<?= $post[0]['user_name']; ?>" >
                </div>
                <div class="form-group">
                    <label>Email</label><p class="text-danger"><?php echo empty($mailErr) ? '' :'*'.$mailErr; ?></p>
                    <input type="email" class="form-control" name="email" value="<?= $post[0]['email']; ?>">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" name="role" value="1" type="radio" <?php echo $post[0]['role'] == 1 ? 'checked':''?> id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Admin
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" name="role" value="0" type="radio" <?php echo $post[0]['role'] == 0 ? 'checked':''?> id="flexCheckChecked">
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
 