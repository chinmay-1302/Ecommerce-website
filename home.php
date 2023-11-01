<?php
// include database configuration file
include 'dbConfig.php';
include 'Cart.php';
$cart = new Cart;
//echo $cart->total_items();
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile!";
  header("location: error.php");
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="utf-8">
    <title>Welcome <?= $first_name.' '.$last_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="./js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    .container{padding: 0px;}
    body{ background-color: #EEEEEE}
    .glyphicon .badge .navbar{font-size: 17px;}
    .navbar{font-size: 17px;}
    .badge{font-size: 17px;}
    </style>
</head>
</head>
<body>
  <nav class="navbar navbar-inverse"  style="border-radius: 0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">E-Shop</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="home.php">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?= $first_name?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <li><a href="viewCart.php" title="View Cart">
          <span class="glyphicon glyphicon-shopping-cart"></span> Cart:
          <span class="badge"><?php echo $cart->total_items();?></span>
        </a></li>
      </ul>
    </div>
  </nav>


  
   </div>
  
<div class="container" >
<form action="" method="post"class="cf">
  <input type="text" name="search" placeholder="Is it me you’re looking for?" style="border-radius:8px; border-bottom:2px solid black;">
  <button type="submit" style="border:none; "><i class="fa fa-search"></i></button>
</form>
<br>
    <h1 >Products</h1><br>
    
    
    <?php
    if(isset($_POST['search'])){
      $b=$_POST['search'];
      $query = $db->query("SELECT * FROM products where description like '%$b%' ");
      if($query->num_rows > 0){
        while($row = $query->fetch_assoc()){
          $a =$row['id'];
          $quert = $db->query("SELECT avg(score) as avge FROM rating where p_id = '$a'");
          $row2 = $quert->fetch_assoc();
    ?>
    <div class="item col-lg-4 ">
        <div class="thumbnail" >
            <div class="caption" style="height:170px;">
                <h4 class="list-group-item-heading"><?php echo $row["name"]; ?></h4>
                <p class="list-group-item-text" style="padding-bottom:10px"><?php echo $row["description"]; ?></p>
                <div class="row">
                    <div class="col-md-6">
                        <p>Rating: <?php
                        if ($row2 != null) {
                          echo round($row2["avge"],2);
                        }
                        else {
                          echo "NA";
                        }
                        ?></p>
                        <p class="lead"><?php echo 'Rs. '.$row["price"]; ?></p>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-success" href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>">Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } }else{ ?>
    <p>Product(s) not found.....</p>
    <?php }
    }else{
    ?>

    <div id="products" class="row list-group" >
        <?php
        //get rows query
        // $query = $db->query("SELECT * FROM products ORDER BY id ");
        // if($query->num_rows > 0){
        //     while($row = $query->fetch_assoc()){
        //       $a =$row['id'];
        //       $quert = $db->query("SELECT avg(score) as avge FROM rating where p_id = '$a'");
        //       $row2 = $quert->fetch_assoc();
        ?>
        <div class="item col-lg-4 ">
            <div class="thumbnail" >
                <div class="caption" style="height:170px;">
                    <h4 class="list-group-item-heading"><?php //echo $row["name"]; ?></h4>
                    <p class="list-group-item-text" style="padding-bottom:10px"><?php //echo $row["description"]; ?></p>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Rating: <?php
                            //if ($row2 != null) {
                              //echo round($row2["avge"],2);
                            //}
                            //else {
                              //echo "NA";
                            //}
                            ?></p>
                            <p class="lead"><?php// echo 'Rs. '.$row["price"]; ?></p>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-success" href="cartAction.php?action=addToCart&id=<?php //echo $row["id"]; ?>">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } //else{ ?>
        <p>Product(s) not found.....</p>
        <?php //} 
        //}?>
    </div>
</div>
</body>
</html>
