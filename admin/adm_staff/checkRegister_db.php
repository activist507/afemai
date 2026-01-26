<?php 
include('../../admin/config/db_connect.php');

if(isset($_POST['type']) && $_POST['type'] == 'checkRegister'){
  function staff_list($conn,$gen_branch): array
	{
		$tot = $conn->query("SELECT Staff_ID,Fullname  FROM staff_records WHERE Staff_Status = 'Active'  AND Branch ='$gen_branch'")->fetch_all(MYSQLI_ASSOC);
		return $tot;
	}
  $sdatee=explode(';', $_POST['date_range']);
  // $stdLists = $_POST['stdList'];

  $branch = $_POST['branch'];
  $staffList = staff_list($conn,$branch);
  $title=$sdatee[1];
  $sdate=explode('~', $sdatee[0]);
  $html='';

  if($title == 'Custom Range' || $title == 'Last 7 Days' || $title == 'Last 30 Days' || $title == 'This Month' || $title == 'Last Month'){
      $dt=new DateTime($sdate[0]);
      $dt1=new DateTime($sdate[1]);
      $date1 = $dt->format('jS M, Y');
      $date2 = $dt1->format('jS M, Y');
      $title = $date1.' - '.$date2;
      $date_query = "BETWEEN '$sdate[0]' AND ' $sdate[1]'";
    }
    else{
      $dt=new DateTime($sdate[0]);
      $title .= ', '.$dt->format('jS M, Y');
      $date_query = " = '$sdate[0]'";
  }

  $sqldate = $conn->query("SELECT work_date FROM workdays WHERE is_holiday = 0  AND work_date $date_query ORDER BY work_date ")->fetch_all(MYSQLI_ASSOC);


  // <!------------------------------------------------------------------->
  $html .= '<h4 class="text-center pt-3 "><strong>Attendance '.$title.'</strong></h4>';
  $html .= '<table class="table table-striped table-hover table-bordered"><thead class="table-light">
  <tr><th scope="col" nowrap="nowrap">Name</th>';
  foreach($sqldate as $date){
    $html .= '<th scope="col" nowrap="nowrap">'.$date['work_date'].'</th>';
  }
  $html .= '</tr></thead>';
  foreach ($staffList as $std) {
    $id = $std['Staff_ID'];
    $name = $std['Fullname'];
    $html .= "<tr><td nowrap='nowrap'>$name</td>";

    $sql2 = $conn->query(" SELECT w.work_date,CASE WHEN a.status = 1 THEN 1 ELSE 0 END AS status
      FROM workdays w LEFT JOIN attendance_staff a ON w.work_date = a.date AND a.staffID = '$id' AND a.branch = '$branch'
      WHERE w.is_holiday = 0  AND w.work_date $date_query ORDER BY w.work_date ")->fetch_all(MYSQLI_ASSOC);

    foreach ($sql2 as $entry) {
      $checked = ($entry['status'] == 1) ? "checked":"";
      $html .= '<td><div class="text-center"><input class="form-check-input" type="checkbox" '.$checked.' disabled></div></td>';
    }
    $html .= '</tr>';
  }
  $resp['html'] = $html ; 
  echo json_encode($resp);
}





?>