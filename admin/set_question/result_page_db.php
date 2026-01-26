<?php 
include('../../admin/config/db_connect.php');
$result = array();



// dynamic_ans_entry   
if(isset($_POST['type']) && $_POST['type'] == 'dynamic_ans_entry'){
    $html = '';
    $exam_id = $_POST['exam_id'];
    $subject = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id' LIMIT 1")->fetch_assoc();
    $answers = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id' ORDER BY name ASC");
    while($ans = $answers->fetch_object()){
      $html .= ' <tr class="rem">
      
      <td nowrap="nowrap">'.$ans->name.'</td>
      <td nowrap="nowrap">'.$ans->score.'</td>
      </tr>';
    //   <td nowrap="nowrap">'.$ans->student_id.'</td>
    }
    $result['subject'] = $subject['subject'];
    $result['html'] = $html;
    echo json_encode($result);
}

// dynamic_ans_entry   
if(isset($_POST['type']) && $_POST['type'] == 'dynamic_ans_entry2'){
    $html = '';
    $exam_id = $_POST['exam_id'];
    $subject = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id' LIMIT 1")->fetch_assoc();
    $answers = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id' ORDER BY name ASC");
    while($ans = $answers->fetch_object()){
      $html .= ' <tr class="rem">
      
      <td nowrap="nowrap">'.$ans->name.'</td>
      <td nowrap="nowrap">'.$ans->score.'</td>
      </tr>';
    //   <td nowrap="nowrap">'.$ans->student_id.'</td>
    }
    $result['subject'] = $subject['subject'];
    $result['html'] = $html;
    echo json_encode($result);
}

// dynamic_ans_entry   
if(isset($_POST['type']) && $_POST['type'] == 'dynamic_ans_entry3'){
    $html = '';
    $exam_id = $_POST['exam_id'];
    $subject = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id' LIMIT 1")->fetch_assoc();
    $answers = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id' ORDER BY name ASC");
    while($ans = $answers->fetch_object()){
      $html .= ' <tr class="rem">
      
      <td nowrap="nowrap">'.$ans->name.'</td>
      <td nowrap="nowrap">'.$ans->score.'</td>
      </tr>';
    //   <td nowrap="nowrap">'.$ans->student_id.'</td>
    }
    $result['subject'] = $subject['subject'];
    $result['html'] = $html;
    echo json_encode($result);
}

// dynamic_ans_all   
if(isset($_POST['type']) && $_POST['type'] == 'dynamic_ans_all'){
    $exam_id1 = $_POST['exam_id1'];
    $exam_id2 = $_POST['exam_id2'];
    $exam_id3 = $_POST['exam_id3'];
    
    if($exam_id1 != 0){
        $html = '';
        $subject = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id1' LIMIT 1")->fetch_assoc();
        $answers = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id1' ORDER BY name ASC");
        while($ans = $answers->fetch_object()){
        $html .= ' <tr class="rem">
        <td nowrap="nowrap">'.$ans->name.'</td>
        <td nowrap="nowrap">'.$ans->score.'</td>
        </tr>';
        }
        $result['subject1'] = $subject['subject'];
        $result['html1'] = $html;
    } else {
        $result['subject1'] = '';
        $result['html1'] = '';
    }

    if($exam_id2 != 0){
        $html2 = '';
        $subject = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id2' LIMIT 1")->fetch_assoc();
        $answers = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id2' ORDER BY name ASC");
        while($ans = $answers->fetch_object()){
        $html2 .= ' <tr class="rem">
        <td nowrap="nowrap">'.$ans->name.'</td>
        <td nowrap="nowrap">'.$ans->score.'</td>
        </tr>';
        }
        $result['subject2'] = $subject['subject'];
        $result['html2'] = $html2;
    } else {
        $result['subject2'] = '';
        $result['html2'] = '';
    }

    if($exam_id3 != 0){
        $html3 = '';
        $subject = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id3' LIMIT 1")->fetch_assoc();
        $answers = $conn->query("SELECT * FROM answers WHERE exam_id='$exam_id3' ORDER BY name ASC");
        while($ans = $answers->fetch_object()){
        $html3 .= ' <tr class="rem">
        <td nowrap="nowrap">'.$ans->name.'</td>
        <td nowrap="nowrap">'.$ans->score.'</td>
        </tr>';
        }
        $result['subject3'] = $subject['subject'];
        $result['html3'] = $html3;
    } else {
        $result['subject3'] = '';
        $result['html3'] = '';
    }
    echo json_encode($result);
}


?>