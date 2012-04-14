<?php require('reminders.php');

$newReminder = new Reminders;

$newReminder->title = $_REQUEST['title'];
$newReminder->description = $_REQUEST['description'];

$newReminder->start_date = 1;
$newReminder->expire_date = $_REQUEST['expire_date'];

$reminder_query = new Reminders;
$reminder_query->add($newReminder);

?>