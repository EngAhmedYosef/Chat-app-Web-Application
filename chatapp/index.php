<?php

include("db.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function aj() {
            var req = new XMLHttpRequest();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    document.getElementById('chat').innerHTML = req.responseText;
                }
            }
            req.open('GET', 'chat.php', true);
            req.send();
        }
        setInterval(function(){aj()},1000);
    </script>
</head>

<body onload="aj();">
    <div id="container">
        <div id="chatbox">

            <div id="chat"></div>

            
        </div>
        <form action="index.php" method="POST">
            <input type="text" name="name" placeholder="Enter Your Name">
            <textarea name="msg" placeholder="Enter Your Message"></textarea>
            <input type="submit" value="Send" name="submit">
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $nam = $_POST['name'];
            $msg = $_POST['msg'];

            $insert = "INSERT INTO chatapp (name,message) VALUES ('$nam','$msg')";
             $run_insert = mysqli_query($con, $insert);
             if ($run_insert) {
                echo'<embed loop="false" hidden="true" src="suond.wav" autoplay="true">';
             }
             header("LOCATION: index.php");
        }
        ?>
    </div>
</body>

</html>