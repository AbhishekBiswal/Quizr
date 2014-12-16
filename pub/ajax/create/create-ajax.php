<?php
	session_start();
	echo '<h3>Create Quiz</h3>';
	include('fn/loggedin.php');
	if($loggedin == 0)
	{
?>
	<p class="grayinfo">Please Login To Continue</p>
<?php
	}
	else
	{
?>
<div id="editquiz" class="">
	<div class="quiz">
		<form class="create-quiz-det ajax withhelp" action="/ajax/create/createnew.php">
			<p class="submitinfo"></p>
			<div><input type="text" name="title" placeholder="Title"></div>
			<textarea name="desc" placeholder="Description Here (Optional)"></textarea>

			<br>
			<p class="text-info">Select a Category:
			<select class="select-cat" name="cat">
				<option value="1">General</option>
				<option value="2">Technology</option>
				<option value="3">Gaming</option>
				<option value="4">Sports</option>
				<option value="5">History</option>
				<option value="6">Science</option>
				<option value="7">Music</option>
				<option value="8">Miscellaneous</option>
			</select>
			</p><br>
			</p>
			
			<input class="btn btn-blue" value="Create" type="submit">
		</form>
	</div>

</div>

<?php	
	}
?>