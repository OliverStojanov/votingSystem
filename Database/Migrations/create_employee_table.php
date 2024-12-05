<?php

include './database/db_connection.php';

$db = connectDatabase();

$query = "CREATE TABLE IF NOT EXISTS employees (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        surname TEXT NOT NULL,
        username TEXT NOT NULL,
        password TEXT NOT NULL
    )";

$db->exec($query);
$db->close();
?>