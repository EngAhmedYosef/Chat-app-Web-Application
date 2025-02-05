<?php 
include_once "conn.php";

?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $translations['Dashboard']?></title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            text-align: center;
        }

        .message h1 {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 20px;
        }

        .message p {
            font-size: 20px;
            color: #555;
        }

        .message {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message">

            <h1><?= $translations['Soon']?>..</h1>
            <p><?= $translations['We are working on improving this page, and we will be here soon! Thank you for your patience']?>.</p>

        </div>
    </div>
</body>

</html>