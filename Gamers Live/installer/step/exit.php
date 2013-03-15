<?php
session_unset();
session_destroy();
header('Location: http://www.gamers-live.net/installer/');
exit;
?>