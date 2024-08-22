<html>

	<head>
		<title>Api controller</title>
	</head>

	<body>

		<h2>Profiles</h2>

		<table cellpadding="3" cellspacing="0" border="1">

			<thead>
				<tr>
					<th>id</th>
					<th>name</th>
					<th>lastname</th>
					<th>phone</th>
					<th>ts_creation</th>
					<th>ts_modification</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($profiles as $profile){ ?>
				<tr>
					<td><?php echo $profile->id; ?></td>
					<td><?php echo $profile->name; ?></td>
					<td><?php echo $profile->lastname; ?></td>
					<td><?php echo $profile->phone; ?></td>
					<td><?php echo $profile->ts_creation; ?></td>
					<td><?php echo $profile->ts_modification; ?></td>
				</tr>
				<?php } ?>
			</tbody>		

		</table>

		<h2>Attributes</h2>

		<table cellpadding="3" cellspacing="0" border="1">

			<thead>
				<tr>
					<th>id</th>
					<th>profile_id</th>
					<th>attribute</th>
					<th>ts_creation</th>
					<th>ts_modification</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($attributes as $attribute){ ?>
				<tr>
					<td><?php echo $attribute->id; ?></td>
					<td><?php echo $attribute->profile_id; ?></td>
					<td><?php echo $attribute->attribute; ?></td>
					<td><?php echo $attribute->ts_creation; ?></td>
					<td><?php echo $attribute->ts_modification; ?></td>
				</tr>
				<?php } ?>
			</tbody>		

		</table>

		<h2>Log</h2>
		<table cellpadding="3" cellspacing="0" border="1">

			<thead>
				<tr>
					<th>date</th>
					<th>method</th>
					<th>uri</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($logs as $log){ ?>
				<tr>
					<td><?php echo $log->date; ?></td>
					<td><?php echo $log->method; ?></td>
					<td><?php echo $log->uri; ?></td>
				</tr>
				<?php } ?>
			</tbody>		

		</table>

	</body>

</html>