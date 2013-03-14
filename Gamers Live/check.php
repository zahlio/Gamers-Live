<?php
error_reporting(0);
// this is not a public function

// this function is used to check if a key is valid

$serial_key = $_GET['key'];

if($serial_key == ""){
    die("EMPTY");
}

if($serial_key == null){
    die("EMPTY");
}

// Database info
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("store", $connect) or die(mysql_error());

// first we check if there is a key wihh that string

$select_key = mysql_query("SELECT * FROM store_nexus_licensekeys WHERE lkey_key = '$serial_key' AND lkey_active = '1'") or die(mysql_error());
$select_key_results = mysql_fetch_array($select_key);
$select_key_count = mysql_num_rows($select_key);

if($select_key_count < "1"){
    die("BAD");
}

// setting variable
$ps_member = $select_key_results['lkey_member'];

// new we need to check if the key is expired

$select_product = mysql_query("SELECT * from store_nexus_purchases WHERE ps_member = '$ps_member' AND ps_active = '1'") or die(mysql_error());
$select_product_count = mysql_num_rows($select_product);

if($select_product_count >= "1"){
    die("GOOD");
}else{
    die("EXPIRED");
}
?>