<?php 
include('../../admin/config/db_connect.php');
$result = array();



    //updating setup table(for bulletin)
    if(isset($_POST['type']) && $_POST['type'] == 'updateCalendar'){
      $calendar_id = $_POST['calendar_id'];
      $calendar_title = $_POST['calendar_title'];
      $status_ = $_POST['status_'];
      $calendar_date = $_POST['calendar_date'];
      function random($length){
        $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str),0,$length);
      }
      $imageReal = random(10);

      /////<!--------- pdf bulletin-----------!>/////////////
      if(isset($_FILES['file'])){
        $file = $_FILES['file'];
        $pdf = $file["name"];
        $tempname = $file["tmp_name"];
        $ext = substr($pdf, strrpos($pdf, '.', -1), strlen($pdf));
        $finalName = $imageReal.$ext;
        $folder = "../../storege/setup_pdf/".$finalName;
        move_uploaded_file($tempname, $folder);   
      }
      /////<!--------- -----------!>/////////////

      if($calendar_id == 0){
        if(isset($_FILES['file'])){
          $sqlins = $conn->query("INSERT INTO cbt_calendar SET title='$calendar_title',status='$status_',date='$calendar_date',homepage_pdf='$finalName'");
        } 
        else {
          $sqlins = $conn->query("INSERT INTO cbt_calendar SET title='$calendar_title',status='$status_',date='$calendar_date'");
        }
      } else {
        if(isset($_FILES['file'])){
          $sqlins = $conn->query("UPDATE cbt_calendar SET title='$calendar_title',status='$status_',date='$calendar_date',homepage_pdf='$finalName' WHERE id='$calendar_id'");
        }
        else{
          $sqlins = $conn->query("UPDATE cbt_calendar SET title='$calendar_title',status='$status_',date='$calendar_date' WHERE id='$calendar_id'");
        }
      }

      if($sqlins){
        $result['msg'] = 'Calendar Saved Successfully';
      } else {
        $result['msg'] = 'An error was encountered';
      }
      
      echo json_encode($result);
    }



?>