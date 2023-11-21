<?php
require_once "../../lib/db.php";

throw_exception();

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


$sql = "SELECT * FROM service_provider WHERE branch_id='" . BRANCHID . "' ORDER by id DESC";

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

        $statusColor = ($value->status == 1) ? 'success' : 'danger';
        $oppStatusColor = ($value->status == 1) ? 'danger' : 'success';

        $deactiveStyle = ($value->status == 0) ? "style='background-color:#f1f1f1'" : "";

        $emp_photo = (!empty($value->photo)) ? $target_dir . $value->photo : $target_dir . 'female.png';
        $statusIcon = ($value->status == 1) ? 'down' : 'up';

        if ($value->status == 2) {
            $statusBtn = "<span class='badge badge-pill badge-success'>Transferred</span>";
            $actionBtn = "
                    <a class='btn btn-success btn-sm btn-block text-nowrap' type='button'>Transferred</a>
                ";
        } else {
            $statusBtn = "<span class='badge badge-pill badge-{$statusColor}'>{$status}</span>";
            $actionBtn = "
                <a href='service-provider.php?editid={$value->id}' class='btn btn-warning btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                <a href='#' onclick='deleteServiceProvider({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-trash' aria-hidden='true'></i> Delete</a>
                <a href='./service-provider-commission.php?pid={$value->id}' class='btn btn-secondary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-money-bill' aria-hidden='true'></i> Commission</a>
                <a href='./inc/service-provider/service-provider-status-update.php?id={$value->id}' class='btn btn-{$oppStatusColor} btn-sm btn-block text-nowrap' type='button'><i class='fas fa-angle-double-{$statusIcon}'></i> {$oppStatus} </a>
                <a href='service-provider-profile.php?spid={$value->id}' class='btn btn-primary btn-sm btn-block' type='button'> <i class='fa fa-eye' aria-hidden='true'></i> View</a></td>
            ";
        }

        // /
        $html .= "<tr {$deactiveStyle}>
            <td class='avatar'>
            <img src='{$emp_photo}' class='img-responsive'>
            </td>
            <td>{$value->name}</td>
            <td>{$value->contact_number}</td>
            <td>{$value->emer_contact_number}</td>
            <td>{$value->emer_contact_person}</td>
            <td></td>
            <td></td>
            <td>{$value->username}</td>
            <td>{$statusBtn}</td>
            <td class='multi-action-btn'>{$actionBtn}</tr>";
    }
} else {

    /*
    $html .= "<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";
    */
}


echo $html;


//<!-- <a href="payroll.php?pid=6"><button class="btn btn-warning btn-xs" type="button"><i class="fa fa-book" aria-hidden="true"></i>Payroll</button></a>  -->
