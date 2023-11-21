<?php
require_once "../../lib/db.php";
throw_exception();

$branch_id = BRANCHID;
$modal = fetch_all($db, "SELECT * FROM feedback WHERE branch_id='{$branch_id}' ORDER by id DESC");

$html = "";

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {

        $value = (object) $val;
        $count++;


        $rating = '<div style="white-space:nowrap">';

        for ($i = 0; $i < $value->rating; $i++) {
            $rating .= '<i class="fa fa-star rating-color" style="margin:0px;" aria-hidden="true"></i>';
        }

        $rating .= '</div>';

        $approveText = ($value->status == 1) ? 'Approved' : 'Approve';
        $cancelText = ($value->status == 0) ? 'Cancelled' : 'Cancel';

        $approveDisable = ($value->status == 1) ? 'disabled' : '';
        $cancelDisable = ($value->status == 0) ? 'disabled' : '';

        $approveLink = ($value->status == 1) ? '#' : "./inc/feedback/feedback-status-update.php?id={$value->id}";
        $cancelLink = ($value->status == 0) ? '#' : "./inc/feedback/feedback-status-update.php?id={$value->id}";

        $approveBtn = "<a href='{$approveLink}' class='btn btn-sm btn-primary text-nowrap m-1 {$approveDisable}' {$approveDisable}><i class='fas fa-thumbs-up'></i> {$approveText}</a>";
        $cancelBtn = "<a href='{$cancelLink}' class='btn btn-sm btn-danger text-nowrap m-1 {$cancelDisable}' {$cancelDisable}><i class='fas fa-trash'></i> {$cancelText}</a>";

        $html .= "<tr>
            <td>{$count}</td>
            <td>" . date("d/m/Y", strtotime($value->created_at)) . "</td>
            <td>{$value->name}</td>
            <td>{$value->email}</td>
            <td>{$value->review}</td>
            <td>{$value->overall_experience}</td>
            <td>{$value->timely_response}</td>
            <td>{$value->our_support}</td>
            <td>{$value->overall_satisfaction}</td>
            <td>{$rating}</td>
            <td>{$value->suggestion}</td>
            <td>
                {$approveBtn}
                {$cancelBtn}
            </td>
            </tr>";
    }
} else {

    /*
    $html .= "<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";
    */
}

echo $html;
