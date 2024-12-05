<?php

include './database/db_connection.php';

$db = connectDatabase();

$query = "CREATE TABLE IF NOT EXISTS votes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category TEXT NOT NULL,
        nominee TEXT NOT NULL,
        voter INTEGER NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        comment TEXT NOT NULL
    )";

$db->exec($query);
$db->close();
?>