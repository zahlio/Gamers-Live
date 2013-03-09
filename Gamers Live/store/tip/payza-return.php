<?php
error_reporting(0);

define("IPN_SECURITY_CODE", "Iy5QY4xQsAk1uSqg");
define("MY_MERCHANT_EMAIL", "admin@gamers-live.net");

//Setting information about the transaction
$receivedSecurityCode = $_POST['ap_securitycode'];
$receivedMerchantEmailAddress = $_POST['ap_merchant'];
$transactionStatus = $_POST['ap_status'];
$testModeStatus = $_POST['ap_test'];
$purchaseType = $_POST['ap_purchasetype'];
$totalAmountReceived = $_POST['ap_totalamount'];
$feeAmount = $_POST['ap_feeamount'];
$netAmount = $_POST['ap_netamount'];
$transactionReferenceNumber = $_POST['ap_referencenumber'];
$currency = $_POST['ap_currency'];
$transactionDate= $_POST['ap_transactiondate'];
$transactionType= $_POST['ap_transactiontype'];

//Setting the customer's information from the IPN post variables
$customerFirstName = $_POST['ap_custfirstname'];
$customerLastName = $_POST['ap_custlastname'];
$customerAddress = $_POST['ap_custaddress'];
$customerCity = $_POST['ap_custcity'];
$customerState = $_POST['ap_custstate'];
$customerCountry = $_POST['ap_custcountry'];
$customerZipCode = $_POST['ap_custzip'];
$customerEmailAddress = $_POST['ap_custemailaddress'];

//Setting information about the purchased item from the IPN post variables
$myItemName = $_POST['ap_itemname'];
$myItemCode = $_POST['ap_itemcode'];
$myItemDescription = $_POST['ap_description'];
$myItemQuantity = $_POST['ap_quantity'];
$myItemAmount = $_POST['ap_amount'];

//Setting extra information about the purchased item from the IPN post variables
$additionalCharges = $_POST['ap_additionalcharges'];
$shippingCharges = $_POST['ap_shippingcharges'];
$taxAmount = $_POST['ap_taxamount'];
$discountAmount = $_POST['ap_discountamount'];

//Setting your customs fields received from the IPN post variables
$myCustomField_1 = $_POST['apc_1'];
$myCustomField_2 = $_POST['apc_2'];
$myCustomField_3 = $_POST['apc_3'];
$myCustomField_4 = $_POST['apc_4'];
$myCustomField_5 = $_POST['apc_5'];
$myCustomField_6 = $_POST['apc_6'];

if ($receivedMerchantEmailAddress != MY_MERCHANT_EMAIL) {
    // The data was not meant for the business profile under this email address.
    // Take appropriate action
    die("There was an error, please contact admin@gamers-live.net regarding ERROR CODE: payza-1");
}
else {
    //Check if the security code matches
    if ($receivedSecurityCode != IPN_SECURITY_CODE) {
        // The data is NOT sent by Payza.
        // Take appropriate action.
        die("There was an error, please contact admin@gamers-live.net regarding ERROR CODE: payza-2");
    }
    else {
        if ($transactionStatus == "Success") {

            // so we need to contact the mysql database
            $database_url = "127.0.0.1";
            $database_user = "root";
            $database_pw = "";

            // connect to database
            

            // select the database we need
            

            $date = date("d/m-Y G:i:s");
            if ($testModeStatus == "1") {
                // Since Test Mode is ON, no transaction reference number will be returned.
                // Your site is currently being integrated with Payza IPN for TESTING PURPOSES
                // ONLY. Don't store any information in your production database and
                // DO NOT process this transaction as a real order.

                // we will find where the $ap_itemcode = our stored item_code

                $result_test = mysql_query("SELECT * FROM tips_payza WHERE item_code='$myItemCode'");
                $result_test_count = mysql_num_rows($result_test);

                // this tap should now be updated

                if($result_test_count != 0){
                    $update_test_purchase = mysql_query("UPDATE tips_payza SET date='$date', value='$totalAmountReceived', testing='1', paid_email='$customerEmailAddress', gateway='payza' WHERE item_code='$myItemCode'") or die(mysql_error());
                }else{
                    die("There was an error, please contact support wiht the following error code: ".$myItemCode."");
                }
            }
            else {
                // This REAL transaction is complete and the amount was paid successfully.
                // Process the order here by cross referencing the received data with your database.
                // Check that the total amount paid was the expected amount.
                // Check that the amount paid was for the correct service.
                // Check that the currency is correct.
                // ie: if ($totalAmountReceived == 50) ... etc ...
                // After verification, update your database accordingly.

                $result_paid = mysql_query("SELECT * FROM tips_payza WHERE item_code='$myItemCode'");
                $result_paid_count = mysql_num_rows($result_paid);

                // this tap should now be updated

                if($result_paid_count != 0){
                    $update_paid_purchase = mysql_query("UPDATE tips_payza SET date='$date', value='$totalAmountReceived', testing='0', paid_email='$customerEmailAddress', paid='1', gateway='payza' WHERE item_code='$myItemCode'") or die(mysql_error());
                }else{
                    die("There was an error, please contact support wiht the following error code: ".$myItemCode."");
                }
            }
        }
        else {
            // Transaction was cancelled or an incorrect status was returned.
            // Take appropriate action.
            die("There was an error, please contact admin@gamers-live.net regarding ERROR CODE: payza-3");
        }
    }
}
?>