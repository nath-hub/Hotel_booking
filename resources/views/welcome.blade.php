<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>SSE demo with PHP</h1>

    <ol id="list">
    </ol>

    <script>
        // Create new event, the server script is sse.php
        var eventSource = new EventSource("http://hotel_booking.test/api/listen-sse-message");

        // Event when receiving a message from the server
        eventSource.onmessage = function(event) {
            // Append the message to the ordered list
            document.getElementById("list").innerHTML += '<li>' + event.data + "</li>";
        };
    </script>
</body>

</html>