<?php use App\HtmlHelper; ?>

<h1>Accueil</h1>

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Firstname</th>
			<th>Date</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $user) : ?>
		<tr>
			<td><?= $user->name ?></td>
			<td><?= $user->firstname ?></td>
			<td><?= $user->date ?></td>
			<td><a href="<?= HtmlHelper::link('edit',[$user->id]); ?>">Edit</a></td>
			<td><a href="<?= HtmlHelper::link('delete',[$user->id]); ?>">Delete</a></td>
		</tr>
		<?php endforeach; ?>
	<tbody>
</table>

<p><a href="<?= HtmlHelper::link('createForm'); ?>">Ajouter </a></p>