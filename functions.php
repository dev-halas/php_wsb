<?php
include 'admin/sql_connect.php';



function generate_dashboard()
{

    $sql = "SELECT items.name, customers.customerName, customers.customerSurname, reservations.cost, reservations.to_date, items.id FROM reservations INNER JOIN items ON reservations.item_id = items.id INNER JOIN customers ON customers.customerID = reservations.customer_id;";

    $mysqli = OpenConnDB();
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    CloseConDB($mysqli);
}

function reserve($name, $surname, $phone_number, $item_id, $termin, $days, $hours)
{
    global $mysqli;

    $from_date = $termin;

    $to_date = date('Y-m-d H:i', strtotime($from_date . '+ ' . $days . ' days + ' . $hours . ' hours'));

    $sql = "SELECT price FROM items WHERE id = $item_id";

    $result = $mysqli->query($sql);
    $row = $result->fetch_row();

    $price = $row[0];


    $cost = ($days * 24 + $hours) * $price;

    $sql_2 = "INSERT INTO clients (`name`,`surname`,`phone_number`) VALUES (?,?,?)";


    if ($statement = $mysqli->prepare($sql_2)) {
        if ($statement->bind_param('sss', $name, $surname, $phone_number)) {
            $statement->execute();

            $client_id = $mysqli->insert_id;
            $sql_3 = "INSERT INTO reservations(`client_id`, `item_id`,`from_date`,`to_date`,`cost`) VALUES (?,?,?,?,?)";
            if ($statement_2 = $mysqli->prepare($sql_3)) {
                if ($statement_2->bind_param('iissi', $client_id, $item_id, $from_date, $to_date, $cost)) {
                    $statement_2->execute();
                    $mysqli->query("UPDATE items SET available = 0 WHERE id = $item_id");

                    header("Location:index.php");
                }
            }
        }
    } else {
        die('Niepoprawne zapytanie');
        //die('Niepoprawne zapytanie' . $mysqli->errno);????
    }
}

function getAvaliableItems()
{
    $sql = "SELECT id,name,photo_url,type,price FROM items WHERE available >= 1";
    $mysqli = OpenConnDB();
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $avaliableItems = $result->fetch_all(MYSQLI_ASSOC);
        return $avaliableItems;
    }

    CloseConDB($mysqli);
}

function getUnavaliableItems()
{
    $sql = "SELECT items.id,items.name,items.photo_url,items.type,items.price,reservations.to_date FROM items INNER JOIN reservations ON items.id = reservations.item_id
    WHERE items.available = 0";
    $mysqli = OpenConnDB();
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $unavaliableItems = $result->fetch_all(MYSQLI_ASSOC);
        return $unavaliableItems;
    } else {
        echo '<p><u>' . 'Obecnie wszystkie urz??dzenia s?? dost??pne.' . '</u></p>';
    }

    CloseConDB($mysqli);
}

function selectAvaliableItems()
{
    $sql = "SELECT id,name FROM items WHERE available >= 1";
    $mysqli = OpenConnDB();
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $selectItems = $result->fetch_all(MYSQLI_ASSOC);
        return $selectItems;
    }

    CloseConDB($mysqli);
}

function changeItemStatus($item_id)
{
    $mysqli = OpenConnDB();
    $changeStatus_querry = "UPDATE items SET available = 0 WHERE id = $item_id";

    $mysqli->query($changeStatus_querry);

    CloseConDB($mysqli);
}


function doItemUnavaliable($item_id)
{
    $mysqli = OpenConnDB();
    $changeStatus_querry = "UPDATE items SET available = 0 WHERE id = $item_id";

    $mysqli->query($changeStatus_querry);

    CloseConDB($mysqli);
}

function doItemAvaliable($item_id)
{
    $mysqli = OpenConnDB();
    $changeStatus_querry = "UPDATE items SET available = 1 WHERE id = $item_id";

    $mysqli->query($changeStatus_querry);

    CloseConDB($mysqli);
}


function reservation($customerID, $item_id, $termin, $days, $hours)
{
    $mysqli = OpenConnDB();

    $from_date = $termin;

    $to_date = date('Y-m-d H:i', strtotime($from_date . '+ ' . $days . ' days + ' . $hours . ' hours'));

    $sql = "SELECT price FROM items WHERE id = $item_id";

    $result = $mysqli->query($sql);
    $row = $result->fetch_row();

    $price = $row[0];
    $cost = ($days * 24 + $hours) * $price;

    $reservation_querry = "INSERT INTO reservations (customer_id, item_id , from_date, to_date, cost) VALUES (?, ?, ?, ?, ?)";
    $statement = mysqli_stmt_init($mysqli);

    if (!mysqli_stmt_prepare($statement, $reservation_querry)) {
        header("location: /index.php?error=statement_failed");
        exit();
    }

    mysqli_stmt_bind_param($statement, "iissi", $customerID, $item_id, $from_date, $to_date, $cost);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    changeItemStatus($item_id);

    header("Location: user/reservation_success.php");

    CloseConDB($mysqli);
}


function getAllItems()
{
    $sql = "SELECT * FROM items";
    $mysqli = OpenConnDB();
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $avaliableItems = $result->fetch_all(MYSQLI_ASSOC);
        return $avaliableItems;
    }

    CloseConDB($mysqli);
}
