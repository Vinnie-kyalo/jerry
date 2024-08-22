<?php
include 'db.php';

$from = mysqli_real_escape_string($conn, $_POST['from']);
$to = mysqli_real_escape_string($conn, $_POST['to']);
$number = mysqli_real_escape_string($conn, $_POST['number']);
$date = mysqli_real_escape_string($conn, $_POST['date']);

$sql = "SELECT s.id, b.number as bus_number, r.start_location, r.end_location, s.departure_time 
        FROM schedules s
        JOIN buses b ON s.bus_id = b.id
        JOIN routes r ON s.route_id = r.id
        WHERE r.start_location = '$from' 
        AND r.end_location = '$to' 
        AND b.number = '$number' 
        AND s.departure_time >= '$date'";

$result = $conn->query($sql);

$availableBuses = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $availableBuses[] = $row;
    }
} else {
    $availableBuses = [];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bus Search Results</title>
</head>
<body>
    <h1>Available Coaches</h1>
    <?php if (!empty($availableBuses)) : ?>
        <ul>
            <?php foreach ($availableBuses as $bus) : ?>
                <li>
                    Bus Number: <?php echo htmlspecialchars($bus['bus_number']); ?>,
                    From: <?php echo htmlspecialchars($bus['start_location']); ?>,
                    To: <?php echo htmlspecialchars($bus['end_location']); ?>,
                    Departure Time: <?php echo htmlspecialchars($bus['departure_time']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No available buses found for the specified criteria.</p>
    <?php endif; ?>
    <p>Back to Search</a></p>
</body>
</html>
