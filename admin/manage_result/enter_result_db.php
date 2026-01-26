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

	function getTermlyGrade($sub_failed,$section){
		global $conn;
		global $branch;
		global $session;
		if($section =='Nursery'){
			$sql = "SELECT CsrN1 AS c_f1,CsrN2 AS c_f2,CsrN3 AS c_f3,CsrN11 AS c_r1,CsrN12 AS c_r2,CsrN13 AS c_r3";
		} elseif($section =='Primary'){
			$sql = "SELECT CsrU1 AS c_f1,CsrU2 AS c_f2,CsrU3 AS c_f3,CsrU11 AS c_r1,CsrU12 AS c_r2,CsrU13 AS c_r3";
		} elseif($section =='Junior Sec'){
			$sql = "SELECT CsrJ1 AS c_f1,CsrJ2 AS c_f2,CsrJ3 AS c_f3,CsrJ11 AS c_r1,CsrJ12 AS c_r2,CsrJ13 AS c_r3";
		} else {
			$sql = "SELECT CsrS1 AS c_f1,CsrS2 AS c_f2,CsrS3 AS c_f3,CsrS11 AS c_r1,CsrS12 AS c_r2,CsrS13 AS c_r3";
		}
		$sql .= " FROM subjects WHERE Branch='$branch' AND C_Session ='$session'";
		$gs = $conn->query($sql)->fetch_object();
		$response1 = $gs->c_r1;
		$response2 = $gs->c_r2;
		$response3 = $gs->c_r3;
		$failed1 = $gs->c_f1;
		$failed2 = $gs->c_f2;
		$failed3 = $gs->c_f3;

		$returnedRemark;

		if($sub_failed >= $failed1){
			$returnedRemark = $response1;
		} elseif($sub_failed >= $failed2){
			$returnedRemark = $response2;
		}  else {
			$returnedRemark = $response3;
		}
		return $returnedRemark;
	}

	function getTermlyRemark($score){
		global $conn;
		global $branch;
		global $session;
		$gs = $conn->query("SELECT Trr1,Trr2,Trr3,Trr4,Trr5,Trr6,Sc1,Sc2,Sc3,Sc4,Sc5,Sc6 FROM subjects WHERE Branch='$branch' AND C_Session ='$session'")->fetch_object();
		$Trr1 = $gs->Trr1;
		$Trr2 = $gs->Trr2;
		$Trr3 = $gs->Trr3;
		$Trr4 = $gs->Trr4;
		$Trr5 = $gs->Trr5;
		$Trr6 = $gs->Trr6;
		$Sc1 = $gs->Sc1;
		$Sc2 = $gs->Sc2;
		$Sc3 = $gs->Sc3;
		$Sc4 = $gs->Sc4;
		$Sc5 = $gs->Sc5;
		$Sc6 = $gs->Sc6;
		$returnedRemark;

		if($score >= $Sc1){
			$returnedRemark = $Trr1;
		} elseif($score >= $Sc2){
			$returnedRemark = $Trr2;
		} elseif($score >= $Sc3){
			$returnedRemark = $Trr3;
		} elseif($score >= $Sc4){
			$returnedRemark = $Trr4;
		} elseif($score >= $Sc5){
			$returnedRemark = $Trr5;
		} else {
			$returnedRemark = $Trr6;
		}
		return $returnedRemark;
	}

	function getSubjectRemark($score){
		global $conn;
		global $branch;
		global $session;
		$gs = $conn->query("SELECT Rem1,Rem2,Rem3,Rem4,Rem5,Rem6,Sc1,Sc2,Sc3,Sc4,Sc5,Sc6 FROM subjects WHERE Branch='$branch' AND C_Session ='$session'")->fetch_object();
		$Rem1 = $gs->Rem1;
		$Rem2 = $gs->Rem2;
		$Rem3 = $gs->Rem3;
		$Rem4 = $gs->Rem4;
		$Rem5 = $gs->Rem5;
		$Rem6 = $gs->Rem6;
		$Sc1 = $gs->Sc1;
		$Sc2 = $gs->Sc2;
		$Sc3 = $gs->Sc3;
		$Sc4 = $gs->Sc4;
		$Sc5 = $gs->Sc5;
		$Sc6 = $gs->Sc6;
		$returnedRemark;

		if($score >= $Sc1){
			$returnedRemark = $Rem1;
		} elseif($score >= $Sc2){
			$returnedRemark = $Rem2;
		} elseif($score >= $Sc3){
			$returnedRemark = $Rem3;
		} elseif($score >= $Sc4){
			$returnedRemark = $Rem4;
		} elseif($score >= $Sc5){
			$returnedRemark = $Rem5;
		} else {
			$returnedRemark = $Rem6;
		}
		return $returnedRemark;
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


	//get student
	if(isset($_POST['type']) && $_POST['type'] == 'getStudent'){
		$studentID = $_POST['studentID'];
		$branch = $_POST['branch'];
		$className = $_POST['className'];
		$session = $_POST['session'];
		$table = $_POST['term'];
		$student = $conn->query("SELECT Student_ID,Fullnames,Student_Class,Student_Section FROM student_records WHERE Student_ID = '$studentID' AND Branch='$branch' AND Student_Class='$className'")->fetch_object();

		//check if entered before
		$checkEntered = $conn->query("SELECT ID FROM {$table} WHERE Student_ID='$studentID' AND C_Session ='$session'")->fetch_object();
		if(isset($checkEntered->ID)){
			$result['msg'] = 'This student record has been entered'; 
			$result['query'] = 'fair';
		} elseif(isset($student->Student_ID)){
			$result['studentID'] = $student->Student_ID;
			$result['Fullnames'] = $student->Fullnames;
			$result['Student_Class'] = $student->Student_Class;
			$result['Student_Section'] = $student->Student_Section;
			$subjectArray = [];
			if($student->Student_Section == 'Senior Sec'){
				for($i=1; $i < 20;$i++){
					$column ='Se'.$i;
					$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
					$subject = $row->{$column};
					$subjectArray[] = $subject;
				}
			} 
			elseif($student->Student_Section == 'Junior Sec'){
				for($i=1; $i < 20;$i++){
					$column ='Je'.$i;
					$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
					$subject = $row->{$column};
					$subjectArray[] = $subject;
				}
			} elseif($student->Student_Section == 'Nursery'){
				for($i=1; $i < 12;$i++){
					$column ='Ne'.$i;
					$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
					$subject = $row->{$column};
					$subjectArray[] = $subject;
				}
			} else {
				if($student->Student_Class == 'Pry4' || $student->Student_Class == 'Pry5'){
					for($i=1; $i < 16;$i++){
						$column ='Ue'.$i;
						$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
						$subject = $row->{$column};
						$subjectArray[] = $subject;
					}
				} else {
					for($i=1; $i < 14;$i++){
						$column ='Le'.$i;
						$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
						$subject = $row->{$column};
						$subjectArray[] = $subject;
					}
				}
			}

			$html = '';
			foreach($subjectArray as $subject){
				$html .= '
				<div class="row sum-row pt-1 g-1">
					<div class="col-3">
						<input type="text" name="field1" class="form-control text-center auto field1" maxlength="2" inputmode="numeric">
					</div>
					<div class="col-3">
						<input type="text" name="field2" class="form-control text-center auto field2" maxlength="2" inputmode="numeric">
					</div>
					<div class="col-3">
						<input type="text" name="field3" class="form-control text-center auto field3" maxlength="2" inputmode="numeric">
					</div>
					<div class="col-3">
						<input type="text" name="total" class="form-control text-center total" readonly style="background-color: #e4eaf4ff;" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$subject.'"> 
					</div>
				</div>';
			}

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
		$className = $_POST['className'];
		$session = $_POST['session'];
		$table = $_POST['term'];
		$resultStatus = $_POST['resultStatus'];
		if($table === 'first_term_result'){
			$term = '1st Term';
		} elseif($table === 'second_term_result'){
			$term = '2nd Term';
		} else {
			$term = '3rd Term';
		}
		$num = 1;
		$div = 0;
		$T_Score = 0;
		$Third_Score = 0;
		$sub_failed = 0;
		$std_section = $form[3]['value'];
		$data = [];
		$data['Update_ID'] = $form[2]['value'];
		$data['Student_ID'] = $form[0]['value'];
		$data['Fullname'] = $form[1]['value'];
		$data['Class'] = $className;
		$data['Section1'] = $std_section;
		$data['Term'] = $term;
		$data['Branch'] = $branch;
		$data['C_Session'] = $session;
		$data['Result_Status2'] = $resultStatus;
		$ID = (!empty($data['Update_ID'])) ? $data['Update_ID'] : $data['Student_ID'];
		for($i = 4; $i<count($form);$i += 4){
			$t1 = $form[$i]['value'];
			$t2 = $form[$i+1]['value'];
			$e = $form[$i+2]['value'];
			$to = $form[$i+3]['value'];
			$grade = getGrade($to);
			if($grade == 'F'){
				$sub_failed++;
			}

			$column1 = 'T1'.$num;
			$column2 = 'T2'.$num;
			$column3 = 'E'.$num;
			$column4 = 'To'.$num;
			$column5 = 'G'.$num;
			$column6 = 'At'.$num;
			$column7 = 'Tg'.$num;
			$column8 = 'Re'.$num;

			$data[$column1] = $t1;
			$data[$column2] = $t2;
			$data[$column3] = $e;
			$data[$column4] = $to;
			$data[$column5] = $grade;
			$subAvg = 1;
			$to1 = 0;
			$to2 = 0;
			if($table === 'third_term_result'){
				$sql1 = $conn->query("SELECT {$column4} FROM first_term_result WHERE Student_ID='$ID' AND Branch='$branch' AND C_Session='$session'")->fetch_object();
				if(isset($sql1->{$column4})){
					$to1 = $sql1->{$column4};
					$subAvg++;
				}
				
				$sql2 = $conn->query("SELECT {$column4} FROM second_term_result WHERE Student_ID='$ID' AND Branch='$branch' AND C_Session='$session'")->fetch_object();
				if(isset($sql2->{$column4})){
					$to2 = $sql2->{$column4};
					$subAvg++;
				}
				$At = round(($to + $to1 + $to2)/$subAvg,1);
				$data[$column6] = $At;
				$data[$column7] = getGrade($At);
				$data[$column8] = getSubjectRemark($At);
				$Third_Score += $At; // for third
			}
			$T_Score += $to; // for first and second
			$num++;
			$div++;
		}
		$per_score = round($T_Score/$div); 
		$data['Subjects_Failed'] = $sub_failed;
		$data['Core_Subjects'] = $sub_failed;
		$data['T_Score'] = ($table === 'third_term_result') ? $Third_Score : $T_Score ;
		if($table === 'third_term_result'){
			$data['Third_Result'] = $T_Score;
			$per_score = round($Third_Score/$div); 
			$data['Mgt_Comment'] = getMgtComment($per_score);  //Mgt_comment
		}
		$data['Percent_Score'] = $per_score; 
		$data['Termly_Grade'] = getTermlyGrade($sub_failed,$std_section);
		$data['Termly_Rem'] = getTermlyRemark($per_score);
		$data['Teachers_Comment'] = getTeacherComment($per_score);

		// ----------------------------------------------------------
		//  DECIDE INSERT OR UPDATE
		// ----------------------------------------------------------

		if (!empty($data['Update_ID'])) {
			// UPDATE MODE
			$studentID = $data['Update_ID'];
			$sessionID = $data['C_Session'];
			unset($data['Update_ID']); 
			unset($data['Student_ID']);
			unset($data['C_Session']);
			$setParts = [];
			foreach ($data as $key => $value) {
				$setParts[] = "$key = ?";
			}
			$setString = implode(", ", $setParts);
			$sql = "UPDATE {$table} SET $setString WHERE Student_ID = ? AND C_Session = ?";
			$stmt = $conn->prepare($sql);
			$params = array_values($data);
			$params[] = $studentID;
			$params[] = $sessionID;
			$result['msg'] = 'Result Updated successfully';
		} else if (!empty($data['Student_ID'])) {
			unset($data['Update_ID']);
			// INSERT MODE
			$columns = implode(", ", array_keys($data));
			$placeholders = implode(", ", array_fill(0, count($data), "?"));
			$sql = "INSERT INTO {$table} ($columns) VALUES ($placeholders)";
			$stmt = $conn->prepare($sql);
			$params = array_values($data);
			$result['msg'] = 'Result inserted successfully';
		} else {
			// No Student_ID = nothing to insert
			$result['success'] = 'false';
			$result['msg'] = 'Student_ID is empty';
			echo json_encode($result);
			exit;
		}

		// ----------------------------------------------------------
		//  BIND FUNCTION
		// ----------------------------------------------------------
		function dynamicBind($stmt, $params){
			$types = '';
			$values = [];

			foreach ($params as $value) {
				if (is_int($value)) $types .= 'i';
				elseif (is_float($value)) $types .= 'd';
				else $types .= 's';
				$values[] = $value;
			}

			$stmt_params = array_merge([$types], $values);

			$refs = [];
			foreach ($stmt_params as $key => $value) {
				$refs[$key] = &$stmt_params[$key];
			}

			call_user_func_array([$stmt, 'bind_param'], $refs);
		}

		// ----------------------------------------------------------
		//  EXECUTE
		// ----------------------------------------------------------

		dynamicBind($stmt, $params);

		// ----------------------------------------------------------
		//  CALCULATE POSITION
		// ----------------------------------------------------------
		$allGroup = $conn->query("SELECT ID,T_Score FROM {$table} WHERE Class='$className' AND Branch='$branch' AND C_Session='$session' ORDER BY T_Score DESC")->fetch_all(MYSQLI_ASSOC);
		$rank = 0;
		$last_score = null;
		$position = 0;
		foreach($allGroup as $student){
			$rank++;
			if($last_score !== $student['T_Score']){
				$position = $rank;
				$rposition = addOrdinalSuffix($position);
			}
			$last_score = $student['T_Score'];
			$updateId = $student['ID'];
			$update = $conn->query("UPDATE {$table} SET Position_ = '$rposition' WHERE ID='$updateId'");
		}
		

		if ($stmt->execute()) {
			$result['success'] = 'true';
		} else {
			$result['success'] = 'false';
		}

		echo json_encode($result);
	}

	//getUpdate
	if(isset($_POST['type']) && $_POST['type'] == 'getUpdate'){
		$studentID = $_POST['studentID'];
		$branch = $_POST['branch'];
		$session = $_POST['session'];
		$className = $_POST['className'];
		$table = $_POST['term'];
		$subjectArray = [];
		$scoreArray = [];
		$student = $conn->query("SELECT Student_ID,Fullnames,Student_Class,Student_Section FROM student_records WHERE Student_ID = '$studentID' AND Branch='$branch' AND Student_Class='$className'")->fetch_object();
		$result['studentID'] = $student->Student_ID;
		$result['Fullnames'] = $student->Fullnames;
		$result['Student_Class'] = $student->Student_Class;
		$result['Student_Section'] = $student->Student_Section;
		//check if entered before
		$checkEntered = $conn->query("SELECT ID FROM {$table} WHERE Student_ID='$studentID' AND C_Session ='$session'")->fetch_object();
		if(!isset($checkEntered->ID)){
			$result['msg'] = 'This student record has been entered'; 
			$result['query'] = 'fair';
		} elseif(isset($student->Student_ID)){
			if($student->Student_Section == 'Senior Sec'){
				for($i=1; $i < 20;$i++){
					$column ='Se'.$i;
					$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
					$subject = $row->{$column};
					$subjectArray[] = $subject;
					$scoreArray[] = ['T1'.$i,'T2'.$i,'E'.$i,'To'.$i];
				}
			} 
			elseif($student->Student_Section == 'Junior Sec'){
				for($i=1; $i < 20;$i++){
					$column ='Je'.$i;
					$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
					$subject = $row->{$column};
					$subjectArray[] = $subject;
					$scoreArray[] = ['T1'.$i,'T2'.$i,'E'.$i,'To'.$i];
				}
			} elseif($student->Student_Section == 'Nursery'){
				for($i=1; $i < 12;$i++){
					$column ='Ne'.$i;
					$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
					$subject = $row->{$column};
					$subjectArray[] = $subject;
					$scoreArray[] = ['T1'.$i,'T2'.$i,'E'.$i,'To'.$i];
				}
			} else {
				if($student->Student_Class == 'Pry4' || $student->Student_Class == 'Pry5'){
					for($i=1; $i < 16;$i++){
						$column ='Ue'.$i;
						$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
						$subject = $row->{$column};
						$subjectArray[] = $subject;
						$scoreArray[] = ['T1'.$i,'T2'.$i,'E'.$i,'To'.$i];
					}
				} else {
					for($i=1; $i < 14;$i++){
						$column ='Le'.$i;
						$row = $conn->query("SELECT {$column} FROM subjects WHERE Branch='$branch' AND C_Session='$session' ")->fetch_object();
						$subject = $row->{$column};
						$subjectArray[] = $subject;
						$scoreArray[] = ['T1'.$i,'T2'.$i,'E'.$i,'To'.$i];
					}
				}
			}
			$html = '';
			foreach($subjectArray as $index=>$value){
				$columns = $scoreArray[$index];
				$column1 = $columns[0];
				$column2 = $columns[1];
				$column3 = $columns[2];
				$column4 = $columns[3];

				$sql = $conn->query("SELECT {$column1},{$column2},{$column3},{$column4} FROM {$table} WHERE Student_ID='$studentID' AND C_Session='$session'")->fetch_object();
				$t = $sql->{$column1} ?? 0;
				$t2 = $sql->{$column2} ?? 0;
				$E = $sql->{$column3} ?? 0;
				$To = $sql->{$column4} ?? 0;

				$html .= '
				<div class="row sum-row pt-1 g-1">
					<div class="col-3">
						<input type="text"value="'.$t.'" name="field1" class="form-control text-center auto field1" maxlength="2" inputmode="numeric">
					</div>
					<div class="col-3">
						<input type="text" value="'.$t2.'" name="field2" class="form-control text-center auto field2" maxlength="2" inputmode="numeric" >
					</div>
					<div class="col-3">
						<input type="text" value="'.$E.'" name="field3" class="form-control text-center auto field3" maxlength="2" inputmode="numeric" >
					</div>
					<div class="col-3">
						<input type="text" value="'.$To.'" name="total" class="form-control text-center total" readonly style="background-color: #e4eaf4ff;" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$value.'"> 
					</div>
				</div>';
			}
			$resultStatus = ($conn->query("SELECT Result_Status2 FROM {$table} WHERE Student_ID='$studentID' AND C_Session='$session'")->fetch_object())->Result_Status2;

			$result['resultStatus'] = $resultStatus; 
			$result['html'] = $html; 
			$result['query'] = 'true';
		} else {
			$result['query'] = 'false';
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