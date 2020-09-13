<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['ScUriTe'])==0)
{	
header('location:index.php');
}
else{
if(isset($_REQUEST['orderid']))
{
$orderid=intval($_GET['orderid']);
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
    <title>Grocery | View Order  
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
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
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
                <div class="col-md-3 h5">
                  <a href="manage-orders.php"> GO BACK
                  </a>
                </div>
                <div class="col-md-3 h5">
                </div>
                <div class="col-md-3 h5">
                </div>
                <div class="col-md-3 h5">
                  <b>Order No. : 
                    <?php echo htmlentities($orderid); ?>
                  </b>
                </div>	
              </div>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">Order List
                </div>
                <div class="panel-body">
                  <div class="container">
                    <div class="row text-left">
                      <?php $sql = "SELECT * from orders WHERE orderid = :orderid";
                          $query = $dbh -> prepare($sql);
                          $query-> bindParam(':orderid',$orderid, PDO::PARAM_STR);
                          $query->execute();
                          $resultm=$query->fetch(PDO::FETCH_OBJ);
                          ?>
                      
                      <div class="col-md-4">Name : <?php echo htmlentities($resultm->fname);?></div>
                      <div class="col-md-4">Mobile : <?php echo htmlentities($resultm->mobile);?></div>
                      <div class="col-md-4">City : <?php echo htmlentities($resultm->city);?></div>
                      <div class="col-md-4">Area : <?php echo htmlentities($resultm->area);?></div>
                      <div class="col-md-4">Address : <?php echo htmlentities($resultm->address);?></div>
                      <div class="col-md-4">PayType : <?php echo htmlentities($resultm->paymenttype);?></div>
                      <div class="col-md-4">PayId : <?php echo htmlentities($resultm->payid);?></div>
                      <div class="col-md-4">Delivery Type : <?php echo htmlentities($resultm->dtype);?></div>
                    </div>
                  </div>
                  <br>
                  <table class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#
                        </th>
                        <th>Name
                        </th>
                        <th>Quantity
                        </th>
                         
                        <th>Price
                        </th>
                        <th>Qty
                        </th>
                        <th>Total
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from orderslist WHERE orderid = :orderid";
                          $query = $dbh -> prepare($sql);
                          $query-> bindParam(':orderid',$orderid, PDO::PARAM_STR);
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
                          <?php echo htmlentities($result->itemname);?> 
                        </td>
                        <td>
                          <?php echo htmlentities($result->itemquantity);?>  <?php echo htmlentities($result->itemquantitytype);?>
                        </td>
                       
                        <td>
                          $<?php echo htmlentities($result->itemprice);?>
                        </td>
                         <td>
                          <?php echo htmlentities($result->Mquantity);?>
                        </td>
                        <td>
                          $<?php echo htmlentities($result->itemprice * $result->Mquantity);?>
                        </td>
                      </tr>
                      <?php $cnt=$cnt+1; }} ?>	
                    </tbody>
                  </table>
                  <div class="container">
                    <div class="row">
                      <div class="col-md-10">
                      </div>
                      <div class="col-md-2 h4">
                        <b>Shipping : 
                          $<?php echo htmlentities($resultm->shipping);?>
                        </b>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-10">
                      </div>
                      <div class="col-md-2 h4">
                        <b>Grand Total : 
                          $<?php echo htmlentities($resultm->total);?>
                        </b>
                      </div>
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
  </body>
</html>
<?php } ?>