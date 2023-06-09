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
    $id = $_POST['id'];
     $stm = $pdo->prepare("UPDATE users SET user_name='$name',email='$email',role='$role' WHERE id='$id'");
        $result = $stm->execute();
        if($result){
            echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
        }
}else{
  $id = $_GET['id'];
  $stm = $pdo->prepare("SELECT * FROM users WHERE id=".$id);
  $stm->execute();
  $post = $stm->fetchAll();
}



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
                <input type="hidden" name="id" value="<?= $post[0]['id'] ?>">
                <div class="form-group">
                    <label>Name</label><br>
                    <input type="text" class="form-control" name="name" value="<?= $post[0]['user_name'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label><br>
                    <input type="email" class="form-control" name="email" value="<?= $post[0]['email'] ?>" required>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" name="role" type="radio" <?php if($post[0]['role'] == '1') { echo 'checked';} ?> id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Admin
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" name="role" type="radio" <?php if($post[0]['role'] == '0') { echo 'checked';} ?> id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            User
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="index.php" class="btn btn-default">Back</a>
                </div>
            </form>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
   
<?php include ("layouts/footer.php"); ?>
 