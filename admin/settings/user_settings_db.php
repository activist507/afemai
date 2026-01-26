<?php 
include('../../admin/config/db_connect.php');
$result = array();




//updating role
if(isset($_POST['type']) && $_POST['type'] == 'UpdateRole'){
    $role_id = $_POST['role_id'];
    $col_name = $_POST['col_name'];
    $newCond = $_POST['newCond'];

    $sql = $conn->query("UPDATE cbt_user_permit SET {$col_name} = '$newCond' WHERE id = '$role_id'");
    if($sql){
        $result['status'] = 1;
    } else {
        $result['status'] = 0;
    }
    echo json_encode($result);
}

?>