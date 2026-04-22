<?php
session_start();
session_destroy();
header("Location: /mvc-project/views/auth/login.php");
exit();
?>
