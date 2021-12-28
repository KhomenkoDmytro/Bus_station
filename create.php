<?php
require_once '../config/connect.php';
$DepatureTime=mysqli_real_escape_string($connect, $_POST['DepatureTime']);
$Destination=mysqli_real_escape_string($connect, $_POST['Destination']);
$ArrivalTime=mysqli_real_escape_string($connect, $_POST['ArrivalTime']);
$Day=mysqli_real_escape_string($connect, $_POST['Day']);
$TravelTime=mysqli_real_escape_string($connect, $_POST['TravelTime']);
$Price=mysqli_real_escape_string($connect, $_POST['Price']);

if($Day=="Кожен день"){
    $Day=1;
}
else if($Day=="Парні дні"){
    $Day=2;
}
else if($Day=="Непарні дні"){
    $Day=3;
}
echo $Day;
mysqli_query($connect, "INSERT INTO destination (Destination) VALUES('$Destination');");
mysqli_query($connect, "INSERT INTO route (DestinationID, DayID, TravelTime) 
VALUES((SELECT ID FROM destination WHERE Destination='$Destination'), '$Day', '$TravelTime');");
mysqli_query($connect,"INSERT INTO trip(DepatureTime, ArrivalTime, RouteID, Price) 
VALUES ('$DepatureTime', '$ArrivalTime', (SELECT RouteID FROM route WHERE 
DestinationID=(SELECT ID FROM destination WHERE Destination='$Destination') AND DayID='$Day'
AND TravelTime='$TravelTime'), '$Price');");
header('Location: /');
?>