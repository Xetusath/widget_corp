<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>

<?php

if (!$_GET["id"]) {
	redirect_to("manage_admin.php");
}

$query = "DELETE FROM admins WHERE id = {$_GET["id"]} LIMIT 1";	
$result = mysqli_query($connection, $query);
    	//Test if there was a query error
if ($result && mysqli_affected_rows($connection) == 1) {
	$_SESSION["message"] = "Admin deleted.";
	redirect_to("manage_admin.php"); 
} else {
	$_SESSION["message"] = "Admin deletion failed.";
	redirect_to("manage_admin.php"); 
} 

?>

