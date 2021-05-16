<?php

require_once "db.inc.php";
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$POSTI = filter_var_array($_POST, FILTER_SANITIZE_NUMBER_INT);




if (isset($_POST['starRate'])) {
    
    $starRate = mysqli_real_escape_string($conn, $POSTI['starRate']);
    $rateMsg  = mysqli_real_escape_string($conn, $POST['rateMsg']);
    $date     = mysqli_real_escape_string($conn, $POST['date']);
    $name     = mysqli_real_escape_string($conn, $POST['name']);
    $moto_id     = mysqli_real_escape_string($conn, $POST['moto_id']);
    
    
    $sql = $conn->prepare("SELECT * FROM rate WHERE userName=?");
    
    $sql->bind_param("s", $name);
    $sql->execute();
    $res = $sql->get_result();
    $rst = $res->fetch_assoc();
    $val = $rst["userName"];
    
    // if (!$val) {    
        // $stmt = $conn->prepare("INSERT INTO  rate  (`userName`, `userReview`, `userMessage`, `dateReviewed`) VALUES (?, ?, ?, ?)");
        // $stmt->bind_param("ssss", $name, $starRate, $rateMsg, $date);
        // $stmt->execute();
        
        $query[]=("SET NAMES 'utf8'");
        $query[]=("SET CHARACTER SET 'utf8'");
        $query= implode($query);
        mysqli_query($conn, $query);
        
        mysqli_query($conn,"INSERT INTO  rate  (`userName`, `userReview`, `userMessage`, `dateReviewed`,`moto_id`) VALUES ('$name', '$starRate', '$rateMsg', '$date','$moto_id')");
        echo "Inserted Successfully";
       
    // } else {
        
       
    //     // $stmt = $conn->prepare("UPDATE rate SET userName=?, userReview=?, userMessage=?, dateReviewed=? WHERE userName=?" );
    //     // $stmt->bind_param("sssss",$name,  $starRate, $rateMsg, $date, $name);
    //     // $stmt->execute();

    //     $query[]=("SET NAMES 'utf8'");
    //     $query[]=("SET CHARACTER SET 'utf8'");
    //     $query= implode($query);
    //     mysqli_query($conn, $query);
    //     mysqli_query($conn,"UPDATE `rate` SET `userName`='$name',`userReview`='$starRate',`userMessage`='$rateMsg',`dateReviewed`='$date' WHERE `userName`= '$name'");
    //     echo "Update Successfully";
    // }
}
