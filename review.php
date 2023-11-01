<?php

include 'db.php';
// if (!isset($_REQUEST['id'])) {
//   header("Location: home.php");
// }

$myID = $_GET['id'];
// echo $myID;



$query = $mysqli->query("SELECT * FROM products WHERE id IN
  (
    SELECT product_id FROM order_items where order_id = '$myID'
  )");



$query2 = $mysqli->query("SELECT * FROM orders where id = '$myID'");

if ($query2->num_rows > 0) {
  while ($row = $query2->fetch_assoc()) {
    // echo $row['customer_id'];
  }
}
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
      <h1>Order Review</h1>
      <p>Order ID #<?php echo $_GET['id']; ?> has been delivered.</p>
      <p>Please give a review for your experience.</p>
      <p>You had ordered: </p>
      <form method="post" action="">
      
      <?php
      
      if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
          echo $row['name'], $row['id'];
          ?><br><textarea rows="5" cols="150" name="review-text-<?php echo $row['id']; ?>" >
                </textarea>
                <br>
                <br>
          <?php
                $s1 = 'review-text-';
                $s2 = $row['id'];
                $res = $s1 . $s2;
                if(isset($_POST[$res])){
                $paragraph = $_POST[$res];
                
                //echo $paragraph;
                $lines = explode(". ", $paragraph);
                

                $quality = array("quality","Quality","Excellence","Superiority","High standard","Perfection","Merit","Value","Grade","Caliber","Standard","Class","Craftsmanship","Workmanship","Fineness","Precision","Refinement","Sophistication","Polish","Elegance","Professionalism","Expertise", "Skillfulness","Mastery","Competence","Flawlessness","Faultlessness","Pristineness","Immaculateness","Neatness","Cleanliness","excellence", "superiority", "high standard", "perfection", "merit", "value", "grade", "caliber", "standard", "class", "craftsmanship", "workmanship", "fineness", "precision", "refinement", "sophistication", "polish", "elegance", "professionalism", "expertise", "skillfulness", "mastery", "competence", "flawlessness", "faultlessness", "pristineness", "immaculateness", "neatness", "cleanliness");

                $good = array("good","Good","Excellent", "Outstanding", "Exceptional", "Superb", "Great", "Fine", "Wonderful", "Terrific", "Splendid", "Awesome", "excellent", "outstanding", "exceptional", "superb", "great", "fine", "wonderful", "terrific", "splendid", "awesome", "yes", "Yes", "fast", "efficient", "prompt","speedy", "quick", "timely", "affordable", "reasonable", "cheap", "economical", "budget-friendly", "competitive", "attractive");

                $bad = array("Bad","bad","Poor","Terrible","Unacceptable","Inferior","Faulty","Defective","Awful","Lousy","Dismal","Disappointing","poor","terrible","unacceptable","inferior","faulty","defective","awful","lousy","dismal","disappointing", "do not", "No", "no", "slow", "delayed", "poor", "late", "unreliable","terrible", "expensive", "overpriced", "pricey", "costly", "exorbitant", "outrageous", "high-priced", "unaffordable");

                $average = array("average","Average","Mediocre","Ordinary","Run-of-the-mill","Standard","Typical","Fair","Adequate","OK","So-so","Middle-of-the-road","mediocre","ordinary","run-of-the-mill","standard","typical","fair","adequate","ok","so-so","middle-of-the-road", "moderate", "fair", "satisfactory", "adequate","tolerable", "acceptable", "mid-range", "moderate", "fair-priced", "competitively-priced", "typical", "standard", "middle-of-the-road", "neither cheap nor expensive");

                $service = array("service","Service","Assistance", "Support", "Help", "Aid", "Care", "Maintenance", "Repair", "Provision", "Accommodation", "Attention", "assistance", "support", "help", "aid", "care", "maintenance", "repair", "provision", "accommodation", "attention");

                $delivery = array("delivery", "Delivery","Shipping","Fulfillment","Dispatch","Distribution","Transportation","Logistics","Arrival","Reception","Shipment","Conveyance","shipping","fulfillment","dispatch","distribution","transportation","logistics","arrival","reception","shipment","conveyance", "delivered","Delivered","Shipped","Fulfilled","Dispatched","Distributed","Transported","Managed","Arrived","Received","Shipped","Conveyed","shipped","fulfilled","dispatched","distributed","transported","managed","arrived","received","shipped","conveyed");

                $price = array("price","Price","Cost","Expense","Charge","Fee","Rate","Value","Amount","Price tag","Selling price","Market price","Money","cost","expense","charge","fee","rate","value","amount","price tag","selling price","market price", "money");

                $time = array("time","Time","Duration","Length","Span","Period","Timeline","Schedule","Timing","Deadline","Delivery time","Lead time","duration","length","span","period","timeline","schedule","timing","deadline","delivery time","lead time");

                $trust = array("Trust","trust","Confidence","Reliability","Dependability","Credibility","Integrity","Honesty","Authenticity","Reputation","Assurance","Faith","confidence","reliability","dependability", "credibility","honesty","authenticity","reputation","assurance","faith");

                $fear = array("fear","Fear","Apprehension","Worry","Dread","Anxiety","Panic","Nervousness","Unease","Insecurity","Trepidation","Phobia","Apprehension","Worry","Dread","Anxiety","Panic","Nervousness","Unease","Insecurity","Trepidation","Phobia");

                $harmful_chemicals = array("harmful","Harmful","irritation","redness","itching","burning","stinging","allergic reaction","Harsh","Drying","Overpowering scent","breakout","rash","acne","inflammation","sensitivity","discoloration","Not suitable for sensitive skin","Irritation","Redness","Itching","Burning","Stinging","Allergic reaction","harsh","drying","overpowering scent","Breakout","Rash","Acne","Inflammation","Sensitivity","Discoloration","not suitable for sensitive skin");

                $service_index = $delivery_index = $price_index = $time_index = $trust_index = $fear_index = $harmfulchem_index = $quality_index = $score = null;

                //for assigning a point to the service
                foreach ($lines as $words) {
                    foreach($service as $s_word) {
                        if(strpos($words, $s_word) == true) {
                            //for searching if it is a "good" review
                            foreach($good as $g_word) {
                                if(strpos($words, $g_word) == true) {
                                    $service_index = 5;
                                    break;
                                }
                            }
                            //for searching if it is a "average" review
                            foreach($average as $a_word) {
                                if(strpos($words, $a_word) == true) {
                                    $service_index = 3;
                                    break;
                                }
                            }
                            //for searching if it is a "bad" review
                            foreach($bad as $b_word) {
                                if(strpos($words, $b_word) == true) {
                                    $service_index = 1;
                                    break;
                                }
                            }
                        }
                        else {
                            continue;
                        }
                    }
                }

                //for assigning a point to the delivery
                //change the delivery criteria to fast, etc - fixed
                foreach ($lines as $words) {
                    foreach($delivery as $d_word) {
                        if(strpos($words, $d_word) == true) {
                            //for searching if it is a "good" review
                            foreach($good as $g_word) {
                                if(strpos($words, $g_word) == true) {
                                    $delivery_index = 5;
                                    break;
                                }
                            }
                            //for searching if it is a "average" review
                            foreach($average as $a_word) {
                                if(strpos($words, $a_word) == true) {
                                    $delivery_index = 3;
                                    break;
                                }
                            }
                            //for searching if it is a "bad" review
                            foreach($bad as $b_word) {
                                if(strpos($words, $b_word) == true) {
                                    $delivery_index = 1;
                                    break;
                                }
                            }
                        }
                        else {
                            continue;
                        }
                    }
                }

                //for assigning a point to the price
                //change the delivery criteria to affordable, etc - fixed
                foreach ($lines as $words) {
                    foreach($price as $p_word) {
                        if(strpos($words, $p_word) == true) {
                            //for searching if it is a "good" review
                            foreach($good as $g_word) {
                                if(strpos($words, $g_word) == true) {
                                    $price_index = 5;
                                    break;
                                }
                            }
                            //for searching if it is a "average" review
                            foreach($average as $a_word) {
                                if(strpos($words, $a_word) == true) {
                                    $price_index = 3;
                                    break;
                                }
                            }
                            //for searching if it is a "bad" review
                            foreach($bad as $b_word) {
                                if(strpos($words, $b_word) == true) {
                                    $price_index = 1;
                                    break;
                                }
                            }
                        }
                        else {
                            continue;
                        }
                    }
                }

                //for assigning a point to the trust
                foreach ($lines as $words) {
                    foreach($trust as $t_word) {
                        if(strpos($words, $t_word) == true) {
                            //for searching if it is a "good" review
                            foreach($good as $g_word) {
                                if(strpos($words, $g_word) == true) {
                                    $trust_index = 5;
                                    break;
                                }
                            }
                            //for searching if it is a "average" review
                            foreach($average as $a_word) {
                                if(strpos($words, $a_word) == true) {
                                    $trust_index = 3;
                                    break;
                                }
                            }
                            //for searching if it is a "bad" review
                            foreach($bad as $b_word) {
                                if(strpos($words, $b_word) == true) {
                                    $trust_index = 1;
                                    break;
                                }
                            }
                        }
                        else {
                            continue;
                        }
                    }
                }

                //for assigning a point to the fear
                foreach ($lines as $words) {
                    foreach($fear as $f_word) {
                        if(strpos($words, $f_word) == true) {
                            //for searching if it is a "good" review
                            foreach($good as $g_word) {
                                if(strpos($words, $g_word) == true) {
                                    $fear_index = 5;
                                    break;
                                }
                            }
                            //for searching if it is a "average" review
                            foreach($average as $a_word) {
                                if(strpos($words, $a_word) == true) {
                                    $fear_index = 3;
                                    break;
                                }
                            }
                            //for searching if it is a "bad" review
                            foreach($bad as $b_word) {
                                if(strpos($words, $b_word) == true) {
                                    $fear_index = 1;
                                    break;
                                }
                            }
                        }
                        else {
                            continue;
                        }
                    }
                }

                //for assigning a point to the harmful chemicals
                foreach ($lines as $words) {
                    foreach($harmful_chemicals as $hc_word) {
                        if(strpos($words, $hc_word) == true) {
                            $harmfulchem_index = 1;
                        }
                        else {
                            continue;
                        }
                    }
                }

                //for assigning a point to the quality
                foreach ($lines as $words) {
                    foreach($quality as $q_word) {
                        if(strpos($words, $q_word) == true) {
                            //for searching if it is a "good" review
                            foreach($good as $g_word) {
                                if(strpos($words, $g_word) == true) {
                                    $quality_index = 5;
                                    break;
                                }
                            }
                            //for searching if it is a "average" review
                            foreach($average as $a_word) {
                                if(strpos($words, $a_word) == true) {
                                    $quality_index = 3;
                                    break;
                                }
                            }
                            //for searching if it is a "bad" review
                            foreach($bad as $b_word) {
                                if(strpos($words, $b_word) == true) {
                                    $quality_index = 1;
                                    break;
                                }
                            }
                        }
                        else {
                            continue;
                        }
                    }
                }

                // echo "\n\nService Index: ".$service_index;
                // echo "\nDelivery Index: ".$delivery_index;
                // echo "\nPrice Index: ".$price_index;
                // echo "\nTrust Index: ".$trust_index;
                // echo "\nFear Index: ".$fear_index;
                // echo "\nHarmful Chemical Index: ".$harmfulchem_index;
                // echo "\nQuality Index: ".$quality_index;

                $count = 0;
                $index_sum = 0;
                if($service_index != null){
                    $count++;
                    $index_sum += $service_index;
                }
                if($delivery_index != null){
                    $count++;
                    $index_sum += $delivery_index;
                }
                if($price_index != null){
                    $count++;
                    $index_sum += $price_index;
                }
                if($trust_index != null){
                    $count++;
                    $index_sum += $trust_index;
                }
                if($fear_index != null){
                    $count++;
                    $index_sum += $fear_index;
                }
                if($harmfulchem_index != null){
                    $count++;
                    $index_sum += $harmfulchem_index;
                }
                if($quality_index != null){
                    $count++;
                    $index_sum += $quality_index;
                }
                // echo "\nCount: ".$count;
                if($count!=0){
                  $score = $index_sum/$count;
                }
                // echo "\nScore: ".$score;

                $s = $mysqli->query("INSERT INTO rating (p_id, service, delivery, price, trust, fear, harmful_chemicals, quality, score) VALUES ('$s2', '$service_index', '$delivery_index', '$price_index', '$trust_index', '$fear_index', '$harmfulchem_index', '$quality_index', '$score')");
              }
            }            
            }
          ?>
      <br> <br>
      
      <button type="submit" name="submit11" class="btn btn-warning">Submit Review</button>
      <!-- <textarer>
    a rows="5" cols="150" name="review-text" placeholder="Enter Review here...">
      </textarer> -->
      </form>
    </div>
  </div>
</body>
</html>

<?php
 if(isset($_POST['submit11'])){
    header('Location:home.php');
 }
?>