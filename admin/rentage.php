<?php 
    $sqlSection = $conn->query("SELECT * FROM cbt_section");
    $allsection = fetch_all_assoc($sqlSection);
    $sqlSessionn = $conn->query("SELECT * FROM tblsession");
    $sqlTermm = $conn->query("SELECT * FROM cbt_term");
    $banks = $conn->query("SELECT * FROM cbt_bank");
    
    // $sqlStudStat = $conn->query("SELECT * FROM cbt_stud_status");
    $sqlTransArea = $conn->query("SELECT * FROM cbt_trans_area");
?>
<style>
.table th,
.table td {
    border-width: 2px;
    border-color: #000;
}
</style>
<main class="main" id="main">
    <section class="section">
        <div class="card pb-2">
            <div class="card-body pb-2">

              <div class="row pt-2">
                <div class="col-lg-12">
                  <h5 class="card-title text-center pt-1 fw-bold text-uppercase" id="formTitle">Tenant Information </h5>
                </div>
              </div>

                <div class="row pt-0">
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-4 text-center mb-2">
                      <img src="../storege/students/no_image.jpg" id="img_of_stud" class="rounded-circle mx-4" alt=""style="width: 5rem; height: 5rem;" />
                    </div>
                    <div class="col-lg-4">
                    </div>
                </div>

                <form action="" class="g-3 pt-2" id="stdRegForm" method="POST" enctype="multipart/form-data">
                    <!-- student details -->
                    <div class="row pb-2 gy-2">
                        <div class="col-lg-2 col-sm-12">
                          <input type="hidden" id="hidden_T_ID" value="0">
                          <input type="text" class="form-control text-center pt-0" id="T_ID" name="T_ID" maxlength="4" placeholder="Tenant ID" />
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <input type="text" class="form-control pt-0" id="T_Name" name="T_Name" required placeholder="Fullnames" />
                        </div>
                        <div class="col-lg-2 col-sm-12">
                          <input type="date" class="form-control pt-0" id="Next_Date" name="Next_Date" required data-bs-toggle="tooltip" data-bs-placement="top" title="Next Due Date"/>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="T_Status" id="T_Status" class="form-select pt-0" required>
                                <option value="0">Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row pb-2 gy-2">
                      <div class="col-lg-2 col-sm-12">
                          <input type="text" class="form-control pt-0 text-center" id="Phone" name="Phone" placeholder="Phone"  required />
                        </div>
                      <div class="col-lg-10 col-sm-12">
                        <input type="text" class="form-control pt-0" id="H_Address" name="H_Address" placeholder="H_Address" required />
                      </div>
                    </div>

                    <div class="row pb-2 gy-2">
                      <div class="col-lg-2 col-sm-12">
                        <select name="Owned_By" id="Owned_By" class="form-select pt-0" required>
                          <option value="0">Select Owner</option>
                          <option value="HIRA">HIRA</option>
                          <option value="RAAID">RAAID</option>
                          <option value="EL-AMIN">EL-AMIN</option>
                        </select>
                      </div>
                      <div class="col-lg-10 col-sm-12">
                        <input type="text" class="form-control pt-0" id="Comment" name="Comment" placeholder="Comment" />
                      </div>
                    </div>

                    <div class="row pb-3 gy-3">
                      <div class="col-lg-2 col-sm-12">
                          <input type="text" class="form-control text-center pt-0 " name="paymentmade"
                              value="A_Payable" disabled style="background:rgba(233, 240, 239, 0.93);" />
                      </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold" id="A_Payable"
                                name="A_Payable" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Amount Payable" value="0" style="background:rgba(163, 235, 168, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 " name="paymentmade"
                                value="A_Paid" disabled style="background:rgba(233, 240, 239, 0.93);" />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 fw-bold" id="A_Paid"
                                name="A_Paid" data-bs-toggle="tooltip" data-bs-placement="top" title="A_Paid"
                                value="0" style="background:rgba(163, 235, 168, 0.93);"  />
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0 " name="Balance" value="Balance"
                                style="background:rgba(233, 240, 239, 0.93);" disabled />
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control text-center pt-0  fw-bold" id="Balance"
                                name="Balance" data-bs-toggle="tooltip" data-bs-placement="top" title="Balance"
                                value="0" style="background:rgba(157, 197, 239, 0.93);"  />
                        </div>
                    </div>
                    <div class="row pb-2 gy-2">
                      <div class="col-lg-2 col-sm-12">
                        <input type="text" disabled class="form-control text-center pt-0 fw-bold" id="N_ID" name="N_ID" maxlength="4"/>
                      </div>
                      <div class="col-2"></div>
                      <div class="col-2"></div>
                      <div class="col-2"></div>
                      <div class="col-lg-2 col-sm-12">
                         <button type="button" style="width: 8.7rem;" class="btn btn-danger w-100 mb-4" id="clearForm">
                          Clear
                        </button>
                      </div>
                      <div class="col-lg-2 col-sm-12">
                        <button type="submit" style="width: 8.7rem;" class="btn btn-primary w-100 mb-4" id="saveTenant">
                          Save
                        </button>
                      </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- Receipt section -->
        <div class="row">
          <div class="col-lg-12 col-sm-12">
              <div class="card info-card sales-card">
                  <div class="card-body">
                      <h5 class="card-title text-center"><strong><i>TENANTS HISTORY</i></strong></h5>

                      <div class="row py-2">
                          <div class="col-lg-3 col-sm-12">
                              <select class="form-select" id="limit2">
                                  <option selected value="20">20</option>
                                  <option value="20">20</option>
                                  <option value="50">50</option>
                                  <option value="100">100</option>
                              </select>
                          </div>
                          <div class="col-lg-3 col-sm-12">
                              <p class="small pt-2">Per Page</p>
                          </div>
                          <div class="col-lg-6 col-sm-12">
                              <div class="input-group">
                                  <input type="text" placeholder="search" class="form-control" id="search2"
                                      data-bs-toggle="tooltip" data-bs-placement="top" title="Search ID or Name">
                                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                              </div>
                          </div>
                      </div>

                      <table class="table small">
                          <thead>
                            <tr>
                              <th scope="col" >T_ID</th>
                              <th scope="col" class="text-nowrap">Name</th>
                              <th scope="col" class="text-center text-nowrap">Due Date</th>
                              <th scope="col" class="text-center">Status</th>
                              <th scope="col" class="text-center">Phone</th>
                              <th scope="col" class="text-nowrap">Address</th>
                              <th scope="col" class="text-center">Owned_By</th>
                              <th scope="col" class="text-nowrap">Comment</th>
                              <th scope="col" class="text-center">A_Payable</th>
                              <th scope="col" class="text-center">A_Paid</th>
                              <th scope="col" class="text-center">Balance</th>
                              <th scope="col" class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody id="unprinted">

                          </tbody>
                      </table>

                      <nav>
                          <ul class="pagination pagination-sm" id="pagination2">
                              <!-- Pagination buttons -->
                          </ul>
                      </nav>

                  </div>
              </div>
          </div>
        </div>
        <!--END Receipt section -->
    </section>
</main>


<!-- jQuery functions -->
<script type="text/javascript">
$(document).ready(function() {

  $('#saveTenant').click(function(e) {
      e.preventDefault(); //
    //<!--New Intake details -->
      var t_ID = $('#T_ID').val();
      var T_Name = $('#T_Name').val();
      var Next_Date = $('#Next_Date').val();
      var T_Status = $('#T_Status').val();
      var Phone = $('#Phone').val();
      var H_Address = $('#H_Address').val();
      var Owned_By = $('#Owned_By').val();
      var Comment = $('#Comment').val();
      var A_Payable = $('#A_Payable').val();
      var A_Paid = $('#A_Paid').val();
      var Balance = $('#Balance').val();
      var hidden_T_ID = $('#hidden_T_ID').val();


      var sdata = new FormData();
    // <!-- New Intake  details -->
      sdata.append("T_ID", t_ID);
      sdata.append("T_Name", T_Name);
      sdata.append("Next_Date", Next_Date);
      sdata.append("T_Status", T_Status);
      sdata.append("Phone", Phone);
      sdata.append("H_Address", H_Address);
      sdata.append("Owned_By", Owned_By);
      sdata.append("Comment", Comment);
      sdata.append("A_Payable", A_Payable);
      sdata.append("A_Paid", A_Paid);
      sdata.append("Balance", Balance);
      sdata.append("hidden_T_ID", hidden_T_ID);
      sdata.append("type", "saveTenant");


    if (T_Name == '' || Next_Date == '' || T_Status == '0' || Phone.length < 11 ||
        H_Address == '' || Owned_By == '0' || A_Payable == '0') {
        $.confirm({
            icon: 'bi bi-patch-question',
            theme: 'bootstrap',
            title: 'Message',
            content: 'An important field is missing',
            animation: 'scale',
            type: 'orange'
        })
    } else {
      $.ajax({
        url: 'rentage_db.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: sdata,
        success: function(result) {
          $.alert({title: 'Message',content: result.msg,});
        },
        error: function(result) {
          console.log(result);
        }
      })
      // Reset the form
      $('#stdRegForm').trigger('reset');
      $('#img_of_stud').attr("src", '../storege/students/no_image.jpg');
    }
  })

  function getDetails(id) {
    $.ajax({
      url: 'rentage_db.php',
      type: 'POST',
      dataType: 'json',
      data: {"T_ID": id,"type": "getTenantDetails"},
      success: function(response) {
        if (response.query == 'true') {
          $('#T_ID').val(response.T_ID);
          $('#T_Name').val(response.T_Name);
          $('#Next_Date').val(response.Next_Date);
          $('#T_Status').val(response.T_Status);
          $('#Phone').val(response.Phone);
          $('#H_Address').val(response.H_Address);
          $('#Owned_By').val(response.Owned_By);
          $('#Comment').val(response.Comment);
          $('#A_Payable').val(response.A_Payable);
          $('#A_Paid').val(response.A_Paid);
          $('#Balance').val(response.Balance);
          $('#hidden_T_ID').val(response.T_ID);
          $('#saveTenant').text('Update');
          // $('#formTitle').text('NEW INTAKE REGISTRATION');
        }
      },
      error: function(err) {
        console.log(err);
      }
    })
  }

  $('#T_ID').keyup(function(e){
    e.preventDefault();
    var tid = $(this).val();
    if(tid.length == 4){
      getDetails(tid);
    }
    if(tid.length == 0){
      clearForm();
    }
  })

    //cleear form
    function clearForm() {
      $('#stdRegForm').trigger('reset');
      $('#saveTenant').text('Save');
      $('#img_of_stud').attr("src", '../storege/students/no_image.jpg');
    }

    $('#clearForm').click(function(){clearForm()})


    /////
    $('#unprinted').on('click', '.tenant', function(e) {
      var checkID = $('#T_ID').val();
      var T_Name = $('#T_Name').val();
      if (checkID.length > 1 || T_Name != '') {
        $.confirm({
          icon: 'bi bi-patch-question',
          theme: 'bootstrap',
          title: 'Message',
          content: 'There is work in progress...please complete',
          animation: 'scale',
          type: 'orange'
        })
      } else {
        var id = $(this).attr('data-id');
        $('#T_ID').val(id);
        getDetails(id);
        $('html,body').animate({scrollTop: 0}, 'fast');
      }
    })

    /////
    $('#unprinted').on('click', '.deleteTenant', function() {
      var qId = $(this).attr("data-Nid");
      var allowDel = $('#allowdel').val();
      if (allowDel == 1) {
        $.confirm({
          title: 'CONFIRM',
          content: 'Are you sure you want to delete this Tenant?',
          buttons: {
            confirm: {
              btnClass: 'btn-green',
              text: 'Yes',
              action: function() {
                $.ajax({
                  url: 'rentage_db.php',
                  type: "POST",
                  dataType: 'json',
                  data: { "ID": qId,"type": "deleteTenant" },
                  success: function(response) {
                    $.alert({ title: 'Message',content: response.msg});
                    clearForm()
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


    ///////////////////////////
    function loadData2(page = 1, search = '') {
        const limit = $('#limit2').val();
        $.ajax({
            url: 'rentage_db.php',
            type: 'POST',
            data: {
                "page2": page,
                "limit2": limit,
                "search2": search,
                "type": "paginateTenant"
            },
            dataType: 'json',
            success: function(response) {
              $('#N_ID').val(response.N_ID);
                $('#unprinted').html(response.html);
                let pagination = '';
                // Previous Button
                pagination += `<li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage - 1}">&laquo;</a>
                              </li>`;
                // ===== Limit Page Numbers to Max 10 ===== //
                let start = response.currentPage - 4;
                let end = response.currentPage + 5;

                // Adjust if start or end goes out of bounds
                if (start < 1) {
                    end += 1 - start;
                    start = 1;
                }
                if (end > response.totalPages) {
                    start -= end - response.totalPages;
                    end = response.totalPages;
                }
                if (start < 1) start = 1;

                // Add page numbers from start to end
                for (let i = start; i <= end; i++) {
                    pagination += `<li class="page-item ${response.currentPage == i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                      </li>`;
                }
                // Next Button
                pagination += `<li class="page-item ${response.currentPage == response.totalPages ? 'disabled' : ''}">
                                <a class="page-link" href="#" data-page="${response.currentPage + 1}">&raquo;</a>
                              </li>`;
                $('#pagination2').html(pagination);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
    // Initial load
    loadData2();
    // <!-- Pagination Click Event  -->
    $('#pagination2').on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $('#search2').val();
        if (page) {
            loadData2(page, search);
        }
    });
    // <!-- END Pagination Click Event  -->

    // <!-- Search Keyup Event (debounced)  -->
    let typingTimer2;
    $('#search2').on('keyup', function() {
        clearTimeout(typingTimer2);
        typingTimer2 = setTimeout(function() {
            loadData2(1, $('#search2').val());
        }, 500); // delay to avoid too many requests
    });
    // <!--END Search Keyup Event (debounced)  -->

    // <!-- 3 seconds calling  -->
    setInterval(() => {
        var activePge = parseInt($('#pagination2 li.active .page-link').text());
        if (isNaN(activePge)) {
            activePge = 1;
        }
        // console.log(activePge)
        var serch = $('#search2').val()
        loadData2(activePge, serch);
    }, 3000);
    // <!-- 3 seconds calling  -->


})
</script>