<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);


$sql = "SELECT * FROM client WHERE id='".$client_id."'";


$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_array($modalSql, MYSQLI_ASSOC);

$rewardSql = "SELECT sum(points) AS reward_points FROM reward_point WHERE client_id='".$client_id."'";
$rewardQuery = mysqli_query($db, $rewardSql);
$rewardModel = mysqli_fetch_assoc($rewardQuery);

$reward_points = ($rewardModel['reward_points']) ? $rewardModel['reward_points'] : 0;

$modal['branch_name'] = 'Branch 1<br /><i class="fa fa-user" class="mx-0"></i> <a href="client-profile.php?id='.$modal['id'].'" target="_blank"><u>View profile</u></a>';
$modal['customer_type'] = 'newcustomer';
$modal['last_feedback'] = '----';
$modal['lastvisit'] = 'NA';
$modal['membership'] = '----';
$modal['packages'] = '';
$modal['reward_points'] = $reward_points;
$modal['total_spending'] = '0.00';
$modal['total_visit'] = '0';
$modal['wallet'] = '0.00';

echo json_encode($modal);
