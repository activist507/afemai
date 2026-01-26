<?php 
	$start = 2025;
	$end = 2025 + 50;

?>
<style>
.no-data {
    text-align: center;
    color: gray;
    font-style: italic;
}
</style>
<main id="main" class="main">
    <div class="container">

        <div class="card mt-0">
            <div class="card-footer bg-body-tertiary py-2 text-center">
				<div class="col-lg-12 pt-2">
					<div class="tom-select-custom">
						<input type="text" class="form-control text-center text-white fw-bold" value="IDEA MEMBERSHIP REGISTRATION" name=""
							style="background:rgba(18, 115, 100, 0.93);" disabled>
					</div>
				</div>
				<div class="row pt-1">
					<div class="col-lg-4">
					</div>
					<div class="col-lg-4 text-center mb-2">
						<img src="../storege/students/no_image.jpg" id="img_of_member" class="rounded-circle mx-4"
							alt="" style="width: 5rem; height: 5rem;" />
					</div>
					<div class="col-lg-4">
					</div>
				</div>
                <form action="" method="post" id="registration_form" enctype="multipart/form-data">
                    <div class="row gy-3">
                        <div class="col-lg-2 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" name="membership_id" placeholder="Search"
                                    id="membership_id" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Membership ID" value="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control" name="member_name" placeholder="Name"
                                    id="member_name" data-bs-toggle="tooltip" data-bs-placement="top" required
                                    title="Name">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" name="member_contact" placeholder="Contact"
                                    id="member_contact" data-bs-toggle="tooltip" data-bs-placement="top" required
                                    title="Contact">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control" name="member_comment" placeholder="Comment"
                                    id="member_comment" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Comment">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                               	<input type="text" class="form-control text-center" name="member_monthly_due" placeholder="Monthly Due"
                                    id="member_monthly_due" data-bs-toggle="tooltip" data-bs-placement="top" required style="background:rgba(201, 231, 226, 0.93);"
                                    title="Monthly Due">
                            </div>
                        </div>

                        <div class="col-lg-2 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" name="member_payment" placeholder="Payment"
                                    id="member_payment" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Payment">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center" disabled name="total_paid" placeholder="Total Paid"
                                    id="total_paid" data-bs-toggle="tooltip" data-bs-placement="top" style="background:rgba(201, 231, 226, 0.93);"
                                    title="Total Paid">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select class="form-control text-center" id="month" data-bs-toggle="tooltip" data-bs-placement="top"
									title="Month" required>
									<option value="0">Month</option>
									<option value="January">January</option>
									<option value="February">February</option>
									<option value="March">March</option>
									<option value="April">April</option>
									<option value="May">May</option>
									<option value="June">June</option>
									<option value="July">July</option>
									<option value="August">August</option>
									<option value="September">September</option>
									<option value="October">October</option>
									<option value="November">November</option>
									<option value="December">December</option>
								</select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select class="form-control text-center" id="year" data-bs-toggle="tooltip" data-bs-placement="top" title="Year" required>
									<option value="0">Year</option>
									<?php for($y=$start; $y <= $end; $y++){?>
										<option value="<?= $y?>"><?= $y?></option>
									<?php }?>
								</select>
                            </div>
                        </div>
                    </div>

                    <!--  -->
                    <div class="row gy-1 pt-3">
						<div class="col-lg-2 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                                <select class="form-control text-center" id="Role" data-bs-toggle="tooltip" data-bs-placement="top" title="Role" required>
									<option value="0">Role</option>
									<option value="Member">Member</option>
									<option value="Executive">Executive</option>
								</select>
                            </div>
                        </div>
						<div class="col-lg-2 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                               <input type="text" class="form-control text-center" name="bank_account" placeholder="Bank Account"
                                    id="bank_account" data-bs-toggle="tooltip" data-bs-placement="top" title="Bank Account"> 
                            </div>
                        </div>
						<div class="col-lg-2 col-sm-6 mb-2 mb-sm-0">
                            <div class="tom-select-custom">
                               <input type="text" class="form-control text-center" name="bank_name" placeholder="Bank Name"
                                    id="bank_name" data-bs-toggle="tooltip" data-bs-placement="top" title="Bank Name"> 
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 pb-2">
                            <input type="file" class="form-control" id="mem_img" name="img_file" accept="image/*" />
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <button type="submit" style="width: 8.5rem;" class="btn btn-primary w-100"
                                name="completeReg" id="submit_form_btn">
                                Submit
                            </button>
                        </div>
                    </div>
                    <!--  -->
                </form>

				<div class="row pt-3">
					<div class="col-lg-12 py-2">
						<div class="tom-select-custom">
							<input type="text" class="form-control text-center text-white fw-bold" value="CALCULATE SHARES" name=""
								style="background:rgba(18, 115, 100, 0.93);" disabled>
						</div>
					</div>
					<div class="col-6">
						<input type="text" name="declaredProfit" id="declaredProfit" class="form-control text-center" placeholder="Profit Declared" data-bs-toggle="tooltip" data-bs-placement="top" title="Declared Profit">
					</div>
					<div class="col-6">
						<button id="calcShare" class="btn btn-primary w-100">Cal Shares</button>
					</div>
				</div>

                <div class="table-responsive pt-0">
                    <div class="row py-2">
                        <div class="col-lg-2 col-sm-12 pt-2">
                            <select class="form-select" id="limit" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Entries Per Page">
                                <option selected value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-lg-4 col-sm-12 pt-2">
                            <div class="input-group">
                                <input type="text" placeholder="search" class="form-control" id="search">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered border-primary table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="text-nowrap">M-ID</th>
                                <th scope="col" class="text-nowrap">Name</th>
                                <th scope="col" class="text-nowrap">Contact</th>
                                <th scope="col" class="text-nowrap">Role</th>
                                <th scope="col" class="text-nowrap">Bank_Acct</th>
                                <th scope="col" class="text-nowrap">Bank_Name</th>
                                <th scope="col" class="text-nowrap">M_Due</th>
                                <th scope="col" class="text-nowrap">Total Paid</th>
                                <th scope="col" class="text-nowrap">L_Month</th>
                                <th scope="col" class="text-nowrap">L_Year</th>
                                <th scope="col" class="text-nowrap">Shares</th>
                                <th scope="col" class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody id="allMember">

                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination pagination-sm" id="pagination">
                            <!-- Pagination buttons -->
                        </ul>
                    </nav>
                </div>

                <!--  -->
                    <div class="row gy-3">                   
                        <div class="col-lg-6 col-sm-2 pt-2">
                           
                        </div>
                        <div class="col-lg-6 col-sm-2 pt-2">
                            <!-- <button type="button" style="width: 9rem;" class="btn btn-danger w-100" name="del_exam"
                                value="del_exam" id="del_exam">
                                Delete All Exam
                            </button> -->
                        </div>
                    </div>
                <!--  -->

            </div>
        </div>

    </div>
</main>
<script type="text/javascript">
$(document).ready(function() {


    $('#registration_form').on('submit', function(e) {
        e.preventDefault();

        var membership_id = $('#membership_id').val();
        var member_name = $('#member_name').val();
        var member_contact = $('#member_contact').val();
        var member_comment = $('#member_comment').val();
        var member_monthly_due = $('#member_monthly_due').val();
        var member_payment = $('#member_payment').val();
        var total_paid = $('#total_paid').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var Role = $('#Role').val();
        var bank_account = $('#bank_account').val();
        var bank_name = $('#bank_name').val();
        var mem_img = $('#mem_img').prop('files')[0];

        var sdata = new FormData();

        sdata.append("membership_id", membership_id);
        sdata.append("member_name", member_name);
        sdata.append("member_contact", member_contact);
        sdata.append("member_comment", member_comment);
        sdata.append("member_monthly_due", member_monthly_due);
        sdata.append("member_payment", member_payment);
        sdata.append("total_paid", total_paid);
        sdata.append("month", month);
        sdata.append("year", year);
        sdata.append("Role", Role);
        sdata.append("bank_account", bank_account);
        sdata.append("bank_name", bank_name);
        sdata.append("file", mem_img);
        sdata.append("type", "completeReg");

        $.ajax({
            url: '../admin/idea_member/registration_db.php',
            type: "POST",
            dataType: 'json',
            processData: false,
            contentType: false,
            data: sdata,
            success: function(response) {
                $.alert({
                    title: 'Message',
                    content: response.msg,
                    buttons: {
                        ok: function() {
                            $('#registration_form').trigger('reset');
                        }
                    }
                });
            },
            error: function(err) {
                console.log(err);
            }
        })
    })

    $('#membership_id').keyup(function(e) {
        var id = $(this).val();
        if (id.length == 4) {
            $('#submit_form_btn').val('Update');
            $('#submit_form_btn').text('Update');
            $.ajax({
                url: '../admin/idea_member/registration_db.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    "membership_id": id,
                    "type": "getMember"
                },
                success: function(response) {
                    if (response.query == 'true') {
                        $('#membership_id').val(response.membership_id);
                        $('#member_name').val(response.member_name);
                        $('#member_contact').val(response.member_contact);
                        $('#member_comment').val(response.member_comment);
                        $('#member_monthly_due').val(response.member_monthly_due);
                        $('#total_paid').val(response.total_paid);
                        $('#month').val(response.month);
                        $('#year').val(response.year);
                        $('#Role').val(response.role);
                        $('#bank_account').val(response.bank_account);
                        $('#bank_name').val(response.bank_name);
                        $('#img_of_member').attr("src", response.img);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
            // }
        } else if (id.length == 0) {
            $('#registration_form').trigger('reset');
            $('#img_of_member').attr("src", '../storege/students/no_image.jpg');
            $('#submit_form_btn').val('Submit');
            $('#submit_form_btn').text('Submit');
        }
    })

    $('#allMember').on('click', '.deleteQst', function() {
        var mID = $(this).attr("data-qid");
        $.confirm({
            title: 'CONFIRM',
            content: 'Are you sure you want to delete this member?',
            buttons: {
                confirm: {
                    btnClass: 'btn-green',
                    text: 'Yes',
                    action: function() {
                        $.ajax({
                            url: '../admin/idea_member/registration_db.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "mID": mID,
                                "type": "delete_member"
                            },
                            success: function(response) {
                                $.alert({
                                    title: 'Message',
                                    content: response.msg,
                                    buttons: {
                                        ok: function() {
                                            location.reload(true);
                                        }
                                    }
                                });
                            },
                            error: function(err) {
                                console.log(err);
                            }
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

    $('#allMember').on('click', '.clearPass', function() {
        var mID = $(this).attr("data-qid");
        $.confirm({
            title: 'CONFIRM',
            content: 'Are you sure you want to clear password?',
            buttons: {
                confirm: {
                    btnClass: 'btn-green',
                    text: 'Yes',
                    action: function() {
                        $.ajax({
                            url: '../admin/idea_member/registration_db.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "mID": mID,
                                "type": "reset_password"
                            },
                            success: function(response) {
                                $.alert({
                                    title: 'Message',
                                    content: response.msg,
                                    buttons: {
                                        ok: function() {
                                            location.reload(true);
                                        }
                                    }
                                });
                            },
                            error: function(err) {
                                console.log(err);
                            }
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

	$('#calcShare').click(function(){
		var profit = $('#declaredProfit').val();
		let regex = /^\d+$/;
		if(!regex.test(profit)){
			$.alert("Please Insert Number","Message");
		} else {
			$.confirm({
				title: 'CONFIRM',
				content: 'Are you sure you want to calculate shares?',
				buttons: {
					confirm: {
						btnClass: 'btn-green',
						text: 'Yes',
						action: function() {
							$.ajax({
								url: '../admin/idea_member/registration_db.php',
								type: "POST",
								dataType: 'json',
								data: {
									"profit": profit,
									"type": "calculateShares"
								},
								success: function(response) {
									$.alert({title: 'Message',content: response.msg});
									$('#declaredProfit').val('');
								},
								error: function(err) {
									console.log(err);
								}
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
		}
	})

	//not working yet
    $('#del_exam').click(function() {
        var typ = $('#del_exam').val();
        var session = $('#gen_Session').val();
        var term = $('#gen_Term').val();
        $.confirm({
            title: 'CONFIRM',
            content: 'Are you sure you want to delete all exam questions?',
            buttons: {
                confirm: {
                    btnClass: 'btn-green',
                    text: 'Yes',
                    action: function() {
                        $.ajax({
                            url: '../admin/idea_member/registration_db.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "session": session,
                                "term": term,
                                "type": "delete_all_exam"
                            },
                            success: function(response) {
                                $.alert({
                                    title: 'Message',
                                    content: response.msg,
                                    buttons: {
                                        ok: function() {
                                            location.reload(true);
                                        }
                                    }
                                });
                            },
                            error: function(err) {
                                console.log(err);
                            }
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

    // <!-- getting member  -->
    function loadData(page = 1, search = '') {
        const limit = $('#limit').val();
        $.ajax({
            url: '../admin/idea_member/registration_db.php',
            type: 'POST',
            data: {
                "page": page,
                "limit": limit,
                "search": search,
                "type": "paginateMember"
            },
            dataType: 'json',
            success: function(response) {
                $('#allMember').html(response.html);
                let pagination = '';
                // Previous Button
                pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                                        <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                                    </li>`;
                // Pages
                for (let i = 1; i <= response.totalPages; i++) {
                    pagination += `<li class="page-item ${response.currentPage == i ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                        </li>`;
                }
                // Next Button
                pagination += `<li class="page-item ${response.currentPage == response.totalPages ? 'disabled' : ''}">
                                        <a class="page-link" href="#" data-page="${response.currentPage + 1}">&raquo;</a>
                                    </li>`;
                $('#pagination').html(pagination);
            }
        });
    }
    loadData();

    $('#pagination').on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $('#search').val();
        if (page) {
            loadData(page, search);
        }
    });
    let typingTimer;
    $('#search').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            loadData(1, $('#search').val());
        }, 500); 
    });
    setInterval(() => {
        var activePge = parseInt($('#pagination li.active .page-link').text());
        if (isNaN(activePge)) {
            activePge = 1;
        }
        var serch = $('#search').val()
        loadData(activePge, serch);
    }, 3000);
})
</script>