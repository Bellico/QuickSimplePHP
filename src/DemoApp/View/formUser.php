<?php use App\HtmlHelper; ?>

<h1>New</h1>

<form action="<?= HtmlHelper::link('createPost'); ?>" method="POST">
	<?= HtmlHelper::createForm($userForm); ?>
	<input type="submit">
</form>