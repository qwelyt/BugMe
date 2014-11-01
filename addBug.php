	<div id='add-bug'>
		<form action='index.php' method='post'>
			<select name='addBug-Part' required>
				<?php
					$query = $mysqli->prepare("SELECT * FROM parts");
					$query->execute();
					$query = $query->get_result();
					if($query->num_rows > 0){
						while($row = $query->fetch_array(MYSQLI_ASSOC)){
							$id=$row['id'];
							$name=$row['name'];
							echo "<option value='$id'>$name</option>";
						}
					}
				?>
			</select>
			<br>
			<input type='text' name='addBug-Name' placeholder='Bug name...' required><br>
			<textarea name='addBug-Desc' placeholder='Describe the bug...' cols='25' rows='10' required></textarea><br>
			<button type='submit' name='addBug' value='true'>Report bug</button>
		</form>
	</div>
