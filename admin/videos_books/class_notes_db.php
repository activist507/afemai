<?php 
include('../../admin/config/db_connect.php');
    $result = array();

    //submitting book 
    if(isset($_POST['type']) && $_POST['type'] == 'submitNotes'){

      //--------------------//
      $auto_notes_id = $_POST['notes_id'];
      $subject = $_POST['subject'];
      $topic = $_POST['topic'];
      $_class = $_POST['_class'];
      $term = $_POST['term'];
      $week_ = $_POST['week_'];


      // ------------------creating digit for code --------------------------//
      $notes = $conn->query("SELECT note_id FROM notes ORDER BY id DESC LIMIT 1");
      if($notes->num_rows > 0){
        $last_note = $notes->fetch_object();
        $lastID = $last_note->note_id;
        $digi = substr($lastID, 2, 3);
        $digit = (int)$digi + 1;
        $notes_id = 'N-'.$digit;
      } else {
        $notes_id = 'N-101';
      }

      if($auto_notes_id == ''){
        $db_notes_id = $notes_id;
      } else {
        $db_notes_id = $auto_notes_id;
      }

        // ------------------Uploading video to folder --------------------------//
        if(isset($_FILES['file'])){
            $file = $_FILES['file'];
            $note = $file["name"];
            $tempname = $file["tmp_name"];
            $ext = substr($note, strrpos($note, '.', -1), strlen($note));
            $nam = $db_notes_id.'-'.$subject.'-'.$_class.$ext;
            // $nam = $db_notes_id.'-'.$topic.'-'.$subject.'-'.$_class.$ext;
            // $fornow = "class_notes/".$nam;
            $folder = "../../storege/class_notes/".$nam;
            move_uploaded_file($tempname, $folder);   
        }
      
      if($auto_notes_id == ''){
        $sqlins = $conn->query("INSERT INTO notes SET note_id='$notes_id',week='$week_',topic='$topic',subject='$subject',class='$_class',term='$term',note_pdf='$nam'");
        $msg = 'Note uploaded successfully';
      } else {
        if(!empty($tempname)){
           $sqlins = $conn->query("UPDATE notes SET topic='$topic',week='$week_',subject='$subject',class='$_class',term='$term',note_pdf='$nam' WHERE note_id='$auto_notes_id'");
            $msg = 'Note updated successfully';
        } else {
          $sqlins = $conn->query("UPDATE notes SET  topic='$topic',week='$week_',subject='$subject',class='$_class',term='$term' WHERE note_id='$auto_notes_id'");
          $msg = 'Note updated successfully 2';
        }
        
      }

      $result['msg'] = $msg;
      echo json_encode($result);
    }


    //getting book to view
    if(isset($_POST['type']) && $_POST['type'] == 'getNotes'){

        $notes_id = $_POST['note_id'];
        $notes = $conn->query("SELECT * FROM notes WHERE id ='$notes_id'");
        $note = $notes->fetch_object();

        $result['notes_id'] = $note->note_id;
        $result['topic'] = $note->topic;
        $result['subject'] = $note->subject;
        $result['class'] = $note->class;
        $result['term'] = $note->term;
        $result['week'] = $note->week;
        $result['pdf_path'] = "../storege/class_notes/".$note->note_pdf;

        echo json_encode($result);
    }

    //deleting book 
    if(isset($_POST['type']) && $_POST['type'] == 'delete_book'){

        $notes_id = $_POST['note_id'];
        $notes = $conn->query("SELECT * FROM notes WHERE id ='$notes_id'");
        $note = $notes->fetch_object();

        $file = '../../storege/class_notes/'.$note->note_pdf;
        if(file_exists($file)){
            if(unlink($file)){
                clearstatcache();
                $sql = $conn->query("DELETE FROM notes WHERE id = '$notes_id'");
                $result['msg'] = $file.' Deleted Successfully.';
                $result['status'] = 'success';
            }
        } else{
            $result['msg'] = 'There is no file in the database with the name ' . $file;
            $result['status'] = 'failed';
        }

        echo json_encode($result);
    }
?>