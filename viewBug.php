<?php
	$bug =  $mysqli->real_escape_string(clean_input($_GET['bug']));
	$query = $mysqli->prepare("SELECT * FROM bugs WHERE id=?");
	$query->bind_param('i', $bug);
	$query->execute();
	$query = $query->get_result();
	if($query->num_rows>0){
		while($row = $query->fetch_array(MYSQLI_ASSOC)){
			$bugID		= $row['id'];
			$bugTitle	= $row['name'];
			$bugDesc	= str_replace('\r\n','<br>',$row['desc']);
			//$bugDesc	= html_entity_decode($row['desc']);
			$reporter	= $row['reporter'];
			$bugStats	= $row['status'];
			$bugAdded	= $row['date'];
			$part		= $row['part'];
			$bugStatChange = $row['statusChange'];
			$bugSub='NaN';
			$bugPart='NaN';

			$q = $mysqli->prepare("SELECT username FROM users WHERE id=?");
			$q->bind_param('i',$reporter);
			$q->execute();
			$q=$q->get_result();
			if($q->num_rows==1){
				$bugSub = $q->fetch_array(MYSQLI_NUM)[0];
			}

			$u = $mysqli->prepare("SELECT name FROM parts WHERE id=?");
			$u->bind_param('i', $part);
			$u->execute();
			$u=$u->get_result();
			if($u->num_rows==1){
				$bugPart = $u->fetch_array(MYSQLI_NUM)[0];
			}

			echo "<div class='bug'>";
			echo "	<div class='bug-head'>";
			echo "		<span class='bug-id'><a href='?bug=$bugID'>#$bugID</a></span>";
			echo "		<span class='bug-part'>($bugPart)</span>";
			echo "		<span class='bug-status-holder'>";
			echo "			<span class='bug-status'>Status: $bugStats</span><br>";
			echo "			<span class='bug-statChange'>Change: $bugStatChange</span>";
			echo "		</span><!-- bug-status-holder -->";
			echo "		<br>";
			echo "		<span class='bug-title'><a href='?bug=$bugID'>$bugTitle</a></span>";
			echo "		<br>";
			echo "		<span class='bug-submitter'>Reported by:<span class='bug-submitter-name'> $bugSub</span></span>";
			echo "		<span class='bug-added'>On: $bugAdded</span>";
			echo "		<br>";
			echo "	</div><!-- bug-head -->";
			echo "	<div class='bug-desc'>$bugDesc</div><!-- bug-desc -->";
			echo "</div><!-- bug -->";
		}
	}
?>
