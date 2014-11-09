<?php use App\HtmlHelper; ?>

<!DOCTYPE html>
<html>
	<head>
		<title>QuickSimplePHP</title>
	</head>
	<body>
		<h1>Accueil</h1>

		<a href="<?= HtmlHelper::link('create'); ?>">lien</a>
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Surname</th>
					<th>Telephone</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Jack</td>
					<td>Sales</td>
					<td>555-5555</td>
				</tr>
				<tr>
					<td>John</td>
					<td>Admin</td>
					<td>555-5555</td>
				</tr>
				<tr>
					<td>James</td>
					<td>Sales</td>
					<td>555-5555</td>
				</tr>
			<tbody>
			<tfoot>
				<tr>
					<td>Total</td>
					<td>Total</td>
					<td>Total</td>
				</tr>
			</tfoot>
		</table>
	</body>
</html>