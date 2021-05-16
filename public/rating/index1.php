<?php
$mytime = getdate(date("U"));
$date = "$mytime[weekday], $mytime[month], $mytime[mday], $mytime[year]";

require_once "db.inc.php";
$sql = $conn->query("SELECT id FROM rate");
$numR = $sql->num_rows;

$sql = $conn->query("SELECT SUM(userReview) AS total FROM rate");
$data = $sql->fetch_array();
$total = $data["total"];

$avg = '';
if ($numR  != 0) {
    if (is_nan(round(($total / $numR), 1))) {
        $avg = 0;
    } else {
        $avg = round(($total / $numR), 1);
    }
} else {
    $avg = 0;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script src="jquery/jquery.js"></script>
    <script src="main.js"></script>
    

</head>

<body>
    <div class="container">
        <div class="rating-review">
            <div class="tri table-flex">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <div class="rnb rvl">
                                    <h3> <?php echo $avg; ?>/5.0</h3>
                                </div>
                                <div class="pdt-rate">
                                    <div class="pro-rating">
                                        <div class="clearfix rating mart8">
                                            <div class="rating-stars">
                                                <div class="grey-stars">
                                                </div>
                                                <div class="filled-stars" style="width:<?php echo $avg * 20; ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rnrn">
                                    <p class="rars"><?php if ($numR == 0) {
                                                        echo "No";
                                                    } else {
                                                        echo $numR;
                                                    } ?> Reviews</p>
                                </div>
                            </td>
                            <td>
                                <div class="rpb">
                                    <div class="rnpb">
                                        <label>5 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:20%">
                                            </div>
                                        </div>
                                        <div class="label"> (1)</div>
                                    </div>
                                    <div class="rnpb">
                                        <label>4 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:50%"> </div>
                                        </div>
                                        <div class="label"> (1)</div>
                                    </div>
                                    <div class="rnpb">
                                        <label>3 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:80%"> </div>
                                        </div>
                                        <div class="label"> (15)</div>
                                    </div>
                                    <div class="rnpb">
                                        <label>2<i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:30%"> </div>
                                        </div>
                                        <div class="label"> (11)</div>
                                    </div>
                                    <div class="rnpb">
                                        <label>1 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:40%"> </div>
                                        </div>
                                        <div class="label"> (13)</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="rrb">
                                    <p>Please review our Product</p>
                                    <button class="rbtn opmd">Add Reviews</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="review-modal" style="display:none">
                    <div class="review-bg">
                    </div>
                    <div class="rmp">
                        <div class="rpc">
                            <span><i class="fas fa-times"></i></span>
                        </div>
                        <div class="rps" align="center">
                            <i class="fa fa-star" data-index="0" style="display:none"></i>
                            <i class="fa fa-star" data-index="1"></i>
                            <i class="fa fa-star" data-index="2"></i>
                            <i class="fa fa-star" data-index="3"></i>
                            <i class="fa fa-star" data-index="4"></i>
                            <i class="fa fa-star" data-index="5"></i>
                        </div>
                        <input type="hidden" value="" class="starRateV">
                        <input type="hidden" value="<?php echo $date ?>" class="rateDate">
                        <div class="rptf" align="center">
                            <input type="text" class="raterName" placeholder="Enter Your name ...">
                        </div>
                        <div class="rptf" align="center">
                            <textarea class="rateMsg" id="rate-field" placeholder="Describe your Expecrirnce"></textarea>
                        </div>
                        <div class="rate-error" align="center"></div>
                        <div class="rpsb" align="center">
                            <button class="rpbtn">Post Reviews</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="bri">
                <div class="uscm">
                    <?php 
                        $sqlp = "SELECT * FROM rate";
                        $result = $conn->query($sqlp);
                        if(mysqli_num_rows($result)>0){
                            while($row=$result->fetch_assoc()){

                           
                    ?>
                    <div class="uscm-secs">
                        <div class="us-img">
                            <p> <?= substr($row['userName'],0,1) ?> </p>
                        </div>
                        <div class="uscms">
                            <div class="us-rate">
                                <div class="pdt-rate">
                                    <div class="pro-rating">
                                        <div class="clearfix rating mart8">
                                            <div class="rating-stars">
                                                <div class="grey-stars">
                                                </div>
                                                <div class="filled-stars" style="width:<?= $row['userReview']*20 ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="us-cmt">
                                    <p><?= $row['userMessage']?></p>
                                </div>
                                <div class="us-nm">
                                    <p><i>By <span class="cmnm"><?= $row['userName']?></span> on <span class="cmdt"><?= $row['dateReviewed']?></span> </i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                     }
                    } ?>
                </div>
            </div>
        </div>


    </div>

</body>

</html>