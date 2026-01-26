<?php 
    unset($_SESSION['invCode']);
    unset($_SESSION['authentication']);
    session_destroy();
    echo "<script>
    window.location = '../';
    </script>";



?>