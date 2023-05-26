<?php 
session_start();
require "../config/config.php";

if(empty($_SESSION['id']) || empty($_SESSION['logged_in'])){
  header("Location: login.php");
}
if($_POST){
    
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id = $_POST['id'];
   
   
    if($_FILES['image']['name'] != null){

        $stm = $pdo->prepare("SELECT image FROM posts WHERE id=".$id);
        $stm->execute();
        $data = $stm->fetchAll();
        unlink('images/'.$data[0]['image']);

        $file = "images/".$_FILES['image']['name'];
        $imgType = pathinfo($file,PATHINFO_EXTENSION);

        if($imgType != 'png' && $imgType != 'jpg' && $imgType != 'jpeg'){
            echo "<script>alert('Image type must be jpg,png,jpeg');</script>";
        }else{
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],$file);

            $stm = $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
            $result = $stm->execute();
            if($result){
                echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
            }
        }

    }else{
        $stm = $pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
        $result = $stm->execute();
        if($result){
            echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
        }
    }
}else{
  $id = $_GET['id'];
  $stm = $pdo->prepare("SELECT * FROM posts WHERE id=".$id);
  $stm->execute();
  $post = $stm->fetchAll();
}



?>
<?php include ("layouts\header.html"); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Starter Page</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
            <form action="edit.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $post[0]['id'] ?>">
                <div class="form-group">
                    <label>Title</label><br>
                    <input type="text" class="form-control" name="title" value="<?= $post[0]['title'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Content</label><br>
                    <textarea type="text" class="form-control" name="content" rows="8" cols="80"><?= $post[0]['content'] ?></textarea>
                </div>
                <div class="form-group">
                    <label>Image</label><br>
                    <input type="file" class="form-control" name="image">
                    <img src="images/<?= $post[0]['image'] ?>" class="img-thumbnail" width="100px" height="100px">
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
   
<?php include ("layouts/footer.html"); ?>
 