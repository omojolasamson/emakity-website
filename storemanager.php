<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['ScUriTe'])==0)
{	
header('location:index.php');
}
else{
if(isset($_REQUEST['del']))
{
$delid=intval($_GET['del']);
$sqldel = "DELETE FROM storemanager WHERE id=:delid";
$querydel = $dbh->prepare($sqldel);
$querydel-> bindParam(':delid',$delid, PDO::PARAM_STR);
$querydel -> execute();
unset($sqldel);
$msg="Deleted Sucessfully";
}
if(isset($_POST['submit']))
{
$sname=$_POST['sname'];
$smobile=$_POST['smobile'];
$susername=$_POST['susername'];
$spassword=$_POST['spassword'];
$sql="INSERT INTO storemanager(sname, smobile, susername, spassword) VALUES(:sname,:smobile, :susername, :spassword)";
$query = $dbh->prepare($sql);
$query->bindParam(':sname',$sname,PDO::PARAM_STR);
$query->bindParam(':smobile',$smobile,PDO::PARAM_STR);
$query->bindParam(':susername',$susername,PDO::PARAM_STR);
$query->bindParam(':spassword',$spassword,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Added Sucessfully";
}
else 
{
$error="Something went wrong. Please try again";
}
}
?>
<!doctype html>
<html lang="en" class="no-js">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Store Manager
    </title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
      .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #dd3d36;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #5cb85c;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
    </style>
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4>Store Manager Info
                      </h4>
                    </div>
                    <div class="panel-body">
                      <form method="post" class="form-horizontal">
                        <?php if($error){?>
                        <div class="errorWrap">
                          <strong>ERROR
                          </strong>:
                          <?php echo htmlentities($error); ?> 
                        </div>
                        <?php } 
else if($msg){?>
                        <div class="succWrap">
                          <strong>SUCCESS
                          </strong>:
                          <?php echo htmlentities($msg); ?> 
                        </div>
                        <?php }?>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Name
                            </label>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" name="sname" required>
                            </div>
                            <label class="col-sm-1 control-label">Mobile
                            </label>
                            <div class="col-sm-5">
                              <input type="text" class="form-control" name="smobile" required>
                            </div>
                          </div>
                          <div class="form-group">
                          <label class="col-sm-1 control-label">Username
                          </label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" name="susername" required>
                          </div>
                          <label class="col-sm-1 control-label">Password
                          </label>
                          <div class="col-sm-5">
                            <input type="text" class="form-control" name="spassword" required>
                          </div>
                          </div>
                          <div class="col-sm-2">
                            <button class="btn btn-primary" name="submit" type="submit">ADD
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">Store Manager
            </div>
            <div class="panel-body">
              <table class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#
                    </th>
                    <th>Name
                    </th>
                    <th>Mobile
                    </th>
                    <th>Username
                    </th>
                    <th>Password
                    </th>
                    <th>Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php $sql = "SELECT * from storemanager";
                      $query = $dbh -> prepare($sql);
                      $query->execute();
                      $results=$query->fetchAll(PDO::FETCH_OBJ);
                      $cnt=1;
                      if($query->rowCount() > 0)
                      {
                      foreach($results as $result)
                      {				?>	
                  <tr>
                    <td>
                      <?php echo htmlentities($cnt);?>
                    </td>
                    <td>
                      <?php echo htmlentities($result->sname);?>
                    </td>
                    <td>
                      <?php echo htmlentities($result->smobile);?>
                    </td>
                    <td>
                      <?php echo htmlentities($result->susername);?>
                    </td>
                    <td>
                      <?php echo htmlentities($result->spassword);?>
                    </td>
                    <td>
                      <a href="storemanager.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete');">
                        <i class="fa fa-close" style="color:red">
                        </i>
                      </a>
                    </td>
                  </tr>
                  <?php $cnt=$cnt+1; }} ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Loading Scripts -->
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap-select.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/jquery.dataTables.min.js">
    </script>
    <script src="js/dataTables.bootstrap.min.js">
    </script>
    <script src="js/Chart.min.js">
    </script>
    <script src="js/fileinput.js">
    </script>
    <script src="js/chartData.js">
    </script>
    <script src="js/main.js">
    </script>
    <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.succWrap').slideUp("slow");
        }
                   , 3000);
      }
                       );
    </script>
  </body>
</html>
<?php } ?>
