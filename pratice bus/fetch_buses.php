<?php
include('db_connection.php');

if (isset($_GET['from']) && isset($_GET['to']) && isset($_GET['date'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $date = $_GET['date'];

    $stmt = $conn->prepare("SELECT id, bus_name, departure_time, arrival_time FROM buses WHERE from_location = ? AND to_location = ? AND date = ?");
    $stmt->bind_param("sss", $from, $to, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='bus'>
                    <h3>{$row['bus_name']}</h3>
                    <p>Departure: {$row['departure_time']}</p>
                    <p>Arrival: {$row['arrival_time']}</p>
                    <a class='view-seats' href='view_seats.php?busId={$row['id']}'>View Seats</a>
                  </div>";
        }
    } else {
        echo "<p>No buses found for the selected route and date.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid request.</p>";
}

$conn->close();
?>
