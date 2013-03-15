<?php

// should run every month on the 16th

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_site_url."/files/check.php");

$p_day = date("j");
$p_month = date("m");
$p_year = date("Y");

$now = date("d/m-Y G:i:s");

$get_payments = mysql_query("SELECT * FROM tips_payza WHERE paid='1' AND pending='1'") or die(mysql_error());

while($row = mysql_fetch_array($get_payments)){
    if($row['p_month'] >= $p_month){
        // then its from the same month as now
        echo 'test';
    }else{
        // else its not from this month and the payments period is done
        // we need to set pending to 0
        $item_code = $row['item_code'];
        $partner_id = $row['streamer'];
        $amount = $row['value'];
        $item_id = $row['item_code'];
        $update_payment = mysql_query("UPDATE tips_payza SET pending='0' WHERE item_code='$item_code'") or die(mysql_error());
        $insert_to_do = mysql_query("INSERT INTO partner_payments_to_do (partner_id, amount, done, info, item_id) VALUES ('$partner_id', '$amount', '0', 'tips', '$item_id')") or die(mysql_error());
    }

}

exit;

?>