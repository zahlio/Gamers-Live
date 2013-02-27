<?php
error_reporting(0);

// Validate the Moneybookers signature
$concatFields = $_POST['merchant_id']
    .$_POST['transaction_id']
    .strtoupper(md5('Paste your secret word here'))
    .$_POST['mb_amount']
    .$_POST['mb_currency']
    .$_POST['status'];

$MBEmail = 'admin@gamers-live.net';

    // Ensure the signature is valid, the status code == 2,
    // and that the money is going to you
    if (strtoupper(md5($concatFields)) == $_POST['md5sig']
        && $_POST['status'] == 2
        && $_POST['pay_to_email'] == $MBEmail)
    {
        // Valid transaction.

        $myItemCode = $_POST['transaction_id'];
        $totalAmountReceived = $_POST['mb_amount'];

        $result_paid = mysql_query("SELECT * FROM tips_payza WHERE item_code='$myItemCode'");
        $result_paid_count = mysql_num_rows($result_paid);

        // this tap should now be updated

        if($result_paid_count != 0){
            $update_paid_purchase = mysql_query("UPDATE tips_payza SET date='$date', value='$totalAmountReceived', testing='0', paid_email='0', paid='1', gateway='mb' WHERE item_code='$myItemCode'") or die(mysql_error());
        }else{
            die("There was an error, please contact support with the following error code: ".$myItemCode."");
        }
    }
    else
    {
        // Invalid transaction. Bail out
        die("There was an error, please contact support with the following error code: ".$myItemCode."");
    }
?>