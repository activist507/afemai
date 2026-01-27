<?php 
	include('../../admin/config/db_connect.php');
    $result = array();

	function getGrade($score){
		global $conn;
		global $branch;
		global $session;
		$gs = $conn->query("SELECT Grade1,Grade2,Grade3,Grade4,Grade5,Grade6,Sc1,Sc2,Sc3,Sc4,Sc5,Sc6 FROM subjects WHERE Branch='$branch' AND C_Session ='$session'")->fetch_object();
		$Grade1 = $gs->Grade1;
		$Grade2 = $gs->Grade2;
		$Grade3 = $gs->Grade3;
		$Grade4 = $gs->Grade4;
		$Grade5 = $gs->Grade5;
		$Grade6 = $gs->Grade6;
		$Sc1 = $gs->Sc1;
		$Sc2 = $gs->Sc2;
		$Sc3 = $gs->Sc3;
		$Sc4 = $gs->Sc4;
		$Sc5 = $gs->Sc5;
		$Sc6 = $gs->Sc6;
		$returnedGrade;

		if($score >= $Sc1){
			$returnedGrade = $Grade1;
		} elseif($score >= $Sc2){
			$returnedGrade = $Grade2;
		} elseif($score >= $Sc3){
			$returnedGrade = $Grade3;
		} elseif($score >= $Sc4){
			$returnedGrade = $Grade4;
		} elseif($score >= $Sc5){
			$returnedGrade = $Grade5;
		} else {
			$returnedGrade = $Grade6;
		}
		return $returnedGrade;
	}

	function getTeacherComment($score){
		global $conn;
		global $branch;
		global $session;
		$gs = $conn->query("SELECT Tc1,Tc2,Tc3,Tc4,Tc5,Sc1,Sc2,Sc3,Sc4,Sc5,Sc6 FROM subjects WHERE Branch='$branch' AND C_Session ='$session'")->fetch_object();
		$Tc1 = $gs->Tc1;
		$Tc2 = $gs->Tc2;
		$Tc3 = $gs->Tc3;
		$Tc4 = $gs->Tc4;
		$Tc5 = $gs->Tc5;
		$Tc6 = $gs->Tc5;
		$Sc1 = $gs->Sc1;
		$Sc2 = $gs->Sc2;
		$Sc3 = $gs->Sc3;
		$Sc4 = $gs->Sc4;
		$Sc5 = $gs->Sc5;
		$Sc6 = $gs->Sc6;
		$returnedRemark;

		if($score >= $Sc1){
			$returnedRemark = $Tc1;
		} elseif($score >= $Sc2){
			$returnedRemark = $Tc2;
		} elseif($score >= $Sc3){
			$returnedRemark = $Tc3;
		} elseif($score >= $Sc4){
			$returnedRemark = $Tc4;
		} elseif($score >= $Sc5){
			$returnedRemark = $Tc5;
		} else {
			$returnedRemark = $Tc6;
		}
		return $returnedRemark;
	}

	function getMgtComment($score){
		global $conn;
		global $branch;
		global $session;
		$gs = $conn->query("SELECT Trr11,Trr12,Trr13,Trr14,Trr15,Trr16,Sc1,Sc2,Sc3,Sc4,Sc5,Sc6 FROM subjects WHERE Branch='$branch' AND C_Session ='$session'")->fetch_object();
		$Trr11 = $gs->Trr11;
		$Trr12 = $gs->Trr12;
		$Trr13 = $gs->Trr13;
		$Trr14 = $gs->Trr14;
		$Trr15 = $gs->Trr15;
		$Trr16 = $gs->Trr16;
		$Sc1 = $gs->Sc1;
		$Sc2 = $gs->Sc2;
		$Sc3 = $gs->Sc3;
		$Sc4 = $gs->Sc4;
		$Sc5 = $gs->Sc5;
		$Sc6 = $gs->Sc6;
		$returnedRemark;

		if($score >= $Sc1){
			$returnedRemark = $Trr11;
		} elseif($score >= $Sc2){
			$returnedRemark = $Trr12;
		} elseif($score >= $Sc3){
			$returnedRemark = $Trr13;
		} elseif($score >= $Sc4){
			$returnedRemark = $Trr14;
		} elseif($score >= $Sc5){
			$returnedRemark = $Trr15;
		} else {
			$returnedRemark = $Trr16;
		}
		return $returnedRemark;
	}

	function addOrdinalSuffix($number){
		if($number % 100 >= 11 && $number % 100 <= 13){
			return $number."th";
		}
		switch ($number % 10){
			case 1: return $number."st";
			case 2: return $number."nd";
			case 3: return $number."rd";
			default: return $number."th";
		}
	}

	function get_memorization_score($sub_id){
		global $conn,$term,$session,$class_id,$studentID;
		$memorization_scores = $conn->query("SELECT test1,test2,obj,theory,total_score FROM memorization_scores 
		WHERE student_id ='$studentID' AND subject_id ='$sub_id'
		AND term ='$term' AND year ='$session' AND class_id ='$class_id'")->fetch_object();

		$array['test1'] = $memorization_scores->test1 ?? '';
		$array['test2'] = $memorization_scores->test2 ?? '';
		$array['obj'] = $memorization_scores->obj ?? '';
		$array['theory'] = $memorization_scores->theory ?? '';
		$array['total'] = $memorization_scores->total_score ?? '';

		return $array;
	}

	function get_memorization_scores_total(){
		global $conn,$term,$session,$class_id,$studentID,$branch;
		$memorization_scores_total = $conn->query("SELECT * FROM memorization_scores_total 
			WHERE student_id ='$studentID'
			AND branch = '$branch'
			AND class_id = '$class_id'
			AND term = '$term'
			AND year = '$session'
			")->fetch_object();
		return $memorization_scores_total;
	}

	function get_memorization_class(){
		global $conn,$class_id;
		$memorization_class = $conn->query("SELECT * FROM memorization_class WHERE id ='$class_id'")->fetch_object();
		return $memorization_class;
	}


	//get student
	if(isset($_POST['type']) && $_POST['type'] == 'getStudent'){
		$studentID = $_POST['studentID'];
		$branch = $_POST['branch'];
		$class_id = $_POST['className'];
		$session = $_POST['session'];
		$term = $_POST['term'];
		$student = $conn->query("SELECT Student_ID,Fullnames FROM student_records WHERE Student_ID = '$studentID' AND Branch='$branch'")->fetch_object();

		if(isset($student->Student_ID)){
			$result['studentID'] = $student->Student_ID;
			$result['Fullnames'] = $student->Fullnames;
			$result['Student_Class'] = get_memorization_class()->class_name;
			$subjectArray = [];
			$html = '';
			
			$memorization_subject = $conn->query("SELECT * FROM memorization_subject");
			while($subject = $memorization_subject->fetch_object()):
				$scores = get_memorization_score($subject->id);
				$html .= '
				<div class="row sum-row pt-1 g-1" data-sub="'.$subject->subject.'">
					<div class="col-3">
						<input type="text" value="'.$scores['test1'].'" name="field1" class="form-control text-center auto field1" maxlength="2" inputmode="numeric">
					</div>
					<div class="col-3">
						<input type="text" value="'.$scores['test2'].'" name="field2" class="form-control text-center auto field2" maxlength="2" inputmode="numeric">
					</div>
					<div class="col-3">
						<input type="text" value="'.$scores['obj'].'" name="field3" class="form-control text-center auto field3" maxlength="2" inputmode="numeric">
					</div>
					<div class="col-3">
						<input type="text" value="'.$scores['theory'].'" name="field4" class="form-control text-center auto field4" maxlength="2" inputmode="numeric">
					</div>
					<div class="col-3 d-none">
						<input type="text" value="'.$scores['total'].'" name="total" class="form-control text-center total" readonly style="background-color: #e4eaf4ff;"> 
					</div>
					<input type="hidden" name="subject_id" class="form-control text-center subject_id" readonly value="'.$subject->id.'"> 
				</div>';
			endwhile;

			$result['startingSurah'] = get_memorization_scores_total()->starting_surah ?? '';
			$result['endingSurah'] = get_memorization_scores_total()->ending_surah ?? '';
			$result['daily_submission'] = get_memorization_scores_total()->daily_submission ?? '';
			$result['attendance'] = get_memorization_scores_total()->attendance ?? '';
			$result['holiday'] = get_memorization_scores_total()->holiday ?? '';

			$result['html'] = $html; 
			$result['query'] = 'true';
		} else {
			$result['query'] = 'false';
		}
		echo json_encode($result);
	}

	//submit result
	if(isset($_POST['type']) && $_POST['type'] == 'submitResult'){
		$form = $_POST['form'];
		$branch = $_POST['branch'];
		$class_id = $_POST['className'];
		$session = $_POST['session'];
		$term = $_POST['term'];
		$startingSurah = $_POST['startingSurah'];
		$endingSurah = $_POST['endingSurah'];
		$daily_submission = $_POST['daily_submission'];
		$attendance = $_POST['attendance'];
		$holiday = $_POST['holiday'];
		
		$num = 1;
		$div = 0;
		$T_Score = 0;
		$student_id = $form[0]['value'];
		$Fullname = $form[1]['value'];
		$std_section = $form[2]['value'];
		try{
			$sql = "INSERT INTO memorization_scores
			(student_id, subject_id, branch, test1, test2, obj, theory, term, year, class_id, total_score, sub_grade)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
			ON DUPLICATE KEY UPDATE
				test1       = VALUES(test1),
				test2       = VALUES(test2),
				obj         = VALUES(obj),
				theory      = VALUES(theory),
				total_score = VALUES(total_score),
				sub_grade   = VALUES(sub_grade);
			";
			$scStmt = $conn->prepare($sql);
			$scStmt->bind_param("iisiiiiisiis",$student_id,$sub_id,$branch,$test1,$test2,$obj,$theory,$term,$session,$class_id,$total,$grade);

			for($i = 3; $i<count($form);$i += 6){
				$test1 = $form[$i]['value'];
				$test2 = $form[$i+1]['value'];
				$obj = $form[$i+2]['value'];
				$theory = $form[$i+3]['value'];
				$total = (int)$form[$i+4]['value'];
				$sub_id = $form[$i+5]['value'];
				$grade = getGrade($total);
				$scStmt->execute();

				$T_Score += $total;
				$num++;
				$div++;
			}
			$out_of = 100 * $div;
			$avg = round($T_Score/$div);

			$sql2 = "INSERT INTO memorization_scores_total
			(student_id, branch, class_id, term, year, total_score, out_of, starting_surah, ending_surah, daily_submission, average,fullname,attendance,holiday)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)
			ON DUPLICATE KEY UPDATE
				total_score       = VALUES(total_score),
				out_of            = VALUES(out_of),
				starting_surah    = VALUES(starting_surah),
				ending_surah      = VALUES(ending_surah),
				daily_submission  = VALUES(daily_submission),
				average           = VALUES(average),
				fullname           = VALUES(fullname),
				attendance           = VALUES(attendance),
				holiday           = VALUES(holiday);
			";
			$totStmt = $conn->prepare($sql2);
			$totStmt->bind_param("isiisiisssdsss",$student_id,$branch,$class_id,$term,$session,$T_Score,$out_of,$startingSurah,$endingSurah,$daily_submission,$avg,$Fullname,$attendance,$holiday);
			$totStmt->execute();

			// ----------------------------------------------------------
			//  CALCULATE POSITION
			// ----------------------------------------------------------
			$allGroup = $conn->query("SELECT id,total_score FROM memorization_scores_total WHERE class_id='$class_id' AND branch='$branch' AND term='$term' AND year='$session' ORDER BY total_score DESC")->fetch_all(MYSQLI_ASSOC);
			$rank = 0;
			$last_score = null;
			$position = 0;
			foreach($allGroup as $student){
				$rank++;
				if($last_score !== $student['total_score']){
					$position = $rank;
					$rposition = addOrdinalSuffix($position);
				}
				$last_score = $student['total_score'];
				$TeacherComment = getTeacherComment($student['total_score']);
				$MgtComment = getMgtComment($student['total_score']);
				$updateId = $student['id'];
				$update = $conn->query("UPDATE memorization_scores_total SET class_pos = '$rposition',TeacherComment='$TeacherComment',MgtComment='$MgtComment' WHERE id='$updateId'");
			}
			
			$result['success'] = 'true';
			$result['msg'] = 'Successful Entry';

		} catch(Exception $e){
			$conn->rollback();
			die('Insert failed: ' . $e->getMessage());
		}

		echo json_encode($result);
	}

	if(isset($_POST['type']) && $_POST['type'] == 'auto_id_rec'){   
		$branch = $_POST['branch'];
		$className = $_POST['className'];
		$session = $_POST['session'];
		$table = $_POST['term'];
		$row = $conn->query("SELECT COUNT(ID) AS total FROM {$table} WHERE Class='$className' AND C_Session='$session' AND Branch='$branch'")->fetch_object();
		$count = $row->total;

		$row1 = $conn->query("SELECT COUNT(ID) AS pass FROM {$table} WHERE Termly_Grade='PASS' AND Class='$className' AND C_Session='$session' AND Branch='$branch'")->fetch_object();
		$pass = $row1->pass;

		$row2 = $conn->query("SELECT COUNT(ID) AS fail FROM {$table} WHERE Termly_Grade='FAIL' AND Class='$className' AND C_Session='$session' AND Branch='$branch'")->fetch_object();
		$failed = $row2->fail;

		$result['total'] = $count;
		$result['pass'] = $pass;
		$result['failed'] = $failed;
		echo json_encode($result);
    }

?>