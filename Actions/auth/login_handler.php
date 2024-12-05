<?php

session_start();

include "../../Database/db_connection.php";
include "../../jwt_helper.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $db = connectDatabase();

    $stmt = $db->prepare("SELECT * FROM employees WHERE username = :username");
    $stmt->bindValue(":username", $username);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $token = createJWT($user["id"], $username);

        session_regenerate_id(true);

        $_SESSION['jwt'] = $token;
        $_SESSION['emp_id'] = $user['id'];


        header("Location: ../../home.php");
        exit();
    }else{
        echo "The username or password is incorrect";
        echo "<a href='../../Pages/auth/login.php'>Try again</a>";
    }
}

?>