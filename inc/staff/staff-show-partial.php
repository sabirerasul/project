<?php
require_once "../../lib/db.php";

throw_exception();


$id = $_REQUEST['eid'];

/*

$cond = 1;

if($_POST){

    $uid = mysqli_real_escape_string($db, $uid);
    $uid = $uid ? $uid : '';
    $name = mysqli_real_escape_string($db, $name);
    $name = $name ? $name : '';
    $number = mysqli_real_escape_string($db, $number);
    $number = $number ? $number : '';
    $email = mysqli_real_escape_string($db, $email);
    $email = $email ? $email : '';
    $source = mysqli_real_escape_string($db, $source);
    $source = $source ? $source : '';
    $spname = mysqli_real_escape_string($db, $spname);
    $spname = $spname ? $spname : '';
    $sname = mysqli_real_escape_string($db, $sname);
    $sname = $sname ? $sname : '';
    $sid = mysqli_real_escape_string($db, $sid);
    $sid = $sid ? $sid : '';
    $gender = mysqli_real_escape_string($db, $gender);
    $gender = $gender ? $gender : '';

    $cond = "`id` LIKE '{$uid}' AND `client_name` LIKE '%{$name}%' AND `contact` LIKE '%{$number}%' AND `gender` LIKE '{$gender}' AND `email` LIKE '{$email}' AND `source_of_client` LIKE '{$source}'";
}

$removeStr = [
    "`id` LIKE '' AND",
    "`client_name` LIKE '%%' AND",
    "`contact` LIKE '%%' AND",
    "`gender` LIKE '' AND",
    "`email` LIKE '' AND",
    "`source_of_client` LIKE '' AND"
];

foreach($removeStr as $k => $v){
    $cond = str_replace($v,'', $cond);
}

$cond = ($cond == '     ') ? 1 : $cond;

*/


$sql = "SELECT * FROM employee WHERE id='".$id."'";


$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);
//$modal = mysqli_fetch_object($modalSql);

//$activeClient = mysqli_num_rows($modalSql);

$html = "";
$target_dir = "./web/employee_doc/";

if (count($modal) > 0) {
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        $cGender = ucfirst($value->gender);

        $status = ($value->status == 1) ? 'Active' : 'Deactive';
        $oppStatus = ($value->status == 1) ? 'Deactive' : 'Active';

        $statusColor = ($value->status== 1) ? 'success' : 'danger';
        $oppStatusColor = ($value->status== 1) ? 'danger' : 'success';

        $deactiveStyle = ($value->status == 0) ? "style='background-color:#f1f1f1'" : "";
        
        $emp_photo = (!empty($value->photo)) ? $target_dir.$value->photo : $target_dir.'female.png';
        $emp_frontproof = (!empty($value->frontproof)) ? $target_dir.$value->photo : $target_dir.'female.png';
        $emp_backproof = (!empty($value->backproof)) ? $target_dir.$value->photo : $target_dir.'female.png';
        $statusIcon = ($value->status== 1) ? 'down':'up';
        // /

        $html .= "
        
        <tr>
            <th>Name</th>
            <th>DOB</th>
            <th>Contact Number</th>
        </tr>
        <tr>
            <td>{$value->name}</td>
            <td>{$value->dob}</td>
            <td>{$value->contact_number}</td>
        </tr>
        <tr>
            <th>Email</th>
            <th>Working Time</th>
            <th>Salary</th>
        </tr>
        <tr>
            <td>{$value->email}</td>
            <td>{$value->working_hours_start} - {$value->working_hours_end}</td>
            <td>{$value->salary}</td>
        </tr>
        <tr>
            <th>Emergency Contact Number</th>
            <th>Emergency Contact Person</th>
            <th>Address</th>
        </tr>
        <tr>
            <td>{$value->emer_contact_number}</td>
            <td>{$value->emer_contact_person}</td>
            <td>{$value->address}</td>
        </tr>
        <tr>
            <th>Username</th>
            <th>Gender</th>
            <th>Date Of Joining</th>
        </tr>
        <tr>
            <td>{$value->username}</td>
            <td>{$cGender}</td>
            <td>{$value->date_of_joining}</td>
        </tr>
        <tr>
            <th>User Type</th>
            <th>Department</th>
            <th>Status</th>
            <th>User Since</th>
        </tr>
        <tr>
            
            <td>{$value->user_type}</td>
            <td>{$value->department}</td>
            <td>{$status}</td>
            <td>{$value->created_at}</td>
        </tr>
        <tr>
            <th>Photo</th>
            <th>Front ID Proof</th>
            <th>Back ID Proof</th>
                        
        </tr>
        <tr>
            <td class='avatar'>
                <img src='{$emp_photo}' class='img-responsive'>
            </td>

            <td class='avatar'>
                <img src='{$emp_frontproof}' class='img-responsive'>
            </td>
            <td class='avatar'>
                <img src='{$emp_backproof}' class='img-responsive'>
            </td>
        </tr>";        
    }
} else {

    $html .="<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";

}


echo $html;


//<!-- <a href="payroll.php?pid=6"><button class="btn btn-warning btn-xs" type="button"><i class="fa fa-book" aria-hidden="true"></i>Payroll</button></a>  -->
?>


