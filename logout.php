<?php
session_start();
session_unset();
session_destroy();
session_destroy();
header("Location:index.php");  // adjust path
exit();
