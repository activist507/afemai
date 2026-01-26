<?php 
// <!-- Database connection -->
    define ('DB_HOST', 'localhost');
    define ('DB_USER', 'hiracoll_root');
    define ('DB_PASS', 'Bestwap012##$');
    define ('DB_NAME', 'hiracoll_school_db');

    $conn = new MYSQLi(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if($conn->connect_errno)
    {
        printf("Connection Failed:%s\n", $conn->connect_error);
        exit();
    }
    mysqli_set_charset($conn, "utf8mb4");
?>