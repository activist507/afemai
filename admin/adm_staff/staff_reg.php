<?php 
    $sqlSection = $conn->query("SELECT * FROM cbt_section");
	$allsection = fetch_all_assoc($sqlSection);
    $sqlSessionn = $conn->query("SELECT * FROM tblsession");
    $sqlTermm = $conn->query("SELECT * FROM cbt_term");
    $banks = $conn->query("SELECT * FROM banks");
    
    $sqlStafStat = $conn->query("SELECT * FROM cbt_staff_status");
    $sqlTransArea = $conn->query("SELECT * FROM cbt_trans_area");
?>

<main class="main" id="main">
	<section class="section">
		<div class="card pb-2">
			<div class="card-body pb-2">

				<div class="row pt-2">
					<div class="col-lg-12">
						<h5 class="card-title text-center pt-1">STAFF REGISTRATION</h5>
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
					<!-- staff details -->
					<div class="row pb-2 gy-2">
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="staff_ID" name="staff_ID"
								maxlength="4" placeholder="Search ID" />
						</div>
						<div class="col-lg-4 col-sm-12">
							<input type="text" class="form-control pt-0" id="Fullnames" name="Fullnames" required
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Fullnames"
								placeholder="Fullnames" />
						</div>

						<div class="col-lg-2 col-sm-12">
							<select name="staff_gender" id="staff_gender" class="form-control pt-0"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Gender" required>
								<option>Select Gender</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-12">
							<select name="staff_branch" id="staff_branch" class="form-control pt-0"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Branch" required>
								<option value="0">Select Branch</option>
								<?php foreach($branches_rows as $branc){?>
								<option value="<?= $branc['Branch_Name']?>"><?= $branc['Branch_Name']?>
								</option>
								<?php }?>
							</select>
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="date" class="form-control pt-0" id="staff_dob" name="staff_dob"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Date Of Birth" required />
						</div>
					</div>

					<!-- Select Status -->
					<div class="row pb-2 gy-2">
						<div class="col-lg-2 col-sm-12">
							<input type="date" class="form-control pt-0" id="date_emp" name="date_emp"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Date Employed" required />
						</div>
						<div class="col-lg-2 col-sm-12">
							<select name="staff_term" id="staff_term" class="form-control pt-0" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Term Employed" required>
								<option value="0">Select Term</option>
								<?php while($term = $sqlTermm->fetch_object()){?>
								<option value="<?= $term->term?>"><?= $term->term?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-lg-2 col-sm-12">
							<select name="staff_session" id="staff_session" class="form-control pt-0"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Session Employed"
								required>
								<option value="0">Select Session</option>
								<?php while($session = $sqlSessionn->fetch_object()){?>
								<option value="<?= $session->csession?>"><?= $session->csession?>
								</option>
								<?php }?>
							</select>
						</div>
						<div class="col-lg-2 col-sm-12">
							<select name="staff_qualification" id="staff_qualification" class="form-control pt-0"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Qualification" required>
								<option value="0">Select Qualification</option>
								<option value="O Level">O Level</option>
								<option value="NCE">NCE</option>
								<option value="Diploma">Diploma</option>
								<option value="HND">HND</option>
								<option value="PGD">PGD</option>
								<option value="BSc">BSc</option>
								<option value="Masters">Masters</option>
								<option value="Phd">Phd</option>
							</select>
						</div>

						<div class="col-lg-4 col-sm-12">
							<input type="file" class="form-control pt-0" id="staff_img" name="staff_img"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Image" />
						</div>
					</div>
					<!-- End staff details -->

					<!-- n info -->
					<div class="row pb-2 gy-2">
						<div class="col-lg-2 col-sm-12">
							<select name="work_Area" id="work_Area" class="form-control pt-0" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Staff Work Area" required>
								<option value="0">Work Area</option>
								<option value="Academic">Academic</option>
								<option value="Non Academic">Non Academic</option>
								<option value="Both A & N">Both A & N</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-12">
							<select name="staff_section" id="staff_section" class="form-control pt-0"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Section" required>
								<option value="0">Select Section</option>
								<option value="Nursery">Nursery</option>
								<option value="Primary">Primary</option>
								<option value="Secondary">Secondary</option>
								<option value="Exempted">Exempted</option>
							</select>
						</div>
						<div class="col-lg-4 col-sm-12">
							<input type="text" class="form-control pt-0" id="staff_phone" name="staff_phone"
								placeholder="Phone Number" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Staff Phone Number" required />
						</div>
						<div class="col-lg-4 col-sm-12">
							<input type="text" class="form-control pt-0" id="staff_email" name="staff_email"
								placeholder="Email" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Staff Email" />
						</div>
					</div>

					<div class="row pb-2 gy-2">
						<div class="col-lg-2 col-sm-12">
							<select name="staff_status" id="staff_status" class="form-control pt-0"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Status" required>
								<option value="0">Select Status</option>
								<?php while($status = $sqlStafStat->fetch_object()){?>
								<option value="<?= $status->status?>"><?= $status->status?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="date" class="form-control pt-0" id="date_resigned" name="date_resigned"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Date Resigned" required />
						</div>
						<div class="col-lg-4 col-sm-12">
							<input type="text" class="form-control pt-0" id="staff_address" name="staff_address"
								placeholder="Address" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Staff Address" required />
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control pt-0" id="staff_comment" name="staff_comment"
								placeholder="Comment" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Staff Comment" />
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control pt-0" id="staff_pass" name="staff_pass"
								placeholder="Staff Pass" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Staff pass" />
						</div>
					</div>

					<!-- Other details -->
					<div class="row pb-3 gy-3">
						<div class="col-lg-2 col-sm-12">
							<select name="emp_type" id="emp_type" class="form-control pt-0" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Staff Emp. Type">
								<option value="0">Emp. Type</option>
								<option value="FullTime">FullTime</option>
								<option value="Part Time">Part Time</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-12">
							<select id="staff_bank_name" name="staff_bank_name" class="form-control pt-0"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Staff Bank">
								<option value="0">Select Bank</option>
								<?php while($bank = $banks->fetch_object()){?>
								<option value="<?= $bank->Bank_Name?>"><?= $bank->Bank_Name?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-lg-4 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="account_name"
								placeholder="Account Name" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Account Name" />
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="account_number"
								placeholder="Account Number" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Account Number" />
						</div>
						<div class="col-lg-2 col-sm-12">
							<select name="staff_role" id="staff_role" class="form-control pt-0" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Staff Role">
								<option value="0">Select Role</option>
								<option value="staff">Staff</option>
								<option value="registrar">Registrar</option>
								<option value="accountant">Accountant</option>
								<option value="admin">Admin</option>
							</select>
						</div>
					</div>

					<!-- Salary Details -->
					<div class="row pb-3 gy-3">
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="basic_salary"
								placeholder="Basic Sal" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Basic Salary" readonly style="background:rgba(216, 220, 231, 0.93);" />
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="salary_increment"
								name="salary_increment" readonly placeholder="Sal. Incr."
								style="background:rgba(216, 220, 231, 0.93);" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Salary Increment" />
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="Transportation"
								name="Transportation" readonly placeholder="Trans."
								style="background:rgba(216, 220, 231, 0.93);" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Transportation" />
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="feeding_allowance"
								name="feeding_allowance" readonly placeholder="Feeding Allow."
								style="background:rgba(216, 220, 231, 0.93);" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Feeding Allowance" />
						</div>
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="addition_resp"
								name="addition_resp" readonly placeholder="Add. Resp."
								style="background:rgba(216, 220, 231, 0.93);" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Add. Responsibility" />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="Sal_Nego" name="Sal_Nego"
								readonly placeholder="Health Allow." style="background:rgba(216, 220, 231, 0.93);"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Health Allowance" />
						</div>
					</div>

					<div class="row pb-3 gy-3">
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="incentive" name="incentive"
								readonly placeholder="Incentive" style="background:rgba(216, 220, 231, 0.93);"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Incentive" />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0 cbt_misc" id="house_allow"
								name="house_allow" placeholder="House Allow."
								style="background:rgba(216, 220, 231, 0.93);" data-bs-toggle="tooltip"
								data-bs-placement="top" title="House Allowance" readonly />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0 cbt_misc" id="emissary_allow"
								name="emissary_allow" placeholder="Emissary Allow"
								style="background:rgba(216, 220, 231, 0.93);" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Emissary Allow" readonly />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="total_salary"
								placeholder="Total Salary" name="total_salary" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Total Salary" readonly
								style="background:rgba(163, 235, 168, 0.93);" />
						</div>

						<div class=" col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="deductions"
								placeholder="Deductions" name="deductions" data-bs-toggle="tooltip"
								data-bs-placement="top" title="Deductions" readonly
								style="background:rgba(243, 190, 180, 0.93);" />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="Ded" placeholder="Part_Pay"
								name="Ded" data-bs-toggle="tooltip" data-bs-placement="top" title="Part_Pay" readonly
								style="background:rgba(243, 190, 180, 0.93);" />
						</div>
					</div>

					<!-- Amount Payable -->
					<div class="row pb-3 gy-3">
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="Gov_M_Tax" name="Gov_M_Tax"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Gov_M_Tax"
								placeholder="Gov_M_Tax" readonly style="background:rgba(243, 190, 180, 0.93);" />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="Gov_A_Tax" name="Gov_A_Tax"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Gov_A_Tax"
								placeholder="Gov_A_Tax" readonly style="background:rgba(243, 190, 180, 0.93);" />
						</div>

						<div class=" col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="loan_paid" name="loan_paid"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Loan Paid" readonly
								style="background:rgba(243, 190, 180, 0.93);" placeholder="Loan Paid" />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="m_sav" name="m_sav"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Monthly Savings"
								placeholder="Monthly Sav." readonly style="background:rgba(243, 190, 180, 0.93);" />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="gratuity" name="gratuity"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Gratuity" readonly
								placeholder="Gratuity" style="background:rgba(243, 190, 180, 0.93);" />
						</div>

						<div class=" col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="amt_pay_able"
								name="amt_pay_able" data-bs-toggle="tooltip" data-bs-placement="top" title="A_Payable"
								readonly style="background:rgba(163, 235, 168, 0.93);" placeholder="A_Payable" />
						</div>
					</div>

					<div class="row pb-3 gy-3">
						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0" id="amt_paid_staff"
								name="amt_paid_staff" data-bs-toggle="tooltip" data-bs-placement="top"
								title="Amount Paid" readonly style="background:rgba(163, 235, 168, 0.93);"
								placeholder="Amount Paid" />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0 control_pay_btn" id="balance"
								name="balance" data-bs-toggle="tooltip" data-bs-placement="top" placeholder="Balance"
								title="Balance" style="background:rgba(163, 235, 168, 0.93);" readonly />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0 control_pay_btn" id="loan_bal"
								name="loan_bal" data-bs-toggle="tooltip" data-bs-placement="top"
								placeholder="Loan Balance" title="Loan Balance"
								style="background:rgba(216, 220, 231, 0.93);" readonly />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0 control_pay_btn" id="t_savings"
								name="t_savings" data-bs-toggle="tooltip" data-bs-placement="top" title="T. Savings"
								style="background:rgba(216, 220, 231, 0.93);" placeholder="T. Savings" readonly />
						</div>

						<div class="col-lg-2 col-sm-12">
							<input type="text" class="form-control text-center pt-0 control_pay_btn" id="t_gratuity"
								placeholder="T_Gratuity" name="t_gratuity" data-bs-toggle="tooltip"
								data-bs-placement="top" title="T_Gratuity" style="background:rgba(216, 220, 231, 0.93);"
								readonly />
						</div>

						<div class="col-lg-2 col-sm-12">
							<button type="submit" style="width: 8.7rem;" class="btn btn-primary pt-0" id="stud_reg_btn"
								value="Submit">
								Submit
							</button>
						</div>
					</div>

					<div class="row pb-3 gy-3">
						<div class="col-lg-6">
							<input type="text" class="form-control text-center pt-0" id="Pay_Ref" name="Pay_Ref"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Receipt No" readonly
								style="background:rgba(233, 240, 239, 0.93);" />
						</div>
						<div class="col-lg-6">
							<input type="text" class="form-control text-center pt-0" id="Last_ID" name="staff_ID"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Last_ID" maxlength="4"
								placeholder="staff_ID" style="background:rgba(233, 240, 239, 0.93);" readonly />
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

	$('#stdRegForm').on('submit', function(e) {
		e.preventDefault(); //

		//<!-- student details -->
		var staff_ID = $('#staff_ID').val();
		var Fullnames = $('#Fullnames').val();
		var staff_gender = $('#staff_gender').val();
		var staff_branch = $('#staff_branch').val();
		var staff_dob = $('#staff_dob').val();

		var date_emp = $('#date_emp').val();
		var staff_term = $('#staff_term').val();
		var staff_session = $('#staff_session').val();
		var staff_qualification = $('#staff_qualification').val();
		var staff_img = $('#staff_img')[0].files[0];

		var work_Area = $('#work_Area').val();
		var staff_section = $('#staff_section').val();
		var staff_phone = $('#staff_phone').val();
		var staff_email = $('#staff_email').val();

		var staff_status = $('#staff_status').val();
		var date_resigned = $('#date_resigned').val();
		var staff_address = $('#staff_address').val();
		var staff_comment = $('#staff_comment').val();
		var staff_pass = $('#staff_pass').val();

		var emp_type = $('#emp_type').val();
		var staff_bank_name = $('#staff_bank_name').val();
		var account_name = $('#account_name').val();
		var account_number = $('#account_number').val();
		var staff_role = $('#staff_role').val();

		var meth = $('#stud_reg_btn').val();

		var sdata = new FormData();

		// <!-- student details -->
		sdata.append("staff_ID", staff_ID);
		sdata.append("Fullnames", Fullnames);
		sdata.append("staff_gender", staff_gender);
		sdata.append("staff_branch", staff_branch);
		sdata.append("staff_dob", staff_dob);

		sdata.append("date_emp", date_emp);
		sdata.append("staff_term", staff_term);
		sdata.append("staff_session", staff_session);
		sdata.append("staff_qualification", staff_qualification);
		sdata.append("image", staff_img);

		sdata.append("work_Area", work_Area);
		sdata.append("staff_section", staff_section);
		sdata.append("staff_phone", staff_phone);
		sdata.append("staff_email", staff_email);

		sdata.append("staff_status", staff_status);
		sdata.append("date_resigned", date_resigned);
		sdata.append("staff_address", staff_address);
		sdata.append("staff_comment", staff_comment);
		sdata.append("staff_pass", staff_pass);

		sdata.append("emp_type", emp_type);
		sdata.append("staff_bank_name", staff_bank_name);
		sdata.append("account_name", account_name);
		sdata.append("account_number", account_number);
		sdata.append("staff_role", staff_role);

		sdata.append("method", meth);
		sdata.append("type", "submitStaffReg");


		if (staff_branch == '0' || staff_section == '0') {
			console.log('An important field is missing');
		} else {
			$.ajax({
				url: '../admin/adm_staff/staff_reg_db.php',
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
		$('#staff_bank_name').val('0');
		$('#std_cur_section').val('0');
		$('#std_cur_class').html('<option>Select Class</option>');
		$('#img_of_stud').attr("src", '../storege/students/no_image.jpg');
	})

	// Search / Update button
	$('#staff_ID').keyup(function(e) {
		var id = $(this).val();
		if (id.length == 4) {
			if (!isNaN(id) && id.trim() !== "") {
				$('#stud_reg_btn').val('Update');
				$('#stud_reg_btn').text('Update');
				$.ajax({
					url: '../admin/adm_staff/staff_reg_db.php',
					type: 'POST',
					dataType: 'json',
					data: {
						"staff_ID": id,
						"type": "getStaffDetails"
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
							// $('#staff_ID').val();
							$('#Fullnames').val(response.Fullname);
							$('#staff_gender').val(response.Gender);
							$('#staff_branch').val(response.Branch);
							$('#staff_dob').val(response.D_O_B);

							$('#date_emp').val(response.Date_Emp);
							$('#staff_term').val(response.Term_Emp);
							$('#staff_session').val(response.Session);
							$('#staff_qualification').val(response.Qualifications);
							$('#img_of_stud').attr("src", response.imgSrc);

							$('#work_Area').val(response.Work_area);
							$('#staff_section').val(response.Staff_section);
							$('#staff_phone').val(response.Phone_No);
							$('#staff_email').val(response.Email);

							$('#staff_status').val(response.Staff_Status);
							$('#date_resigned').val(response.Date_Resigned);
							$('#staff_address').val(response.Address);
							$('#staff_comment').val(response.Comment);
							$('#staff_pass').val(response.Staff_pass);

							$('#emp_type').val(response.Emp_Type);
							$('#staff_bank_name').val(response.Staff_bank);
							$('#account_name').val(response.Account_name);
							$('#account_number').val(response.Account_number);
							$('#staff_role').val(response.Staff_role);

							$('#basic_salary').val(response.Basic_Salary);
							$('#salary_increment').val(response.Increment);
							$('#Transportation').val(response.Transport);
							$('#feeding_allowance').val(response.Feeding_All);
							$('#addition_resp').val(response.Add_Resp_Fee);
							$('#Sal_Nego').val(response.Sal_Nego);

							$('#incentive').val(response.Incentive);
							$('#house_allow').val(response.House_All);
							$('#emissary_allow').val(response.Emissary_All);
							$('#total_salary').val(response.Total_Salary);
							$('#gratuity').val(response.M_Gratuity);
							$('#loan_paid').val(response.Loan_paid);

							$('#Gov_M_Tax').val(response.Gov_M_Tax);
							$('#Gov_A_Tax').val(response.Gov_A_Tax);
							$('#m_sav').val(response.Monthly_Savings);
							$('#deductions').val(response.Deductions);
							$('#Ded').val(response.Ded);
							$('#amt_pay_able').val(response.Amt_Payable);

							$('#amt_paid_staff').val(response.Amt_Paid);
							$('#balance').val(response.Balance);
							$('#loan_bal').val(response.Loan_Bal);
							$('#t_savings').val(response.T_Savings);
							$('#t_gratuity').val(response.T_Gratuity);


						}
					},
					error: function(err) {
						console.log(err);
					}
				})
			} else {
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
			$('#img_of_stud').attr("src", '../storege/staff/no_image.jpg');
		}
	})

	// Timer 
	setInterval(() => {
		$.ajax({
			url: '../admin/adm_staff/staff_reg_db.php',
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