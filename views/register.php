<?php

$this->title = 'Register';
?>


<h1>Create an account</h1>
<?php $form = \app\core\form\Form::begin('', "post")?>
	<?php echo $form->field($model, 'firstname');?>
	<?php echo $form->field($model, 'lastname')?>
	<?php echo $form->field($model, 'email')?>
	<?php echo $form->field($model, 'password')->passwordField() ?>
	<?php echo $form->field($model, 'confirmPassword')->passwordField()?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php \app\core\form\Form::end()?>

<!--	<div class="mb-3">-->
<!--		<label>First Name</label>-->
<!--		<input type="text" class="form-control" name="firstname">-->
<!---->
<!--	</div>-->
<!--	<div class="mb-3">-->
<!--		<label>Last Name</label>-->
<!--		<input type="text" name="lastname" class="form-control" >-->
<!--	</div>-->
<!--	<div class="mb-3">-->
<!--		<label>Email</label>-->
<!--		<input type="text" name="email" class="form-control" >-->
<!--	</div>-->
<!--	<div class="mb-3">-->
<!--		<label>Password</label>-->
<!--		<input type="text" name="password" class="form-control" >-->
<!--	</div>-->
<!--	<div class="mb-3">-->
<!--		<label>Confirm Password</label>-->
<!--		<input type="text" name="confirmPassword" class="form-control" >-->
<!--	</div>-->


