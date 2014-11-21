<?php use App\HtmlHelper; ?>


<h1>Accueil</h1>
<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Firstname</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $user) : ?>
		<tr>
			<td><?= $user->Name ?></td>
			<td><?= $user->Firstname ?></td>
			<td><?= $user->Date ?></td>
		</tr>
		<?php endforeach; ?>
	<tbody>

	<form action="<?= HtmlHelper::link('create'); ?>" method="POST">
		<?= HtmlHelper::createForm($userForm); ?>
		<input type="submit">
	</form>

</table>

<p><a href="<?= HtmlHelper::link('test', [65,88]); ?>">Ajouter </a></p>

<p><a href="<?= HtmlHelper::link('new',[65,545]); ?>">new </a></p>