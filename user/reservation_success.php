<?php
session_start();
if (!isset($_SESSION["customerID"])) :

    header('location: login.php');

else :

?>

    <!DOCTYPE html>
    <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/reset.css">
            <link rel="stylesheet" href="../css/core.css">
            <title>Pomyślnie zarezerwowano</title>
        </head>

        <body>
            <div class="resSuccess">

                    <div class="reservationSuccess">
                        <h1>Rezerwacja przebiegła pomyślnie! :) </h1>

                        <div class="buttons">
                            <a href="dashboard.php" class="button">Panel uzytkwonika</a>
                            <a href="../index.php" class="button">Wróć do strony głównej</a>
                        </div>
                    </div>

            </div>
        </body>

    </html>

<?php endif; ?>
