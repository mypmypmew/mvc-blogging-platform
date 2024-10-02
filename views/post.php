
<?php

//TODO : Generate form using Field classes
?>


<h1>Create a New Post</h1>

<form action="" method="post" class="form-horizontal">

	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Post Title</label>
		<div class="col-sm-10">
			<input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" required>
		</div>
	</div>

	<div class="form-group">
		<label for="content" class="col-sm-2 control-label">Post Content</label>
		<div class="col-sm-10">
			<textarea name="content" id="content" class="form-control" rows="5" placeholder="Write your post here..." required></textarea>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-primary">Publish Post</button>
		</div>
	</div>
</form>