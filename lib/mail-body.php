<?php

function commonBodyHeader()
{
    $html = <<< EOD
        <!DOCTYPE html>
        <html>
            <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
            
            *,
            body {
                margin: 0px;
                padding: 0px;
            }

            .container {
                background-color: #025043;
                height: 100%;
                margin-left: auto;
                margin-right: auto;
                padding-top: 50px;
                padding-bottom: 50px;
                overflow: auto;
            }

            .wrapper {
                width: 600px;
                max-width: 100%;
                background: #fff;
                border: 3px solid #01231d;
                border-radius: 15px;
                padding: 15px;
                box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
                margin-left: auto;
                margin-right: auto;
            }

            .footer {
                text-align: center;
            }

            .hr {
                border-bottom: 1px dotted #01231d;
                width: 100%;
                border-radius: 15px;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .header {
                width: 100%;
            }

            .header div {
                display: inline-block;
                text-align: center;
            }

            .mail-text {
                font-size: 20px;
                text-align: left;
                margin-top: 20px;
            }

            .footer-text {
                font-size: 10px;
                text-align: right !important;
                width: 60%;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2
            }

            th {
                color: #000000;
            }

            .table-wrapper {
                border-radius: 15px;
                border: 1px solid;
                margin: 20px auto;
            }

            .service-box {
                width: 100%;
                margin-top: 20px;
                margin-bottom: 20px;

            }

            .service-box table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            .service-box table td,
            .service-box table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            .service-box table tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .service-box table tr:hover {
                background-color: #ddd;
            }

            .service-box table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #025043;
                color: white;
            }
        </style>
        </head>
        <body>

        <div class='container'>
            <div class='wrapper'>
    EOD;
    return $html;
}

function commonBodyFooter($embed_img_array, $salon_name, $branchModel, $year, $powerby)
{
    $html = <<< EOD
            <div class="hr"></div>

                <div class='header'>
                    <div style='width:30%'>
                    
                        <img width='130px' src="cid:{$embed_img_array['cid']}" alt="{$salon_name}">
                    </div>
                    <div class='footer-text'>
                        <p><b>Branch Address: </b>{$branchModel->address}</p>
                        <p><b>Contact : </b>{$branchModel->phone}</p>
                        <p><b>Email : </b>{$branchModel->email}</p>
                        <p><b>Website : </b>{$branchModel->website}</p>
                    </div>
                </div>

                <div class="hr"></div>
                
                <div class="footer">
                    <span>&copy; Pixel Salon Software - {$year} | {$powerby}</span>
                </div>
            </div>
            </div>
            </body>
        </html>
    EOD;
    return $html;
}

function appointmentBody($appointmentModel, $clientModel, $branchModel, $embed_img_array)
{
    $powerby = POWEREDBY;
    $year = date("Y");

    $brandlogo = BRANDLOGO;
    $salon_name = SALONNAME;

    $html = commonBodyHeader();
    $html .= <<< EOD
    
        <div>
            <p class='mail-text'>Thank You {$clientModel->client_name}. Your Appointment is booked for {$appointmentModel->appointment_date} {$appointmentModel->appointment_time}. at {$salon_name}.</p>
        </div>
    EOD;

    $html .= commonBodyFooter($embed_img_array, $salon_name, $branchModel, $year, $powerby);

    return $html;
}


function billingBody($db, $billingModel, $clientModel, $branchModel, $invoiceLink, $feedbackLink, $discountArr, $embed_img_array)
{
    $powerby = POWEREDBY;
    $year = date("Y");
    $brandlogo = BRANDLOGO;
    $salon_name = SALONNAME;

    $billingProductModel = fetch_all($db, "SELECT * FROM `client_billing_product` WHERE `billing_id`='{$billingModel->id}'");

    $count = 0;
    foreach ($billingProductModel as $billingProductKey => $billingProductVal) {

        $billingProductValue = (object) $billingProductVal;

        $enquiryForModel = fetch_object($db, "SELECT * FROM {$billingProductValue->service_type} WHERE id='{$billingProductValue->service_id}'");

        $arrayField = [
            'service' => 'service_name',
            'membership' => 'membership_name',
            'package' => 'package_name',
            'stock' => 'product_id'
        ];

        $fieldName = $arrayField[$billingProductValue->service_type];

        $enquiryForText = '';
        if ($billingProductValue->service_type == 'stock') {
            $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$enquiryForModel->$fieldName}'");
            $enquiryForText = $productModel->product;
        } else {
            $enquiryForText = $enquiryForModel->$fieldName;
        }

        if ($billingProductValue->service_discount == 0) {
            $rate = $billingProductValue->price;
        } else {
            if ($billingProductValue->service_discount_type == 'percentage') {
                $rate = round(($billingProductValue->price * 100) / (100 - $billingProductValue->service_discount));
            } else {
                $rate = round(($billingProductValue->price + $billingProductValue->service_discount));
            }
        }

        $serviceProviderAssignModel = fetch_all($db, "SELECT * FROM client_billing_assign_service_provider WHERE billing_id='{$billingProductValue->billing_id}' AND billing_service_id='{$billingProductValue->id}'");

        $serviceProvider = '';
        foreach ($serviceProviderAssignModel as $serviceProviderAssignKey => $serviceProviderAssignVal) {
            $serviceProviderAssignValue = (object) $serviceProviderAssignVal;
            $serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='{$serviceProviderAssignValue->service_provider_id}'");

            $serviceProvider .= $serviceProviderModel->name . ",<br>";
        }

        $serviceProvider = rtrim($serviceProvider, ',<br>');

        $services = '';


        $serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='{$billingProductVal['service_id']}'");
        $count++;
        $services  .= "
        <tr>
            <td>{$count}</td>
            <td>{$enquiryForText}</td>
            <td>{$serviceProvider}</td>
            <td>{$rate}</td>
            <td>{$billingProductValue->service_discount} {$discountArr[$billingProductValue->service_discount_type]}</td>
            <td>{$billingProductValue->quantity}</td>
            <td>{$billingProductValue->price}</td>
        ";
    }

    $html = commonBodyHeader();
    $html .= <<< EOD
        <div style='width:100%'>
            <p class='mail-text'>Thank you {$clientModel->client_name} for your Services of {$billingModel->total} on {$billingModel->billing_date} From {$salon_name}.<p>
        </div>
        <div style='width:100%'>
            <p style='text-align:left'>Invoice link: <a href='{$invoiceLink}'>{$invoiceLink}</a></p>
            <p style='text-align:left'>Feedback link: <a href='{$feedbackLink}'>{$feedbackLink}</a></p>
        </div>
        <div class='service-box'>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service & Product</th>
                        <th>Provider</th>
                        <th>Rate</th>
                        <th>Discount</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                    
                <tbody>
                            {$services}
                </tbody>
            </table>
        </div>        
    EOD;

    $html .= commonBodyFooter($embed_img_array, $salon_name, $branchModel, $year, $powerby);
    return $html;
}



function walletBody($credit, $available, $clientModel, $branchModel, $embed_img_array)
{
    $powerby = POWEREDBY;
    $year = date("Y");
    $brandlogo = BRANDLOGO;
    $salon_name = SALONNAME;
    $html = commonBodyHeader();
    $html .= <<< EOD
        <div>
            <p class='mail-text'>Dear {$clientModel->client_name}, Your wallet is credited with INR {$credit}. Available Wallet Balance INR {$available}. From {$salon_name}.</p>
        </div>
    EOD;

    $html .= commonBodyFooter($embed_img_array, $salon_name, $branchModel, $year, $powerby);

    return $html;
}



function pendingDueBody($paid, $available, $clientModel, $branchModel, $embed_img_array)
{
    $powerby = POWEREDBY;
    $year = date("Y");
    $brandlogo = BRANDLOGO;
    $salon_name = SALONNAME;
    $html = commonBodyHeader();
    $html .= <<< EOD
        <div>
            <p class='mail-text'>Thank you {$clientModel->client_name} for the payment of INR {$paid}. Your current outstanding is {$available}. From {$salon_name}.</p>
        </div>
    EOD;
    $html .= commonBodyFooter($embed_img_array, $salon_name, $branchModel, $year, $powerby);
    return $html;
}


function daySummaryReportBody($date, $branchModel, $embed_img_array, $summary_array)
{
    $powerby = POWEREDBY;
    $year = date("Y");
    $brandlogo = BRANDLOGO;
    $salon_name = SALONNAME;
    extract($summary_array);
    $html = commonBodyHeader();
    $html .= <<< EOD
        <div>
            <p class='mail-text'>Daily summary report for {$date}</p>
            <div class='table-wrapper'>
                <table>
                <tr>
                <th>Total Invoice Amount</th>
                <td>{$totalInvoiceAmount}</td>
            </tr>
            <tr>
                <th>Pending Payable By Clients</th>
                <td>{$pendingPaymentClient}</td>
            </tr>
            <tr>
                <th>Total Collection</th>
                <td>{$totalCollection}</td>
            </tr>
            <tr>
                <th>Product Sales</th>
                <td>{$productSale}</td>
            </tr>
            <tr>
                <th>Service Sales</th>
                <td>{$serviceSale}</td>
            </tr>
            <tr>
                <th>Pending Payment Received</th>
                <td>{$pendingPaymentReceived}</td>
            </tr>
            <tr>
                <th>Appointment Advance</th>
                <td>{$appointmentAdvance}</td>
            </tr>
            <tr>
                <th>Wallet Recharged</th>
                <td>{$walletRecharge}</td>
            </tr>
            <tr>
                <th>Paid By Cash</th>
                <td>{$cash}</td>
            </tr>
            <tr>
                <th>Paid By Online Payment Mode</th>
                <td>{$onlinePayment}</td>
            </tr>
            <tr>
                <th>Paid By Credit/Debit Card</th>
                <td>{$creditDebitCard}</td>
            </tr>
            <tr>
                <th>Paid By Cheque</th>
                <td>{$cheque}</td>
            </tr>
            <tr>
                <th>Paid By Wallet</th>
                <td>{$wallet}</td>
            </tr>
            <tr>
                <th>Paid By Paytm</th>
                <td>{$paytm}</td>
            </tr>
            <tr>
                <th>Paid By Gpay</th>
                <td>{$gPay}</td>
            </tr>
            <tr>
                <th>Paid By PhonePe</th>
                <td>{$phonePe}</td>
            </tr>
            <tr>
                <th>Paid By Reward Points</th>
                <td>{$rewardPoint}</td>
            </tr>
            <tr>
                <th>Total Discount Given</th>
                <td>{$totalDiscountGiven}</td>
            </tr>
            <tr>
                <th>Total TAX</th>
                <td>
                    <p><strong>Inclusive tax : </strong>{$inclusiveTax}</p>
                    <p><strong>Exclusive tax : </strong>{$exclusiveTax}</p>
                </td>
            </tr>
            <tr>
                <th>Total Commisions Payable</th>
                <td>{$totalCommisionsPayable}</td>
            </tr>
            <tr>
                <th>Clients Visit</th>
                <td>{$todayClient}</td>
            </tr>
            <tr>
                <th>New Clients</th>
                <td>{$todayNewClients}</td>
            </tr>
            <tr>
                <th>Total Expenses</th>
                <td>{$expensesToday}</td>
            </tr>

                </table>
            </div>
            <small>This is a system generated mail. Please do not reply. If you need any support, please contact support@pixelitsoftware.com</small>
        </div>
    EOD;
    $html .= commonBodyFooter($embed_img_array, $salon_name, $branchModel, $year, $powerby);
    return $html;
}
