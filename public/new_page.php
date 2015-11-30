<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php find_selected_page(); ?>

<?php
if (!isset($_GET["subject"])) {
	redirect_to("manage_content.php");
}
?>

<?php 
if (isset($_POST["submit"])) {
	$required_fields = array("menu_name", "position", "content");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_length($fields_with_max_lengths);

	if (empty($errors)) {
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
		$content = mysql_prep($_POST["content"]);
		$subject_id = (int) $current_subject["id"];

		$query  = "INSERT INTO pages (";
			$query .= " subject_id, menu_name, position, visible, content";
			$query .= ") VALUES (";
			$query .= " {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'";
			$query .= ")";
echo $query;
$result = mysqli_query($connection, $query);
 //Test if there was a query error
if ($result) {
 	// Success
	$_SESSION["message"] = "Page created for ".htmlentities($current_subject["menu_name"]).".";
	redirect_to("manage_content.php"); 
} else {
	//Failure
	$_SESSION["message"] = "Page creation failed.";
	redirect_to("new_page.php?subject=".$subject_id);
} } else {
	//Probably a GET
	//redirect_to("new_page.php?subject=".$subject_id);*/
}}

?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php") ?>
<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject, $current_page); ?>
	</div>
	<div id="page">
		<?php
		if (!empty($message)) {
			echo "<div class=\"message\">".htmlentities($message)."</div>";			
		}	
		?>
		<?php echo form_errors($errors); ?>
		<h2>Create Page for <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
		<form id="create_page" action="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
			<p> 
				Menu name: <input type="text" name="menu_name" value="">
			</p>
			<p>
				Position: 
				<select name="position">
					<?php
					$page_set = find_pages_for_subject($current_subject["id"], false);
					$page_count= mysqli_num_rows($page_set);
					for($count=1; $count <= $page_count + 1; $count++) {
						echo "<option value=\"{$count}\">{$count}</option>";					
					}
					?>
				</select>
			</p>
			<p>
				Visible:
				<input type="radio" name="visible" value="0" checked/> No
				&nbsp;
				<input type="radio" name="visible" value="1" /> Yes
			</p>
			<p>
				Content: <br>
				<textarea rows="15" cols="100" name="content" form="create_page"></textarea>
			</p>
			<input type="submit" name="submit" value="Create Page" /><br><br>
			<a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Cancel</a>

		</form>
	</div>
</div>

<?php include("../includes/layouts/footer.php") ?>