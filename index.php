<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Persons</title>
	<link rel="stylesheet" href="/css/style.css">
</head>
<body>
	<?php

		include 'person.php';

		//рандомное имя из массива
		$fullname = $example_persons_array[random_int(0, count($example_persons_array) - 1)]['fullname'];
	?>
	<div class="wrapper">
		<h4>Полное ФИО:</h4>
		<div> <?php echo $fullname; ?> </div>

		<h4>Сокращенное ФИО:</h4>
		<div> <?php echo getShortName($fullname); ?> </div>

		<h4>Пол:</h4>
		<div> <?php echo getGenderFromName($fullname); ?> </div>

		<h4>Гендерный состав аудитории:</h4>
		<div> <?php $genderDesc = getGenderDescription($example_persons_array); ?> </div>

		<h3>Подходящая пара:</h3>
		<div> <?php $name = getPartsFromFullname($fullname);
		echo getPerfectPartner($name['surname'], $name['name'], $name['patronymic'], $example_persons_array);
			?>
		</div>
	</div>
</body>
</html>