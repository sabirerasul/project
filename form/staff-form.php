<?php

$genderArr = [
    'male' => 'Male',
    'female' => 'Female'
];

$userArr = [
    'user' => 'User',
    'admin' => 'Admin'
];

$departmentArr = [
    'sales' => 'Sales',
    'management' => 'Management',
    'accounts' => 'Accounts',
    'janitor' => 'Janitor',
    'others' => 'Others',
];

$hoursArr = genNumArr(12);

$minuteArr = genNumArr(60);

$apArr = [
    'am' => 'AM',
    'pm' => 'PM'
];


if(!empty($model->working_hours_start)){
    $fTime = strtotime($model->working_hours_start);
    $fTimeHour = date("h", $fTime);
    $fTimeMinute = date("i", $fTime);
    $fTimeAp = date("A", $fTime);

    $fromHour = $fTimeHour;
    $fromMinute = $fTimeMinute;
    $fromAp = $fTimeAp;
}else{
    $fromHour = $fromMinute = $fromAp = '';
}

if(!empty($model->working_hours_end)){
    $tTime = strtotime($model->working_hours_end);
    $tTimeHour = date("h", $tTime);
    $tTimeMinute = date("i", $tTime);
    $tTimeAp = date("A", $tTime);

    $toHour = $tTimeHour;
    $toMinute = $tTimeMinute;
    $toAp = $tTimeAp;
}else{
    $toAp = $toHour = $toMinute = '';
}


?>

<?php
if($staffText != 'Add'){ ?>
<div class="col-12 mb-3">
    <a href="./staff.php" class="text-decoration-none"> <i class="fas fa-arrow-left"></i> Back To Staff</a>
</div>
<?php } ?>
<form action="./inc/staff/staff-<?=($staffText == 'Add') ? 'add':'update'?>.php" method="post" enctype="multipart/form-data" id="<?=strtolower($staffText)?>StaffForm">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="name" class="emp_name_label required">Enter Name </label>
                <input type="text" class="form-control emp_name" id="name" name="name" placeholder="Employee name" value="<?=!empty($model->name) ? $model->name : ''?>">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="cont" class="emp_number_label required">Contact Number </label>
                <input type="number" class="emp_number form-control" maxlength="10" name="contact_number" id="bcont" placeholder="Contact Number" value="<?=!empty($model->contact_number) ? $model->contact_number : ''?>">
                <div class="showErr"></div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="working_hours_start" class="working_hours_start_label required">Working Hours Start</label>
                <input type="text" class="form-control working_hours_start" id="working_hours_start" name="working_hours_start" placeholder="Start Time" value="<?= $model->working_hours_start ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="working_hours_end" class="working_hours_end_label required">Working Hours End</label>
                <input type="text" class="form-control working_hours_end" id="working_hours_end" name="working_hours_end" placeholder="End Time" value="<?= $model->working_hours_end ?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="salary" class="emp_salary_label required">Monthly Salary</label>
                <input type="number" class="emp_salary form-control" id="month_sal" name="salary" placeholder="Monthly Salary" value="<?=!empty($model->salary) ? $model->salary : ''?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="userName" class="emp_username_label required">Username</label>
                <input type="text" class="emp_username form-control" name="username" id="userName" placeholder="Username" value="<?=$username?>" readonly>
                <div class="showErr"></div>
            </div>
        </div>
        <?php /*
        <div class="col-md-3">
            <div class="form-group">
                <label for="password" class="emp_password_label required">Password</label>
                <input type="password" class="emp_password form-control" name="password" id="password" placeholder="Password">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="confirm-password" class="emp_confirm_password_label required">Confirm password</label>
                <input type="password" class="emp_confirm_password form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password">
                <div class="showErr"></div>
            </div>
        </div>
       <?php */ ?>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="emp_gender" class="emp_gender_label required">Gender</label>
                <select class="form-select emp_gender" id="emp_gender" class="emp_user_type" name="gender">
                    <option value="">Select</option>
                    <?php
                    foreach ($genderArr as $genKey => $genValue) {
                    ?>
                    <option value="<?=$genKey?>"
                    <?=($model->gender == $genKey)? 'selected' : ''?>><?=$genValue?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="doj" class="emp_doj_label required">Date Of Joining</label>
                <input type="text" class="form-control date_of_joining" name="date_of_joining" id="doj" value="<?=!empty($model->date_of_joining) ? $model->date_of_joining : ''?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="role" class="emp_user_type_label required">User Type</label>
                <select class="form-select emp_user_type" name="user_type" id="role">
                    <?php
                    foreach ($userArr as $userKey => $userValue) {
                    ?>
                    <option value="<?=$userKey?>"
                    <?=($model->user_type == $userKey)? 'selected' : ''?>><?=$userValue?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <?php /*<div class="col-md-3">
            <div class="form-group">
                <label for="attendenceId" class="emp_attendence_id_label required">Attendence id</label>
                <input type="text" class="form-control emp_attendence_id" name="attendence_id" id="attendenceId" placeholder="Attendence id" value="<?=$attendance_id?>"  readonly>
                <div class="showErr"></div>
            </div>
        </div><?php */ ?>

        <div class="col-md-3">
            <div class="form-group">
                <label for="role" class="emp_department_label required">Department</label>
                <select class="form-select emp_department" name="department" id="department">
                    <option value="">Select</option>
                    <?php
                    foreach ($departmentArr as $departmentKey => $departmentValue) {
                    ?>
                    <option value="<?=$departmentKey?>"
                    <?=($model->department == $departmentKey)? 'selected' : ''?>><?=$departmentValue?>
                    </option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="dob emp_dob_label">Date Of Birth</label>
                <input type="text" class="form-control emp_dob" id="dob" name="dob" readonly value="<?=!empty($model->dob) ? $model->dob : ''?>">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="email" class="emp_email_label">Email</label>
                <input type="email" class="emp_email form-control" id="email" name="email" placeholder="Email" value="<?=!empty($model->email) ? $model->email : ''?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="econt">Emergency Contact Number</label>
                <input type="number" class="form-control" maxlength="10" name="emer_contact_number" id="econt" placeholder="Emergency Contact Number" value="<?=!empty($model->emer_contact_number) ? $model->emer_contact_number : ''?>">
                <div class="showErr"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="eperson">Emergency Contact Person</label>
                <input type="text" class="form-control" id="eperson" name="emer_contact_person" placeholder="Emergency Contact Person" value="<?=!empty($model->emer_contact_person) ? $model->emer_contact_person : ''?>">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="photo" class="photo_label">Upload Photo (file format: jpg,png | Size: 500kb)</label>
                <input type="file" class="form-control photo" id="photo" name="photo" placeholder="profile">
                <div class="showErr"></div>

                <?php
                if($editid != 0){
                    $photoImg = (!empty($model->photo)) ? $model->photo : 'male.png';
                    echo "<img src='".$target_dir.$photoImg."' class='img-responsive edit-avt-img img-thumbnail'>";
                }
                ?>

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="proof" class="id_front_proof_label">Upload Front ID Proof (file format: jpg,png,pdf | Size: 500kb)</label>
                <input type="file" class="form-control frontproof" id="id_front_proof" name="frontproof" placeholder="idproof">
                <div class="showErr"></div>

                <?php
                if($editid != 0){
                    $frontproofImg = (!empty($model->frontproof)) ? $model->frontproof : 'male.png';
                    echo "<embed src='".$target_dir.$frontproofImg."' class='img-responsive edit-avt-img img-thumbnail'></embed>";
                }
                ?>

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="proof" class="id_back_proof_label">Upload Back ID Proof (file format: jpg,png,pdf | Size: 500kb)</label>
                <input type="file" class="form-control backproof" id="id_back_proof" name="backproof" placeholder="idproof">
                <div class="showErr"></div>

                <?php
                if($editid != 0){
                    $backproofImg = (!empty($model->backproof)) ? $model->backproof : 'male.png';
                    echo "<embed src='".$target_dir.$backproofImg."' class='img-responsive edit-avt-img img-thumbnail'></embed>";
                }
                ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="addr">Address</label>
                <textarea class="form-control" id="addr" name="address" placeholder="Address" rows="3" style="width: 100%;"><?=!empty($model->address) ? $model->address : ''?></textarea>
            </div>
        </div>
        
        <?php
        if($editid != 0){ ?>
            <input type="hidden" name="eid" value="<?=$model->id?>">
        <?php } ?>
        
        <hr>
        <div class="col-md-12 d-flex justify-content-center my-3">
            <div class="form-group">
                <button type="submit" name="staff_submit" class="btn btn-success">
                    <i class="fa fa-plus" aria-hidden="true"></i> <?=$staffText?> Staff</button>
            </div>
        </div>
    </div>
</form>