<?php
setcookie("empno", "", time()-3600);
setcookie("log", "", time()-3600);
setcookie("fname", "", time()-3600);
echo "<script> alert('Logout');";
echo "window.location.href='main.php'; </script>";
?>