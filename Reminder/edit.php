<?php require('reminders.php'); 

if(isset($_POST['submit'])):

$reminder_update = new Reminders;
$reminder_update->id = $_POST['id'];
$reminder_update->title = $_POST['title'];
$reminder_update->description = $_POST['description'];
$reminder_update->expire_date = $_POST['expire_date'];

$reminder_update->edit($reminder_update->id, $reminder_update);

endif;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reminders</title>
<link rel="stylesheet" href="css/styles.css" />
<script type="text/javascript" src="js/DateTimePicker.js"></script>
</head>

<body>
<div style="width:400px; margin:0px auto;">
<a href="index.php"><img src="images/images.jpg" width="100" height="100"/><br />
    </a><ul class="menu">
  <li><a href="index.php"><span>Home</span></a></li>
   </ul>
	
<div id="add_form">
    <?php if(isset($_REQUEST['id'])):

	$reminder_query = new Reminders;
	$reminder_query->show($_REQUEST['id']);
	?>

<?php endif;?>

</div>
</div>
</body>
</html>