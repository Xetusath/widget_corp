<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php 
$username = "";
if (isset($_POST["submit"])) {
	$required_fields = array("username", "password");
	validate_presences($required_fields);

	if (empty($errors)) {
		//attempt login
		$username = $_POST["username"];
		$password = $_POST["password"];
 	$found_admin = attempt_login($username, $password);
 //Test if there was a query error
if ($found_admin) {
 	// Success
 	//mark user as logged in
	$_SESSION["admin_id"] =  $found_admin["id"];
	$_SESSION["username"] =  $found_admin["username"];
	redirect_to("admin.php"); 
} else {
	//Failure
	$message = "Username/password not found";
	//redirect_to("create_admin.php");
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
		<h2>Login</h2>
		<form action="login.php" method="post">
			<p> 
				User name: <input type="text" name="username" value="<?php echo htmlentities($username); ?>">
			</p>
			<p> 
				Password: <input type="password" name="password" value="">
			</p>
			<input type="submit" name="submit" value="Login" /><br><br>

		</form>
	</div>
</div>

<?php include("../includes/layouts/footer.php") ?>