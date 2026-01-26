<?php 
include('../../admin/config/db_connect.php');
    $result = array();

    //submitting book 
    if(isset($_POST['type']) && $_POST['type'] == 'submitBook'){

      //--------------------//
      $auto_book_ID = $_POST['book_ID'];
      $subject = $_POST['subject'];
      $topic = $_POST['topic'];
      $_class = $_POST['_class'];
      $term = $_POST['term'];


      // ------------------creating digit for code --------------------------//
      $books = $conn->query("SELECT book_id FROM books ORDER BY id DESC LIMIT 1");
      if($books->num_rows > 0){
        $last_video = $books->fetch_object();
        $lastID = $last_video->book_id;
        $digi = substr($lastID, 2, 3);
        $digit = (int)$digi + 1;
        $book_ID = 'B-'.$digit;
      } else {
        $book_ID = 'B-101';
      }

      if($auto_book_ID == ''){
        $db_book_id = $book_ID;
      } else {
        $db_book_id = $auto_book_ID;
      }

        // ------------------Uploading video to folder --------------------------//
        if(isset($_FILES['file'])){
            $file = $_FILES['file'];
            $book = $file["name"];
            $tempname = $file["tmp_name"];
            $ext = substr($book, strrpos($book, '.', -1), strlen($book));
            $nam = $db_book_id.'-'.$subject.'-'.$_class.$ext;
            // $nam = $db_book_id.'-'.$topic.'-'.$subject.'-'.$_class.$ext;
            // $fornow = "class_books/".$nam;
            $folder = "../../storege/class_books/".$nam;
            move_uploaded_file($tempname, $folder);   
        }
      
      if($auto_book_ID == ''){
        $sqlins = $conn->query("INSERT INTO books SET book_id='$book_ID',topic='$topic',subject='$subject',class='$_class',term='$term',book_pdf='$nam'");
        $msg = 'Book uploaded successfully';
      } else {
        if(!empty($tempname)){
           $sqlins = $conn->query("UPDATE books SET topic='$topic',subject='$subject',class='$_class',term='$term',book_pdf='$nam' WHERE book_id='$auto_book_ID'");
            $msg = 'Book updated successfully';
        } else {
          $sqlins = $conn->query("UPDATE books SET  topic='$topic',subject='$subject',class='$_class',term='$term' WHERE book_id='$auto_book_ID'");
          $msg = 'Book updated successfully 2';
        }
        
      }

      $result['msg'] = $msg;
      echo json_encode($result);
    }


    //getting book to view
    if(isset($_POST['type']) && $_POST['type'] == 'getBook'){

        $book_ID = $_POST['book_id'];
        $books = $conn->query("SELECT * FROM books WHERE id ='$book_ID'");
        $book = $books->fetch_object();

        $result['book_id'] = $book->book_id;
        $result['topic'] = $book->topic;
        $result['subject'] = $book->subject;
        $result['class'] = $book->class;
        $result['term'] = $book->term;
        $result['pdf_path'] = "../storege/class_books/".$book->book_pdf;

        echo json_encode($result);
    }

    //deleting book 
    if(isset($_POST['type']) && $_POST['type'] == 'delete_book'){

        $book_ID = $_POST['book_id'];
        $books = $conn->query("SELECT * FROM books WHERE id ='$book_ID'");
        $book = $books->fetch_object();

        $file = '../../storege/class_books/'.$book->book_pdf;
        if(file_exists($file)){
          if(unlink($file)){
            clearstatcache();
            $sql = $conn->query("DELETE FROM books WHERE id = '$book_ID'");
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