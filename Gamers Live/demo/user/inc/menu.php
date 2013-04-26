<?php
error_reporting(0);


ob_start();
include_once("../../config.php");
include_once("../../analyticstracking.php");
ob_end_clean();
?>
<!-- topmenu -->
<div class="topmenu">
    <ul class="dropdown">
        <li><a href="<?=$conf_site_url?>/browse/?s=league+of+legends"><span>LoL</span></a></li>
        <li><a href="<?=$conf_site_url?>/browse/?s=dota+2"><span>LoL</span></a></li>
        <li><a href="<?=$conf_site_url?>/browse/?s=Heroes+of+Newerth"><span>HoN</span></a></li>
        <li><a href="<?=$conf_site_url?>/browse/?s=Star+Craft+2"><span>SC 2</span></a></li>
        <li><a href="<?=$conf_site_url?>/browse/?s=World+Of+Warcraft"><span>WoW</span></a></li>
        <li><a href="<?=$conf_site_url?>/browse/?s=Call+Of+Duty"><span>Call Of Duty</span></a></li>
        <li><a href="<?=$conf_site_url?>/browse/?s=Minecraft"><span>Minecraft</span></a></li>
        <li><a href="<?=$conf_site_url?>/browse/"><span>Other</span></a></li>
        <li><a href="<?=$conf_site_url?>/events/"><span>Events</span></a></li>
        <li><a href="#"><span>More</span></a>
            <ul>
                
                <li><a href="<?=$conf_site_url?>/company/support/"><span>Contact</span></a></li>
                <li><a href="<?=$conf_site_url?>/account/partner/"><span>Partner</span></a></li>
            </ul>
        </li>
    </ul>
</div>
<!--/ topmenu -->