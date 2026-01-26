<?php 
  if(session_status() === PHP_SESSION_NONE){
    session_start();
  }
  include('admin/config/db_connect.php');
  $result = array();

  if(isset($_POST['type']) && $_POST['type'] == 'reset'){
    $Member_ID = htmlspecialchars($_POST['Member_ID']);
    $password = htmlspecialchars($_POST['password']);
    $result = array();

    $sql =  $conn->prepare("SELECT mem_id,password FROM idea_member WHERE mem_id=?");
    $sql->bind_param("i",$Member_ID);
    $sql->execute();
    $memb = $sql->get_result();
    $member = $memb->fetch_object();
    // 
    if(!isset($member->mem_id)){
      $result['success'] = 'failed';
      $result['message'] = 'Wrong Details';
    } else{
      if($member->password == '@@@aimonomie&&&&&'){
        $sql =  $conn->prepare("UPDATE idea_member SET password=? WHERE mem_id=?");
        $sql->bind_param("si",$password,$Member_ID);
        $sql->execute();
        $result['message'] = 'Password Reset Successfully';
        $result['link'] = 'memberLogin.php';  
        $result['success'] = 'successful';  
      } else {
        $result['message'] = 'You cannot reset password';
        $result['success'] = 'failed'; 
      }                   
    }
    echo json_encode($result);
  }



?>