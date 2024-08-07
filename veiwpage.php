<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>


  <div class="PageHeader PageHeader--withBackground">
  <div class="PageHeader__ImageWrapper" data-optimumx="1.2" style="background-image: url(&quot;//www.lakmeindia.com/cdn/shop/collections/new_arrivals_page_banner.jpg?v=1696182698&quot;); transform: translate3d(0px, 0px, 0px);">
          </div>

          <noscript>
            <div class="PageHeader__ImageWrapper "
             style="background-image: url(../img/imgview.webp)">
             <img src="img/imgview.webp" alt="">
            </div>
          </noscript>
  </div>
</body>
<script src="https://apis.google.com/_/scs/abc-static/_/js/k=gapi.lb.en.Oh6mNxd5OYM.O/m=auth2/exm=client/rt=j/sv=1/d=1/ed=1/rs=AHpOoo-goHQwcBQdTSfIcaYi5vOvnb-P8g/cb=gapi.loaded_1?le=scs" async=""></script>

</html> -->

<?php
session_start();


include("connection.php");
extract($_REQUEST);
$arr=array();
if(isset($_GET['msg']))
{
	$loginmsg=$_GET['msg'];
}
else
{
	$loginmsg="";
}
if(isset($_SESSION['cust_id']))
{
	 $cust_id=$_SESSION['cust_id'];
	 $cquery=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
	 $cresult=mysqli_fetch_array($cquery);
}
else
{
	$cust_id="";
}





$query=mysqli_query($con,"select  tblvendor.fld_name,tblvendor.fldvendor_id,tblvendor.fld_email,
tblvendor.fld_mob,tblvendor.fld_address,tblvendor.fld_logo,tbproduct.product_id,tbproduct.productname,tbproduct.cost,
tbproduct.Cosmetics,tbproduct.paymentmode 
from tblvendor inner join tbproduct on tblvendor.fldvendor_id=tbproduct.fldvendor_id;");
while($row=mysqli_fetch_array($query))
{
	$arr[]=$row['product_id'];
	shuffle($arr);
}

//print_r($arr);

 if(isset($addtocart))
 {
	 
	if(!empty($_SESSION['cust_id']))
	{
		 
		header("location:form/cart.php?product=$addtocart");
	}
	else
	{
		header("location:form/?product=$addtocart");
	}
 }
 
 if(isset($login))
 {
	 header("location:form/index.php");
 }
 if(isset($logout))
 {
	 session_destroy();
	 header("location:index.php");
 }
 $query=mysqli_query($con,"select tbproduct.productname,tbproduct.fldvendor_id,tbproduct.cost,tbproduct.Cosmetics,tbproduct.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbproduct inner  join tblcart on tbproduct.product_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
if(isset($message))
 {
	 
	 if(mysqli_query($con,"insert into tblmessage(fld_name,fld_email,fld_phone,fld_msg) values ('$nm','$em','$ph','$txt')"))
     {
		 echo "<script> alert('We will be Connecting You shortly')</script>";
	 }
	 else
	 {
		 echo "failed";
	 }
 }

?>
<html>
  <head>
     <title>Home</title>
	 <!--bootstrap files-->
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	  <!--bootstrap files-->
	 
	 <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
     <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
	 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Permanent+Marker" rel="stylesheet">
     
	 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	 
	 
	 <script>
	 //search product function
            $(document).ready(function(){
	
	             $("#search_text").keypress(function()
	                      {
	                       load_data();
	                       function load_data(query)
	                           {
		                        $.ajax({
			                    url:"fetch2.php",
			                    method:"post",
			                    data:{query:query},
			                    success:function(data)
			                                 {
				                               $('#result').html(data);
			                                  }
		                                });
	                             }
	
	                           $('#search_text').keyup(function(){
		                       var search = $(this).val();
		                           if(search != '')
		                               {
			                             load_data(search);
		                                }
		                            else
		                             {
			                         $('#result').html(data);			
		                              }
	                                });
	                              });
	                            });
								
								//Salon search
								$(document).ready(function(){
	
	                            $("#search_salon").keypress(function()
	                         {
	                         load_data();
	                       function load_data(query)
	                           {
		                        $.ajax({
			                    url:"fetch.php",
			                    method:"post",
			                    data:{query:query},
			                    success:function(data)
			                                 {
				                               $('#resultsalon').html(data);
			                                  }
		                                });
	                             }
	
	                           $('#search_salon').keyup(function(){
		                       var search = $(this).val();
		                           if(search != '')
		                               {
			                             load_data(search);
		                                }
		                            else
		                             {
			                         load_data();			
		                              }
	                                });
	                              });
	                            });
</script>
<style>
//body{
     background-image:url("img/Products.jpg");
	 background-repeat: no-repeat;
	 background-attachment: fixed;
	  background-position: center;
}
ul li {list-style:none;}
ul li a{color:black; font-weight:bold;}
ul li a:hover{text-decoration:none;}


</style>
  </head>
  
    
	<body>
	




<div id="result" style="position:fixed;top:300; right:500;z-index: 3000;width:350px;background:white;"></div>
<div id="resultsalon" style=" margin:0px auto; position:fixed; top:150px;right:750px; background:white;  z-index: 3000;"></div>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  
    <a class="navbar-brand" href="index.php"><span style="color:green;font-family: 'Permanent Marker', cursive;">GLAM HAVEN</span></a>
    <?php
	if(!empty($cust_id))
	{
	?>
	<a class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"><?php echo $cresult['fld_name']; ?></i></a>
	<?php
	}
	?>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
      <ul class="navbar-nav ml-auto"  style="font-size: 18px;">
        
		<li class="nav-item"><!--salon search-->
		     <a href="#" class="nav-link"><form method="post"><input type="text" name="search_salon" id="search_salon" placeholder="Search Salon " class="form-control " /></form></a>
		  </li>
          <li class="nav-item">
		     <a href="#" class="nav-link"><form method="post"><input type="text" name="search_text" id="search_text" placeholder="Search by Product Name " class="form-control " /></form></a>
		  </li>
		  <li class="nav-item active">
          <a class="nav-link" href="index.php">Home</a>
        </li>
		<li class="nav-item active">
          <a class="nav-link" href="categories.php">Categories</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="aboutus.php">About</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="services.php">Services</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
		<li class="nav-item">
		  <form method="post">
          <?php
			if(empty($cust_id))
			{
			?>
			<a href="form/index.php?msg=you must be login first"><span style="color:red; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart"  class="badge badge-light">0</span></i></span></a>
			
			&nbsp;&nbsp;&nbsp;
			<button class="btn btn-outline-danger my-2 my-sm-0" name="login" type="submit">Log In</button>&nbsp;&nbsp;&nbsp;
            <?php
			}
			else
			{
			?>
			<a href="form/cart.php"><span style=" color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) { echo $re; }?></span></i></span></a>
			<button class="btn btn-outline-success my-2 my-sm-0" name="logout" type="submit">Log Out</button>&nbsp;&nbsp;&nbsp;
			<?php
			}
			?>
			</form>
        </li>
		
      </ul>
	  
    </div>
	
</nav>
<!--menu ends-->
<div id="demo" class="carousel slide" data-ride="carousel">
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/back8A.jpg" alt="Los Angeles" class="d-block w-100">
      <div class="carousel-caption">
        <h3>Los Angeles</h3>
        <p>We had such a great time in LA!</p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="img/imgview1.jpg" alt="Chicago" class="d-block w-100">
      <div class="carousel-caption">
        <h3>Chicago</h3>
        <p>Thank you, Chicago!</p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="img/Products1.jpg" alt="New York" class="d-block w-100">
      <div class="carousel-caption">
        <h3>New York</h3>
        <p>We love the Cosmetics Product!</p>
      </div>   
    </div>
  </div>
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
<!--slider ends-->

<!--container 1 starts-->
<div class="row row-cols-1 row-cols-md-3 g-4" style="padding: 312px;">
  <div class="col">
    <div class="card h-100">
      <img src="img/viewlipstics1.png" class="card-img-top" alt="..."style="padding: 10px  height: 263px; width: 100%;">
      <div class="card-body">
        <h5 class="card-title">Lipstics</h5>
        <p class="card-text">(ALL SKIN TYPE)</p>
      </div>
      <h6  style="margin-bottom: -1.5rem; font-weight: 500; line-height: 0.2;">Rs.100</h6>
      <ul style="color: #ff9f43;font-weight: 900; font-size: 26px;transition: .4s;margin: 3px;font-family:Font Awesome 5 Free; font-style: normal;font-variant: normal;text-rendering: auto;line-height: 1;display: flex;justify-content: center; align-items: center;">
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star"></i></li>
          <li><i class="fa fa-star"></i></li>
      </ul>
      <button class="button" style=" background: #2183a2; text-align: center;font-size: 24px; color: #fff;padding:4px;border: 0;outline: none;cursor: pointer;margin-top: 5px ">Buy Now</button>
      <div class="card-footer">
        <small class="text-muted">Last updated 10 mins ago</small>
      </div>
    </div>
  </div>

  <div class="col">
    <div class="card h-100">
      <img src="img/Viewlipstics2.jpg" class="card-img-top" alt="..."style="padding: 10px height: 263px; width: 100%;">
      <div class="card-body">
        <h5 class="card-title">Matte Lipstic</h5>
        <p class="card-text">(ALL SKIN TYPE)</p>
      </div>
      <h6 style="margin-bottom: -1.5rem; font-weight: 500; line-height: 0.2;">Rs.200</h6>
      <ul style="color: #ff9f43;font-weight: 900; font-size: 26px;transition: .4s;margin: 3px;font-family:Font Awesome 5 Free; font-style: normal;font-variant: normal;text-rendering: auto;line-height: 1;display: flex;justify-content: center; align-items: center;">
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star"></i></li>
          <li><i class="fa fa-star"></i></li>
      </ul>
      <button class="button" style=" background: #2183a2; text-align: center;font-size: 24px; color: #fff;padding:4px;border: 0;outline: none;cursor: pointer;margin-top: 5px">Buy Now</button>
      <div class="card-footer">
        <small class="text-muted">Last updated 5 mins ago</small>
      </div>
    </div>
  </div>


  <div class="col">
    <div class="card h-100">
      <img src="img/Viewlipstics3.png" class="card-img-top" alt="..."style="padding: 10px height: 263px; width: 100%; ">
      <div class="card-body">
        <h5 class="card-title">Lipstic</h5>
        <p class="card-text">(ALL SKIN TYPE)</p>
      </div>
      <h6  style="margin-bottom: -1.5rem; font-weight: 500; line-height: 0.2;">Rs.250</h6>
      <ul style="color: #ff9f43;font-weight: 900; font-size: 26px;transition: .4s;margin: 3px;font-family:Font Awesome 5 Free; font-style: normal;font-variant: normal;text-rendering: auto;line-height: 1;display: flex;justify-content: center; align-items: center;">
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star checked"></i></li>
          <li><i class="fa fa-star"></i></li>
          <li><i class="fa fa-star"></i></li>
      </ul>
      <button class="button" style=" background: #2183a2; text-align: center;font-size: 24px; color: #fff;padding:4px;border: 0;outline: none;cursor: pointer;margin-top: 5px">Buy Now</button>

      <div class="card-footer">
        <small class="text-muted">Last updated 3 mins ago</small>
      </div>
    </div>
  </div>
</div> 


<br>
		    <?php
			include("footer.php");
			?>
			 			 
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  
          

	</body>
</html>