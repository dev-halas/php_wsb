<?php
session_start();
if (!isset($_SESSION["customerID"])) :

    header('location: login.php');

else :


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/core.css">
        <link rel="stylesheet" href="../css/dashboard.css">
        <title>User dashboard</title>
    </head>

    <body>


        <div class="container">
            <h1>USER DASHBOARD</h1>
            <div class="buttonsDash">
                <a href="../index.php" class="button">Wróć do strony głównej</a>
                <a href="logout.php" class="button">Wyloguj</a>
            </div>
            <?php

            require_once '../includes/customer/functions.php';





            include '../admin/sql_connect.php';
            $conn = OpenConnDB();
            $customerID = $_SESSION["customerID"];

            $reservations = customerReservation($conn, $customerID);

            ?>

            <div class="reservations">
                <div class="reservations--header">
                    <div class="reservation">
                        <div class="reservation--itemImg">
                            Zdjęcie
                        </div>
                        <div class="reservation--itemName">
                            Konsola
                        </div>
                        <div class="reservation--dateFrom">
                            od kiedy
                        </div>
                        <div class="reservation--dateTo">
                            do kiedy
                        </div>
                        <div class="reservation--cost">
                            całkowity koszt
                        </div>
                    </div>
                </div>
                <?php
                foreach ($reservations as $reservation) {
                ?>

                    <div class="reservation">
                        <div class="reservation--itemImg">
                            <img src="../assets/<?php echo $reservation['photo_url']; ?>" alt="">
                        </div>
                        <div class="reservation--itemName">
                            <?php echo $reservation['name']; ?>
                        </div>
                        <div class="reservation--dateFrom">
                            <?php echo $reservation['from_date']; ?>
                        </div>
                        <div class="reservation--dateTo">
                            <?php echo $reservation['to_date']; ?>
                        </div>
                        <div class="reservation--cost">
                            <?php echo $reservation['cost']; ?> zł
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>

    </body>

    </html>

<?php



endif;

?>
