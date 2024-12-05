<?php

session_start();

include "../Database/db_connection.php";
include "../jwt_helper.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $category = $_POST['category'];
    $nominee = $_POST['nominee'];
    $emp_id = $_POST['emp_id'];
    $comment = $_POST['comment'];

    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO votes (category, nominee, voter, comment) VALUES (:category, :nominee, :voter, :comment)");
    $stmt->bindValue(':category', $category);
    $stmt->bindValue(':nominee', $nominee);
    $stmt->bindValue(':voter', $emp_id);
    $stmt->bindValue(':comment', $comment);

    $stmt->execute();

    header("Location: ../../home.php");
    exit();
}else{
    echo "Error voting";
}

?>
