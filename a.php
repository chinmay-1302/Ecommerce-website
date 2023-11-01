<?php
$a=$_GET['id'];


/* Displays user information and some useful messages */
session_start();
include 'dbConfig.php';
include 'db.php';
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ||  $_SESSION['email']!=='admin@eshop.com') {
  $_SESSION['message'] = "You must log in as an admin to view this page!";
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

$query = $mysqli->query("SELECT * FROM products where id='$a' ");
$row = $query->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add product</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="./js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    .container{padding: 0px;}
    body{ background-color: #EEEEEE}
    .glyphicon .badge .navbar{font-size: 17px;}
    .navbar{font-size: 17px;}
    .badge{font-size: 17px;}
    th, td {padding: 15px;text-align: center;}
    table, th, td {border: 2px solid black;}
    input[type="number"]{width: 20%;}
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
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Page</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= $first_name?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </a></li>
      </ul>
    </div>
  </nav>

  <div class="container" style="margin:40px">

    <form class="form-horizontal" method="post" action="">
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Product name:</label>
        <div class="col-sm-10">
          <input type="text" required class="form-control" name="name" id="name" value="<?php echo $row['name'];?>">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="description">Product description:</label>
        <div class="col-sm-10">
          <textarea required rows="3" class="form-control" name="description"
           id="description"><?php echo $row["description"]; ?></textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="price" >Product price:</label>
        <div class="col-sm-10">
          <input type="number" required class="form-control" name="price" id="price" step="any" value="<?php echo $row["price"]; ?>">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default" name="ss">Submit</button>
        </div>
      </div>
    </form>
  </div>

</div>
</body>
</html>

<?php

 
 if(isset($_POST['ss'])){
    $price=$_POST['price'];
    $name=$_POST['name'];
    $desc=$_POST['description'];
    $sql=$mysqli->query("UPDATE products SET name = '$name', description= '$desc', price='$price' WHERE id = '$a'");
    header("location:admin.php");
 }

?>