<?php
class Reminders{
	var $id;
	var $title;
	var $description;
	var $start_date;
	var $expire_date;
	
	//Database Connection
	var $host = 'localhost';
	var $db_username = 'root';
	var $db_password = '';
	var $db_name = 'reminders';
	var $db_table = 'reminders';
	
	
	function add($newReminder){
		
		$dbLink = mysql_connect($this->host, $this->db_username, $this->db_password);
        if(!$dbLink) die("Could not connect to database. " . mysql_error());

        // Select database
        mysql_select_db($this->db_name);
		$sql = "INSERT INTO $this->db_table VALUES('', 
		'$newReminder->title', 
		'$newReminder->description', 
		NOW(),
		'$newReminder->expire_date');";
		$result = mysql_query($sql);
       
	    // Test to make sure query worked
        if(!$result) die("Query didn't work. " . mysql_error());
		mysql_close($dbLink);
		header("Location: index.php?message=add");
	}
	//Function to delete reminder
	//input reminderID 
	function delete($id){
    	$dbLink = mysql_connect($this->host, $this->db_username, $this->db_password);
        if(!$dbLink) die("Could not connect to database. " . mysql_error());
		
        // Select database
        mysql_select_db($this->db_name);
		
		$query = "DELETE from $this->db_table WHERE id = $id";
		mysql_query($query) 
		or die(mysql_error());
		mysql_close($dbLink);
		header("Location: index.php?message=delete");
	}
	//To display list of Reminders
	//input reminderID 
	function show($id){
	$dbLink = mysql_connect($this->host, $this->db_username, $this->db_password);
        if(!$dbLink) die("Could not connect to database. " . mysql_error());

        // Select database
        mysql_select_db($this->db_name);
		
		$query = "Select * from $this->db_table WHERE id = $id";
		$results = mysql_query ($query);
		while ($row = mysql_fetch_array($results)):	?>
<!--For Popup messages-->
<div id='myForm_errorloc' class='error_strings' style=''></div>
<!--Start Form-->
<form method="post" action="edit.php" name="myForm" id="myForm" class="myForm">
  <div><span class="form-label">Reminder Title</span> <span class="form-text">
    <input type="text" name="title" value="<?php echo $row['title'];?>"/>
    </span></div>
  <div> <span class="form-label">Reminder Description</span> <span class="form-text">
    <input type="text" name="description" value="<?php echo $row['description'];?>"/>
    </span></div>
  <div> <span class="form-label">Reminder Expire Date</span> <span class="form-text">
    <input type="text" name="expire_date" id="expire_date" value="<?php echo $row['expire_date'];?>"/>
    <img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date" style="cursor:pointer;" onclick="javascript:NewCssCal('expire_date','yyyyMMdd','dropdown',true,'24',true);"> </span></div>
  <input type="hidden" name="id" value="<?php echo $row['id'];?>">
  <div><span class="form-submit">
    <input type="submit" name="submit" value="Update Reminder"/>
    </span></div>
</form>
<!--End Form-->
<!--Form Validation-->
<script src='js/gen_validatorv5.js' type='text/javascript'></script>
<script src='js/sfm_moveable_popup.js' type='text/javascript'></script>
<script type='text/javascript'>
var myFormValidator = new Validator("myForm");

myFormValidator.EnableOnPageErrorDisplay();
myFormValidator.SetMessageDisplayPos("right");

myFormValidator.EnableMsgsTogether();
myFormValidator.addValidation("title","req","Please fill in title");

myFormValidator.addValidation("title","maxlen=20","The length of the input for title should not exceed 50");
myFormValidator.addValidation("description","req","Please fill in description");

</script>
<?php endwhile; ?>
<?php 
		
	}
	function edit($id, $reminderObject){
		
		$dbLink = mysql_connect($this->host, $this->db_username, $this->db_password);
        if(!$dbLink) die("Could not connect to database. " . mysql_error());

        // Select database
        mysql_select_db($this->db_name);
		
		$query = "UPDATE $this->db_table SET 
				  title = '$reminderObject->title',
				  description = '$reminderObject->description',
				  expire_date = '$reminderObject->expire_date' 
				  WHERE 
				  id = $id";
				  echo $query;
		mysql_query($query) 
		or die(mysql_error());
		mysql_close($dbLink);
		header("Location: index.php?message=update");		
	}
	
	//To display All Reminders
	//input reminderID 
	function showAll(){
		
		$dbLink = mysql_connect($this->host, $this->db_username, $this->db_password);
        if(!$dbLink) die("Could not connect to database. " . mysql_error());


        // Select database
        mysql_select_db($this->db_name);
		
		$query = "select * from $this->db_table";
		
		$results = mysql_query($query);
		echo '<table class="reminder-list"><thead><tr><th scope="col">Title</th><th>Description</th><th>Start Date</th><th>Expire Date</th><th></th><th></th></tr></thead>';
		if(mysql_num_rows($results)>0):
		while ($row = mysql_fetch_array($results)):
			?>
<tr>
  <td style="font-weight:bold" width="100px"><?php echo $row['title'];?></td>
  <td width="200px"><?php echo $row['description'];?></td>
  <td><?php echo $row['start_date'];?></td>
  <td><?php echo $row['expire_date'];?></td>
  <td style="padding:0px 0px"><a href="edit.php?id=<?php echo $row['id'];?>"><img src="images/edit.gif" title="Edit" width="20" height="20" /></a></td>
  <td style="padding:0px 0px"><a href="delete.php?id=<?php echo $row['id'];?>"><img src="images/delete.gif" title="Delete" width="20" height="20" /></a></td>
</tr>
<?php 			
		endwhile;
		else:
		echo '<tr><td>No reminders found.</td></tr>';
		endif;
		echo '</table>';
			
	}
	
	//To display list of NonExpired Reminders
	//input reminderID 
	function showNonExpired(){
		
		$dbLink = mysql_connect($this->host, $this->db_username, $this->db_password);
        if(!$dbLink) die("Could not connect to database. " . mysql_error());


        // Select database
        mysql_select_db($this->db_name);
		
		$query = "select * from $this->db_table where expire_date > NOW()";
		
		$results = mysql_query($query);
		echo '<table class="reminder-list"><thead><tr><th scope="col">Title</th><th>Description</th><th>Start Date</th><th>Expire Date</th><th></th><th></th></tr></thead>';
		while ($row = mysql_fetch_array($results)):
			?>
<tr>
  <td><?php echo $row['title'];?></td>
  <td><?php echo $row['description'];?></td>
  <td><?php echo $row['start_date'];?></td>
  <td><?php echo $row['expire_date'];?></td>
  <td><a href="edit.php?id=<?php echo $row['id'];?>"><img src="images/edit.gif" title="Edit" width="20" height="20" /></a></td>
  <td><a href="delete.php?id=<?php echo $row['id'];?>"><img src="images/delete.gif" title="Delete" width="20" height="20" /></a> </td>
</tr>
<?php 			
		endwhile;
		echo '</table>';
		
	}
}