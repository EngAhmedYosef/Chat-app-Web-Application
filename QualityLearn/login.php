<?php
include_once "conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Sign Up</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: radial-gradient(circle, #d7dce9, #001f5b);
            background-size: 200% 200%;
            animation: gradientAnimation 10s infinite alternate;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: center;
            }

            100% {
                background-position: bottom right;
            }
        }

        .container {
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            width: 400px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
        }


        .logo img {
            max-width: 250px;
        }

        h2 {
            margin: 20px 0;
            color: #003f8a;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            background-color: #f2f7fc;
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #003f8a;
            border-radius: 8px;
            font-size: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            padding: 12px 0;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            margin: 10px 0;
            width: 90%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background: linear-gradient(to right, #0057b7, #003f8a);
            transform: translateY(-3px);
        }

        .link {
            margin-top: 10px;
            font-size: 14px;
            color: #003f8a;
        }

        .link a {
            color: #003f8a;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none;
        }

        .button {
            display: inline-block;
            background: rgb(238, 238, 239);
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;

        }
    </style>
</head>

<body>
    <?php

    if (isset($_POST['log_in'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

        $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');
        $row = mysqli_fetch_assoc($select);

        if (mysqli_num_rows($select) > 0) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            @$user_id = $_SESSION['user_id'];

            @$_SESSION['user_id'] = $user_id;
            header('location: HomePage.php');
        } else {
            $_SESSION['message'] = 'Incorrect email or password!';
        }
    }
    ?>


    <div class="content">

        <form method="POST" action="">
            <select name="lang" id="language" style="width: 70px; height: 40px; border-radius: 5px;">
                <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
                <option value="ar" <?= $lang === 'ar' ? 'selected' : '' ?>>العربية</option>
            </select>
            <button class="button" type="submit"><?= $translations['language'] ?></button>
        </form>

        <div class="container">
            <div class="logo">
                <img src="ql-removebg-preview (1).png" alt="Quality Learn Logo">
            </div>

            <!-- Login Form -->
            <form id="loginForm" method="post">
                <h2><?= $translations['Log in'] ?></h2>
                <input name="email" type="email" id="loginEmail" placeholder="<?= $translations['Email'] ?>" required>
                <input name="password" type="password" id="loginPassword" placeholder="<?= $translations['Password'] ?>" required>
                <button name="log_in" type="submit" class="btn"><?= $translations['Log in'] ?></button>

                <?php

                if (isset($_SESSION['message'])) {
                    echo '<span style="color: red;">' . $translations[$_SESSION['message']] . '</span>';
                    unset($_SESSION['message']);
                }
                ?>
            </form>

            <!-- Toggle Links -->
            <div class="link">
                <p id="createAccountLink"><?= $translations['Create new account'] ?> <a href="register.php"><?= $translations['Sign up'] ?></a></p>
                <p id="backToLoginLink" class="hidden"><?= $translations['Already have an account?'] ?> <a href="#"><?= $translations['Log in'] ?></a></p>
            </div>
        </div>
    </div>
</body>

</html>