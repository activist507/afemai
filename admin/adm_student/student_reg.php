<?php 
    $sqlSection = $conn->query("SELECT * FROM cbt_section");
	$allsection = fetch_all_assoc($sqlSection);
    $sqlSes = $conn->query("SELECT * FROM tblsession");
    $sqlSessionn = fetch_all_assoc($sqlSes);
    $sqlTermm = $conn->query("SELECT * FROM cbt_term");
    $banks = $conn->query("SELECT * FROM banks");
    $sqlStudStat = $conn->query("SELECT * FROM cbt_stud_status");
    for($i = 1;$i<11;$i++){
        $column = 'Location'.$i;
        $column1 = 'Cat'.$i;
        $column2 = 'Amount'.$i;
        $sql = $conn->query("SELECT {$column},{$column1},{$column2} FROM fees_determination WHERE Term='$gen_term' AND Branch='$gen_branch'")->fetch_object();
        $TransArea[$column] = $sql->{$column};
        $sholarshipType[$column2] = $sql->{$column1};
    }
    // $sqlTransArea = $conn->query("SELECT * FROM cbt_trans_area");
?>

<main class="main" id="main">
    <section class="section">
        <div class="card pb-2">
            <div class="card-body pb-2">

                <div class="row pt-2">
                    <div class="col-lg-12">
                        <h5 class="card-title text-center pt-1">STUDENT REGISTRATION</h5>
                    </div>
                </div>

                <div class="row pt-0">
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-4 text-center mb-2">
                        <img src="../storege/students/no_image.jpg" id="img_of_stud" class="rounded-circle mx-4" alt=""
                            style="width: 5rem; height: 5rem;" />
                    </div>
                    <div class="col-lg-4">
                    </div>
                </div>

                <form action="" class="g-3 pt-2" id="stdRegForm" method="POST" enctype="multipart/form-data">
                    <!-- student details -->
                        <input type="hidden" id="role_db" value="<?= $role?>">
                        <input type="hidden" id="branch_db" value="<?= $staff_branch?>">
                        <div class="row pb-2 gy-1">
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="Student_ID" name="Student_ID"
                                    maxlength="4" placeholder="Search" inputmode="numeric" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="std_gender" id="std_gender" class="form-control pt-0" required>
                                    <option>Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <input type="text" class="form-control pt-0" id="Fullnames" name="Fullnames" required
                                    placeholder="Fullnames" />
                            </div>
                        </div>
                    <div id="section_one">
                        <!-- Select Status -->
                        <div class="row pb-2 gy-1">
                            <div class="col-12 col-md-6 col-lg-2">
                                <input type="text" class="form-control pt-0" id="ArabicName" name="ArabicName"
                                    placeholder="ArabicName" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Arabic Name" dir="auto"/>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" value="Date Of Birth" class="form-control pt-0" disabled />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="date" class="form-control pt-0" id="std_dob" name="std_dob" required />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="std_status" id="std_status" class="form-control pt-0" required>
                                    <option value="0">Select Status</option>
                                    <?php while($status = $sqlStudStat->fetch_object()){?>
                                    <option value="<?= $status->status?>"><?= $status->status?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="year_graduated" id="year_graduated" class="form-control pt-0" disabled>
                                    <option value="0">Year Grad</option>
                                    <?php foreach($sqlSessionn as $session){?>
                                    <option value="<?= $session['csession']?>"><?= $session['csession']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="std_Session" id="std_Session" class="form-control pt-0" required>
                                    <option value="0">Sess. Admitted</option>
                                    <?php foreach($sqlSessionn as $session){?>
                                    <option value="<?= $session['csession']?>"><?= $session['csession']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="Std_Term" id="Std_Term" class="form-control pt-0" required>
                                    <option value="0">Term Admitted</option>
                                    <?php while($term = $sqlTermm->fetch_object()){?>
                                    <option value="<?= $term->term?>"><?= $term->term?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="Std_section" id="std_section" class="form-control pt-0" required>
                                    <option value="0">Sect. Admitted</option>
                                    <?php foreach($allsection as $section){?>
                                    <option value="<?= $section['section']?>"><?= $section['section']?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="std_Class" id="std_class" class="form-control pt-0" required>
                                    <option value="0">Class Admitted</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input name="date_admitted" id="date_admitted" placeholder="Date Admitted" class="form-control pt-0">
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="std_branch" id="std_branch" class="form-control pt-0" required>
                                    <option value="0">Select Branch</option>
                                    <?php foreach($branches_rows as $branc){?>
                                    <option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>
                            
                            
                        </div>
                        <!-- End student details -->

                        <!-- Parent/Guardian info -->
                        <div class="row pb-2 gy-1">
                            <div class="col-12 col-sm-12">
                                <input type="file" class="form-control pt-0" id="std_img" name="std_img" />
                            </div>
                            <div class="col-12 py-2">
                                <div class="tom-select-custom">
                                    <input type="text" class="form-control text-center text-white fw-bold" value="PARENT/GUARDIAN INFORMATION"
                                        style="background:rgba(18, 115, 100, 0.93);" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <input type="text" class="form-control pt-0" id="Std_parent" name="Std_parent"
                                    placeholder="Parent Name" required />
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <input type="text" class="form-control pt-0" id="std_phone" name="std_phone"
                                    placeholder="Phone Number" required />
                            </div>
                        </div>

                        <div class="row pb-2 gy-1">
                            <div class="col-12 col-md-6 col-lg-4">
                                <input type="text" class="form-control pt-0" id="Std_email" name="Std_email"
                                    placeholder="Email" />
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <input type="text" class="form-control pt-0" id="Std_address" name="Std_address"
                                    placeholder="Address" required />
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <input type="text" class="form-control pt-0" id="std_comment" name="std_comment"
                                    placeholder="Comment" />
                            </div>
                        </div>

                        <!-- school fees determination -->
                        <div class="row pb-3 gy-1">
                            <div class="col-12 py-1">
                                <div class="tom-select-custom">
                                    <input type="text" class="form-control text-center text-white fw-bold" value="SCHOOL FEES DETERMINATION"
                                        style="background:rgba(18, 115, 100, 0.93);" disabled>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="entry_type" id="entry_type" class="form-control fees_deter pt-0">
                                    <option value="0">S_Entry Type</option>
                                    <option value="Old">Old</option>
                                    <option value="Nur New">Nur New</option>
                                    <option value="Pry New">Pry New</option>
                                    <option value="Jnr.Sec New">Jnr.Sec New</option>
                                    <option value="Snr.Sec New">Snr.Sec New</option>
                                    <option value="Diploma1">Diploma1</option>
                                    <option value="Diploma2">Diploma2</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select id="std_trans" name="std_trans" class="form-control fees_deter pt-0">
                                    <option value="0">Transp. Area</option>
                                    <?php foreach($TransArea as $key=>$value){?>
                                    <option value="<?= $key?>"><?= $value?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="Std_cur_section" id="std_cur_section" class="form-control fees_deter pt-0"
                                    required>
                                    <option value="0">Current Section</option>
                                    <?php foreach($allsection as $section){?>
                                    <option value="<?= $section['section']?>"><?= $section['section']?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="std_cur_Class" id="std_cur_class" class="form-control fees_deter pt-0"
                                    required>
                                    <option>Select Class</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="ext_exam" id="ext_exam" class="form-control fees_deter pt-0">
                                    <option value="None">External Exam</option>
                                    <option value="Pry6 Exam">Pry6 Exam</option>
                                    <option value="Junior WAEC">Junior WAEC</option>
                                    <option value="Senior WAEC">Senior WAEC</option>
                                    <option value="Senior NECO">Senior NECO</option>
                                    <option value="WAEC & NECO">WAEC & NECO</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="Std_adm_type" id="Std_adm_type" class="form-control fees_deter pt-0" required>
                                    <option>Admission Type</option>
                                    <option value="Day">Day</option>
                                    <option value="NurSec">Nur Boarding</option>
                                    <option value="PrySec">Pry Boarding</option>
                                    <option value="JssSec">Jss Boarding</option>
                                    <option value="SsSec">SS Boarding</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="scholarship_determination" id="scholarship_determination" class="form-control pt-0" required>
                                    <option value="0">Scholarship Type</option>
                                    <?php foreach($sholarshipType as $key=>$value){?>
                                    <option value="<?= $key?>"><?= $value?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="tax_option" id="tax_option" class="form-control " required>
                                    <option value="0">Tax Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control text-center" id="std_pin" name="std_pin">
                            </div>
                            

                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100 mb-4"
                                    id="continue_btn" value="button">
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="section_two" class="d-none">
                        <!-- Entry Fee -->
                        <div class="row pb-3 gy-1">
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="prev_debt_amt"
                                    name="prev_debt_amt" value="0" style="background:rgba(233, 240, 239, 0.93);"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Pre Debt" readonly />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="entry_type_amt" value="0"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Entry Fee" readonly
                                    style="background:rgba(233, 240, 239, 0.93);" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="std_cur_section_amt"
                                    name="std_amt_paid" value="0" style="background:rgba(233, 240, 239, 0.93);"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Sch Fees + PTA" readonly />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="std_trans_amt"
                                    name="std_trans_amt" value="0" style="background:rgba(233, 240, 239, 0.93);"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Trasport" readonly />
                            </div>
                            
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="std_cur_class_amt"
                                    name="std_cur_class_amt" value="0" style="background:rgba(233, 240, 239, 0.93);"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Books" readonly />
                            </div>
                            

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="ext_exam_amt"
                                    name="ext_exam_amt" value="0" style="background:rgba(233, 240, 239, 0.93);"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Exam" readonly />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="Std_adm_type_amt"
                                    name="Std_adm_type_amt" value="0" style="background:rgba(233, 240, 239, 0.93);"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Boarding" readonly />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0 cbt_misc" id="std_cbt_les"
                                    name="std_cbt_les" value="0" style="background:rgba(163, 235, 168, 0.93);"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="CBT/Lesson" readonly />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0 cbt_misc" id="Std_misc_cert"
                                    name="Std_misc_cert" value="0" style="background:rgba(231, 122, 233, 0.93);"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Misc/Cert" readonly />
                            </div>

                            <!-- payment info -->
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="std_tot_fees"
                                    name="std_tot_fees" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Fees"
                                    value="0" readonly style="background:rgba(233, 240, 239, 0.93);" />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="number" class="form-control text-center pt-0" id="std_scholar"
                                    name="std_scholar" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Scholarship Fee" value="0" readonly
                                    style="background:rgba(233, 240, 239, 0.93);" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="number" class="form-control text-center pt-0" id="std_dis_fees"
                                    name="std_dis_fees" data-bs-toggle="tooltip" data-bs-placement="top" title="Discount"
                                    value="0" readonly style="background:rgba(208, 218, 160, 0.93);" />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="std_amt_pay" name="std_amt_pay"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Amount Payable" value="0"
                                    readonly style="background:rgba(233, 240, 239, 0.93);" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="number" class="form-control text-center pt-0" id="std_amt_paid"
                                    name="std_amt_paid" data-bs-toggle="tooltip" data-bs-placement="top" title="Amount Paid"
                                    value="0" readonly style="background:rgba(140, 132, 228, 0.93);" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="" name=""
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Empty" value="Empty" disabled
                                    readonly style="background:rgba(233, 240, 239, 0.93);" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="std_bal" name="std_bal"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Balance" value="0" readonly
                                    style="background:rgba(233, 240, 239, 0.93);" />
                            </div>
                        </div>

                        <!-- Amount Payable -->
                        <div class="row pb-3 gy-1 d-none">
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="tution_fee" name=""
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Tution Fee"
                                    placeholder="Tution Fee" readonly style="background:rgba(233, 240, 239, 0.93);" />
                            </div>

                            
                        </div>

                        <div class="row pb-3 gy-1">
                            <div class="tom-select-custom">
                                <input type="text" class="form-control text-center text-white fw-bold" value="SCHOOL FEES PAYMENT"
                                    style="background:rgba(18, 115, 100, 0.93);" disabled>
                            </div>
                            <div class="col-12 col-lg-2">
                                <input type="text" class="form-control pt-0 text-center control_pay_btn" inputmode="numeric" id="prev_debt_new" name="prev_debt_new" placeholder="Prev Debt" 
                                style="background:rgba(233, 240, 239, 0.93);"/>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0 control_pay_btn" id="pay_mis_cert"
                                    name="paymentmade" data-bs-toggle="tooltip" data-bs-placement="top" inputmode="numeric"
                                    title="Pay Mics/Cert" value="0" style="background:rgba(231, 122, 233, 0.93);" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0 control_pay_btn" id="pay_cbt_less"
                                    name="paymentmade" data-bs-toggle="tooltip" data-bs-placement="top" inputmode="numeric"
                                    title="Pay CBT/Lesson" value="0" style="background:rgba(163, 235, 168, 0.93);" />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0 control_pay_btn" id="discgiven"
                                    name="discgiven" data-bs-toggle="tooltip" data-bs-placement="top" inputmode="numeric" title="Pay Discount"
                                    value="0" style="background:rgba(208, 218, 160, 0.93);" />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0 control_pay_btn" id="paymentmade"
                                    name="paymentmade" data-bs-toggle="tooltip" data-bs-placement="top" inputmode="numeric" title="A_Paid"
                                    value="0" style="background:rgba(140, 132, 228, 0.93);" />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="pay_option" id="pay_option" class="form-control pt-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Pay Option" style="background:rgba(117, 202, 189, 0.93);">
                                    <option>Pay Option</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>

                            <div class="col-6 col-md-6 col-lg-2">
                                <select name="Bank" id="Bank" class="form-control pt-0" data-bs-toggle="tooltip" disabled
                                    data-bs-placement="top" title="Select Bank" style="background:rgba(119, 210, 196, 0.93);">
                                    <option value="Cash">Select Bank</option>
                                    <?php while($bank = $banks->fetch_object()){?>
                                    <option value="<?= $bank->Bank_Name?>"><?= $bank->Bank_Name?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center pt-0" id="reference" name="reference" data-bs-toggle="tooltip" 
                                data-bs-placement="top"  title="Reference" />
                            </div>

                            <div class="col-12 pt-2">
                                <button type="btn" style="width: 8.7rem;" class="btn btn-primary w-100 pt-0 disabled"
                                    id="add_btn" value="addition">
                                    Pay
                                </button>
                            </div>
                        </div>

                        <div class="row pb-3 gy-1">
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center mb-3" id="Last_ID" name="Student_ID"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Last ID" maxlength="4"
                                    placeholder="Student_ID" style="background:rgba(233, 240, 239, 0.93);" readonly />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2">
                                <input type="text" class="form-control text-center mb-3" id="Pay_Ref" name="Pay_Ref"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Receipt No" readonly
                                    style="background:rgba(233, 240, 239, 0.93);" />
                            </div>
                        </div>
                        <div class="row pb-2 gy-0">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100 mb-4"
                                    id="previous_btn" value="button">
                                    Previous
                                </button>
                                
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100 mb-4"
                                    id="stud_reg_btn" value="Submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>


<!-- jQuery functions -->
<script type="text/javascript">
$(document).ready(function() {

    // // disable the pay btn depending on the four input field
    $('.control_pay_btn').keyup(function() {
        var totalValue = 0;
        $('.control_pay_btn').each(function() {
            const inputValue = parseInt($(this).val());
            if (!isNaN(inputValue)) {
                totalValue += inputValue;
            }
        })
        if (totalValue != 0) {
            $('#add_btn').removeClass('disabled');
            $('#stud_reg_btn').addClass('disabled');
        }
        if (totalValue == 0) {
            $('#add_btn').addClass('disabled');
            $('#stud_reg_btn').removeClass('disabled');
        }
    });

    $('#std_section').change(function() {
        var sect = $('#std_section').val();
        var gen_Term = $('#gen_Term').val();
        var gen_branch = $('#gen_branch').val();
        if (sect == 0) {
            $("#std_class").attr("disabled", true);
        } else {
            $("#std_class").removeAttr("disabled");
            $.ajax({
                // url: './admFunctions.php',
                url: '../admin/adm_student/student_reg_db.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    "type": "getClassFromSection",
                    "term": gen_Term,
                    "branch": gen_branch,
                    "section": sect
                },
                success: function(response) {
                    $('#std_class').html(response.html);
                    // $('#main').html(response.html);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    })

    $('#std_cur_section').change(function() {
        var sect = $('#std_cur_section').val();
        var gen_Term = $('#gen_Term').val();
        var gen_branch = $('#gen_branch').val();
        if (sect == 0) {
            $("#std_cur_class").attr("disabled", true);
        } else {
            $("#std_cur_class").removeAttr("disabled");
            $.ajax({
                // url: './admFunctions.php',
                url: '../admin/adm_student/student_reg_db.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    "type": "getClassFromSection",
                    "term": gen_Term,
                    "branch": gen_branch,
                    "section": sect,
                },
                success: function(response) {
                    $('#std_cur_class').html(response.html);
                    $('#tution_fee').val(response.tution_fee);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    })

    $('#stdRegForm').on('submit', function(e) {
        // $('#stud_reg_btn').click(function(e) {
        e.preventDefault(); //

        //<!-- student details -->
        var Student_ID = $('#Student_ID').val();
        var Fullnames = $('#Fullnames').val();
        var ArabicName = $('#ArabicName').val();
        var std_gender = $('#std_gender').val();
        var std_dob = $('#std_dob').val();
        var std_status = $('#std_status').val();
        var std_Session = $('#std_Session').val();
        var Std_Term = $('#Std_Term').val();
        var std_section = $('#std_section').val();
        var std_class = $('#std_class').val();
        var std_branch = $('#std_branch').val();
        var std_pin = $('#std_pin').val();
        var date_admitted = $('#date_admitted').val();
        var year_graduated = $('#year_graduated').val();
        


        // <!-- Parent/Guardian info -->
        var std_img = $('#std_img')[0].files[0];
        // var std_img = $('#std_img').prop('files')[0];

        var Std_parent = $('#Std_parent').val();
        var std_phone = $('#std_phone').val();
        var Std_email = $('#Std_email').val();
        var Std_address = $('#Std_address').val();
        var std_comment = $('#std_comment').val();

        //<!-- school fees determination -->
        var entry_type = $('#entry_type').val();
        var std_trans = $('#std_trans').val();
        var std_cur_section = $('#std_cur_section').val();
        var std_cur_class = $('#std_cur_class').val();
        var ext_exam = $('#ext_exam').val();
        var Std_adm_type = $('#Std_adm_type').val();
        var scholarship_determination = $('#scholarship_determination').val();
        var tax_option = $('#tax_option').val();
        
        //<!-- School fees details -->
        var entry_type_amt = $('#entry_type_amt').val();
        var std_trans_amt = $('#std_trans_amt').val();
        var std_cur_section_amt = $('#std_cur_section_amt').val();
        var std_cur_class_amt = $('#std_cur_class_amt').val();
        var prev_debt_amt = $('#prev_debt_amt').val();
        var ext_exam_amt = $('#ext_exam_amt').val();
        var Std_adm_type_amt = $('#Std_adm_type_amt').val();
        var std_cbt_les = $('#std_cbt_les').val();
        var Std_misc_cert = $('#Std_misc_cert').val();

        //<!-- payment info -->
        var std_tot_fees = $('#std_tot_fees').val();
        var std_scholar = $('#std_scholar').val();
        var std_dis_fees = $('#std_dis_fees').val();
        var tution_fee = $('#tution_fee').val();
        var std_amt_pay = $('#std_amt_pay').val();
        var std_amt_paid = $('#std_amt_paid').val();
        var std_bal = $('#std_bal').val();
        var meth = $('#stud_reg_btn').val();

        //<!-- extra info -->
        var pay_option = $('#pay_option').val();
        var bank = $('#Bank').val();
        // var bank_ref = $('#bank_ref').val(); 
        var pay_ref = $('#Pay_Ref').val();
        var gen_Term = $('#gen_Term').val();
        var gen_branch = $('#gen_branch').val();
        var gen_Session = $('#gen_Session').val();

        var sdata = new FormData();

        // <!-- student details -->
        sdata.append("Student_ID", Student_ID);
        sdata.append("Fullnames", Fullnames);
        sdata.append("ArabicName", ArabicName);
        sdata.append("std_gender", std_gender);
        sdata.append("std_dob", std_dob);
        sdata.append("std_status", std_status);
        sdata.append("std_Session", std_Session);
        sdata.append("Std_Term", Std_Term);
        sdata.append("std_section", std_section);
        sdata.append("std_class", std_class);
        sdata.append("std_branch", std_branch);
        sdata.append("std_pin", std_pin);
        sdata.append("date_admitted", date_admitted);
        sdata.append("year_graduated", year_graduated);


        sdata.append("image", std_img);
        sdata.append("Std_parent", Std_parent);
        sdata.append("std_phone", std_phone);
        sdata.append("Std_email", Std_email);
        sdata.append("Std_address", Std_address);
        sdata.append("std_comment", std_comment);

        //<!-- school fees determination -->
        sdata.append("entry_type", entry_type);
        sdata.append("std_trans", std_trans);
        sdata.append("std_cur_section", std_cur_section);
        sdata.append("std_cur_class", std_cur_class);
        sdata.append("ext_exam", ext_exam);
        sdata.append("Std_adm_type", Std_adm_type);
        sdata.append("scholarship_determination", scholarship_determination);
        sdata.append("tax_option", tax_option);
        

        //<!-- School fees details -->
        sdata.append("entry_type_amt", entry_type_amt);
        sdata.append("std_trans_amt", std_trans_amt);
        sdata.append("std_cur_section_amt", std_cur_section_amt);
        sdata.append("std_cur_class_amt", std_cur_class_amt);
        sdata.append("prev_debt_amt", prev_debt_amt);
        sdata.append("ext_exam_amt", ext_exam_amt);
        sdata.append("Std_adm_type_amt", Std_adm_type_amt);
        sdata.append("std_cbt_les", std_cbt_les);
        sdata.append("Std_misc_cert", Std_misc_cert);

        //<!-- payment info -->
        sdata.append("std_tot_fees", std_tot_fees);
        sdata.append("std_scholar", std_scholar);
        sdata.append("std_dis_fees", std_dis_fees);
        sdata.append("tution_fee", tution_fee);
        sdata.append("std_amt_pay", std_amt_pay);
        sdata.append("std_amt_paid", std_amt_paid);
        sdata.append("std_bal", std_bal);

        //<!-- extra info -->
        sdata.append("Pay_Option", pay_option);
        sdata.append("Bank", bank);
        // sdata.append("bank_ref", bank_ref);
        sdata.append("Pay_Ref", Pay_Ref);
        sdata.append("gen_Term", gen_Term);
        sdata.append("gen_branch", gen_branch);
        sdata.append("gen_Session", gen_Session);


        sdata.append("method", meth);
        sdata.append("type", "submitStdReg");


        if (std_branch == '0' || std_section == '0') {
            console.log('An important field is missing');
        } else {
            $.ajax({
                // url: './admFunctions.php',
                url: '../admin/adm_student/student_reg_db.php',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: sdata,
                success: function(result) {
                    $.confirm({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: result.msg,
                        animation: 'scale',
                        type: 'orange'
                    })
                    $('#hidID').val(result.lastID);
                    var lasid = result.lastID;
                },
                error: function(result) {
                    console.log(result);
                }
            })
        }

        // Reset the form
        $('#stdRegForm').trigger('reset');
        $('#std_trans').val('0');
        $('#std_cur_section').val('0');
        $('#std_cur_class').html('<option>Select Class</option>');
        $('#img_of_stud').attr("src", '../storege/students/no_image.jpg');
        $('#Student_ID').attr("disabled",false);
    })

    //adding to discount and amount paid
    $('#add_btn').click(function(e) {
        e.preventDefault();
        var pay_option = $('#pay_option').val();
        var Bank = $('#Bank').val();
        var reference = $('#reference').val();
        console.log(pay_option,Bank,reference);
        if(pay_option == 'Pay Option' || reference == '' || Bank == ''){
            $.alert('Please select pay_option/bank/Reference','Message')
        } else {
            $.confirm({
                icon: 'bi bi-patch-question',
                theme: 'bootstrap',
                title: 'Message',
                content: 'Do You want to Submit This Payment?',
                animation: 'scale',
                type: 'orange',
                buttons: {
                    Yes: function() {
                        // CBT Payment
                        $('#std_cbt_les').val(parseInt($('#std_cbt_les').val()) + parseInt($('#pay_cbt_less').val()));

                        // Misc Payment
                        $('#Std_misc_cert').val(parseInt($('#Std_misc_cert').val()) + parseInt($('#pay_mis_cert').val()));

                        // Disc Payment
                        $('#std_dis_fees').val(parseInt($('#std_dis_fees').val()) + parseInt($('#discgiven').val()));

                        // Amount Paid
                        $('#std_amt_paid').val(parseInt($('#std_amt_paid').val()) + parseInt($('#paymentmade').val()));


                        // Total School Fees
                        $('#std_tot_fees').val(
                            parseInt($('#entry_type_amt').val()) + parseInt($('#std_trans_amt').val()) + parseInt($('#std_cur_section_amt').val()) + 
                            parseInt($('#std_cur_class_amt').val()) + parseInt($('#prev_debt_amt').val()) + parseInt($('#ext_exam_amt').val()) +
                            parseInt($('#Std_adm_type_amt').val()) + parseInt($('#std_cbt_les').val()) + parseInt($('#Std_misc_cert').val())
                        );

                        // Amount Payable
                        $('#std_amt_pay').val(parseInt($('#std_tot_fees').val()) - parseInt($('#std_scholar').val()) - parseInt($('#std_dis_fees').val()));

                        // Balance
                        $('#std_bal').val(
                            parseInt($('#std_tot_fees').val()) - parseInt($('#std_scholar').val()) - parseInt($('#std_dis_fees').val()) - parseInt($('#std_amt_paid').val())
                        );

                        //scholarship addition
                        $('#std_scholar').val(
                            Number($('#std_scholar').val()) + Number($('#prev_debt_new').val())
                        )

                        // =========================================================

                        // you sibmit here to the database
                        var Student_ID = $('#Student_ID').val();
                        var Fullnames = $('#Fullnames').val();
                        var std_cur_section = $('#std_cur_section').val();
                        var std_cur_class = $('#std_cur_class').val();
                        var gen_Term = $('#gen_Term').val();
                        // var gen_branch = $('#gen_branch').val();
                        var gen_branch = $('#std_branch').val();
                        var gen_Session = $('#gen_Session').val();
                        var pay_option = $('#pay_option').val();
                        var bank = $('#Bank').val();
                        var pay_ref = $('#Pay_Ref').val();
                        var entry_type_amt = $('#entry_type_amt').val();
                        var std_trans_amt = $('#std_trans_amt').val();
                        var std_cur_section_amt = $('#std_cur_section_amt').val();
                        var std_cur_class_amt = $('#std_cur_class_amt').val();
                        var ext_exam_amt = $('#ext_exam_amt').val();
                        var prev_debt_amt = $('#prev_debt_amt').val();
                        var Std_adm_type_amt = $('#Std_adm_type_amt').val();
                        var std_cbt_les = $('#std_cbt_les').val();
                        var Std_misc_cert = $('#Std_misc_cert').val();
                        var std_tot_fees = $('#std_tot_fees').val();
                        var std_scholar = $('#std_scholar').val();
                        var std_phone = $('#std_phone').val();
                        var std_amt_pay = $('#std_amt_pay').val();
                        var std_amt_paid = $('#std_amt_paid').val();
                        var std_bal = $('#std_bal').val();
                        var std_dis_fees = $('#std_dis_fees').val();
                        var reference = $('#reference').val();

                        $.ajax({
                            url: '../admin/adm_student/student_reg_db.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                "Student_ID": Student_ID,
                                "Fullnames": Fullnames,
                                "std_cur_section": std_cur_section,
                                "std_cur_class": std_cur_class,
                                "gen_Term": gen_Term,
                                "gen_branch": gen_branch,
                                "std_phone": std_phone,
                                "prev_debt_amt": prev_debt_amt,
                                "gen_Session": gen_Session,
                                "pay_option": pay_option,
                                "bank": bank,
                                "pay_ref": pay_ref,
                                "reference": reference,
                                "entry_type_amt": entry_type_amt,
                                "std_trans_amt": std_trans_amt,
                                "std_cur_section_amt": std_cur_section_amt,
                                "std_cur_class_amt": std_cur_class_amt,
                                "ext_exam_amt": ext_exam_amt,
                                "Std_adm_type_amt": Std_adm_type_amt,
                                "std_cbt_les": std_cbt_les,
                                "std_amt_pay": std_amt_pay,
                                "Std_misc_cert": Std_misc_cert,
                                "std_tot_fees": std_tot_fees,
                                "std_scholar": std_scholar,
                                "std_amt_paid": std_amt_paid,
                                "std_bal": std_bal,
                                "std_dis_fees": std_dis_fees,
                                "type": "submit_payment"
                            },

                            success: function(resp) {
                                $.alert({
                                    icon: 'bi bi-patch-question',
                                    theme: 'bootstrap',
                                    title: 'Message',
                                    content: resp.msg,
                                    animation: 'scale',
                                    type: 'orange'
                                })

                                $('#pay_cbt_less').val(0);
                                $('#pay_mis_cert').val(0)
                                $('#discgiven').val(0);
                                $('#paymentmade').val(0);
                                $('#stud_reg_btn').removeClass('disabled');
                                $('#add_btn').addClass('disabled');
                                $('#reference').val('');
                                $('#Student_ID').attr("disabled",true);
                            },
                            error: function(result) {
                                console.log(result);
                            }
                        })
                    },
                    No: function() {
                        close()
                    }
                }
            })
        }
    });

    // Search / Update button
    $('#Student_ID').keyup(function(e) {
        var id = $(this).val();
        var role_db = $('#role_db').val();
        var branch_db = $('#branch_db').val();
        
        if (id.length == 4) {
            if (!isNaN(id) && id.trim() !== "") {
                $('#stud_reg_btn').val('Update');
                $('#stud_reg_btn').text('Update');
                $.ajax({
                    url: '../admin/adm_student/student_reg_db.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "student_ID": id,
                        "role_db": role_db,
                        "branch_db": branch_db,
                        "type": "getStudentDetails"
                    },

                    success: function(response) {
                        if (response.query == 'false') {
                            $.confirm({
                                icon: 'bi bi-patch-question',
                                theme: 'bootstrap',
                                title: 'Message',
                                content: response.msg,
                                animation: 'scale',
                                type: 'orange'
                            })
                        } else if (response.query == 'true') {
                            $('#Fullnames').val(response.Fullnames);
                            $('#ArabicName').val(response.ArabicName);
                            $('#std_dob').val(response.D_O_B);
                            $('#std_branch').val(response.Branch);
                            $('#Std_Term').val(response.Term);
                            $('#std_Session').val(response.Session);
                            $('#std_section').val(response.Section);
                            // $('#std_class').val(response.Class); html(response.html)
                            $('#std_class').html(response.Class_html);
                            $('#std_gender').val(response.Gender);
                            $('#std_status').val(response.Status);
                            $('#Std_adm_type').val(response.Admission_Type);
                            $('#Std_parent').val(response.Parent_Name);
                            $('#Std_address').val(response.Address);
                            $('#std_phone').val(response.Phone_Number);
                            $('#Std_email').val(response.Email);
                            $('#std_pin').val(response.std_pin);
                            $('#std_scholar').val(response.Scholarship_Fees);
                            $('#date_admitted').val(response.Date_Adm);
                            $('#year_graduated').val(response.Year_Graduated);
                            


                            $('#std_comment').val(response.Comment);
                            $('#entry_type_amt').val(response.Entry_Fee);
                            $('#entry_type').val(response.entry_type);
                            $('#std_trans').html(response.trans_area_html);
                            $('#scholarship_determination').html(response.scholar_html);
                            $('#std_cur_section').html(response.curr_sect_html);
                            $('#std_cur_class').html(response.Curr_Class_html);
                            $('#tax_option').val(response.tax_option);
                            $('#std_cur_section_amt').val(response.std_cur_section_amt);
                            $('#std_cur_class_amt').val(response.Book_Fee);
                            $('#prev_debt_amt').val(response.Previous_Debt_Fee);
                            $('#ext_exam').val(response.External_Exam);
                            $('#ext_exam_amt').val(response.Ext_Exam_Fee);
                            $('#Std_adm_type_amt').val(response.Boarding_Fee);
                            $('#std_cbt_les').val(response.Others_Fee);
                            $('#Std_misc_cert').val(response.Misc_Fee);
                            $('#std_tot_fees').val(response.Total_Fees);

                            $('#img_of_stud').attr("src", response.imgSrc);
                            $('#std_trans_amt').val(response.Transport_Fee);
                            $('#std_dis_fees').val(response.Discount);
                            $('#tution_fee').val(response.Tuition_Fee);
                            $('#std_amt_pay').val(response.Amount_Payable);
                            $('#std_amt_paid').val(response.Amount_Paid);
                            $('#std_bal').val(response.Balance);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            } else {
                // send a message to the user
                $.confirm({
                    icon: 'bi bi-patch-question',
                    theme: 'bootstrap',
                    title: 'Message',
                    content: 'The input is not a valid number',
                    animation: 'scale',
                    type: 'orange'
                })
            }
        } else if (id.length == 0) {
            $('#stdRegForm').trigger('reset');
            $('#stud_reg_btn').val('Submit');
            $('#stud_reg_btn').text('Submit');
            $('#img_of_stud').attr("src", '../storege/students/no_image.jpg');
        }
    })

    // selecting fee determination 
    $('.fees_deter').change(function() {
        var selct = $(this).attr('id');
        var selct_val = $(this).val();
        var gen_Term = $('#gen_Term').val();
        var gen_branch = $('#gen_branch').val();
        var extra = '_amt';
        if (selct_val != 0) {
            $.ajax({
                url: '../admin/adm_student/student_reg_db.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    "selection_made": selct,
                    "select_val": selct_val,
                    "term": gen_Term,
                    "branch": gen_branch,
                    "type": "fee_deter"
                },
                success: function(resp) {
                    const fee = parseInt(resp.fee);
                    $('#' + selct + extra).val(fee);

                    const add = parseInt($('#entry_type_amt').val()) + parseInt($('#std_trans_amt').val()) + parseInt($('#std_cur_section_amt').val()) + 
                        parseInt($('#std_cur_class_amt').val()) + parseInt($('#prev_debt_amt').val()) + parseInt($('#ext_exam_amt').val()) +
                        parseInt($('#Std_adm_type_amt').val()) + parseInt($('#std_cbt_les').val()) + parseInt($('#Std_misc_cert').val());

                    $('#std_tot_fees').val(add);
                    $('#std_amt_pay').val(add) - parseInt($('#std_scholar').val()) - parseInt($('#std_dis_fees').val());
                    $('#std_bal').val(add) - parseInt(
                        $('#std_scholar').val()) - parseInt($('#std_dis_fees').val()) - parseInt($('#std_amt_paid').val()
                    );
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    })

    //continue button 
    $('#continue_btn').click(function(e){
        e.preventDefault();
        $('#section_one').addClass('d-none');
        $('#section_two').removeClass('d-none');
    })

    $('#previous_btn').click(function(e){
        e.preventDefault();
        $('#section_one').removeClass('d-none');
        $('#section_two').addClass('d-none');

    })

    //scholarship dtermination
    $('#scholarship_determination').change(function(){
        var column = $(this).val();
        $.post("../admin/adm_student/student_reg_db.php",{"type":"getAmount","column":column},null,"json")
        .done(function(response){
            $('#std_scholar').val(response.amount);
        })
        .fail(function(err){console.log(err)})
        // var amount = Number($(this).val()) || 0;
        
    })

    $('#std_status').change(function(){
        var status = $(this).val();
        if(status == 'Graduated'){
            $('#year_graduated').attr("disabled",false);
        } else {
            $('#year_graduated').attr("disabled",true);
        }
    })

    $('#pay_option').change(function(){
        var opt = $(this).val();
        if(opt == 'Bank'){
            $('#Bank').attr("disabled",false);
        } else {
            $('#Bank').attr("disabled",true);
            $('#Bank').val('Cash');
        }
    })

    $('#img_of_stud').click(function(){
        $('#section_one').addClass('d-none');
        $('#section_two').removeClass('d-none');
    })


    // Timer 
    setInterval(() => {
        $.ajax({
            url: '../admin/adm_student/student_reg_db.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'type': 'auto_id_rec'
            },
            success: function(response) {
                $('#Last_ID').val(response.last_id);
                $('#Pay_Ref').val(response.pay_id);
            },
            error: function(err) {
                console.log(err)
            }
        });
    }, 3000);
})
</script>