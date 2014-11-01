 <div id='bug-search'>
		Search for a bug
		<span id='bug-search-input'><input type='text' placeholder='Search...'></span>
		<span id='bug-search-id'>
			<select name='bug-searchID'>
				<option value='1'>Fake</option>
			</select>
		</span>
 </div>
<?php
	$query = $mysqli->prepare("SELECT * FROM bugs");
	$query->execute();
	$query = $query->get_result();
	echo $query->num_rows." bugs found";
	if($query->num_rows>0){
		while($row = $query->fetch_array(MYSQLI_ASSOC)){
			$bugID		= $row['id'];
			$bugTitle	= $row['name'];
			$bugDesc	= $row['desc'];
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
			echo "	<span class='bug-title'>$bugTitle</span>";
			echo "	<span class='bug-id'>$bugID</span>";
			echo "	<span class='bug-part'>$bugPart</span>";
			echo "	<span class='bug-submitter'>$bugSub</span>";
			echo "	<span class='bug-status'>$bugStats</span>";
			echo "	<span class='bug-added'>$bugAdded</span>";
			echo "	<span class='bug-statChange'>$bugStatChange</span>";
			echo "	<div class='bug-desc'>$bugDesc</div>";
			echo "</div><!-- bug -->";
		}
	}
?>
