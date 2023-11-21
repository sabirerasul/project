<?php
include('../../lib/db.php');
throw_exception();

if (isset($_POST['branch_select']) && !empty($_POST['branch_select']) && is_numeric($_POST['branch_select'])) {
    $branch_select = $_POST['branch_select'];
    $referrer = '';
    if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
        $referrer = $_SERVER['HTTP_REFERER'];
        $_SESSION['branch_select'] = $branch_select;
        header('location: ' . $referrer);
    } else {
        header('location: ../../index.php');
    }
} else {
    header('location: ../../index.php');
}
