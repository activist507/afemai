<?php 
include('../../admin/config/db_connect.php');
$result = array();

if(isset($_POST['type']) && $_POST['type'] == 'showTable'){
  $html = '';
  $branch = $_POST['branch_']; 
  $array = explode('~',$_POST['class_']); 
  $class = $array[0];
  $section = $array[1];
  $table = $_POST['term']; 
  $session = $_POST['session']; 
  $scoreArray = [];
  $subjectArray = [];
  if($section == 'Senior Sec'){
    for($i=1; $i < 20;$i++){
      $column ='Se'.$i;
      $scoreColumn ='To'.$i;
      $row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
      $subject = $row->{$column};
      $subjectArray[] = $subject;
      $scoreColumnArray[] = $scoreColumn; 
    }
  } 
  elseif($section == 'Junior Sec'){
    for($i=1; $i < 20;$i++){
      $column ='Je'.$i;
      $scoreColumn ='To'.$i;
      $row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
      $subject = $row->{$column};
      $subjectArray[] = $subject;
      $scoreColumnArray[] = $scoreColumn;;
    }
  } elseif($section == 'Nursery'){
    for($i=1; $i < 12;$i++){
      $column ='Ne'.$i;
      $scoreColumn ='To'.$i;
      $row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
      $subject = $row->{$column};
      $subjectArray[] = $subject;
      $scoreColumnArray[] = $scoreColumn;;
    }
  } else {
    if($class == 'Pry4' || $class == 'Pry5'){
      for($i=1; $i < 16;$i++){
        $column ='Ue'.$i;
        $scoreColumn ='To'.$i;
        $row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
        $subject = $row->{$column};
        $subjectArray[] = $subject;
        $scoreColumnArray[] = $scoreColumn;;
      }
    } else {
      for($i=1; $i < 14;$i++){
        $column ='Le'.$i;
        $scoreColumn ='To'.$i;
        $row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
        $subject = $row->{$column};
        $subjectArray[] = $subject;
        $scoreColumnArray[] = $scoreColumn;;
      }
    }
  }

  $studentList = $conn->query("SELECT Student_ID,Fullname	FROM {$table} WHERE Class='$class' AND Branch='$branch' AND C_Session='$session'")->fetch_all(MYSQLI_ASSOC);

  $html .= '<table class="table small table-bordered table-striped">
              <thead>
              <tr><th scope="col" class="text-nowrap">ID</th>
              <th scope="col" class="text-nowrap">Name</th>';
  $i=1;
  foreach($subjectArray as $subject){
    $html .= '<th scope="col" class="text-nowrap" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$subject.'">Sub'.$i.'</th>';
    $i++;
  }
  $html .= '</tr></thead><tbody>';
  foreach($studentList as $student){
    $id = $student['Student_ID'];
    $name = $student['Fullname'];
    $html .= '<tr data-bs-toggle="tooltip" data-bs-placement="top" title="'.$name.'"><td>'.$id.'</td><td class="text-nowrap">'.$name.'</td>';
    $columns = implode(',', $scoreColumnArray);
    $query = "SELECT $columns FROM {$table} WHERE Student_ID='$id' AND Class='$class' AND Branch='$branch' AND C_Session='$session'";
    $studScore = $conn->query($query)->fetch_object();
    foreach($scoreColumnArray as $column){
      $html .= '<td class="text-center">'.$studScore->$column.'</td>';
    }
    $html .= '</tr>';
  }
  
  $result['html'] = $html;
  echo json_encode($result);
}

?>