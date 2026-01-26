<?php 
    // branch
    $branches = $conn->query("SELECT * FROM branches");
    // class 
    $cbt_class = $conn->query("SELECT * FROM cbt_class");
    $memorization_class = $conn->query("SELECT * FROM memorization_class");
    //session
    $session = $conn->query("SELECT * FROM tblsession");
?>

<main id="main" class="main">
    <section class="section">

	<div class="card mt-3">
            <div class="card-header py-0 d-flex flex-center bg-secondary justify-content-center">
                <h5 class="mb-0 text-white mt-2 text-uppercase text-center"><strong> Display Memorization Results Summary</strong>
                </h5>
            </div>
            <div class="card-footer bg-body-tertiary text-center">
                <form id="check_result_form">
                    <div class="row gx-2 mx-auto">
                        <div class="col-md-3 mb-sm-0 col-sm-6">
                            <div class="tom-select-custom">
                                <select class="js-select form-select " name="branch" id="branch_">
                                    <option value="none">Select Branch</option>
                                    <?php while($branch = $branches->fetch_object()):?>
                                    <option value="<?= $branch->Branch_Name ?>"><?= $branch->Branch_Name ?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="class" id="class_">
                                    <option value="none">Select Class</option>
                                    <?php while($class = $memorization_class->fetch_object()):?>
                                    <option value="<?=$class->id?>"><?=$class->class_name?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="term" id="term">
                                    <option value="none">Select Term</option>
                                    <option value="1">1st Term</option>
                                    <option value="2">2nd Term</option>
                                    <option value="3">3rd Term</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-sm-0 col-sm-6">
                            <div class="tom-select-custom">
                                <select class="js-select form-select" name="session" id="session">
                                    <option value="none">Select session</option>
                                    <?php while($sess = $session->fetch_object()):?>
                                    <option value="<?=$sess->csession?>"><?=$sess->csession?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="row py-2">
                                <div class="col-lg-4 col-sm-6 pt-2">
                                    <select class="form-select" id="limit3" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Entries Per Page">
                                        <option selected value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="col-lg-8 col-sm-6 pt-2">
                                    <div class="input-group">
                                        <input type="text" placeholder="search" class="form-control" id="search3">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    </div>
                                </div>
                            </div>
                            <table class="table small table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" nowrap="nowrap">ID</th>
                                        <th scope="col" nowrap="nowrap">Name</th>
                                        <th scope="col" nowrap="nowrap">T_Score</th>
										<th scope="col" nowrap="nowrap">Position</th>
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
    // <!-- getting question  -->
    function loadData3(page = 1, search = '') {
        const limit = $('#limit3').val();
        const branch_ = $('#branch_').val();
        const class_ = $('#class_').val();
        const term = $('#term').val();
        const session = $('#session').val();
		
        $.ajax({
            url: '../admin/manage_result_memo/display_result_db.php',
            type: 'POST',
            data: {"page": page,"limit": limit, "search": search, "branch_": branch_,"class_": class_,"term": term,"limit": limit,"session": session,"type": "paginateStud"},
            dataType: 'json',
            success: function(response) {
                // console.log("Response from Server:", response);
                $('#stdList').html(response.html);
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

		// ///////////////
		// const branch = $('#branch_').val();
        // const className = $('#class_').val();
        // const term = $('#term').val();
        // const session = $('#session').val();
        // $.ajax({
        //     url: '../admin/manage_result_memo/enter_result_db.php',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: {"type": "auto_id_rec","branch":branch,"className":className,"session":session,"term":term},
        //     success: function(response) {
        //         $('#outOf').val(response.total);
        //         $('#Pass').val(response.pass);
        //         $('#Fail').val(response.failed);
        //     },
        //     error: function(err) {
        //         console.log(err)
        //     }
        // });
		// /////////////////////////
    }, 3000);
});
</script>