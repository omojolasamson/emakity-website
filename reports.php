<?php 
session_start();
//error_reporting(0);
session_regenerate_id(true);
include('includes/config.php');

if(strlen($_SESSION['ScUriTe'])==0)
	{	
	header("Location: index.php"); //
	}
	else{?>
<table border="1">
									<thead>
									
										<tr>
											<th>OrderID</th>
											<th>OrderTime</th>
											<th>Name</th>
											<th>MobileNo</th>
											<th>Address</th>
											<th colspan="3">Info</th>
										</tr>
									</thead>

<?php 
$filename="reports";
$sql = "SELECT * from  orders ORDER BY orderid DESC";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				

	$grandtotal = 0;
echo '  
<tr>  
<td>'.$result->orderid.'</td> 
<td>'.$result->ordertime.'</td> 
<td>'.$result->fname.'</td> 
<td>'.$result->mobile.'</td> 
<td>'.$result->address.'</td> 		
<th colspan="3">'.$result->status.'</th> 	
</tr>  
';

$sqltemp = "SELECT * from  orderslist where orderid =:orderid";
$querytemp = $dbh -> prepare($sqltemp);
$querytemp-> bindParam(':orderid',$result->orderid, PDO::PARAM_STR);
$querytemp->execute();
$resultsdetails=$querytemp->fetchAll(PDO::FETCH_OBJ);
$mnt=1;

echo '
	<tr></tr>

	<tr>
		<th></th>
		<th>#</th>
		<th>ItemName</th>
		<th>ItemQuantity</th>
		<th>Type</th>
		<th>Quantity</th>
		<th>ItemPrice</th>
		<th>ItemTotal</th>
	</tr>
';
if($querytemp->rowCount() > 0)
{
	$subitem = 0;
foreach($resultsdetails as $detail)
{
	
	echo '
	<tr>
	<td></td>
	<td>'.$mnt.'</td> 
	<td>'.$detail->itemname.'</td> 
	<td>'.$detail->itemquantity.'</td> 
	<td>'.$detail->itemquantitytype.'</td> 
	<td>'.$detail->Mquantity.'</td> 
	<td>Rp'.$detail->itemprice.'</td> 
	<td>Rp'.$detail->itemtotal.'</td>			
	</tr>  
	';
	$mnt++;
	$subitem = $subitem + $detail->itemtotal;
}
	

}	
echo '
	<tr>
		<th colspan="5">Total</th>
		<th colspan="3">Rp'.$subitem.'</th>
	</tr>
	<tr></tr>
	
	';

header("Content-Type: application/vnd.ms-excel");   
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
			$cnt++;
		}
	}
?>
</table>
<?php } ?>