<?php require('reminders.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reminders</title>
<link rel="stylesheet" href="css/styles.css" />
<script type="text/javascript" src="js/DateTimePicker.js"></script>
</head>
<body>
<div id="wrapper"> <a href="index.php"><img src="images/images.jpg" width="100" height="100"/><br />
  </a>
  <ul class="menu">
    <li><a href="index.php"><span>Show All</span></a></li>
    <li><a href="index.php?show_non_expired=1"><span>Show Non-Expired Reminders</span></a></li>
  </ul>
 
  <!--Show Popup Messages-->
  <?php if(isset($_REQUEST['message'])): ?>
  <div id="message">
    <?php if( $_REQUEST['message'] == 'add' ): ?>
    Reminder has been added successfully.
    <?php endif; ?>
    <?php if( $_REQUEST['message'] == 'delete' ): ?>
    Reminder has been deleted successfully.
    <?php endif; ?>
    <?php if( $_REQUEST['message'] == 'update' ): ?>
    Reminder has been updated successfully.
    <?php endif; ?>
  </div>
  <?php endif; 
	$reminder_query = new Reminders;
	?>
  <?php 
	if(isset($_REQUEST['show_non_expired']))
	$reminder_query->showNonExpired();
	else
	$reminder_query->showAll();
	?>
	
	<!--Start div For Form-->
  <div id="add_form">
    <ul class="menu">
      <li><a href="#"><span>Add Reminder</span></a></li>
    </ul>
    <script src='js/gen_validatorv5.js' type='text/javascript'></script>
    <script src='js/sfm_moveable_popup.js' type='text/javascript'></script>
    <div id='myForm_errorloc' class='error_strings' style=''></div>
    <form action="add.php" method="post" name="myForm" id="myForm" class="myForm">
      <div><span class="form-label">Reminder Title</span> <span class="form-text">
        <input type="text" name="title"/>
        </span></div>
      <div> <span class="form-label">Reminder Description</span> <span class="form-text">
        <textarea name="description"></textarea>
        </span></div>
      <div> <span class="form-label">Reminder Expire Date</span> <span class="form-text">
        <input type="text" name="expire_date" id="expire_date" />
        <img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date" style="cursor:pointer;" onclick="javascript:NewCssCal('expire_date','yyyyMMdd','dropdown',true,'24',true);"> </span></div>
      <div><span class="form-submit">
        <input type="submit" name="submit" value="Add Reminder"/>
        </span></div>
    </form>
    
	<!-- JavaScript For Form Validation-->
    <script type='text/javascript'> 
		var myFormValidator = new Validator("myForm");
		
		myFormValidator.EnableOnPageErrorDisplay();
		myFormValidator.SetMessageDisplayPos("right");
		
		myFormValidator.EnableMsgsTogether();
		myFormValidator.addValidation("title","req","Please fill in title");
		myFormValidator.addValidation("title","maxlen=20","The length of the input for title should not exceed 50");
		myFormValidator.addValidation("description","req","Please fill in description");
	</script>
  </div>
    <!--End div For Form-->

</div>
</body>
</html>
