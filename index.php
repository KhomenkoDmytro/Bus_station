<?php
require_once 'config/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAB7</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <h1>Київський автовокзал</h1>
    <h2>Розклад</h2>
    <table>
    <th>Час відправлення</th>
    <th>Місто відправлення (автовокзал)</th>
    <th>Місто прибуття (автовокзал)</th>
    <th>Час прибуття</th>
    <th>Дні руху</th>
    <th>Час у дорозі</th>
    <th>Ціна квитка, грн</th>
    <?php
        $routes=mysqli_query(
            $connect,"SELECT trip.DepatureTime, route.DepaturePoint, destination.Destination, trip.ArrivalTime, cday.WorkDay, route.TravelTime, trip.Price
        FROM route
        LEFT JOIN destination ON destination.ID=route.DestinationID
        LEFT JOIN cday ON cday.DayID=route.DayID
        INNER JOIN trip ON trip.RouteID=route.RouteID
        ORDER BY trip.DepatureTime ASC");
        $routes=mysqli_fetch_all($routes);
        foreach($routes as $route){
            ?>
            <tr>
                <td><?= $route[0]?></td>
                <td><?= $route[1]?></td>
                <td><?= $route[2]?></td>
                <td><?= $route[3]?></td>
                <td><?= $route[4]?></td>
                <td><?= $route[5]?></td>
                <td><?= $route[6]?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <h2>Пошук рейсу</h2>
    <form method="post">
        <input type="text" name="destination">
        <br>
        <button type="submit">Пошук</button>
    </form>
    <?php if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $Destination=mysqli_real_escape_string($connect, $_POST['destination']);
$sqlDestination=mysqli_query($connect, "SELECT trip.DepatureTime, route.DepaturePoint, destination.Destination,
 trip.ArrivalTime, cday.WorkDay, route.TravelTime, trip.Price
FROM route
LEFT JOIN destination ON destination.ID=route.DestinationID
LEFT JOIN cday ON cday.DayID=route.DayID
INNER JOIN trip ON trip.RouteID=route.RouteID
WHERE '$Destination'=destination.Destination");
$sqlDestination=mysqli_fetch_all($sqlDestination);
if($sqlDestination){
echo "<table>";
echo "<th>Час відправлення</th>";
echo "<th>Місто відправлення (автовокзал)</th>";
echo "<th>Місто прибуття (автовокзал)</th>";
echo "<th>Час прибуття</th>";
echo "<th>Дні руху</th>";
echo "<th>Час у дорозі</th>";
echo "<th>Ціна квитка, грн</th>";
        foreach($sqlDestination as $result){
            echo "<tr>";
                echo "<td>" . $result[0] . "</td>";
                echo "<td>" . $result[1] . "</td>";
                echo "<td>" . $result[2] . "</td>";
                echo "<td>" . $result[3] . "</td>";
                echo "<td>" . $result[4] . "</td>";
                echo "<td>" . $result[5] . "</td>";
                echo "<td>" . $result[6] . "</td>";
            echo "</tr>";
        }
    echo "</table>";
    }
}
?>
    <h2>Додати рейс</h2>
    <form action="vendor/create.php" method="post">
        <div>
            <p>Час відправлення: </p>
        <input type="time" name="DepatureTime"></div>
        <div>
            <p>Місто прибуття: </p>
        <input type="text" name="Destination"></div>
        <div>
            <p>Час прибуття: </p>
        <input type="time" name="ArrivalTime"></div>
        <div>
            <p>Дні руху: </p>
        <input type="radio" id="everyDay" name="Day" value="Кожен день">
        <p>Кожен день</p>
        <input type="radio" id="even" name="Day" value="Парні дні">
        <p>Парні дні</p>
        <input type="radio" id="odd" name="Day" value="Непарні дні">
        <p>Непарні дні</p></div>
        <div>
            <p>Час у дорозі: </p>
        <input type="time" name="TravelTime"></div>
        <div>
        <p>Ціна квитка: </p>
        <input type="number" name="Price">
        </div>
        <div>
            <button type="submit">Додати новий рейс</button>
        </div>
    </form>
</body>
</html>
