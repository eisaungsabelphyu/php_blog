<?php 
session_start();
require "config/config.php";
require "config/common.php";

if(empty($_SESSION['id']) || empty($_SESSION['logged_in'])){
  header ("Location: login.php");
}
  
  $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
  $stmt->execute();
  $post = $stmt->fetchAll();
  

  $blogId = $_GET['id'];
  $stm = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
  $stm->execute();
  $cmResult = $stm->fetchAll();
 

  $auResult = [];
  if($cmResult){
    foreach($cmResult as $key => $value){
    $user_id = $cmResult[$key]['author_id'];
    $stmau = $pdo->prepare("SELECT * FROM users WHERE id=$user_id");
    $stmau->execute();
    $auResult[] = $stmau->fetchAll();
    
  }
  }
   

  if($_POST){
    if(empty($_POST['comment'])){
      $cmtErr = "Comment must be filled";
    }else{
      $content = $_POST['comment'];
        $stm = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES(:content,:author_id,:post_id)");
        $result = $stm->execute(
            array(
                ':content' => $content,
                ':author_id' => $_SESSION['id'],
                ':post_id' => $blogId
             )
            );
          if($result){
            header ("Location: detail.php?id=".$blogId);
          }
    }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
      <div class="content-wrapper" style="margin-left:0px !important">
        <section class="content-header">
          <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="card-title" style="text-align:center !important;float:none;">
                  <h2><?= escape($post[0]['title']) ?></h2>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="text-align:center !important;float:none;">
                <img  class="img-fluid pad" src="admin/images/<?= $post[0]['image'] ?>" alt="Photo">
                <br><br>
                <p><?= escape($post[0]['content']) ?></p>
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <div class="d-flex justify-content-between mb-3">
                  <h3>Comments</h3>
                  <a href="index.php" class="btn btn-info">Back</a>
                </div>
                <div class="card-comment">
                  <?php if($cmResult){ ?>
                  <div class="comment-text" style="margin-left:0px !important;">
                    <?php foreach($cmResult as $key => $value){ ?>
                    <span class="username">
                      <?= escape($auResult[$key][0]['user_name']) ?>
                      <span class="text-muted float-right"><?= escape($value['created_at']) ?></span>
                    </span><!-- /.username -->
                     <?= escape($value['content']) ?>
                    <?php }?>
                    <!-- /.comment-text -->
                  </div>
                </div>
                  <?php } ?>
              </div>
              <!-- /.card-footer -->
              <div class="card-footer" style="margin-left:0px !important;">
                <form action="" method="post">
                  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                  <div class="img-push">
                    <p class="text-danger"><?php echo empty($cmtErr) ? '' :'*'.$cmtErr; ?></p>
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
        </div>
        </section>
      </div>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important;">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php" class="btn btn-default">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href="#"></a>Coder</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
