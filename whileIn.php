<?php
	if(isset($_POST['addBug'])){
		$addBug=true;
		$abPart = $mysqli->real_escape_string(clean_input($_POST['addBug-Part']));
		$abName = $mysqli->real_escape_string(clean_input($_POST['addBug-Name']));
		$abDesc =  $mysqli->real_escape_string(clean_input($_POST['addBug-Desc']));
		$reporter = $mysqli->real_escape_string(clean_input($_SESSION['usr']));

		if(!(strlen($abPart)>0)){
			$addBug=false;
		}
		if(!(strlen($abName)>0)){
			$addBug=false;
		}
		if(!(strlen($abDesc)>0)){
			$addBug=false;
		}
		
		if($addBug){
			// First check if users exists and get her ID.
			$query = $mysqli->prepare("SELECT id FROM users WHERE username=?");
			$query->bind_param('s',$reporter);
			$query->execute();
			$query = $query->get_result();
			if(($query->num_rows)==1){ // User exists, and we have the ID.
				$reporterID = $query->fetch_array(MYSQLI_NUM)[0];

				// Now we check if the part the bug is in exists, and get the ID for it. Though we already have it.
				$getPart = $mysqli->prepare("SELECT id FROM parts WHERE id=?");
				$getPart->bind_param('i',$abPart);
				$getPart->execute();
				$getPart = $getPart->get_result();
				if(($getPart->num_rows)==1){ // The part that the bug is in exists, and we have the ID.
					$part = $getPart->fetch_array(MYSQLI_NUM)[0]; // Could use this, or abPart.


					$report = $mysqli->prepare("INSERT INTO `bugs`(`part`,`name`,`desc`,`reporter`,`status`) VALUES(?,?,?,?,?)");
					$report->bind_param('issis', $part, $abName, $abDesc, $reporterID, $status='Open');
					$report->execute();
					if($report){
						echo 'Bug reported.';
					}
					else{
						echo 'Failed to report bug.';
					}
				}
			}
		}



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
