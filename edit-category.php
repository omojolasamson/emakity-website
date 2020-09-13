<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['ScUriTe'])==0)
{	
header('location:index.php');
}
else{ 
if(isset($_GET['edit']))
{
$cateid=$_GET['edit'];
}

  if(isset($_POST['submit']))
  {

  $file = $_FILES['cateimg']['name'];

  if($file == ''){
    $itemimg = $_POST['oldimg'];
  }
  else{
    $file_loc = $_FILES['cateimg']['tmp_name'];
    $folder="itemimg/";
    $new_file_name = strtolower($file);
    $final_file=str_replace(' ','-',$new_file_name);
    if(move_uploaded_file($file_loc,$folder.$final_file))
    {
    $itemimg=$final_file;
    }
  }
  
  $catename=$_POST['categry'];
  $catedes=$_POST['catedes'];
  
  $sql="UPDATE category SET categry=(:catename), catedes=(:catedes), cateimg=(:cateimg) WHERE id=(:id)";
  $query = $dbh->prepare($sql);
  $query->bindParam(':catename',$catename,PDO::PARAM_STR);
  $query->bindParam(':catedes',$catedes,PDO::PARAM_STR);
  $query->bindParam(':cateimg',$itemimg,PDO::PARAM_STR);
  $query->bindParam(':id',$cateid,PDO::PARAM_STR);

  if($query->execute())
  {
  $msg="Updated successfully";
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
      <title>Edit Category
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
      <script type= "text/javascript" src="../vendor/countries.js">
      </script>
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
                <h2 class="page-title">Update Category
                </h2>
                <div class="row">
                  <div class="col-md-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">Basic Info
                      </div>
                      <?php if($error){?>
                      <div class="errorWrap">
                        <?php echo htmlentities($error); ?> 
                      </div>
                      <?php } 
  else if($msg){?>
                      <div class="succWrap">
                        <?php echo htmlentities($msg); ?> 
                      </div>
                      <?php }?>
                      <div class="panel-body">

<?php 
  $sql = "SELECT * FROM category WHERE id =:id";
  $query = $dbh -> prepare($sql);
  $query->bindParam(':id',$cateid,PDO::PARAM_STR);
  $query->execute();
  $result=$query->fetch(PDO::FETCH_OBJ);
?>

                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Name
                              <span style="color:red">*
                              </span>
                            </label>
                            <div class="col-sm-4">
                              <input type="text" name="categry" class="form-control" required value="<?php echo $result->categry; ?>">
                              <input type="hidden" name="oldimg" required value="<?php echo $result->cateimg; ?>">
                            </div>
                            <label class="col-sm-2 control-label">Image
                              <span style="color:red">*
                              </span>
                            </label>
                            <div class="col-sm-4">
                              <input type="file" name="cateimg" class="form-control" value="Select Image File">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label">Category Description
                            </label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="catedes"  value="<?php echo $result->catedes; ?>" required>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                              <button class="btn btn-primary" name="submit" type="submit">Update Changes
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
  