<?php
/* Displays user information and some useful messages */
session_start();
include 'dbConfig.php';
include 'db.php';
// Check if user is logged in using the session variable
if ($_SESSION['logged_in'] != 1 || $_SESSION['email'] !== 'admin@eshop.com') {
  $_SESSION['message'] = "You must log in as an admin to view this page!";
  header("location: error.php");
} else {
  // Makes it easier to read
  $first_name = $_SESSION['first_name'];
  $last_name = $_SESSION['last_name'];
  $email = $_SESSION['email'];
  $active = $_SESSION['active'];
  $address = $_SESSION['address'];
  $phone = $_SESSION['phone'];
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="./js/jquery.min.js"></script>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    .container {
      padding: 0px;
    }

    body {
      background-color: #EEEEEE
    }

    .glyphicon .badge .navbar {
      font-size: 17px;
    }

    .navbar {
      font-size: 17px;
    }

    .badge {
      font-size: 17px;
    }

    th,
    td {
      padding: 15px;
      text-align: center;
    }

    table,
    th,
    td {
      border: 2px solid black;
    }

    input[type="number"] {
      width: 20%;
    }
  </style>

</head>
</head>

<body>
  <nav class="navbar navbar-inverse" style="border-radius: 0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">E-Shop</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span>
            <?= $first_name ?>
          </a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </a></li>
      </ul>
    </div>
  </nav>
  <div class="container" style="margin:40px">

    <a class="btn btn-success" href="product.php">Add a product</a><br><br>

    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#home" id="home-id" onclick="document.getElementById('menu6').style.display = 'none';">Home</a></li>
      <li><a data-toggle="tab" href="#menu1" onclick="document.getElementById('menu6').style.display = 'block';">Customers</a></li>
      <li><a data-toggle="tab" href="#menu2" onclick="document.getElementById('menu6').style.display = 'block';">Ordered Items</a></li>
      <li><a data-toggle="tab" href="#menu3" onclick="document.getElementById('menu6').style.display = 'block';">Orders</a></li>
      <li><a data-toggle="tab" href="#menu4" onclick="document.getElementById('menu6').style.display = 'block';">Products</a></li>
      <li><a data-toggle="tab" href="#menu5" onclick="document.getElementById('menu6').style.display = 'block';">reviews</a></li>
    </ul>
    <div class="tab-content">
      <div id="home" class="tab-pane fade in active">
        <h3>HOME</h3>
        <p>You can check the different databases from here</p>
      </div>
      <br>

      <?php
      $showtables = $mysqli->query("SHOW TABLES FROM cart");

      $s = 1;

      while ($table = $showtables->fetch_array()) { // go through each row that was returned in $result
      
        $result = $mysqli->query("SELECT * FROM " . $table[0]);
        $num = $result->field_count;

        echo "<div id='menu" . $s . "' class='tab-pane fade'>";
        $s++;
        echo "<h1>" . ucwords($table[0]) . "</h1><br>";


        echo "<table class='table table-bordered' border='1'
        style='table-layout:fixed;border: 1px solid black;'>
        <tr>";
        while ($finfo = $result->fetch_field()) {
          echo "<th style='border: 1px solid black;'>" . $finfo->name . "</th>";
        }
        echo "</tr>";

        while ($row = $result->fetch_array()) {
          echo "<tr>";
          $i = 0;
          while ($i < $num) {
            echo "<td style='overflow: hidden;text-overflow: ellipsis;
              word-wrap: break-word;border: 1px solid black;'>" . $row[$i] . "</td>";
            $i++;
          }
          echo "</tr>";
        }
        echo "</table>"; // print the table that was returned on that row.
      
        echo "</div>";
      }


      $count = $mysqli->query("SELECT * FROM orders ;");


      echo "<div id='menu" . $s . "' class='tab-pane fade'>
      <h1> Customer orders</h1><br>";

      $x = 0;
      while ($x < $count->num_rows) {

        $x++;
        $view = $mysqli->query(
          "SELECT orders.id, customers.first_name, orders.total_price
          FROM orders
          INNER JOIN customers
          ON orders.customer_id=customers.id
          INNER JOIN order_items
          ON orders.id = " . $x . "
          order by orders.created;"
        );

        echo "<table class='table table-bordered' border='1'
          style='table-layout:fixed;border: 1px solid black;'>
          <tr>";

        while ($finfo1 = $view->fetch_field()) {
          echo "<th style='border: 1px solid black;'>" . $finfo1->name . "</th>";
        }
        echo "</tr>";
        $num1 = $view->field_count;

        $table1 = $view->fetch_array();

        echo "<tr>";
        $i1 = 0;
        while ($i1 < $num1) {
          echo "<td style='overflow: hidden;text-overflow: ellipsis;
                word-wrap: break-word;border: 1px solid black;'>" . $table1[$i1] . "</td>";
          $i1++;
        }
        echo "</tr>";

        echo "</table><button type='button' class='btn btn-info'
          data-toggle='collapse' data-target='#" . $x . "'>Show orders</button><br><br>";

        $view1 = $mysqli->query(
          "SELECT order_id, product_id, quantity
            FROM order_items
            WHERE order_id = " . $x . ";"
        );

        echo "<div id=" . $x . " class='collapse'>";

        echo "<table class='table table-bordered' border='1'
            style='table-layout:fixed;border: 1px solid black;'>
            <tr>";

        while ($finfo2 = $view1->fetch_field()) {
          echo "<th style='border: 1px solid black;'>" . $finfo2->name . "</th>";
        }
        echo "</tr>";
        $num2 = $view1->field_count;


        while ($table2 = $view1->fetch_array()) {

          echo "<tr>";
          $i2 = 0;
          while ($i2 < $num2) {
            echo "<td style='overflow: hidden;text-overflow: ellipsis;
                  word-wrap: break-word;border: 1px solid black;'>" . $table2[$i2] . "</td>";
            $i2++;
          }
          echo "</tr>";
        }

        echo "</table></div><br><br>";

      }
      echo "</div>";

      echo "</div>";
      ?>
      <div id="menu6">
        <div class="container">
          <form action="" method="post" class="cf">
            <input type="text" name="search" placeholder="Is it me you’re looking for?"
              style="border-radius:8px; border-bottom:2px solid black;">
            <button type="submit" style="border:none; "><i class="fa fa-search"></i></button>
          </form>
          <br>
          <h1>Products</h1><br>


          <?php
          if (isset($_POST['search'])) {
            $b = $_POST['search'];
            $query0 = $mysqli->query("SELECT * FROM products where description like '%$b%' ");
            if ($query0->num_rows > 0) {
              while ($row = $query0->fetch_assoc()) {
                $a = $row['id'];
                $_SESSION['id']=$a;
                $quert = $mysqli->query("SELECT avg(score) as avge FROM rating where p_id = '$a'");
                $row2 = $quert->fetch_assoc();
                ?>
                <div class="item col-lg-4 ">
                  <div class="thumbnail">
                    <div class="caption" style="height:170px;">
                      <h4 class="list-group-item-heading">
                        <?php echo $row["name"]; ?>
                      </h4>
                      <p class="list-group-item-text" style="padding-bottom:10px">
                        <?php echo $row["description"]; ?>
                      </p>
                      <div class="row">
                        <div class="col-md-6">
                          <p>Rating:
                            <?php
                            if ($row2 != null) {
                              echo round($row2["avge"], 2);
                            } else {
                              echo "NA";
                            }
                            ?>
                          </p>
                          <p class="lead">
                            <?php echo 'Rs. ' . $row["price"]; ?>
                          </p>
                        </div>
                        <div class="col-md-6">
                          <a class="btn btn-success" href="a.php?id=<?php echo $a; ?>">Update</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }
            } else { ?>
              <p>Product(s) not found.....</p>
            <?php }
          } else {
            ?>

            <div id="products" class="row list-group">
              <?php
              //get rows query
              $query0 = $mysqli->query("SELECT * FROM products ORDER BY id ");
              if ($query0->num_rows > 0) {
                while ($row = $query0->fetch_assoc()) {
                  $a = $row['id'];
                  $_SESSION['id']=$a;
                  $quert = $mysqli->query("SELECT avg(score) as avge FROM rating where p_id = '$a'");
                  $row2 = $quert->fetch_assoc();
                  ?>
                  <div class="item col-lg-4 ">
                    <div class="thumbnail">
                      <div class="caption" style="height:170px;">
                        <h4 class="list-group-item-heading">
                          <?php echo $row["name"]; ?>
                        </h4>
                        <p class="list-group-item-text" style="padding-bottom:10px">
                          <?php echo $row["description"]; ?>
                        </p>
                        <div class="row">
                          <div class="col-md-6">
                            <p>Rating:
                              <?php
                              if ($row2 != null) {
                                echo round($row2["avge"], 2);
                              } else {
                                echo "NA";
                              }
                              ?>
                            </p>
                            <p class="lead">
                              <?php echo 'Rs. ' . $row["price"]; ?>
                            </p>
                          </div>
                          <div class="col-md-6">
                            <a class="btn btn-success" href="a.php?id=<?php echo $a; ?>">Update</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }
              } else { ?>
                <p>Product(s) not found.....</p>
              <?php }
          } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function getChange() {
      document.getElementById('menu6').style.display = "none";
    }

    function displaybox() {
      mainTable.style.display = "block";
    }
  </script>
</body>

</html>