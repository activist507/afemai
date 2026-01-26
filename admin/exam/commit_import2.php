<?php
include '../config/db_connect.php';
header('Content-Type: text/plain; charset=utf-8');
require __DIR__ . '/vendor/autoload.php';

$payloadRaw = $_POST['payload_json'] ?? '';
$filepath = ($_POST['filepath']);
$exam_id = $_POST['exam_id'] ?? 0;
$class_id = $_POST['class_id'] ?? 0;
$subject_id = $_POST['subject_id'] ?? 0;
$term_id = $_POST['term_id'] ?? 'No Term';
$assessment_type = $_POST['assessment_type'] ?? 'N/A';
$no_of_question = $_POST['no_of_question'] ?? 0;
$alloted_mark = $_POST['alloted_mark'] ?? 0;
$total_mark = $_POST['total_mark'] ?? 0;
$duration = $_POST['duration'] ?? 0;
$examTitle = $_POST['exam_title'] ?? 'Imported Exam';
if (!$payloadRaw) die('No payload');
$payload = json_decode($payloadRaw, true);
if ($payload === null) die('Invalid JSON');

$conn->begin_transaction();
try {
    //delete previous questions
        $oldPath = $conn->query("SELECT filepath FROM exams WHERE id = '$exam_id'")->fetch_assoc()['filepath'] ?? '';
        if($oldPath != ''){
            $qL = fetch_all_assoc($conn->query("SELECT id,question_image FROM questionns WHERE exam_id = '$exam_id'"));
            if(count($qL) > 0){
                foreach($qL as $q){
                    $qst_id = $q['id'];
                    $conn->query("DELETE FROM options WHERE question_id = '$qst_id'");

                    $file = $q['question_image'];
                    if(isset($file) && file_exists($file)){
                        if(unlink($file)){
                        clearstatcache();
                        $conn->query("DELETE FROM questionns WHERE id = '$qst_id'");
                        }
                    } else {
                        $conn->query("DELETE FROM questionns WHERE id = '$qst_id'");
                    } 
                }
            }
            
            if(file_exists($filepath)){
                if(unlink($filepath)){
                    clearstatcache();
                }
            } 
        }
    //end delete
    if($exam_id != 0){
        $stmt = $conn->prepare("UPDATE exams SET title=?,class_id=?,subject_id=?,term_id=?,assessment_type=?,no_of_question=?,alloted_mark=?,total_mark=?,duration=? WHERE id=?");
        $stmt->bind_param('sssssidddi',$examTitle,$class_id,$subject_id,$term_id,$assessment_type,$no_of_question,$alloted_mark,$total_mark,$duration,$exam_id);
        $stmt->execute(); 
        $stmt->close();
        $examId = $exam_id; 

        $qstmt = $conn->prepare("INSERT INTO questionns (exam_id, question_text, question_image, question_order) VALUES (?,?,?,?)");
        $qstmt->bind_param('issi', $examId, $qtext, $qimg, $qorder);
        $ostmt = $conn->prepare("INSERT INTO options (question_id, option_key, option_text, is_correct) VALUES (?,?,?,?)");
        $ostmt->bind_param('issi', $qid, $okey, $otext, $oiscorr);

        foreach ($payload as $i => $qblock) {
            $qtext = $qblock['question'] ?? '';
            $qimg = $qblock['image'] ?? null; 
            if ($qimg === '') $qimg = null;
            $qorder = $i+1;
            $qstmt->execute(); 
            $qid = $conn->insert_id;
            foreach ($qblock['options'] as $opt) {
                $okey = $opt['key'] ?? 'A';
                $otext = $opt['text'] ?? '';
                $oiscorr = isset($opt['correct']) && $opt['correct'] ? 1 : 0;
                $ostmt->execute();
            }
        }
        $qstmt->close(); 
        $ostmt->close();
        $conn->commit();
        echo "Replace complete For Exam ID: $examId";
    }
} catch (Exception $e) {
    $conn->rollback();
    die('Replace failed: ' . $e->getMessage());
}