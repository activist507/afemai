<?php 
    // unset($_SESSION['std_id']);
    unset($_SESSION['authentication']);
    session_destroy();
    echo "<script>
    window.location = '../';
    </script>";



?>