<?php 
    $cbt_user_permit = $conn->query("SELECT * FROM cbt_user_permit");

?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">USERS PERMISSION</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Role</th>
                                <th scope="col">A.staf</th>
                                <th scope="col">act.staf</th>
                                <th scope="col">timetable</th>
                                <th scope="col">staff.reg</th>
                                <th scope="col">A.Stud</th>
                                <th scope="col">act.Stud</th>
                                <th scope="col">sch.fee</th>
                                <th scope="col">stud.reg</th>
                                <th scope="col">clas.vid.bk</th>
                                <th scope="col">clas.note</th>
                                <th scope="col">clas.bk</th>
                                <th scope="col">clas.vid</th>
                                <th scope="col">lib.bk</th>
                                <th scope="col">lib.vid</th>
                                <th scope="col">set.qst</th>
                                <th scope="col">set.exam.code</th>
                                <th scope="col">sms</th>
                                <th scope="col">print.cbt.res</th>
                                <th scope="col">disp.cbt.res</th>
                                <th scope="col">user.sett</th>
                                <th scope="col">curr.term</th>
                                <th scope="col">curr.bull</th>
                                <th scope="col">Stud.Att</th>
                                <th scope="col">Staff.Att</th>
                                <th scope="col">New.Intake</th>
                                <th scope="col">Del.Intake</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($role = $cbt_user_permit->fetch_object()){?>
                            <tr data-id="<?= $role->id?>">
                                <th scope="row"><?= strtoupper($role->role)?></th>
                                <td data-col_name="all_staff" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->all_staff==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="act_staff" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->act_staff==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="staff_pass" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->staff_pass==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="staff_reg" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->staff_reg==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="all_stud" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->all_stud==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="act_stud" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->act_stud==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="sch_fee" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->sch_fee==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="stud_reg" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->stud_reg==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="class_vid_bk" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->class_vid_bk==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="clas_note" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->clas_note==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="class_bk" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->class_bk==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="clas_vid" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->clas_vid==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="lib_bk" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->lib_bk==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="lib_vid" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->lib_vid==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="set_quest" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->set_quest==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="set_exam_code" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->set_exam_code==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="send_sms" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->send_sms==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="print_cbt_res" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->print_cbt_res==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="disp_cbt_res" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->disp_cbt_res==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="user_sett" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->user_sett==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="curr_term" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->curr_term==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="curr_bulletin" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->curr_bulletin==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="mark_register" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->mark_register==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="staff_register" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->staff_register==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="new_intake" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->new_intake==1) ? print 'checked' :''; ?>>
                                </td>
                                <td data-col_name="delete_intake" class="text-center">
                                    <input class="form-check-input" type="checkbox"
                                        <?php $chk = ($role->delete_intake==1) ? print 'checked' :''; ?>>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">
$(document).ready(function() {
    $('.form-check-input').change(function() {
        var chk = $(this);
        var cond = 0;
        var prev_state = $(this).prop('checked');
        var col_name = $(this).parent().attr('data-col_name');
        var id = $(this).parent().parent().attr('data-id');
        if (prev_state) {
            cond = 1;
            // console.log('checkbox was previously unchecked now i want to update '+ col_name +' to '+ cond+' for the ID:'+id);
        }
        if (!prev_state) {
            cond = 0;
            // console.log('checkbox was previously checked now i want to update '+ col_name +' to '+ cond+' for the ID:'+id);
        }
        $.ajax({
            url: '../admin/settings/user_settings_db.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                "role_id": id,
                "col_name": col_name,
                "newCond": cond,
                "type": "UpdateRole"
            },
            success: function(response) {
                if (response.status == 0) {
                    $.alert({
                        icon: 'bi bi-patch-question',
                        theme: 'bootstrap',
                        title: 'Message',
                        content: 'An error occured while trying to update a role',
                        animation: 'scale',
                        type: 'orange'
                    })
                }
            },
            error: function() {

            }
        })
    })
})
</script>