<?php
$connect = mysqli_connect("localhost", "root", "947539", "GLAM HAVEN");
$output = '';
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($connect, $_POST["query"]);
	$query = "
	SELECT * FROM tbproduct
	WHERE productname LIKE '%".$search."%'
	OR Cosmetics LIKE '%".$search."%' 
	
	";
}
else
{
	$query = "
	SELECT * FROM tbproduct ";
}
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
	$output .= '';
	while($row = mysqli_fetch_array($result))
	{
		$product_id= $row['product_id'];
		$output .= '
			<tr style="width:100%;background:white; border:1px solid black;">
				<td style="border-bottom:solid 1px black;padding:10px;"><a href="searchproduct.php?product_id='.$product_id.'" style="text-decoration:none;font-weight:bold; color:black;padding:100px;">'.$row["productname"].'</a></td>
				
			</tr>
		';
	}
	echo $output;
}
else
{
	echo 'Data Not Found';
}
?>