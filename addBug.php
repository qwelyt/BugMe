	<div id='add-bug'>
		<form action='index.php' method='post'>
			<select name='addBug-Part' required>
				<option value='-1'>What part is the bug in?</option>
			</select>
			<br>
			<input type='text' name='addBug-Name' placeholder='Bug name...' required><br>
			<textarea name='addBug-Desc' placeholder='Describe the bug...' cols='25' rows='10' required></textarea><br>
			<button type='submit' name='addBug' value='true'>Report bug</button>
		</form>
	</div>
