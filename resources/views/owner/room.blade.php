<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Rooms</title>

     <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
        <h1>List of Rooms</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Room Number</th>
                <th>Size</th>
                <th>Price per Month</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->room_number }}</td>
                    <td>{{ $room->size }}</td>
                    <td>{{ $room->price_per_month }}</td>
                    <td>{{ $room->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>