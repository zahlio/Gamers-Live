<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="ThemeFuse" />
<meta name="Description" content="A short description of your company" />
<meta name="Keywords" content="Some keywords that best describe your business" />
<title>GAMERS LIVE - Legal</title>
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
    
    <div class="styled_table table_white"/>
    <br /><div class="tabs_framed">
                
					<ul class="tabs">
                        <li class="current"><a href="#tabs_1_1">Terms Of Service</a></li>
                        <li><a href="#tabs_1_2">Privacy Guidelines</a></li>
                        <li><a href="#tabs_1_3">Terms Of Sale</a></li>
                    </ul>
                    
                    <div id="tabs_1_1" class="tabcontent" style="display: block;">
                    	<div class="inner">
                       	<h1>Terms Of Service</h1>
                        <p>Last modified on&nbsp;<strong>13/02/2013</strong></p>
                        <h2><strong>1. Introduction; Your Agreement  to these Terms of Service.</strong></h2>
  <p>Welcome to the game video management and streaming platform operated by  Gamers Live consisting of the web site available at the URL  http://www.Gamers-Live.net and all related services, software applications and  networks that allow for the authorized streaming and distribution of video  content over the internet (the &ldquo;<strong>Gamers Live Service&nbsp;</strong>&rdquo;). The Gamers  Live Service also includes any other sites or services that link to these Terms  of Service. Other services offered by Gamers Live may be subject to separate  terms.<br>
    The following Terms of Service for the Gamers Live Service is a legal contract  between you, an individual user of at least 13 years of age or a single entity  (&ldquo;&nbsp;<strong>You&nbsp;</strong>&rdquo; or, collectively, &ldquo;&nbsp;<strong>Users&nbsp;</strong>&rdquo;), and  Gamers Live regarding your use of the Gamers Live Service.<br>
    Gamers Live may offer certain  additional services by which you agree to pay fees to Gamers Live, a list of  such services and terms which may be made available on the Gamers Live web  page. If you register and/or use any such paid fee services, you are also bound  by the Gamers Live Terms of Sale. The Gamers Live Terms of Sale is hereby  incorporated by reference.<br>
    PLEASE READ CAREFULLY THE FOLLOWING TERMS OF SERVICE. BY REGISTERING FOR,  ACCESSING, BROWSING, DOWNLOADING FROM OR USING THE GAMERS LIVE SERVICE, YOU  ACKNOWLEDGE THAT YOU HAVE READ, UNDERSTOOD, AND AGREE TO BE BOUND BY THE  FOLLOWING TERMS AND CONDITIONS, INCLUDING ANY ADDITIONAL GUIDELINES AND FUTURE  MODIFICATIONS (COLLECTIVELY, THE &ldquo;&nbsp;<strong>TERMS&nbsp;</strong>&rdquo;). IF AT ANY TIME  YOU DO NOT AGREE TO THESE TERMS, PLEASE IMMEDIATELY TERMINATE YOUR USE OF THE  GAMERS LIVE SERVICE.<br>
    IF YOU ARE USING OR OPENING AN ACCOUNT WITH GAMERS LIVE ON BEHALF OF A  COMPANY, ENTITY, OR ORGANIZATION (COLLECTIVELY, A &ldquo;&nbsp;<strong>SUBSCRIBING  ORGANIZATION&nbsp;</strong>&rdquo;) THEN YOU REPRESENT AND WARRANT THAT YOU: (I) ARE AN  AUTHORIZED REPRESENTATIVE OF THAT SUBSCRIBING ORGANIZATION WITH THE AUTHORITY  TO BIND SUCH ORGANIZATION TO THESE TERMS; (II) HAVE READ THE FOREGOING TERMS;  (III) UNDERSTAND THESE TERMS, AND (IV) AGREE TO THESE TERMS ON BEHALF OF SUCH  SUBSCRIBING ORGANIZATION.</p>
  <h2><strong>2. Eligibility.</strong></h2>

  <p>The Gamers Live Service is not  available to persons under the age of 13 or to any users previously suspended  or removed from the Gamers Live Service by Gamers Live. BY DOWNLOADING,  INSTALLING OR OTHERWISE USING THE GAMERS LIVE SERVICE, YOU REPRESENT THAT YOU  ARE AT LEAST 13 YEARS OF AGE AND HAVE NOT BEEN PREVIOUSLY SUSPENDED OR REMOVED  FROM THE GAMERS LIVE SERVICE.</p>
  <h2><strong>3. Incorporation by Reference.</strong><strong></strong></h2>

  <p>Your privacy is important to Gamers Live. The Gamers Live&nbsp;Privacy Guidelines&nbsp;is  hereby incorporated into these Terms by reference. Please read this notice  carefully for information relating to Gamers Live&rsquo;s collection, use, and  disclosure of your personal information on or from the Gamers Live Service.</p>
  <h2><strong>4. Individual Features and Services.</strong><strong></strong></h2>

  <p>When using the Gamers Live Service, you will be subject to any additional  posted guidelines or rules applicable to specific services and features which  may be posted from time to time (the &ldquo;&nbsp;<strong>Guidelines&nbsp;</strong>&rdquo;). All such  Guidelines are hereby incorporated by reference into these Terms.</p>
  <h2><strong>5. Modification of these Terms.</strong><strong></strong></h2>
  <p>Gamers Live reserves the  right, at our discretion, to change, modify, add, or remove portions of these  Terms at any time. Please check these Terms and any Guidelines periodically for  changes. Your continued use of the Gamers Live Service after the posting of  changes constitutes your binding acceptance of such changes. For any material  changes to these Terms, such amended terms will automatically be effective  thirty days after they are initially posted on the Gamers Live Service. We will  always make a reasonable effort to notify you if we do change these Terms.</p>
  <h2><strong>6. Digital Millennium Copyright Act.</strong>
  </h2>
  <p>Please note that since we respect game designer and publisher and other  content owner rights, it is Gamers Live&rsquo;s policy to respond to notices of  alleged infringement that comply with the Digital Millennium Copyright Act (the  &ldquo;<strong>DMCA&nbsp;</strong>&rdquo;). For more information, please go to Gamers  Live&rsquo;s&nbsp;DMCA Guidelines. Please note that Gamers Live will promptly  terminate without notice any User&rsquo;s access to the Gamers Live Service if that  User is determined by Gamers Live to be a &ldquo;repeat infringer.&rdquo; A repeat  infringer is a User who has been notified by Gamers Live of infringing activity  violations more than twice and/or who has had their Broadcaster Content or any  other user-submitted content removed from the Gamers Live Service more than  twice. In addition, Gamers Live accommodates and does not interfere with  standard technical measures used by copyright owners to protect their  materials.</p>
  <h2><strong>7. Gamers Live Service License  Grant.</strong><strong></strong></h2>
<ol>
    <p><strong>7.1 License Grant to Upload or  Stream.</strong></p>
    <p>Gamers Live  allows certain users (&ldquo;&nbsp;<strong>Broadcaster&nbsp;</strong>&rdquo;) to distribute streaming  live and pre-recorded videos of video game related activities.<br>
      If you sign up  for an account as a Broadcaster, subject to your compliance with the terms and  conditions set out in this Terms of Service, Gamers Live hereby grants to you a  personal, limited, non-exclusive, non-transferable, freely revocable license to  use the Gamers Live Service for the uploading and distributing of authorized  digital content, including videos (&ldquo;&nbsp;<strong>Broadcaster Content&nbsp;</strong>&rdquo;).</p>
    <strong>7.2 Content is Uploaded at Your  Own Risk.</strong><strong></strong>
    <p>Notwithstanding  any obligations hereunder of Gamers Live to protect Broadcaster Content, Gamers  Live cannot guarantee that there will be no unauthorized copying or  distribution of Broadcaster Content nor will Gamers Live be liable for any  copying or usage of the Broadcaster Content not authorized by Gamers Live.</p>
    <strong>7.3</strong> <strong>License Grant to View by  Streaming.</strong>
    <p>If you sign  up for an Account, subject to your compliance with this Terms of Service,  Gamers Live hereby grants to you a personal, limited, non-exclusive,  non-transferable, freely revocable license to view by streaming Broadcaster  Content solely through the Gamers Live Service subject to the license under  which such Broadcaster Content is distributed.</p>
    <strong>7.4</strong> <strong>Reservation of Rights.</strong>
    <p>Gamers Live  reserves all rights not expressly granted in this Terms of Service.</p>
    <strong>	7.5 Prevention of Unauthorized Use.</strong><strong></strong>
    <p>Unless  expressly permitted in writing by Gamers Live, you may not sell, rent, lease,  share or provide access to your Broadcaster account to any third party,  including without limitation charging any remuneration to any third party for  access to administrative rights on your Broadcaster account. Gamers Live  reserves the right to exercise whatever lawful means it deems necessary to  prevent unauthorized use of the Gamers Live Service, including, but not limited  to, technological barriers, IP mapping, and directly contacting your Internet  Service Provider (ISP) regarding such unauthorized use.</p>
</ol>
 
  <h2><strong>	8. Broadcaster Content License  Grant; Representations and Warranties.</strong></h2>
 
<ol>
   
    <p><strong>8.1 License Grant to Gamers Live.</strong></p>
    <p>Unless  otherwise agreed to in a written agreement between you and Gamers Live that was  signed by an authorized representative of Gamers Live:<br>
      a) By  distributing or disseminating Broadcaster Content through the Gamers Live  Service, you hereby grant to Gamers Live a worldwide, non-exclusive,  transferable, assignable, fully paid-up, royalty-free, license to host,  transfer, display, perform, reproduce, distribute, compress or convert for  streaming, and otherwise exploit your Broadcaster Content, in any media formats  and through any media channels, in order to publish and promote such  Broadcaster Content in connection with services offered or to be offered by  Gamers Live. Such license will apply to any form, media, or technology now  known or hereafter developed.<br>
    b) Subject  to section 8.2, below, the foregoing license granted by you terminates as to a  specific piece of Broadcaster Content once you remove or delete such  Broadcaster Content from the Gamers Live Service.</p>
    <strong>8.2</strong> <strong>License Grant to other Gamers  Live users.</strong>
    <p>By  distributing or disseminating Broadcaster Content through the Gamers Live  Service, you hereby grant to each User of the Gamers Live Service that is  authorized to access your Broadcaster Content a perpetual, personal,  non-commercial, non-transferable, non-exclusive license to access and view your  Broadcaster Content.</p>
    <strong>8.3 Broadcaster Content  Representations and Warranties.</strong>
  <p>You are  solely responsible for your Broadcaster Content and the consequences of posting  or publishing them. By uploading and publishing your Broadcaster Content, you  affirm, represent, and warrant that: (1) you are the creator and owner of or  have the necessary licenses, rights, consents, releases and permissions to use  and to authorize Gamers Live and Gamers Live&rsquo;s Users to use your Broadcaster  Content as necessary to exercise the licenses granted by you in this section  and in the manner contemplated by Gamers Live and this Terms of Service; (2)  your Broadcaster Content does not and will not: (a) infringe, violate, or  misappropriate any third-party right, including any copyright, trademark,  patent, trade secret, moral right, privacy right, right of publicity, or any  other intellectual property or proprietary right (b) slander, defame, or libel  any other person; (3) your Broadcaster Content does not contain any viruses,  adware, spyware, worms, or other malicious code or (4) unless you have received  prior written authorization, your Broadcaster Content specifically does not  contain any prerelease or nonpublic beta software or game content or any  confidential information of Gamers Live or third parties. Violators of these  third-party rights may be subject to criminal and civil liability. Gamers Live  reserves all rights and remedies against any Users who violate this Terms of  Service.</p>
  <strong>8.4 Broadcaster Content Disclaimer.</strong>
  <p>You understand  that when using the Gamers Live Service you will be exposed to Broadcaster  Content from a variety of sources, and that Gamers Live is not responsible for  the accuracy, usefulness, or intellectual property rights of or relating to  such Broadcaster Content. You further understand and acknowledge that you may  be exposed to Broadcaster Content that is inaccurate, offensive, indecent or  objectionable, and you agree to waive, and hereby do waive, any legal or  equitable rights or remedies you have or may have against Gamers Live with  respect thereto. Gamers Live does not endorse any Broadcaster Content or any  opinion, recommendation or advice expressed therein, and Gamers Live expressly  disclaims any and all liability in connection with Broadcaster Content. If  notified by a User or a content owner of Broadcaster Content that allegedly  does not conform to this Terms of Service, Gamers Live may investigate the  allegation and determine in its sole discretion whether to remove the  Broadcaster Content, which it reserves the right to do at any time and without  notice. For clarity, Gamers Live does not permit copyright infringing  activities on the Gamers Live Service.</p>
   
</ol>
 
  <h2><strong>9. Prohibited Conduct.</strong></h2>
  <p>	BY USING THE GAMERS LIVE  SERVICE YOU AGREE NOT TO:</p>
 
<ol>
  <ol>
    <li>use the Gamers Live Service for any purposes other than to disseminate or  receive original or appropriately licensed content and/or to access the Gamers  Live Service as such services are offered by Gamers Live;</li>
    <li>rent, lease, loan, sell, resell, sublicense, distribute or otherwise  transfer the licenses granted herein or any Materials (as defined in section  13, below);</li>
    <li>post, upload, or distribute any defamatory, libelous, or inaccurate  Broadcaster Content or other content;</li>
    <li>post, upload, or distribute any Broadcaster Content or other content that  is unlawful or that a reasonable person could deem to be objectionable,  offensive, indecent, pornographic, invasive of another&rsquo;s privacy, harassing,  threatening, embarrassing, distressing, vulgar, hateful, racially or ethnically  offensive, or otherwise inappropriate;</li>
    <li>impersonate any person or entity, falsely claim an affiliation with any  person or entity, or access the Gamers Live Service accounts of others without  permission, forge another persons&rsquo; digital signature, misrepresent the source,  identity, or content of information transmitted via the Gamers Live Service, or  perform any other similar fraudulent activity;</li>
    <li>delete the copyright or other proprietary rights on the Gamers Live Service  or Broadcaster Content;</li>
    <li>make unsolicited offers, advertisements, proposals, or send junk mail or  spam to other Users of the Gamers Live Service. This includes, but is not  limited to, unsolicited advertising, promotional materials, or other  solicitation material, bulk mailing of commercial advertising, chain mail,  informational announcements, charity requests, petitions for signatures,  promotional giveaways (such as raffles and contests), and other similar  activities;</li>
    <li>use the Gamers Live Service for any illegal purpose, or in violation of any  local, state, national, or international law, including, without limitation,  laws governing intellectual property and other proprietary rights, and data  protection and privacy;</li>
    <li>defame, harass, abuse, threaten or defraud Users of the Gamers Live Service,  or collect, or attempt to collect, personal information about Users or third  parties without their consent;</li>
    <li>use the Gamers Live Service if you are under the age of thirteen (13) years  old;</li>
    <li>remove, circumvent, disable, damage or otherwise interfere with  security-related features of the Gamers Live Service or Broadcaster Content,  features that prevent or restrict use or copying of any content accessible  through the Gamers Live Service, or features that enforce limitations on the  use of the Gamers Live Service or Broadcaster Content;</li>
    <li>reverse engineer, decompile, disassemble or otherwise attempt to discover  the source code of the Gamers Live Service or any part thereof, except and only  to the extent that such activity is expressly permitted by applicable law  notwithstanding this limitation;</li>
    <li>modify, adapt, translate or create derivative works based upon the Gamers  Live Service or any part thereof, except and only to the extent that such  activity is expressly permitted by applicable law notwithstanding this limitation;</li>
    <li>intentionally interfere with or damage operation of the Gamers Live Service  or any user&rsquo;s enjoyment of them, by any means, including uploading or otherwise  disseminating viruses, adware, spyware, worms, or other malicious code;</li>
    <li>relay email from a third party&rsquo;s mail servers without the permission of  that third party;</li>
    <li>use any robot, spider, scraper, or other automated means to access the  Gamers Live Service for any purpose or bypass any measures Gamers Live may use  to prevent or restrict access to the Gamers Live Service;</li>
    <li>manipulate identifiers in order to disguise the origin of any Broadcaster  Content transmitted through the Service; or</li>
    <li>interfere with or disrupt the Gamers Live Service or servers or networks  connected to the Gamers Live Service, or disobey any requirements, procedures,  policies or regulations of networks connected to the Gamers Live Service.<br />
    </li>
  </ol>
</ol>
 
  <h2><strong>10. Account</strong></h2>
   <ol>
    <p><strong>10.1 Account and Password.</strong> <br />
      When you use  the Gamers Live Service to upload and/or download or purchase content or any  products, services, or information from Gamers Live, you may be asked to  provide a password. You are solely responsible for maintaining the  confidentiality of your account and password and for restricting access to your  computer, and you agree to accept responsibility for all activities that occur  under your account or password. You agree that the information you provide to  Gamers Live on registration and at all other times will be true, accurate,  current, and complete. You also agree that you will ensure that this  information is kept accurate and up-to-date at all times. If you have reason to  believe that your account is no longer secure (e.g., in the event of a loss,  theft or unauthorized disclosure or use of your account ID, password, or any  credit, debit or charge card number, if applicable), then you agree to  immediately notify Gamers Live. You may be liable for the losses incurred by  Gamers Live or others due to any unauthorized use of your Gamers Live Service  account.</p>
    
   
    <p>	<strong>10.2 Third Party Accounts.</strong><strong></strong><br />
      Gamers Live may  permit you to register for and log onto the Gamers Live Service via certain  third party social networks, such as by using Facebook Connect. If you log in  via such social networks, the profile information connected to the account you  use to log into the Gamers Live Service, including your name, may be used by  Gamers Live in order to provide and support your account. You also acknowledge  and agree that Gamers Live may publish information regarding your use of the  Gamers Live Service to and in connection with any such third party social  network with which you use the Gamers Live Service</p>
    <p>	<strong>10.3 Third-Party Sites, Products  and Services; Links.</strong><strong></strong><br />
      The Gamers  Live Service may include links or references to other web sites or services  solely as a convenience to Users (&ldquo;&nbsp;<strong>Reference Sites&nbsp;</strong>&rdquo;). Gamers  Live does not endorse any such Reference Sites or the information, materials,  products, or services contained on or accessible through Reference Sites. In  addition, your correspondence or business dealings with, or participation in  promotions of, advertisers found on or through the Gamers Live Service are  solely between you and such advertiser. Access and use of Reference Sites,  including the information, materials, products, and services on or available  through Reference Sites is solely at your own risk.</p>
   
</ol>
 
  <h2><strong>	11. Termination; Terms of Service  Violations.</strong></h2>
   <ol>
    <p><strong>11.1 Gamers Live.</strong><strong></strong><br />
      You agree  that Gamers Live, in its sole discretion, for any or no reason, and without  penalty, may terminate any account (or any part thereof) you may have with  Gamers Live or your use of the Gamers Live Service and remove and discard all  or any part of your account, User profile, and any Broadcaster Content, at any  time. Gamers Live may also in its sole discretion and at any time discontinue  providing access to the Gamers Live Service, or any part thereof, with or  without notice. You agree that any termination of your access to the Gamers  Live Service or any account you may have or portion thereof may be effected  without prior notice, and you agree that Gamers Live will not be liable to you  or any third party for any such termination. Any suspected fraudulent, abusive  or illegal activity may be referred to appropriate law enforcement authorities.  These remedies are in addition to any other remedies Gamers Live may have at  law or in equity. As discussed herein, Gamers Live does not permit copyright  infringing activities on the Gamers Live Service, and will terminate access to  the Gamers Live Service, and remove all Broadcaster Content or other content  submitted by any Users who are found to be repeat infringers.</p>
    <p><strong>11.2 You.</strong><strong></strong><br />
      Your only  remedy with respect to any dissatisfaction with (i) the Gamers Live Service,  (ii) any term of this Terms of Service, (iii) any policy or practice of Gamers  Live in operating the Gamers Live Service, or (iv) any content or information  transmitted through the Gamers Live Service, is to terminate this Terms of  Service and your account. You may terminate this Terms of Service at any time  by discontinuing use of any and all parts of the Gamers Live Service.</p>
    <p><strong>11.3 Broadcaster Content.</strong><strong></strong><br />
      Subject to  section 8.2 above, if you notify Gamers Live by submitting email to  admin@Gamers-Live.net, Gamers Live will discontinue prospective hosting and  distribution of your Broadcaster Content.</p>
   </ol>
  <h2><strong>12. Ownership; Proprietary Rights.</strong><strong></strong>
  </h2>
  <p>The Gamers Live Service is  owned and operated by Gamers Live. The visual interfaces, graphics, design,  compilation, information, computer code (including source code or object code),  products, services, and all other elements of the Gamers Live Service provided  by Gamers Live (the &ldquo;Materials&rdquo;) are protected by United States copyright,  trade dress, patent, and trademark laws, international conventions, and all  other relevant intellectual property and proprietary rights, and applicable  laws. Except for any Broadcaster Content that are provided and owned by Users,  all Materials contained on the Gamers Live Service are the property of Gamers  Live or its subsidiaries or affiliated companies and/or third-party licensors.  All trademarks, service marks, and trade names are proprietary to Gamers Live  or its affiliates and/or third-party licensors. Except as expressly authorized  by Gamers Live, you agree not to sell, license, distribute, copy, modify,  publicly perform or display, transmit, publish, edit, adapt, create derivative  works from, or otherwise make unauthorized use of the Materials. Gamers Live  reserves all rights not expressly granted in this Terms of Service.</p>
  <h2><strong>13. Indemnification.</strong><strong></strong>
  </h2>
  <p>You agree to indemnify, save,  and hold Gamers Live, its affiliated companies, contractors, employees, agents  and its third-party suppliers, licensors, and partners harmless from any  claims, losses, damages, liabilities, including legal fees and expenses,  arising out of your use or misuse of the Gamers Live Service, any violation by  you of these Terms, or any breach of the representations, warranties, and  covenants made by you herein. Gamers Live reserves the right, at your expense,  to assume the exclusive defense and control of any matter for which you are  required to indemnify Gamers Live, and you agree to cooperate with Gamers  Live&rsquo;s defense of these claims. Gamers Live will use reasonable efforts to  notify you of any such claim, action, or proceeding upon becoming aware of it.</p>
  <h2><strong>14. Disclaimers; No Warranties.</strong></h2>
 
<ol>
   
    <p><strong> 14.1 No warranties.</strong><br />
      TO THE  FULLEST EXTENT PERMISSIBLE PURSUANT TO APPLICABLE LAW, GAMERS LIVE, AND ITS  AFFILIATES, PARTNERS, AND SUPPLIERS DISCLAIM ALL WARRANTIES, STATUTORY, EXPRESS  OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT OF  PROPRIETARY RIGHTS. NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED  BY YOU FROM GAMERS LIVE OR THROUGH THE GAMERS LIVE SERVICE WILL CREATE ANY  WARRANTY NOT EXPRESSLY STATED HEREIN. YOU EXPRESSLY ACKNOWLEGE THAT AS USED IN  THIS SECTION 15, THE TERM GAMERS LIVE INCLUDES GAMERS LIVE&rsquo;S OFFICERS,  DIRECTORS, EMPLOYEES, SHAREHOLDERS, AGENTS, LICENSORS AND SUBCONTRACTORS.</p>
    <strong>14.2  &ldquo;As is&rdquo; and &ldquo;As available&rdquo; and  &ldquo;With All Faults&rdquo;.</strong><strong></strong>
  <p>YOU  EXPRESSLY AGREE THAT THE USE OF THE GAMERS LIVE SERVICE IS AT YOUR SOLE RISK.  THE GAMERS LIVE SERVICE AND ANY DATA, INFORMATION, THIRD-PARTY SOFTWARE,  CONTENT (INCLUDING BROADCASTER CONTENT), REFERENCE SITES, SERVICES, OR  APPLICATIONS MADE AVAILABLE IN CONJUNCTION WITH OR THROUGH THE GAMERS LIVE  SERVICE ARE PROVIDED ON AN &ldquo;AS IS&rdquo; AND &ldquo;AS AVAILABLE&rdquo;, &ldquo;WITH ALL FAULTS&rdquo; BASIS  AND WITHOUT WARRANTIES OR REPRESENTATIONS OF ANY KIND EITHER EXPRESS OR  IMPLIED.</p>
  <strong>14.3 Service Operation and  Broadcaster Content.</strong><strong></strong>
  <p>GAMERS LIVE,  ITS SUPPLIERS, LICENSORS, AFFILIATES, AND PARTNERS DO NOT WARRANT THAT THE  DATA, CONTENT, FUNCTIONS, OR ANY OTHER INFORMATION OFFERED ON OR THROUGH THE  GAMERS LIVE SERVICE OR ANY REFERENCE SITES WILL BE UNINTERRUPTED, OR FREE OF  ERRORS, VIRUSES OR OTHER HARMFUL COMPONENTS AND DO NOT WARRANT THAT ANY OF THE  FOREGOING WILL BE CORRECTED.</p>
  <strong>14.4 Accuracy.</strong><strong></strong>
  <p>GAMERS LIVE,  ITS SUPPLIERS, LICENSORS, AFFILIATES, AND PARTNERS DO NOT WARRANT OR MAKE ANY  REPRESENTATIONS REGARDING THE USE OR THE RESULTS OF THE USE OF THE GAMERS LIVE  SERVICE OR ANY REFERENCE SITES IN TERMS OF CORRECTNESS, ACCURACY, RELIABILITY,  OR OTHERWISE.</p>
  <strong>14.5 Harm to Your Computer.</strong>
  <p>YOU  UNDERSTAND AND AGREE THAT YOU USE, ACCESS, DOWNLOAD, OR OTHERWISE OBTAIN  INFORMATION, MATERIALS, OR DATA THROUGH THE GAMERS LIVE SERVICE OR ANY  REFERENCE SITES AT YOUR OWN DISCRETION AND RISK AND THAT YOU WILL BE SOLELY  RESPONSIBLE FOR ANY DAMAGE TO YOUR PROPERTY (INCLUDING YOUR COMPUTER SYSTEM) OR  LOSS OF DATA THAT RESULTS FROM THE DOWNLOAD OR USE OF SUCH MATERIAL OR DATA.</p>
  <strong>14.6 Uploaded Content.</strong>
  <p>THE SECURITY  MEASURES TO PROTECT BROADCASTER CONTENT USED BY GAMERS LIVE HEREIN ARE USED IN  CONJUNCTION WITH THE BROADCASTER CONTENT &ldquo;AS-IS&rdquo; AND WITH NO ASSURANCES THAT  SUCH SECURITY MEASURES WILL WITHSTAND ATTEMPTS TO EVADE SECURITY MECHANISMS OR THAT  THERE WILL BE NO CRACKS, DISABLEMENTS OR OTHER CIRCUMVENTION OF SUCH SECURITY  MEASURES.</p>
   
</ol>
 
  <h2><strong>15. Limitation of Liability and  Damages.</strong></h2>
   <ol>
    <p><strong>15.1 Limitation of Liability.</strong><br />
      UNDER NO  CIRCUMSTANCES, INCLUDING, BUT NOT LIMITED TO, NEGLIGENCE, WILL GAMERS LIVE OR ITS  AFFILIATES, CONTRACTORS, EMPLOYEES, AGENTS, OR THIRD-PARTY PARTNERS, LICENSORS,  OR SUPPLIERS BE LIABLE FOR ANY SPECIAL, INDIRECT, INCIDENTAL, CONSEQUENTIAL,  PUNITIVE, RELIANCE, OR EXEMPLARY DAMAGES (INCLUDING WITHOUT LIMITATION DAMAGES  ARISING FROM ANY UNSUCCESSFUL COURT ACTION OR LEGAL DISPUTE, LOST BUSINESS,  LOST REVENUES OR LOSS OF ANTICIPATED PROFITS OR ANY OTHER PECUNIARY OR  NON-PECUNIARY LOSS OR DAMAGE OF ANY NATURE WHATSOEVER) ARISING OUT OF OR  RELATING TO THESE TERMS OR THAT RESULT FROM YOUR USE OR YOUR INABILITY TO USE  THE MATERIALS (INCLUDING BROADCASTER CONTENT) ON THE GAMERS LIVE SERVICE OR ANY  REFERENCE SITES, OR ANY OTHER INTERACTIONS WITH GAMERS LIVE, EVEN IF GAMERS  LIVE OR AN GAMERS LIVE AUTHORIZED REPRESENTATIVE HAS BEEN ADVISED OF THE POSSIBILITY  OF SUCH DAMAGES.</p>
    <p><strong>15.2 Limitation of Damages.</strong><br />
      IN NO EVENT  WILL GAMERS LIVE OR ITS AFFILIATES, CONTRACTORS, EMPLOYEES, AGENTS, OR  THIRD-PARTY PARTNERS, LICENSORS, OR SUPPLIERS TOTAL LIABILITY TO YOU FOR ALL  DAMAGES, LOSSES, AND CAUSES OF ACTION ARISING OUT OF OR RELATING TO THESE TERMS  OR YOUR USE OF THE GAMERS LIVE SERVICE OR YOUR INTERACTION WITH OTHER GAMERS  LIVE SERVICE USERS (WHETHER IN CONTRACT, TORT INCLUDING NEGLIGENCE, WARRANTY,  OR OTHERWISE), EXCEED THE AMOUNT PAID BY YOU, IF ANY, FOR ACCESSING THE GAMERS  LIVE SERVICE DURING THE TWELVE (12) MONTHS IMMEDIATELY PRECEDING THE DATE OF  THE CLAIM OR ONE HUNDRED DOLLARS, WHICHEVER IS GREATER.</p>
    <p><strong>15.3 Reference Sites.</strong><br />
      THESE  LIMITATIONS OF LIABILITY ALSO APPLY WITH RESPECT TO DAMAGES INCURRED BY YOU BY  REASON OF ANY PRODUCTS OR SERVICES SOLD OR PROVIDED ON ANY REFERENCE SITES OR  OTHERWISE BY THIRD PARTIES OTHER THAN GAMERS LIVE AND RECEIVED THROUGH OR  ADVERTISED ON THE GAMERS LIVE SERVICE OR RECEIVED THROUGH ANY REFERENCE SITES.</p>
    <p><strong>	15.4 
      Basis of the Bargain.</strong><strong></strong><br />
      YOU ACKNOWLEDGE  AND AGREE THAT GAMERS LIVE HAS OFFERED ITS PRODUCTS AND SERVICES, SET ITS  PRICES, AND ENTERED INTO THESE TERMS IN RELIANCE UPON THE WARRANTY DISCLAIMERS  AND THE LIMITATIONS OF LIABILITY SET FORTH HEREIN, THAT THE WARRANTY  DISCLAIMERS AND THE LIMITATIONS OF LIABILITY SET FORTH HEREIN REFLECT A  REASONABLE AND FAIR ALLOCATION OF RISK BETWEEN YOU AND GAMERS LIVE, AND THAT  THE WARRANTY DISCLAIMERS AND THE LIMITATIONS OF LIABILITY SET FORTH HEREIN FORM  AN ESSENTIAL BASIS OF THE BARGAIN BETWEEN YOU AND GAMERS LIVE. GAMERS LIVE  WOULD NOT BE ABLE TO PROVIDE THE GAMERS LIVE SERVICE TO YOU ON AN ECONOMICALLY  REASONABLE BASIS WITHOUT THESE LIMITATIONS.</p>
    <p><strong>15.5 Limitations by Applicable Law.</strong><strong></strong><br />
      CERTAIN  JURISDICTIONS DO NOT ALLOW LIMITATIONS ON IMPLIED WARRANTIES OR THE EXCLUSION  OR LIMITATION OF CERTAIN DAMAGES. IF YOU RESIDE IS SUCH A JURISDICTION, SOME OR  ALL OF THE ABOVE DISCLAIMERS, EXCLUSIONS, OR LIMITATIONS MAY NOT APPLY TO YOU,  AND YOU MAY HAVE ADDITIONAL RIGHTS. THE LIMITATIONS OR EXCLUSIONS OF  WARRANTIES, REMEDIES OR LIABILITY CONTAINED IN THIS TERMS OF SERVICE APPLY TO  YOU TO THE FULLEST EXTENT SUCH LIMITATIONS OR EXCLUSIONS ARE PERMITTED UNDER  THE LAWS OF THE JURISDICTION WHERE YOU ARE LOCATED.</p>
   </ol>
  <h2><strong>16. Miscellaneous.</strong></h2>
   <ol>
    <p><strong>16.1 Notice.</strong><br />
      Gamers Live may  provide you with notices, including those regarding changes to Gamers Live&rsquo;s  terms and conditions, by email, regular mail or postings on the Gamers Live  Service. Notice will be deemed given twenty-four hours after email is sent,  unless Gamers Live is notified that the email address is invalid.  Alternatively, we may give you legal notice by mail to a postal address, if  provided by you through the Gamers Live Service. In such case, notice will be  deemed given three days after the date of mailing. Notice posted on the Gamers  Live Service is deemed given 30 days following the initial posting.</p>
    <p><strong>16.2 Waiver.</strong><br />	
      The failure  of Gamers Live to exercise or enforce any right or provision of these Terms  will not constitute a waiver of such right or provision. Any waiver of any  provision of these Terms will be effective only if in writing and signed by  Gamers Live.</p>
    <p><strong>16.3 Governing Law.</strong>
      <br />
      These Terms  will be governed by and construed in accordance with the laws of the Denmark, without giving effect to any principles of conflicts of law.</p>
    <p><strong>16.4 Jurisdiction.</strong><br />
      You agree  that any action at law or in equity arising out of or relating to these Terms  or Gamers Live will be filed only in the state or federal courts in and for  Santa Clara County, California, and you hereby consent and submit to the  personal and exclusive jurisdiction of such courts for the purposes of  litigating any such action.</p>
    <p><strong>16.5 Severability.</strong><br />	
      If any  provision of these Terms or any Guidelines is held to be unlawful, void, or for  any reason unenforceable, then that provision will be limited or eliminated  from these Terms to the minimum extent necessary and will not affect the  validity and enforceability of any remaining provisions.</p>
    <p><strong>16.6 Assignment.</strong><br />	
      These Terms  and related Guidelines, and any rights and licenses granted hereunder, may not  be transferred or assigned by you, but may be assigned by Gamers Live without  restriction. Any assignment attempted to be made in violation of this Terms of  Service shall be void.</p>
    <p><strong>16.7 Survival.</strong><br />	
      Upon  termination of these Terms, any provision which, by its nature or express terms  should survive, will survive such termination or expiration, including, but not  limited to, sections 6, 7.4, 7.5, and 8-18.</p>
    <p><strong>16.8 Headings.</strong><br />
      The heading  references herein are for convenience purposes only, do not constitute a part  of these Terms, and will not be deemed to limit or affect any of the provisions  hereof.</p>
    <p><strong>16.9 Entire Agreement.</strong><br />
      This is the  entire agreement between you and Gamers Live relating to the subject matter  herein and will not be modified except in writing, signed by both parties, or  by a change to these Terms or Guidelines made by Gamers Live as set forth in  section 5 above.</p>
    <p><strong>16.10 Claims.</strong><br />
      YOU AND  GAMERS LIVE AGREE THAT ANY CAUSE OF ACTION ARISING OUT OF OR RELATED TO THE  GAMERS LIVE SERVICE MUST COMMENCE WITHIN ONE (1) YEAR AFTER THE CAUSE OF ACTION  ACCRUES. OTHERWISE, SUCH CAUSE OF ACTION IS PERMANENTLY BARRED.</p>
    <p><strong>	16.11 Disclosures.</strong><strong></strong><br />
      The services  are offered by Gamers Live, located at: 49 Hagenstrupparken, 8860 Ulstrup  DENMARK and email: admin@Gamers-Live.net.<strong></strong></p>
   </ol>
  </div>
                    </div>
                    
                    <div id="tabs_1_2" class="tabcontent" style="display: block;">
                    	<div class="inner">
                    	<h1>Privacy Guidelines</h1>
<br>
<span style="font-weight: bold; font-size: 13px;">
Because Gamers Live takes privacy issues seriously and wants to protect your
rights we have established this Privacy Policy. Please make sure you
understand our policy on this matter and feel free to contact us if you
have any questions or issues regarding this document.</span><br>
<br>
<span style="font-weight: bold;">Personal
Information Usage</span><br>
Gamers Live&nbsp;will not search to sell, rent, lend, exchange or give
your mail address, your zip code or your phone number at a third party
without your explicit permission. The information provided by you are
protected and can’t be found by a outside person. Gamers Live will
use the customer's personal information only as reasonably necessary to
provide contracted services and to collect fees owed.<br>
<br>
<span style="font-weight: bold;">Disclosure
of Personal Information</span><br>
The Customer authorizes Gamers Live to use it's name, business name, city or
country informations and comments in marketing documents or as
testimonials on Gamers Live's web site. At any time, the Customer can send a
written notice to withdraw this authorization. Gamers Live will only
disclose personal information to a third party if required by law as
evidenced by a valid Court Order of competent jurisdiction or to a
collection agency if needed.<br>
<br>
<span style="font-weight: bold;">Disclosure
of Non-Personal Aggregates</span><br>
Gamers Live&nbsp;could share with its partners or third parties a
non-personal anonymous aggregate of informations about its users or web
site visitors. For example, we could provide statistics data about the
number of users of a particular area. The transmitted information is
for statistic and will not reveal in any way your identity.<br>
<br>
<span style="font-weight: bold;">Emails</span><br>
We collect the e-mail addresses of those who communicate with us via
e-mail, aggregate information on what pages visitors access or visit
and information volunteered by the visitor, such as survey information,
inquiries, and/or site registrations. We also send periodic marketing
emails/newsletters.<br>
If you do not want to receive e-mails from us in the future, please let
us know by sending an e-mail to us at the above address and telling us
that you do not want to receive e-mail from our company.<br>
<br>
<span style="font-weight: bold;">Periodic
Mailings</span><br>
If you supply us with your postal address online you may receive
periodic mailings from us with information on new products and services
or upcoming events. If you do not wish to receive such mailings, please
let us know by sending an e-mail to the above address. We will be sure
your name is removed from the list we use for promotional purposes.<br>
<br>
<span style="font-weight: bold;">Voice
Calls</span><br>
Persons who supply us with their telephone numbers online may receive
telephone contact from us with information regarding account
verification or other account related information, billing or
promotions that we believe may be of interest. Please provide us with
your correct phone number.<br>
<br>
<span style="font-weight: bold;">Questions
or Comments</span><br>
For additional questions, please contact our team using our <a href="http://www.gamers-live.net/company/support/">contact form</a>.
                        </div>
					</div>
                    
                    <div id="tabs_1_3" class="tabcontent" style="display: none;">
                    	<div class="inner">
                    	<h1>Terms Of Sale</h1><br />
<span style="font-weight: bold;">Cancellations and Refunds</span><br>
Gamers Live reserves the right to
cancel, suspend, or otherwise restrict
access to the account at any time with or without notice.<br>
Exchange rate fluctuations for
international payments are constant and
unavoidable. All refunds are processed in U.S. dollars, and will
reflect the exchange rate in effect on the date of the refund. All
refunds are subject to this fluctuation and Gamers Live is not responsible
for any change in exchange rates between time of payment and time of
refund.<br>
Gamers Live gives
you an unconditional 14 day money back guarantee all products / services for any customer who paid the first invoice with a credit
card or Paypal.<br>
<br>
Only first-time accounts are
eligible for a refund. For example, if
you've had an account with us before, canceled and signed up again, you
will not be eligible for a refund or if you have opened a second
account with us.<br>
<br>
Violations of the Terms of Service waive the refund policy. No refunds will be provided if service is terminated due to Abuse activities.<br>
                        </div
                    </div>                   
                    
				</div>
    </div></div>
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
