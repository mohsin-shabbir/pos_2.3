<?php
$postdata1 = file_get_contents("php://input");

$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_select_db("db_test" , $link);
mysql_query("INSERT INTO tbl_curl_receiver (data , status) VALUES('".$postdata1."' , 1)");
mysql_close($link);
?>