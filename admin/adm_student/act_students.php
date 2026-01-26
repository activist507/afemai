<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <h5 class="card-title">Active Student Total = <?= $stud_total_all ?> </h5>
                            <div class="row py-2">
                                <div class="col-lg-4 col-sm-12">
                                    <select class="form-select" id="limit3" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Entries Per Page">
                                        <option selected value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="col-lg-8 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" placeholder="search" class="form-control" id="search3">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    </div>
                                </div>
                            </div>
                            <table class="table small">
                                <thead>
                                    <tr>
                                        <th scope="col" nowrap="nowrap">ID</th>
                                        <th scope="col" nowrap="nowrap">Name</th>
                                        <th scope="col" nowrap="nowrap">Class</th>
                                        <th scope="col" nowrap="nowrap">Password</th>
                                        <th scope="col" nowrap="nowrap">Branch</th>
                                        <th scope="col" nowrap="nowrap">Phone</th>
                                        <th scope="col" nowrap="nowrap">Total Sch Fee</th>
                                        <th scope="col" nowrap="nowrap">Disc</th>
                                        <th scope="col" nowrap="nowrap">Payable</th>
                                        <th scope="col" nowrap="nowrap">Paid</th>
                                        <th scope="col" nowrap="nowrap">Balance</th>
                                        <!-- <th scope="col" nowrap="nowrap">Action</th> -->
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
        $.ajax({
            url: '../admin/adm_student/act_students_db.php',
            type: 'POST',
            data: {
                "page": page,
                "limit": limit,
                "search": search,
                "type": "paginateStud"
            },
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
    }, 3000);

});
</script>