<?php
include('db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Reservation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .header {
            font-size: 28px;
            color: #007BFF; /* Blue */
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745; /* Green */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #218838; /* Darker green */
        }

        #bus-results {
            margin-top: 20px;
        }

        .bus {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .view-seats {
            display: block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #007BFF; /* Blue */
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-seats:hover {
            background-color: #0056b3; /* Darker blue */
        }

        .seats {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .seat {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .seat.available {
            background-color: #90EE90; /* Light green */
        }

        .seat.booked {
            background-color: #FF6347; /* Tomato */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">RESERVE >> PURCHASE >> ADVENTURE</div>
        <form id="search-form" action="#" method="post">
            <div class="form-group">
                <label for="from">From</label>
                <select id="from" name="from">
                    <option value="">Select departure location</option>
                    <option value="kisumu">KISUMU</option>
                    <option value="mombasa">MOMBASA</option>
                    <option value="nairobi">NAIROBI</option>
                    <option value="kisii">KISII</option>
                    <option value="embu">EMBU</option>
                </select>
            </div>
            <div class="form-group">
                <label for="to">To</label>
                <select id="to" name="to">
                    <option value="">Select destination location</option>
                    <option value="kisumu">KISUMU</option>
                    <option value="mombasa">MOMBASA</option>
                    <option value="nairobi">NAIROBI</option>
                    <option value="kisii">KISII</option>
                    <option value="embu">EMBU</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="text" id="date" name="date" class="datepicker">
            </div>
            <button type="button" onclick="searchBuses()">Search Buses</button>
        </form>
        <div id="bus-results"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // JavaScript
        function searchBuses() {
            const fromLocation = document.getElementById('from').value;
            const toLocation = document.getElementById('to').value;
            const date = document.getElementById('date').value;

            if (!fromLocation || !toLocation || !date) {
                alert('Please fill out all fields.');
                return;
            }

            // Fetch bus data via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `fetch_buses.php?from=${fromLocation}&to=${toLocation}&date=${date}`, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    const resultsContainer = document.getElementById('bus-results');
                    resultsContainer.innerHTML = this.responseText;
                }
            }
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#date", {
                dateFormat: "Y-m-d", // Format to match your PHP date handling
                minDate: "today"    // Optional: restrict to future dates only
            });
        });
    </script>
</body>
</html>
