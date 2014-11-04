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
	$query = $mysqli->prepare("SELECT * FROM bugs ORDER BY id DESC");
	$query->execute();
	$query = $query->get_result();
	echo $query->num_rows." bugs found";
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

			// Should probably not display description on this page.
			// List the bug-header, then let the user click on the bug, put the id into
			// a GET variable, and the display it on it's own page. That way 
			// there won't be an as-long page sinc the desc is what takes up the most
			// space. Making it more concise and easier to read.
			echo "<div class='bug'>";
			echo "	<div class='bug-head'>";
			echo "		<span class='bug-id'>$bugID</span>";
			echo "		<span class='bug-part'>($bugPart)</span>";
			echo "		<span class='bug-status-holder'>";
			echo "			<span class='bug-status'>Status: $bugStats</span><br>";
			echo "			<span class='bug-statChange'>Change: $bugStatChange</span>";
			echo "		</span><!-- bug-status-holder -->";
			echo "		<br>";
			echo "		<span class='bug-title'>$bugTitle</span>";
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
