<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="ThemeFuse" />
<meta name="Description" content="A short description of your company" />
<meta name="Keywords" content="Some keywords that best describe your business" />
<title>GAMERS LIVE</title>
<link href="http://www.gamers-live.net/style.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://www.gamers-live.net/js/jquery.min.js"></script>
<script type="text/javascript" src="http://www.gamers-live.net/js/preloadCssImages.js"></script>
<script type="text/javascript" src="http://www.gamers-live.net/js/jquery.color.js"></script>

<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/general.js"></script>
<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/jquery.tools.min.js"></script>
<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/jquery.easing.1.3.js"></script>

<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/slides.jquery.js"></script>

<link rel="stylesheet" href="http://www.gamers-live.net/css/prettyPhoto.css" type="text/css" media="screen" />
<script src="http://www.gamers-live.net/js/jquery.prettyPhoto.js" type="text/javascript"></script>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="css/ie.css" />
<![endif]-->
</head>
<?php 
error_reporting(0);
session_start();

if ($_SESSION['access'] != true) {
 $login_box = ' <div class="top_login_box"><a href="http://www.gamers-live.net/account/login/">Sign in</a><a href="http://www.gamers-live.net/account/register/">Register</a></div>';
}else{
$login_box = '<div class="top_login_box"><a href="http://www.gamers-live.net/account/logout/">Logout</a><a href="http://www.gamers-live.net/account/settings/">Settings</a></div>';
}


include_once("http://www.gamers-live.net/analyticstracking.php");
			
$channel_id_get = $_GET['channel'];
$tip = $_GET['tip'];
			
// first we get all info abou the streamer
// we first get data from our mysql database
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

$dir_name = basename(__DIR__);

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
// select the database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());
		
			
$result = mysql_query("SELECT * FROM channels WHERE channel_id='$channel_id_get'");
$row = mysql_fetch_array($result);

$channel_id = $row['channel_id'];
$donate = $row['donate'];
$tip_per = $row['tip_perc'];
$channel_comment = $row['tip_comment'];

$to_us = 100 - $tip_per;			

?>

<body>
<div class="body_wrap thinpage">

<div class="header_image" style="background-image:url(http://www.gamers-live.net/images/header.png)">&nbsp;</div>

<div class="header_menu">
	<div class="container">
		<div class="logo"><a href="http://www.gamers-live.net/"><img src="http://www.gamers-live.net/images/logo.png" alt="" /></a></div>
        <?=$login_box?>
        <div class="top_search">
        	<form id="searchForm" action="http://www.gamers-live.net/browse/" method="get">
                <fieldset>
                	<input type="submit" id="searchSubmit" value="" />
                    <div class="input">
                        <input type="text" name="s" id="s" value="Type & press enter" />
                    </div>                    
                </fieldset>
            </form>
        </div>
        
          <!-- topmenu -->
        <div class="topmenu">
                    <ul class="dropdown">
                        <li><a href="http://www.gamers-live.net/browse/lol/"><span>LoL</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/dota2/"><span>Dota 2</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/hon/"><span>HoN</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/sc2/"><span>SC 2</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/wow/"><span>WoW</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/callofduty/"><span>Call Of Duty</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/minecraft/"><span>Minecraft</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/other/"><span>Others</span></a></li>
                        <li><a href="http://www.gamers-live.net/blog/"><span>Blog</span></a></li>
                        <li><a href="#"><span>More</span></a>                        
                        	<ul>
                                <li><a href="http://www.gamers-live.net/company/about/"><span>About</span></a></li>
                                <li><a href="http://www.gamers-live.net/company/support/"><span>Contact</span></a></li>
                                <li><a href="http://www.gamers-live.net/account/partner/"><span>Partner</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
        	<!--/ topmenu -->
    </div>
</div>     	
<!--/ header -->



<!-- middle -->
<div class="middle full_width">
<div class="container_12">

	<div class="back_title">
    	<div class="back_inner">
		<a href="http://www.gamers-live.net/"><span>Home</span></a>
        </div>
    </div> 	 
   
    
    <!-- content -->
    <div class="content">
    <br />
    <h1>You are about to tip '<?=$channel_id?>'</h1>
    Thank you for choosing to support <?=$channel_id?>, it is people like you who make a difference in the gaming community!<br />
    <br />
    
    <div class="tabs_framed small_tabs">
		<script type="text/javascript">
            function validate_payza(){
                x=document.paymentpayza
                txt=x.ap_amount.value
                if (txt>=2) {
                    return true
                }else{
                    alert("Due to payments fees we do not accept payments below $2. \n\nShould you have more questions please contact support at: www.gamers-live.net/company/support/")
                    return false
                }
        	}
			function validate_2co(){
                x=document.payment2co
                txt=x.li_0_price.value
                if (txt>=2) {
                    return true
                }else{
                    alert("Due to payments fees we do not accept payments below $2. \n\nShould you have more questions please contact support at: www.gamers-live.net/company/support/")
                    return false
                }
        	}
        </script>
                    <ul class="tabs">
                        <li class="current"><a href="#tabs_1_1">Payza</a></li>
                       <!--- <li><a href="#tabs_1_2">2CO</a></li> --->
                    </ul>
                    
                    <div id="tabs_1_1" class="tabcontent" style="display: none;">
                    	<div class="inner">
							<center>
                            <h3>Payza offers Credit Card and Bank payments!</h3>
                            	<form name="paymentpayza" method="post" action="https://secure.payza.com/checkout" onsubmit="return validate_payza()">
                                    <input type="hidden" name="ap_merchant" value="billing@gamers-live.net"/>
                                    <input type="hidden" name="ap_purchasetype" value="service"/>
                                    <label for="ap_amount">Amount</label>
                                    <input type="hidden" name="ap_itemname" value="Tips to: <?=$channel_id?>"/>
                                    <input name="ap_amount" value="15.00" maxlength="10"><br /><br />
                                    <input type="hidden" name="ap_currency" value="USD"/>
                                
                                    <input type="hidden" name="ap_quantity" value="1"/>
                                    <input type="hidden" name="ap_itemcode" value="<?=$channel_id?>"/>
                                
                                    <input type="image" src="https://www.payza.com/images/payza-buy-now.png"/><br /><br />
                            	</form>
                         	</center>
                        </div>
	              	</div>
                    
                    <div id="tabs_1_2" class="tabcontent" style="display: block;">
                    	<div class="inner">
        					<center>
                            <h3>2CO offers Credit Card and Paypal payments!</h3>
                                <form name="payment2co" action='https://www.2checkout.com/checkout/purchase' method='post' onsubmit="return validate_2co()">
                                    <input type='hidden' name='sid' value='1952130' >
                                    <input type='hidden' name='mode' value='2CO' >
                                    <input type='hidden' name='li_0_type' value='product' >
                                    <input type='hidden' name='li_0_name' value='Tips to: <?=$channel_id?>' >
                                    <label for='li_0_price'>Amount</label>
                                    <input name='li_0_price' value='15.00' maxlength="10">
                                    <input type='hidden' name='li_0_quantity' value='1' ><br /><br />
                                    <input type="image" src="cc.gif"/><br /><i>Please note that the payment fee is larger when using 2CO then when using Payza.</i><br />
                                </form>
                            </center>
                        </div>
                    </div>
                </div><i>NOTE: All prices are in $ USD </i>

    
    <br /><br />
    <h2><span>FAQ</span></h2>
    <h3 class="toggle box">Tipping FAQ (Click to Open) <span class="ico"></span></h3>
    <div class="toggle_content boxed" style="display: block;">
                        	
        <div class="faq_question toggle"><span class="faq_q">Q:</span> <span class="faq_title">How much do the streamer receive from my purchase?</span> <span class="ico"></span></div>
            <div class="faq_answer toggle_content" style="display: none;">
            <p>The percentage amount of the purchase the streamer receives varies from streamer to streamer. In the following case the streamer receives <?=$tip_per?>% of the total payment after the payment fee is subtracted (2.50% + $0.25 for Payza). The rest of the purchase is going directly to Gamers Live (in this case it is <?=$to_us?>% of the payments). <br /><br />
            Also note that: The payment fee is subtracted from the streamers percentage and NOT Gamers Live! <br />So in this case if you choose to pay with Payza: <i><?=$tip_per?>% - 2.5% - $0.25 = <?php echo $tip_per-2.5 ?>% - $0.25</i>, of the total purchase. <br />
           	<b>Because of these fixed fee(s) we are not accepting payments under $2.00!</b>
            <br /><br />
            Additional: As Gamers Live is located in Denmark the fixed fee is higher for paying with Payza: 1.90 DKK &#8776; $0.30 USD, but we only charge the streamer the $0.25 and the rest is payed by Gamers Live.
            <br /><br />
            For more information about the payment fee(s), then it can be found <a href="https://www.payza.com/support/payza-transaction-fees">here for Payza</a>.</p>
        </div>
        
        <div class="faq_question toggle"><span class="faq_q">Q:</span> <span class="faq_title">How do i get in touch with you?</span> <span class="ico"></span></div>
            <div class="faq_answer toggle_content" style="display: none;">
            <p>Should you ever need any support or help with a Gamers Live Service, then please check out our <a href="http://www.gamers-live.net/company/support/">support page</a>. Here you will find all the information needed to submit a ticket and recieve support.</p>
        </div>
        
        <div class="faq_question toggle"><span class="faq_q">Q:</span> <span class="faq_title">What payment options do you support?</span> <span class="ico"></span></div>
            <div class="faq_answer toggle_content" style="display: none;">
            <p>We are currently using Payza as our primary payment gateway. Should you need additional information about the supported credit cards etc. then <a href="https://www.payza.com/">see here</a></p>
        </div>
        
        <div class="faq_question toggle"><span class="faq_q">Q:</span> <span class="faq_title">Refunds?</span> <span class="ico"></span></div>
            <div class="faq_answer toggle_content" style="display: none;">
            <p>There is a 14 days refund period after the payment, as stated in our <a href="http://www.gamers-live.net/company/legal/">Terms Of Sale</a>.</p>
            <p>Should you need to do a refund then please contact us at our <a href="http://www.gamers-live.net/company/support/">support page</a>.</p>
        </div>
            
    </div>
    <center>
    <br />   
	<center><img src="http://www.gamers-live.net/images/logos_creditcards.png"/></center>
    </div>
    <!--/ content --> 
    
   
    <div class="clear"></div>
    
</div>
</div>
<!--/ middle -->
<!--/ middle -->

<div class="footer">
<div class="footer_inner">
<div class="container_12">
	
    <div class="grid_8">
    	<h3>Hostse.net</h3>   
		
        <div class="copyright">
		&copy; 2013 GAMERS LIVE. An Hostse.net production. All Rights Reserved. <br /><a href="http://www.gamers-live.net/company/legal/">Terms of Service</a> - <a href="http://www.gamers-live.net/company/support/">Contact</a> -
		<a href="http://www.gamers-live.net/company/legal/">Privacy guidelines</a> - <a href="http://www.gamers-live.net/company/support/">Advertise with Us</a> - <a href="http://www.gamers-live.net/company/about/">About Us</a></p>
		</div>          
    </div>
    
    <div class="grid_4">
    	<h3>Follow us</h3>
        <div class="footer_social">
        	<a href="http://www.gamers-live.net/facebook/" class="icon-facebook">Facebook</a> 
            <a href="http://www.gamers-live.net/twitter/" class="icon-twitter">Twitter</a>
            <a href="http://www.gamers-live.net/rss/" class="icon-rss">RSS</a>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="clear"></div>
</div>
</div>
</div>   

</div>   
</body>
</html>
