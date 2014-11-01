<?php
	if(isset($_POST['addBug'])){
		$abPart = $mysqli->real_escape_string(clean_input($_POST['addBug-Part']));
		$abName = $mysqli->real_escape_string(clean_input($_POST['addBug-Name']));
		$abDesc =  $mysqli->real_escape_string(clean_input($_POST['addBug-Desc']));
		$reporter = $mysqli->real_escape_string(clean_input($_SESSION['usr']));



		header('location:index.php?searchBugs=true');
	}
?>
Hello thar <?php echo $_SESSION['usr']; ?>.
<div id='whileIn'>
	<div id='whileIn-menu'>
		<form class='whileIn-nav' action='index.php' method='get'>
			<button class='whileIn-nav' name='searchBugs' value='true'>View/Search bugs</button>
		</form>
		<form class='whileIn-nav' action='index.php' method='get'>
			<button class='whileIn-nav' name='reportBugs' value='true'>Report bug</button>
		</form>
	</div><!-- whileIn-menu -->

	<?php
		if(isset($_GET['reportBugs'])){
			include 'addBug.php';
		}
		else{
			include 'searchBug.php';
		}
	?>
</div><!-- whileIn -->
