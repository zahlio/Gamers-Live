<?php
error_reporting(0);



ob_start();
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);
ob_end_clean();


session_start();
$chat_logged_in = $_SESSION['access'];

if($chat_logged_in == 1){

}else{
    $chat_logged_in = 0;
}

$chat_username = $_SESSION['channel_id'];
$chat_channel = $_GET['channel'];

?>
<link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

    <script type="text/javascript">
        var auto_scroll = true;
        var user_status = <?=$chat_logged_in?>;
        var show_menu = false;
        var can_chat;
        var msgUpdate;
        var scrollUpdate;
        var updateSpeed = 5000;
        var msg;
        var slowMode;

        function load(){

            if(user_status == 0){
            document.getElementById('msgbox').value = "Sign up or log in to chat";
            }else{
                document.getElementById('msgbox').value = "Type to chat";
            }
            update();
            getMsg();

            msgUpdate = setInterval(getMsg, updateSpeed);
            scrollUpdate = setInterval(update, 1);
        }

        function update(){
            document.getElementById('menu').style.width = window.innerWidth - 25;
            document.getElementById('msgbox').style.width = window.innerWidth - 130;
            if(window.innerWidth <= 200){
                can_chat = false;
                document.getElementById('chatError').innerHTML = "ERROR: The chat window must be more then 200px wide";
            }else{
                can_chat = true;
            }

        }

        function slowMode(){
            if(updateSpeed == 15000){
                clearInterval(msgUpdate);
                slowMode = setInterval(getMsg, updateSpeed);
            }else{
                location.reload();
            }

        }

        function chatmsg(){
            if(user_status == true){
                document.getElementById('msgbox').value = "";
            }else{
                parent.window.open("<?=$conf_site_url?>/account/login/?link=<?=$chat_channel?>", "_blank");
                window.close();
            }
        }

        function send(){
            document.getElementById('chatError').innerHTML = "";
            if(can_chat == true){
                if(user_status == true){
                    msg = document.getElementById('msgbox').value;
                    if(msg == "Type to chat"){
                        document.getElementById('chatError').innerHTML = "Please type a msg to chat";
                    }else{
                        if (window.XMLHttpRequest)
                        {// code for IE7+, Firefox, Chrome, Opera, Safari
                            xmlhttp=new XMLHttpRequest();
                        }else
                        {// code for IE6, IE5
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange=function()
                        {
                            if (xmlhttp.readyState==4 && xmlhttp.status==200)
                            {
                                error = xmlhttp.responseText;

                                if(error == "TIME"){
                                    document.getElementById('chatError').innerHTML = "You need to wait 5 seconds between sending messages";
                                }
                                if(error == "BANNED"){
                                    document.getElementById('chatError').innerHTML = "You are banned from this chat";
                                }
                                if(error == "LOGIN"){
                                    document.getElementById('chatError').innerHTML = "You need to be logged in before you can chat";
                                }
                                if(error == "EMPTY"){
                                    document.getElementById('chatError').innerHTML = "The chat message can't be shorter then 3 characters";
                                }
                                if(error == "CHANNEL"){
                                    document.getElementById('chatError').innerHTML = "You need to chat form a channel page";
                                }
                                if(error == "SEND"){
                                    document.getElementById('msgbox').value = "";
                                    document.getElementById('chatError').innerHTML = "";
                                }
                            }
                        }
                        xmlhttp.open("GET","<?=$conf_site_url?>/chat/php/send.php?channel=<?=$chat_channel?>&chat="+msg, true);
                        xmlhttp.send();
                        getMsg();
                    }

                }else{
                    parent.window.open("<?=$conf_site_url?>/account/login/?link=<?=$chat_channel?>", "_blank");
                    window.close();
                }
            }else{
                // do nothing
            }
        }
        function menu(){
            show_menu = !show_menu;
            if(show_menu == true){
                document.getElementById('menu').style.display="block";
                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
            }else{
                document.getElementById('menu').style.display="none";
            }
        }

        function getMsg(){
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp_send=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp_send=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp_send.onreadystatechange=function()
            {
                if (xmlhttp_send.readyState==4 && xmlhttp_send.status==200)
                {
                    document.getElementById('msglist').innerHTML=xmlhttp_send.responseText;
                    if(auto_scroll == true){
                        $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    }
                }
            }
            xmlhttp_send.open("GET","<?=$conf_site_url?>/chat/php/get.php?channel=<?=$chat_channel?>", true);
            xmlhttp_send.send();
        }



</script>

<body onload="load()">
    <div id="error">

    </div>
    <div class="content">
        <p id="msglist" class="chat" style="margin-right: 20px; margin-left: 5px"></p>
    </div>

    <div class="buttom_bar">
        <div align="right" id="menu" class="menu" style="display: none;">
            <a title="Toggle auto scroll of the chat on and off" id="autoscroll" class="button_link btn_green" onclick="auto_scroll = !auto_scroll; if(auto_scroll == true){document.getElementById('autoscroll').className = 'button_link btn_green'}else{document.getElementById('autoscroll').className = 'button_link btn_red'}");"><span>Auto scroll</span></a>
            <a title="Toggle slow mode of the chat on and off" id="slowtoggle" class="button_link btn_red" onclick="if(updateSpeed == 5000){updateSpeed = 15000; document.getElementById('slowtoggle').className = 'button_link btn_green'; slowMode();}else{updateSpeed = 5000; document.getElementById('slowtoggle').className = 'button_link btn_red'; slowMode();}");"><span>Slow</span></a>
            <a href="<?=$conf_support?>" title="Get help with the chat" target="_blank">Chat Help</a>
        </div>
        <input onclick="chatmsg()" onkeydown="if (event.keyCode == 13) document.getElementById('chatButton').click()" id="msgbox" class="gamersTextbox" value ="" style="height: 30px; margin-left: 5px" maxlength="200">
        <a title="Send your chat message" id="chatButton" class="button_link" onclick="send()"><span>Chat</span></a>
        <img class="btn_menu" id='menuButton' onclick="menu()" title="Display or hide the chat menu" src="<?=$conf_site_url?>/images/chat/button_menu1.png" style="position:relative; bottom: -12px;">
        <div name="chatError" id="chatError" style="margin-left: 5px; color: red; font-weight: bold"></div>
    </div>
</body>