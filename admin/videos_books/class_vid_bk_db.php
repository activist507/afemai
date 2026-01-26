<?php 
include('../../admin/config/db_connect.php');
    $result = array();

    //submitting book 
    if(isset($_POST['type']) && $_POST['type'] == 'SubmitVidBk'){

      //--------------------//
      $auto_vid_bk_id = $_POST['vid_bk_id'];
      $subject = $_POST['subject'];
      $topic = $_POST['topic'];
      $_class = $_POST['_class'];
      $term = $_POST['term'];
      $week_ = $_POST['week_'];


      // ------------------creating digit for code -----------class ASC---------id DESC------//
      $video_book = $conn->query("SELECT vid_bk_id FROM video_book ORDER BY id DESC LIMIT 1");
      if($video_book->num_rows > 0){
        $last_note = $video_book->fetch_object();
        $lastID = $last_note->vid_bk_id;
        $digi = substr($lastID, 2, 3);
        $digit = (int)$digi + 1;
        // $vid_bk_id = 'VB-101'.$digit;
        $vid_bk_id = '10'.$digit;
      } else {
        // $vid_bk_id = 'VB-101';
        $vid_bk_id = '101';
      }

      if($auto_vid_bk_id == ''){
        $db_vid_bk_id = $vid_bk_id;
      } else {
        $db_vid_bk_id = $auto_vid_bk_id;
      }

        // ------------------Uploading Book to folder --------------------------//
        if(isset($_FILES['book'])){
          $file = $_FILES['book'];
          $note = $file["name"];
          $tempname = $file["tmp_name"];
          $ext = substr($note, strrpos($note, '.', -1), strlen($note));
          $nam_book = $subject.'-'.$topic.'-'.$_class.$ext;
          $folder = "../../storege/class_video_book/".$nam_book;
          move_uploaded_file($tempname, $folder);   
        }
      
      if($auto_vid_bk_id == ''){
        $sqlins = $conn->query("INSERT INTO video_book SET vid_bk_id='$db_vid_bk_id',week='$week_',topic='$topic',subject='$subject',class='$_class',term='$term',book_path='$nam_book'");
        $msg = 'Book uploaded successfully';
      } else {
        if(!empty($tempname)){
          $sqlins = $conn->query("UPDATE video_book SET topic='$topic',week='$week_',subject='$subject',class='$_class',term='$term',book_path='$nam_book' WHERE vid_bk_id='$auto_vid_bk_id'");
          $msg = ' Book File with other details updated successfully';
        }
        else {
          $sqlins = $conn->query("UPDATE video_book SET  topic='$topic',week='$week_',subject='$subject',class='$_class',term='$term' WHERE vid_bk_id='$auto_vid_bk_id'");
          $msg = 'Details of book and video updated successfully ';
        }
      }
      $result['msg'] = $msg;
      echo json_encode($result);
    }

    //submitting video 
    if(isset($_POST['type']) && $_POST['type'] == 'SubmitVidBk2'){

      //--------------------//
      $auto_vid_bk_id = $_POST['vid_bk_id'];
      $subject = $_POST['subject'];
      $topic = $_POST['topic'];
      $_class = $_POST['_class'];
      $term = $_POST['term'];
      $week_ = $_POST['week_'];


      // ------------------creating digit for code --------------------------//
      $video_book = $conn->query("SELECT vid_bk_id FROM video_book ORDER BY id DESC LIMIT 1");
      if($video_book->num_rows > 0){
        $last_note = $video_book->fetch_object();
        $lastID = $last_note->vid_bk_id;
        $digi = substr($lastID, 2, 3);
        $digit = (int)$digi + 1;
        $vid_bk_id = '10'.$digit;
      } else {
        $vid_bk_id = '101';
      }

      if($auto_vid_bk_id == ''){
        $db_vid_bk_id = $vid_bk_id;
      } else {
        $db_vid_bk_id = $auto_vid_bk_id;
      }
      // ------------------Uploading video to folder --------------------------//
      if(isset($_FILES['video'])){
        $file = $_FILES['video'];
        $note = $file["name"];
        $tempname1 = $file["tmp_name"];
        $ext = substr($note, strrpos($note, '.', -1), strlen($note));
        $nam_video = $subject.'-'.$topic.'-'.$_class.$ext;
        $folder = "../../storege/class_video_book/".$nam_video;
        move_uploaded_file($tempname1, $folder);   
      }
      
      if($auto_vid_bk_id == ''){
        $sqlins = $conn->query("INSERT INTO video_book SET vid_bk_id='$db_vid_bk_id',week='$week_',topic='$topic',subject='$subject',class='$_class',term='$term',video_path='$nam_video'");
        $msg = 'Video uploaded successfully';
      } else {
        if(!empty($tempname1)){
          $sqlins = $conn->query("UPDATE video_book SET topic='$topic',week='$week_',subject='$subject',class='$_class',term='$term',video_path='$nam_video' WHERE vid_bk_id='$auto_vid_bk_id'");
          $msg = ' Video File with other details updated successfully';
        }
        else {
          $sqlins = $conn->query("UPDATE video_book SET topic='$topic',week='$week_',subject='$subject',class='$_class',term='$term' WHERE vid_bk_id='$auto_vid_bk_id'");
          $msg = 'Details of video updated successfully ';
        }
      }
      $result['msg'] = $msg;
      echo json_encode($result);
    }


    //getting book to view
    if(isset($_POST['type']) && $_POST['type'] == 'get_video_book'){

        $video_book_id = $_POST['video_book_id'];
        $video_book = $conn->query("SELECT * FROM video_book WHERE id ='$video_book_id'");
        $vid_bk = $video_book->fetch_object();

        $result['video_book_id'] = $vid_bk->vid_bk_id;
        $result['topic'] = $vid_bk->topic;
        $result['subject'] = $vid_bk->subject;
        $result['class'] = $vid_bk->class;
        $result['term'] = $vid_bk->term;
        $result['week'] = $vid_bk->week;
        $result['pdf_path'] = "../storege/class_video_book/".$vid_bk->book_path;
        $result['video_path'] = "../storege/class_video_book/".$vid_bk->video_path;

        echo json_encode($result);
    }

    //deleting book 
    if(isset($_POST['type']) && $_POST['type'] == 'delete_vid_book'){
      $vid_book_id = $_POST['vid_book_id'];
      $video_book = $conn->query("SELECT * FROM video_book WHERE id ='$vid_book_id'");
      $vb = $video_book->fetch_object();

      $file = '../../storege/class_video_book/'.$vb->book_path;
      if(file_exists($file)){
        if(unlink($file)){
          clearstatcache();
          $sql = $conn->query("DELETE FROM video_book WHERE id = '$vid_book_id'");
          $result['msg'] = $file.' and Deleted Successfully.';
          $result['status'] = 'success';
        }
      } else{
        $sql = $conn->query("DELETE FROM video_book WHERE id = '$vid_book_id'");
        $result['msg'] = $file.' and Deleted Successfully.';
        $result['status'] = 'success';
      }

      echo json_encode($result);
    }

    //deleting video 
    if(isset($_POST['type']) && $_POST['type'] == 'delete_vid_book2'){
      $vid_book_id = $_POST['vid_book_id'];
      $video_book = $conn->query("SELECT * FROM video_book WHERE id ='$vid_book_id'");
      $vb = $video_book->fetch_object();

      $file2 = '../../storege/class_video_book/'.$vb->video_path;
      if(file_exists($file2)){
        if(unlink($file2)){
          clearstatcache();
          $sql = $conn->query("DELETE FROM video_book WHERE id = '$vid_book_id'");
          $result['msg'] = $file2.' Deleted Successfully.';
          $result['status'] = 'success';
        }
      } else{
        $sql = $conn->query("DELETE FROM video_book WHERE id = '$vid_book_id'");
        $result['msg'] = $file2.' Deleted Successfully.';
        $result['status'] = 'success';
      }

      echo json_encode($result);
    }
?>