<?php session_start(); $year = time() - 100;
/************ Delete the sessions****************/
setcookie('scontactid', null, -1);
setcookie('scontactid', null, -1, '/');
setcookie('sadminid', null, -1);
setcookie('sadminid', null, -1, '/');
echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=index'>";  exit(0); ?>