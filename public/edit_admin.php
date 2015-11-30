<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>
<?php
if (!isset($_GET["id"])) {
		redirect_to("manage_admin.php");
}
else if (empty($admin=find_admin_by_id($_GET["id"])))	 {
	redirect_to("manage_admin.php");
}

?>
<?php 
if (isset($_POST["submit"])) {
	$required_fields = array("user_name", "password");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("user_name" => 30, "password" => 30 );
	validate_max_length($fields_with_max_lengths);

	if (empty($errors)) {
		$user_name = mysql_prep($_POST["user_name"]);
		$hashed_password = password_encrypt($_POST["password"]);
		$id = (int) $_GET["id"];

		$query  = "UPDATE admins SET ";
		$query .= "username = '{$user_name}', ";
		$query .= "hashed_password = '{$hashed_password}' ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
$result = mysqli_query($connection, $query);
 //Test if there was a query error
if ($result) {
 	// Success
	$_SESSION["message"] = "Admin user editd";
	redirect_to("manage_admin.php"); 
} else {
	//Failure
	$message = "Admin update failed.";
	//redirect_to("edit_admin.php");
} } else {
	//Probably a GET
	//redirect_to("new_page.php?subject=".$subject_id);*/

}}

?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php") ?>
<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
	<div id="page">
		<?php
		if (!empty($message)) {
			echo "<div class=\"message\">".htmlentities($message)."</div>";			
		}	
		?>
		<?php echo form_errors($errors); ?>
		<h2>Edit Admin</h2>
		<form action="edit_admin.php?id=<?php echo "{$_GET["id"]}"; ?>" method="post">
			<p> 
				User name: <input type="text" name="user_name" value="<?php echo "{$admin["username"]}"; ?>">
			</p>
			<p> 
				Password: <input type="password" name="password" value="">
			</p>
			<input type="submit" name="submit" value="Edit Admin" /><br><br>
			<a href="manage_admin.php">Cancel</a>

		</form>
	</div>
</div>

<?php include("../includes/layouts/footer.php") ?>