<?php
require_once 'inc\const.php';

session_unregister("SESS_USERID");
session_unregister("SESS_USERNAME");
session_unregister("SESS_USERLEVEL");
//session_unregister("SESS_USERLOCATION");
//session_unregister("SESS_USERSKIN");

header("location:".SITE_BASEURL."index.php");
?>