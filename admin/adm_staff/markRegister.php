<?php 
  $pres = 1; 
  if(isset($_GET['dateTop']) && isset($_GET['att_branch'])){
	$dateTop = $_GET['dateTop'];
	$attBranch = $_GET['att_branch'];
	$dExp = explode("-",$dateTop);
  	$monthStart = date('Y-'.$dExp[1].'-01');
  	$monthEnd = date('Y-'.$dExp[1].'-31');
  } else {
	$dateTop = date('Y-m-d');
	$attBranch = $gen_branch;
	$monthStart = date('Y-m-01');
  	$monthEnd = date('Y-m-31');
  }

  
  $all_staff = staff_list($conn,$attBranch);
  $tot_todayAtt = $conn->query("SELECT staffID FROM attendance_staff WHERE branch ='$attBranch' AND date='$dateTop' AND status=1");
  $todayAtt = array_column($tot_todayAtt->fetch_all(MYSQLI_ASSOC), 'staffID');
  $todayAttCount = count($todayAtt);

  $tot_todayAtt2 = $conn->query("SELECT staffID FROM attendance_staff WHERE branch ='$attBranch' AND date='$dateTop' AND status_abs=1");
  $todayAtt2 = array_column($tot_todayAtt2->fetch_all(MYSQLI_ASSOC), 'staffID');
  $todayAttCount2 = count($todayAtt2);


  function countPres($conn,$staf_id,$start,$end):int
  {
	$cnt = $conn->query("SELECT SUM(status) AS total FROM attendance_staff WHERE staffID ='$staf_id' AND date >= '$start' AND date <= '$end'")->fetch_object();
	$total = intVal($cnt->total);
	return $total;
  }

  function countPresAbs($conn,$staf_id,$start,$end):int
  {
	$cnt = $conn->query("SELECT SUM(status_abs) AS total FROM attendance_staff WHERE staffID ='$staf_id' AND date >= '$start' AND date <= '$end'")->fetch_object();
	$total = intVal($cnt->total);
	return $total;
  }
  
?>
<main id="main" class="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active">Mark Register</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="row pt-3 pb-2">

                            <div class="col-sm-12 col-lg-3">
                                <h5 class="card-title text-center">Staff Attendance</h5>
                            </div>
                            <div class="col-sm-12 col-lg-3 pt-2">
                                <input type="hidden" name="staff_register" value="">
                                <div class="search-bar">
                                    <input type="date" name="dateTop" id="dateTop" class="form-control"
                                        value="<?= $dateTop?>">
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-3 pt-2">
                                <div class="search-bar">
                                    <select name="att_branch" id="att_branch" class="form-select">
                                        <option value="<?= $attBranch?>"><?= $attBranch?></option>
                                        <?php foreach($branches_rows as $branc){?>
                                        <option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-3 pt-2">
                                <button type="submit" style="width: 8.7rem;"
                                    class="btn btn-primary w-100">Proceed</button>
                            </div>

                        </div>
                    </form>

                    <form class="row g-3 clRegForm">

                        <input type="hidden" name="clas_branch" id="class_branch" value="<?= $attBranch?>">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="">Names of Staff</th>
                                    <th scope="col" class="text-center"><input class="form-check-input" type="checkbox"
                                            id="allM">
                                        M</th>
                                    <th scope="col" class="text-center">T.P</th>
                                    <th scope="col" class="text-center"><input class="form-check-input" type="checkbox"
                                            id="allA">
                                        A</th>
                                    <th scope="col" class="text-center">T.A</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_staff as $stf):?>
                                <tr>
                                    <th scope="row" class="text-center"><?= $stf['Staff_ID']?></th>
                                    <td class="text-uppercase"><?= $stf['Fullname']?></td>
                                    <td
                                        class=" text-center <?php if (in_array($stf['Staff_ID'], $todayAtt)){ echo 'table-success';}?>">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input chkM" type="checkbox"
                                                value="<?=$stf['Staff_ID']?>" name="morningNAme"
                                                <?php if (in_array($stf['Staff_ID'], $todayAtt)){ echo 'checked';}?>>
                                            <!-- <label class="form-check-label" for="inlineRadio1">Attn</label> -->
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p><?= countPres($conn,$stf['Staff_ID'],$monthStart,$monthEnd);?></p>
                                    </td>
                                    <td
                                        class="text-center <?php if (in_array($stf['Staff_ID'], $todayAtt2)){ echo 'table-primary';}?>">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input chkA" type="checkbox"
                                                value="<?=$stf['Staff_ID']?>" name="Afternoon"
                                                <?php if (in_array($stf['Staff_ID'], $todayAtt2)){ echo 'checked';}?>>
                                            <!-- <label class="form-check-label" for="inlineRadio1">Absc</label> -->
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p><?= countPresAbs($conn,$stf['Staff_ID'],$monthStart,$monthEnd);?></p>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>

                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-sm-12 ">
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-primary rounded-pill mrkReg w-100" type="button">
                                        <i class="bi-check2-square"></i> Mark Staff Attendance
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-success rounded-pill mrkAbs w-100" type="button">
                                        <i class="bi-check2-square"></i> Mark Staff Abscorned
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">
$(document).ready(function() {
    // alert('mark register page');
    $('.clRegForm').on('click', '#allM', function() {
        if ($(this).prop('checked') == true) {
            $('.chkM').prop('checked', true);
            $('.chkM').parent().parent().addClass('table-success');
            // $('.chkM').parent().parent().parent().addClass('table-success');
        } else {
            $('.chkM').prop('checked', false);
            $('.chkM').parent().parent().removeClass('table-success');
            // $('.chkM').parent().parent().parent().removeClass('table-success');
        }
    });
    $('.clRegForm').on('click', '.chkM', function() {
        if ($(this).prop('checked') == true) {
            $(this).prop('checked', true);
            $(this).parent().parent().addClass('table-success');
            // $(this).parent().parent().parent().addClass('table-success');
        } else {
            $(this).prop('checked', false);
            $(this).parent().parent().removeClass('table-success');
            // $(this).parent().parent().parent().removeClass('table-success');
        }
    });


    $('.clRegForm').on('click', '#allA', function() {
        if ($(this).prop('checked') == true) {
            $('.chkA').prop('checked', true);
            $('.chkA').parent().parent().addClass('table-primary');
            // $('.chkA').parent().parent().parent().addClass('table-primary');
        } else {
            $('.chkA').prop('checked', false);
            $('.chkA').parent().parent().removeClass('table-primary');
            // $('.chkA').parent().parent().parent().removeClass('table-primary');
        }
    });
    $('.clRegForm').on('click', '.chkA', function() {
        if ($(this).prop('checked') == true) {
            $(this).prop('checked', true);
            $(this).parent().parent().addClass('table-primary');
            // $(this).parent().parent().parent().addClass('table-primary');
        } else {
            $(this).prop('checked', false);
            $(this).parent().parent().removeClass('table-primary');
            // $(this).parent().parent().parent().removeClass('table-primary');
        }
    });

    function markRegister(ids) {
        var class_branch = $('#class_branch').val();
        var dateTop = $('#dateTop').val();
        $.ajax({
            url: '../admin/adm_staff/markRegister_db.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                "ids": ids,
                "type": "markRegister",
                "date": dateTop,
                "class_branch": class_branch
            },
            success: function(data) {
                if (data.status == 'success') {
                    $.alert({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: data.message,
                        animation: 'scale',
                        type: 'orange'
                    })
                    setTimeout(function() {
                        location.reload(true)
                    }, 2500);
                }
            },
            error: function(err) {
                console.log(err);
            }
        })
    }

    function markRegister2(ids, mIDs) {
        var class_branch = $('#class_branch').val();
        var dateTop = $('#dateTop').val();
        $.ajax({
            url: '../admin/adm_staff/markRegister_db.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                "ids": ids,
                "mIDs": mIDs,
                "date": dateTop,
                "type": "markRegister2",
                "class_branch": class_branch
            },
            success: function(data) {
                if (data.status == 'success') {
                    $.alert({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: data.message,
                        animation: 'scale',
                        type: 'orange'
                    })
                    setTimeout(function() {
                        location.reload(true)
                    }, 2500);
                }
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
    var ids;
    var mIDs;
    $('.mrkReg').click(function(e) {
        e.preventDefault();
        var checked = $('.chkM:checkbox:checked').length;
        var listsss = $('.chkM:checkbox:checked').serializeArray();
        mIDs = <?php echo json_encode($todayAtt); ?>;
        if (checked < 1 && mIDs == '') {
            toastr.warning('Please Select At Least One Staff To Mark Present.');
        } else {
            ids = listsss;
            <?php if($todayAttCount > 0){ ?>
            markRegister2(ids, mIDs);
            <?php } else {?>
            markRegister(ids);
            <?php }?>
        }
    })





    function markAbsRegister(absIds) {
        var class_branch = $('#class_branch').val();
        var dateTop = $('#dateTop').val();
        $.ajax({
            url: '../admin/adm_staff/markRegister_db.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                "ids": absIds,
                "date": dateTop,
                "type": "markAbsRegister",
                "class_branch": class_branch
            },
            success: function(data) {
                if (data.status == 'success') {
                    $.alert({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: data.message,
                        animation: 'scale',
                        type: 'orange'
                    })
                    setTimeout(function() {
                        location.reload(true)
                    }, 2500);
                }
            },
            error: function(err) {
                console.log(err);
            }
        })
    }

    function markAbsRegister2(absIds, absMIDs) {
        var class_branch = $('#class_branch').val();
        var dateTop = $('#dateTop').val();
        $.ajax({
            url: '../admin/adm_staff/markRegister_db.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                "ids": absIds,
                "mIDs": absMIDs,
                "date": dateTop,
                "type": "markAbsRegister2",
                "class_branch": class_branch
            },
            success: function(data) {
                if (data.status == 'success') {
                    $.alert({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: data.message,
                        animation: 'scale',
                        type: 'orange'
                    })
                    setTimeout(function() {
                        location.reload(true)
                    }, 2500);
                }
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
    var absIds;
    var absMIDs;
    $('.mrkAbs').click(function(e) {
        e.preventDefault();
        var checked = $('.chkA:checkbox:checked').length;
        var listsss = $('.chkA:checkbox:checked').serializeArray();
        absMIDs = <?php echo json_encode($todayAtt2); ?>;
        if (checked < 1 && absMIDs == '') {
            toastr.warning('Please Select At Least One staff To Mark Abscorned.');
        } else {
            absIds = listsss;
            <?php if($todayAttCount2 > 0){ ?>
            markAbsRegister2(absIds, absMIDs);
            <?php } else {?>
            markAbsRegister(absIds);
            <?php }?>
        }
    })

})
</script>