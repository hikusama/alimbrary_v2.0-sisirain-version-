<?php 


require_once 'config.php';


$tables_sql = file_get_contents("database/login_system_db.sql");

if ($conn->multi_query($tables_sql)) {
    echo "Tables created successfully<br>";
} else {
    echo "Error creating tables: " . $conn->error . "<br>";
}