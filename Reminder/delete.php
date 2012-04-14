<?php require('reminders.php');

$id = $_REQUEST['id'];

$reminder = new Reminders;
$reminder->delete($id);

?>