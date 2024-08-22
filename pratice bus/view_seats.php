<?php
include('db_connection.php');

if (isset($_GET['viewSeats']) && isset($_GET['busId'])):
    $busId = $_GET['busId'];

    $stmt = $conn->prepare("SELECT total_seats FROM buses WHERE id = ?");
    $stmt->bind_param("i", $busId);
    $stmt->execute();
    $stmt->bind_result($totalSeats);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT seat_number, is_booked FROM seats WHERE bus_id = ?");
    $stmt->bind_param("i", $busId);
    $stmt->execute();
    $result = $stmt->get_result();
    $seats = [];
    while ($row = $result->fetch_assoc()) {
        $seats[$row['seat_number']] = $row['is_booked'];
    }
    $stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Seats</title>
    <style>
        .seat {
            width: 50px;
            height: 50px;
            display: inline-block;
            margin: 5px;
            text-align: center;
            line-height: 50px;
            border-radius: 5px;
        }

        .available {
            background-color: lightgreen;
        }

        .booked {
            background-color: lightcoral;
        }
    </style>
</head>
<body>
    <h1>Bus Seats</h1>
    <div class="seats">
        <?php for ($i = 1; $i <= $totalSeats; $i++): ?>
            <div class="seat <?= isset($seats[$i]) && $seats[$i] ? 'booked' : 'available' ?>">
                <?= $i ?>
            </div>
        <?php endfor; ?>
    </div>
</body>
</html>
<?php
else:
    echo "Invalid request.";
endif;
$conn->close();
?>
