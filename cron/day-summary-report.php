<?php
include('../lib/db.php');
include('../lib/sms-config.php');
include('../lib/mail-config.php');
//throw_exception();
echo daySummaryReportMail($db);