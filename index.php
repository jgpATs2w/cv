<?
$lang = preg_replace('/(..).+/','$1',$_SERVER['HTTP_ACCEPT_LANGUAGE']);

header("Location: cv_$lang.html");
?>