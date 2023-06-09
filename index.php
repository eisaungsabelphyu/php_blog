<?php 
session_start();
require "config/config.php";

if(empty($_SESSION['id']) || empty($_SESSION['logged_in'])){
  header ("Location: login.php");
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

<?php 
  if(!empty($_GET['pageno'])){
    $pageno = $_GET['pageno'];
  }else{
    $pageno = 1;
  }
  $numOfRec = 6;
  $offset = ($pageno - 1) * $numOfRec;


  $stm = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
  $stm->execute();
  $totalResult = $stm->fetchAll();
  $totalpages = ceil(count($totalResult) / $numOfRec);

  $stm = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfRec");
  $stm->execute();
  $posts = $stm->fetchAll();

?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin:auto !important;">

        <h3 class="mt-4 mb-4" style="text-align:center;">Social Widgets</h3>
        <div class="row">
          <?php 
          if($posts){
            foreach($posts as $post){
          ?>
          <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget"  >
              <div class="card-header">
                <div class="card-title" style="text-align:center !important;float:none">
                    <h4><?= $post['title'] ?></h4>
                </div>
                <!-- /.user-block -->
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="margin:auto !important;">
                <a href="detail.php?id=<?= $post['id'] ?>"><img class="img-fluid pad" style="height: 200px !important" src="admin/images/<?= $post['image'] ?>" alt="Photo"></a> 
              </div>
              
            </div>
            <!-- /.card -->
          </div>
          <?php 
                }
             }
          ?>
        </div>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end mt-3 mr-3">
            <li class="page-item ">
              <a class="page-link" href="?pageno=1">First</a>
            </li>
            <li class="page-item <?php if($pageno <= 1) { echo 'disabled';} ?>">
              <a class="page-link" href="<?php if($pageno <= 1) { echo '#';}else{ echo '?pageno='.$pageno-1;} ?>" >Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#<?= $pageno ?>">1</a></li>
            <li class="page-item <?php if($pageno >= $totalpages) {echo 'disabled';} ?>">
              <a class="page-link" href="<?php if($pageno >= $totalpages) {echo '#';}else{ echo '?pageno='.$pageno+1;} ?>">Next</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="?pageno<?= $totalpages ?>".>Last</a>
            </li>
          </ul>
      </nav>
        <!-- /.row -->

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
