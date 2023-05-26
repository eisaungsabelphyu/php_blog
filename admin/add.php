<?php 
session_start();
require "../config/config.php";

if(empty($_SESSION['id']) || empty($_SESSION['logged_in'])){
  header("Location: login.php");
}

if($_POST){
    $file = 'images/'.($_FILES['image']['name']);
    $imgType = pathInfo($file,PATHINFO_EXTENSION);

    if($imgType != 'png' && $imgType != 'jpg' && $imgType != 'jpeg'){
        echo "<script>alert('Image must be png,jpg,jpeg');</script>";
    }else{
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
         move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $stm = $pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUES(:title,:content,:image,:author_id)");
        $result = $stm->execute(
            array(
                ':title' => $title,
                ':content' => $content,
                ':image' => $image,
                ':author_id' => $_SESSION['id']
             )
            );
        if($result){
            echo "<script>alert('Successfully added');window.location.href='index.php'</script>";

        }
    }
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
            <form action="add.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Title</label><br>
                    <input type="text" class="form-control" name="title" value="" required>
                </div>
                <div class="form-group">
                    <label>Content</label><br>
                    <textarea type="text" class="form-control" name="content" rows="8" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label>Image</label><br>
                    <input type="file" class="form-control" name="image" value="" required>
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
 