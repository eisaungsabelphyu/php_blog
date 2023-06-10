<?php 
session_start();
require "../config/config.php";
if(empty($_SESSION['id']) || empty($_SESSION['logged_in']) || $_SESSION['role'] != 1){
  header("Location: login.php");
}
if(!(empty($_POST['search']))){
  setcookie('search',$_POST['search'],time() + (86400 * 30), "/");
}else{
  if(empty($_GET['pageno'])){
    setcookie('search', "", time() - 3600);
  }
}
?>
<?php include ("layouts\header.php"); ?>
  <!-- Content Wrapper. Contains page content -->
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
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php 
                  if(!empty($_GET['pageno'])){
                            $pageno = $_GET['pageno'];
                          }else{
                            $pageno = 1;
                          }
                          $numOfrec = 2;
                          $offset = ($pageno -1) * $numOfrec;

                          if(empty($_POST['search'])){
                            $stm = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                            $stm->execute();
                            $rawResult = $stm->fetchAll();
                            $totalpages = ceil(count($rawResult) / $numOfrec);
                            
                            $stm = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrec");
                            $stm->execute();
                            $data = $stm->fetchAll();
                          }else{
                            $search = empty($_POST['search']) ? $_COOKIE['search'] : $_POST['search'];
                            $stm = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY id DESC");
                            $stm->execute();
                            $rawResult = $stm->fetchAll();
                            $totalpages = ceil(count($rawResult) / $numOfrec);
                            
                            $stm = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY id DESC LIMIT $offset,$numOfrec");
                            $stm->execute();
                            $data = $stm->fetchAll();
                            
                          }

                          


                  
                ?>
                <div class="mb-3">
                  <a href="add.php" class="btn btn-success" >New Blog Post</a>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th >Content</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php 
                   if($data){
                   $i = 1;
                   foreach($data as $post){
                   ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $post['title'] ?></td>
                      <td><?= substr($post['content'],0,50) ?></td>
                      <td>
                         <a href="edit.php?id=<?= $post['id'] ?>" type="button" class="btn btn-warning ">Edit</a>
                         <a href="delete.php?id=<?= $post['id'] ?>" type="button" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                   <?php 
                     $i++;
                        }
                      }
                   ?>
                  </tbody>
                </table>
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-end">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1) {echo 'disabled';}?>">
                      <a class="page-link" href="<?php if($pageno <= 1) { echo '#';}else{ echo '?pageno='.$pageno-1; } ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?= $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $totalpages) { echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno >= $totalpages) {echo '#';}else{ echo '?pageno='.$pageno+1; } ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno<?= $totalpages; ?>">Last</a></li>
                  </ul>
              </nav>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark">
    
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside> -->
  <!-- /.control-sidebar -->

  <?php include ("layouts/footer.php"); ?>