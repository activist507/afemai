<?php
include '../config/db_connect.php';
header('Content-Type: text/plain; charset=utf-8');

$payloadRaw = $_POST['payload_json'] ?? '';
$exam_id = ($_POST['exam_id']);
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
    $stmt = $conn->prepare("UPDATE exams SET title=?,class_id=?,subject_id=?,term_id=?,assessment_type=?,no_of_question=?,alloted_mark=?,total_mark=?,duration=? WHERE id=?");
    $stmt->bind_param('sssssidddi',$examTitle,$class_id,$subject_id,$term_id,$assessment_type,$no_of_question,$alloted_mark,$total_mark,$duration,$exam_id);
    $stmt->execute(); 
    $stmt->close();

    
    // $qstmt = $conn->prepare("UPDATE questionns SET question_text =?, question_image=? WHERE id=? ");
    // $qstmt->bind_param('ssi', $qtext, $qimg, $qid);

    $qstmt = $conn->prepare("UPDATE questionns SET question_text =? WHERE id=?");
    $qstmt->bind_param('si', $qtext,$qid);

    $ostmt = $conn->prepare("UPDATE options SET option_key=?, option_text=?, is_correct=? WHERE id=? ");
    $ostmt->bind_param('ssii',$okey, $otext, $oiscorr,$opt_id);

    foreach ($payload as $qblock) {
        $qid = $qblock['qid'];
        $qtext = $qblock['question'] ?? '';
        $qimg = $qblock['image'] ?? null; if ($qimg === '') $qimg = null;
        $qstmt->execute(); 
        foreach ($qblock['options'] as $opt) {
            $opt_id = $opt['opt_id'];
            $okey = $opt['key'] ?? 'A';
            $otext = $opt['text'] ?? '';
            $oiscorr = isset($opt['correct']) && $opt['correct'] ? 1 : 0;
            $ostmt->execute();
        }
    }

    $qstmt->close(); 
    $ostmt->close();
    $conn->commit();
    echo "Question Updated Successfully. Exam ID: $exam_id";
} catch (Exception $e) {
    $conn->rollback();
    die('Update failed: ' . $e->getMessage());
}