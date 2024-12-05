<?php
include "../../Database/db_connection.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];

    if(empty($username) || empty($password) || empty($name) || empty($surname)){
        die("Please fill in all the required fields.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $db = connectDatabase();
    $stmt = $db -> prepare("INSERT INTO employees (name, surname, username, password) VALUES (:name, :surname, :username, :password)");
    $stmt -> bindValue(':name', $name);
    $stmt -> bindValue(':surname', $surname);
    $stmt -> bindValue(':username', $username);
    $stmt -> bindValue(':password', $hashed_password);

    $stmt->execute();

    echo "Your account has been created!<a href='../../pages/auth/login.php'>Login here</a>";
}