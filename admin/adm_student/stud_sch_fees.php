<?php 
// $student_payment = $conn->query("SELECT * FROM student_payment ORDER BY ID DESC LIMIT 7");

    $session = $conn->query("SELECT * FROM tblsession");
    $branches = $conn->query("SELECT * FROM branches");
?>

<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-header py-0 d-flex flex-center bg-secondary justify-content-center">
                <h5 class="mb-0 text-white mt-2 text-uppercase text-center"><strong> Daily Fees Payment</strong>
                </h5>
            </div>
            <div class="card-body">
                <div class="row gx-2 mx-auto">
                    <div class="col-6 col-md-6 col-lg-3 pt-2">
                        <div class="tom-select-custom">
                            <select class="js-select form-select " name="branch" id="branch_">
                                <?php while($branch = $branches->fetch_object()):?>
                                <option value="<?= $branch->Branch_Name ?>"><?= $branch->Branch_Name ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3 pt-2">
                        <div class="tom-select-custom">
                            <select class="js-select form-select" name="term" id="term">
                                <option value="<?= $gen_term?>"><?= $gen_term?></option>
                                <option value="1st Term">1st Term</option>
                                <option value="2nd Term">2nd Term</option>
                                <option value="3rd Term">3rd Term</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3 pt-2">
                        <div class="tom-select-custom">
                            <select class="js-select form-select" name="session" id="session">
                                <option value="<?= $gen_session?>"><?= $gen_session?></option>
                                <?php while($sess = $session->fetch_object()):?>
                                <option value="<?=$sess->csession?>"><?=$sess->csession?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3 pt-2">
                        <div class="tom-select-custom">
                            <input type="date" class="form-control"  id="Date_" name="Date_" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 pt-2"></div>
                    <div class="col-6 col-lg-3 pt-2"></div>
                    <div class="col-6 col-lg-3 pt-2">
                        <button class="btn btn-danger w-100" id="cancelReceipt">Clear Receipt</button>
                    </div>
                    <div class="col-6 col-lg-3 pt-2">
                        <button class="btn btn-primary w-100" id="sendReceipt">Send Receipt</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="row mb-2 pt-2">
                    <div class="col-4">
                        <input type="text" name="cash" id="cash" class="form-control text-center w-100" value="0" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Cash" disabled>
                    </div>
                    <div class="col-4">
                        <input type="text" name="bank" id="bank" class="form-control text-center w-100" value="0"data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Bank" disabled>
                    </div>
                    <div class="col-4 ">
                        <input type="text" name="total" id="total" class="form-control text-center w-100" value="0" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Total" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="row py-2">
                                <div class="col-4 col-md-6 col-lg-2 pt-2">
                                    <select class="form-select" id="limit3" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Entries Per Page">
                                        <option selected value="8">8</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="col-8 col-md-6 col-lg-2 pt-2">
                                    <div class="input-group">
                                        <input type="text" placeholder="search" class="form-control" id="search3">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    </div>
                                </div>
                            </div>
                            <table class="table small table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-nowrap">Stud-ID</th>
                                        <th scope="col" class="text-nowrap">Name</th>
                                        <th scope="col" class="text-nowrap">Class</th>
                                        <th scope="col" class="text-nowrap">Phone</th>
                                        <th scope="col" class="text-nowrap">Option</th>
                                        <th scope="col" class="text-nowrap">Total Fee</th>
                                        <th scope="col" class="text-nowrap">Disc</th>
                                        <th scope="col" class="text-nowrap">Payable</th>
                                        <th scope="col" class="text-nowrap">Amt Paid</th>
                                        <th scope="col" class="text-nowrap">Balance</th>
                                        <th scope="col" class="text-nowrap">Pay Ref</th>
                                        <th scope="col" class="text-nowrap">SmsStatus</th>
                                        <th scope="col" class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="stdList">

                                </tbody>
                            </table>
                            <nav> <ul class="pagination pagination-sm" id="pagination3"></ul> </nav>
                            <!-- End Table with stripped rows new_plain_pass -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript">
$(document).ready(function() {

    function getDetAndSendFeesSms(student, ret = false) {
		return new Promise((resolve, reject) => {
			var concat = 'ID-' + student.Student_ID + ' ' + student.Fullnames +' Total Fees= ' + student.Total_Fees+', Discount= '+
            (student.Gen_Discount+student.Scholarship_Fee)+', Payable='+student.Amt_Payable+', Paid='+student.Amt_Paid+', Bal='+student.Balance
            +', Payment Receipt';
            $.ajax({
                url: '../admin/adm_student/stud_sch_fees_db.php',
                type: 'POST',
                dataType: 'json',
                data: {"phone":student.Phone_Number,"msg": concat,"type": "sendStdFeesSms"},
                success: function(response) {
                    if (response.status != 'error') {
                        var cnt = 1;
                        if (ret) {
                            resolve({
                                cost: response.cost,
                                balance: response.balance,
                                cnt: 1
                            });
                        } else {
                            resolve(cnt);
                        }
                        $.post("../admin/adm_student/stud_sch_fees_db.php",{"type":"updateStatus","id":student.ID},null,"json")
                    } else {
                        console.log(response);
                    }
                    // console.log(response)
                },
                error: function(err) {
                    console.log(err);
                    reject(err);
                }
            })
		});
	}

    // <!-- getting question  -->
    function loadData3(page = 1, search = '') {
        const limit = $('#limit3').val();
        const branch_ = $('#branch_').val();
        const term = $('#term').val();
        const session = $('#session').val();
        const Date_ = $('#Date_').val();
		
        $.ajax({
            url: '../admin/adm_student/stud_sch_fees_db.php',
            type: 'POST',
            data: {"page": page,"limit": limit, "search": search, "branch_": branch_,"term": term,"Date_":Date_,"limit": limit,"session": session,"type": "paginateStud"},
            dataType: 'json',
            success: function(response) {
                // console.log("Response from Server:", response);
                $('#stdList').html(response.html);
                $('#cash').val(response.cash);
                $('#bank').val(response.bank);
                $('#total').val(response.total);
                let pagination = '';

                // Previous Button
                pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                            </li>`;

                let totalPages = response.totalPages;
                let currentPage = response.currentPage;

                // If there are many pages, show only a subset
                if (totalPages <= 7) {
                    // Show all pages if total pages are small
                    for (let i = 1; i <= totalPages; i++) {
                        pagination += `<li class="page-item ${currentPage == i ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                    </li>`;
                    }
                } else {
                    // Always show first page
                    pagination += `<li class="page-item ${currentPage == 1 ? 'active' : ''}">
                                    <a class="page-link" href="#" data-page="1">1</a>
                                </li>`;

                    if (currentPage > 4) {
                        pagination +=
                            `<li class="page-item disabled"><a class="page-link">...</a></li>`;
                    }

                    // Show some middle pages dynamically
                    let startPage = Math.max(2, currentPage - 2);
                    let endPage = Math.min(totalPages - 1, currentPage + 2);

                    for (let i = startPage; i <= endPage; i++) {
                        pagination += `<li class="page-item ${currentPage == i ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                    </li>`;
                    }

                    if (currentPage < totalPages - 3) {
                        pagination +=
                            `<li class="page-item disabled"><a class="page-link">...</a></li>`;
                    }

                    // Always show last page
                    pagination += `<li class="page-item ${currentPage == totalPages ? 'active' : ''}">
                                    <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                                </li>`;
                }

                // Next Button
                pagination += `<li class="page-item ${currentPage == totalPages ? 'disabled' : ''}">
                                    <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                                </li>`;

                $('#pagination3').html(pagination);

            },
            error: function(err) {
                console.log(err)
            }
        });
    }
    loadData3();
    $(document).on('click', '#pagination3 .page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $('#search3').val(); // Ensure search is included
        if (page) {
            loadData3(page, search);
        }
    });
    let typingTimer;
    $('#search3').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            loadData3(1, $('#search3').val());
        }, 500); // delay to avoid too many requests
    });
    setInterval(() => {
        var activePge = parseInt($('#pagination3 li.active .page-link').text());
        if (isNaN(activePge)) {
            activePge = 1;
        }
        var serch = $('#search3').val()
        loadData3(activePge, serch);

		///////////////
		const branch = $('#branch_').val();
        const className = $('#class_').val();
        const term = $('#term').val();
        const session = $('#session').val();
    }, 3000);

    $('#stdList').on('click','.deletePayment',function(){
        const deleteID = $(this).attr("data-deleteID");
        $.confirm({
				title: 'CONFIRM',
				content: 'Are you sure you want to delete these records?',
				buttons: {
					confirm: {
						btnClass: 'btn-green',
						text: 'Yes',
						action: function() {
							$.ajax({
								url: '../admin/adm_student/stud_sch_fees_db.php',
								type: "POST",
								dataType: 'json',
								data: {"deleteID": deleteID,"type": "delete_from_payment"},
								success: function(response) { $.alert(response.msg,"Message")},
								error: function(err) { console.log(err) }
							})
						}
					},
					cancelAction: {
						btnClass: 'btn-red',
						text: 'No',
						close: function() {

						}
					},
				}
			});
    })

    //<!-------------------- Sending Receipt to Parents -------------------->
		$('#sendReceipt').click(function(e) {
			var branch_ = $('#branch_').val();
			var term = $('#term').val();
			var session = $('#session').val();
			var Date_ = $('#Date_').val();

			if (branch_ == '' || term == '' || session == '' || Date_ == '') {
				$.alert("An important field is missing","Message")
			} else {
				$.ajax({
					url: '../admin/adm_student/stud_sch_fees_db.php',
					type: 'POST',
					dataType: 'json',
					data: {"branch_": branch_,"term": term,"session": session,"Date_": Date_,"type": "getListToSendReceipt"},
					success: function(response) {
						if (response.query == 'false') {
                            $.alert("No student with such selections you made","Message")
						} else {
							// console.log(response);
							var lists = response.studentsList;
							var succCount = 0;
							$.each(lists, function(index, value) {
								setTimeout(async function() {
									if (index == lists.length - 1) {
										const {cnt,cost,balance} = await getDetAndSendFeesSms(value, true);
                                        succCount += parseInt(cnt);
                                        totalCost = succCount * cost;
                                        message = "Cost For each: "+ cost +" Total Cost = "+ totalCost +" Balance = "+balance;
                                        $.alert(message,"Message")
									} else {
										var successCount = await getDetAndSendFeesSms(value);
										succCount += parseInt(successCount);
									}
								}, index * 3000);
							})
						}
					},
					error: function(err) {
						console.log(err);
					}
				})
			}
		})
	//<!--------------------END Sending fees message to a class -------------------->

    //<!====== Clear receipt====>
        $('#cancelReceipt').click(function(){
            var branch_ = $('#branch_').val();
            var term = $('#term').val();
            var session = $('#session').val();
            var Date_ = $('#Date_').val();
            var data = {"branch_":branch_,"term":term,"session":session,"Date_":Date_,"type":"clearReceipt"};
            if (branch_ == '' || term == '' || session == '' || Date_ == '') {
                $.alert("An important field is missing","Message")
            } else {
                $.post("../admin/adm_student/stud_sch_fees_db.php",data,null,"json")
                .done(function(response){
                    $.alert("Receipt Cleared successfully","Message");
                })
                .fail(function(err){ console.log(err)});
            }
        })
    //<!====== Clear receipt====>
})
</script>