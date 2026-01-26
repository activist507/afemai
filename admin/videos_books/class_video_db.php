<?php 
include('../../admin/config/db_connect.php');
    $result = array();

    //submitting video 
    if(isset($_POST['type']) && $_POST['type'] == 'submitVideo'){

      //--------------------//
      $auto_video_ID = $_POST['video_ID'];
      $subject = $_POST['subject'];
      $topic = $_POST['topic'];
      $_class = $_POST['_class'];
      $term = $_POST['term'];


      // ------------------creating digit for code ----------------class ASC------id DESC----//
      $video_play_backs = $conn->query("SELECT vid_id FROM video_play_backs ORDER BY id DESC LIMIT 1");
      if($video_play_backs->num_rows > 0){
        $last_video = $video_play_backs->fetch_object();
        $lastID = $last_video->vid_id;
        $digi = substr($lastID, 2, 3);
        $digit = (int)$digi + 1;
        $video_ID = 'V-'.$digit;
      } else {
        $video_ID = 'V-101';
      }

      if($auto_video_ID == ''){
        $db_vid_id = $video_ID;
      } else {
        $db_vid_id = $auto_video_ID;
      }

        // ------------------Uploading video to folder --------------------------//
        if(isset($_FILES['file'])){
            $file = $_FILES['file'];
            $video = $file["name"];
            $tempname = $file["tmp_name"];
            $ext = substr($video, strrpos($video, '.', -1), strlen($video));
            $nam = $db_vid_id.'-'.$subject.'-'.$_class.$ext;
            // $nam = $db_vid_id.'-'.$topic.'-'.$subject.'-'.$_class.$ext;
            // $fornow = "class_videos/".$nam;
            $folder = "../../storege/class_videos/".$nam;
            move_uploaded_file($tempname, $folder);   
        }
      
      if($auto_video_ID == ''){
        $sqlins = $conn->query("INSERT INTO video_play_backs SET vid_id='$video_ID',topic='$topic',subject='$subject',class='$_class',term='$term',file_path='$nam'");
        $msg = 'Video uploaded successfully';
      } else {
        if(!empty($tempname)){
           $sqlins = $conn->query("UPDATE video_play_backs SET topic='$topic',subject='$subject',class='$_class',term='$term',file_path='$nam' WHERE vid_id='$auto_video_ID'");
            $msg = 'Video updated successfully';
        } else {
          $sqlins = $conn->query("UPDATE video_play_backs SET  topic='$topic',subject='$subject',class='$_class',term='$term' WHERE vid_id='$auto_video_ID'");
          $msg = 'Video updated successfully 2';
        }
        
      }

      $result['msg'] = $msg;
      echo json_encode($result);
    }


    //getting video to watch
    if(isset($_POST['type']) && $_POST['type'] == 'getVideo'){

        $video_ID = $_POST['video_id'];
        $video_play_backs = $conn->query("SELECT * FROM video_play_backs WHERE id ='$video_ID'");
        $video = $video_play_backs->fetch_object();

        $result['vid_id'] = $video->vid_id;
        $result['topic'] = $video->topic;
        $result['subject'] = $video->subject;
        $result['class'] = $video->class;
        $result['term'] = $video->term;
        $result['video_path'] = "../storege/class_videos/".$video->file_path;

        echo json_encode($result);
    }

    //deleting video  
    if(isset($_POST['type']) && $_POST['type'] == 'delete_vid'){

        $video_ID = $_POST['video_id'];
        $video_play_backs = $conn->query("SELECT * FROM video_play_backs WHERE id ='$video_ID'");
        $video = $video_play_backs->fetch_object();

        $file = '../../storege/class_videos/'.$video->file_path;
        if(file_exists($file)){
            if(unlink($file)){
                clearstatcache();
                $sql = $conn->query("DELETE FROM video_play_backs WHERE id = '$video_ID'");
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