<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>

<?php

if (!$_GET["page"]) {
	redirect_to("manage_content.php");
}
$current_page = find_page_by_id($_GET["page"], false);

$id = $current_page["id"];
$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";	
$result = mysqli_query($connection, $query);
    	//Test if there was a query error
if ($result && mysqli_affected_rows($connection) == 1) {
	$_SESSION["message"] = "Page deleted.";
	redirect_to("manage_content.php"); 
} else {
	$_SESSION["message"] = "Page deletion failed.";
	redirect_to("manage_content.php?page={$id}"); 
} 

?>

