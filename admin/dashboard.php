<?php


	session_start();

	if (!isset($_SESSION["adminId"])):
		header('location: login.php');

	else: 
	
	require("../functions.php");
?>

<!DOCTYPE html>
<html lang="pl">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
	<link rel="stylesheet" href="../css/core.css" />

	<title>Dashboard</title>
</head>

<body>
	<div class="col-12">
		<h1 class="text-center font-weight-bold p-5">REZERWACJE</h1>
		<div class="text-center">
			<a href="../index.php" class="m-2">POWRÓT</a> |
			<a href="logout.php" class="m-2">WYLOGUJ</a>
		</div>
	</div>

	<div class="container mt-5">
		<div class="row">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">
						</th>
						<th scope="col">Urządzenie</th>
						<th scope="col">Wypożyczył</th>
						<th scope="col">Koszt</th>
						<th scope="col">Zwrot</th>
					</tr>
				</thead>
				<tbody>

					<?php

					$rows = generate_dashboard();

					for ($i = 0; $i < count($rows); $i++) {
						echo '<tr>';
						echo '<th scope="row">' . ($i + 1) . '</th>';
						echo '<td>' . $rows[$i]['name'] . '</td>';
						echo '<td>' . $rows[$i]['customerName'] . ' ' . $rows[$i]['customerSurname'] . '</td>';
						echo '<td>' . $rows[$i]['cost'] . '</td>';
						echo '<td>' . $rows[$i]['to_date'] . '</td>';
						echo '</tr>';
					}
					?>



				

				
				


				</tbody>
			</table>

			<div class="container">
				<?php		
					if(isset($_POST['doUnavaliable'])) {
						$itemId = $_POST["doUnavaliable"];
						doItemUnavaliable($itemId);
					}
					if(isset($_POST['doAvaliable'])) {
						$itemId = $_POST["doAvaliable"];
						doItemAvaliable($itemId);
					}
				?>
				<div class="dashCars">
					<?php
						$items = getAllItems();
						foreach($items as $item):
					?>
						<div class="dashCar">
							<img src="../assets/<?php echo $item['photo_url']; ?>" alt="<?php echo $item['name']; ?>">
							<span><?php echo $item['name']; ?></span>
							<?php if($item['available'] == 1): ?>
								<p class="ava">dostępny</p>
								<form method="post">
									<button class="button" type="submit" name="doUnavaliable" value="<?php echo $item['id']; ?>">Zmień na niedostępne</button>
								</form>
							<?php else: ?>
								<p class="unav">niedostępny</p>
								<form method="post">
									<button class="button" type="submit" name="doAvaliable" value="<?php echo $item['id']; ?>">Zmień na dostępne</button>
								</form>
							<?php endif; ?>
						
						</div>
					<?php endforeach; ?>
				</div>
			</div>


		</div>
	</div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>



</html>

<?php endif; ?>