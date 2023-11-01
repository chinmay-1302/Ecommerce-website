<?php

// require_once "db.php";
// if(!isset($_REQUEST['id'])){
//     header("Location: home.php");
// }

require 'db.php';

session_start();



// if ($_SERVER['REQUEST_METHOD'] == "POST") { 
//   echo "hello";
//   if(isset($_POST['submit1'])){
//     echo "hoya";
//     //$orderID = $db->insert_id;
//     //header("Location: review.php");
//   }
//   }

//echo "hello"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Success</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="./js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    .container{width: 100%;padding: 50px;}
    p{color: #34a853;font-size: 18px;}
    </style>
</head>
</head>
<body>
  <div class="container">
    <div class="jumbotron">
      <from action="" method="post" autocomplete="off">
        <h1>Order Status</h1>
        <p>Your order has placed successfully. Order ID is #<?php echo $_GET['id']; ?></p>
        <!-- <a href="review.php?action=GoToReview" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"> -->
        <a href="cartAction.php?action=placeOrder1" class="btn btn-success orderBtn">Go to Review <i class="glyphicon glyphicon-menu-right"></i></a>
      </from>
    </div>

  </div>
</body>
</html>


