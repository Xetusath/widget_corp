<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php") ?>

<?php
$admin_set = find_all_admins();
?>

<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
	<div id="page">
		<?php echo message(); ?>	
		<h2>Manage Admins</h2>
		<table>
			<tr>
				<td>Username</td>
				<td>Actions</td> 
			</tr>
			<?php
			while ($admin = mysqli_fetch_assoc($admin_set)) {
				echo "<tr>";
				echo "<td>".htmlentities($admin["username"])."<br>".htmlentities($admin["hashed_password"])."</td>";
				echo "<td><a href=\"edit_admin.php?id={$admin["id"]}\">Edit</a>&nbsp;<a href=\"delete_admin.php?id={$admin["id"]}\" onclick=\"return confirm('Are you sure?');\">Delete</a></td>"; 
				echo "</tr>"; }
				?>
			</table>
			<br>
			<a href="create_admin.php">+ Add new admin</a>



		</div>
	</div>

	<?php include("../includes/layouts/footer.php") ?>
