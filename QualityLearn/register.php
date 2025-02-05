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
    </style> <!--The End Of Css Code-->
</head>

<body>

    <?php
    

	if (isset($_POST['sign_up'])) {
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$pass = mysqli_real_escape_string($conn, md5($_POST['password']));
		$cpass = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));
		$verfiycode = rand(10000, 99999);


		if ($pass == $cpass) {

			$select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

			if (mysqli_num_rows($select) > 0) {
				$message[] = 'user already exist!';
			} else {
				mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
				$message[] = 'registered successfully!';
				header("location:login.php");
			}
		} else {
			$message[] = "Password Not Matches";
		}
	}

    ?>
    <div class="container">
        <div class="logo">
            <img src="ql-removebg-preview (1).png" alt="Quality Learn Logo"> <!-- The Login logo-->
        </div>

        <!-- Sign Up Form -->
        <form id="signUpForm" method="POST">
            
            <h2><?= $translations['Sign up']?></h2>
            <input name="name" type="text" id="signUpName" placeholder="<?= $translations['Name']?>" required>
            <input name="email" type="email" id="signUpEmail" placeholder="<?= $translations['Email']?>" required>

            <input name="password" type="password" id="signUpPassword" placeholder="<?= $translations['Password']?>" required>


            <input name="confirm_password" type="password" id="confirmPassword" placeholder="<?= $translations['Confirm Password']?>" required>
            <button name="sign_up" type="submit" class="btn"><?= $translations['Sign up']?></button>

            <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<div class="error-message">' . $translations[$_SESSION['message']] . '</div>';
                    }
                }
                ?>

        </form>

        <!-- Toggle Links -->
        <div class="link">
            <p id="backToLoginLink"><?= $translations['Already have an account?']?> <a href="login.php"><?= $translations['Log in']?></a></p>
        </div>
    </div>

    <!-- <script>
        const loginForm = document.getElementById('loginForm');
        const signUpForm = document.getElementById('signUpForm');
        const createAccountLink = document.getElementById('createAccountLink');
        const backToLoginLink = document.getElementById('backToLoginLink');

        createAccountLink.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.classList.add('hidden');         
            signUpForm.classList.remove('hidden');
            createAccountLink.classList.add('hidden');
            backToLoginLink.classList.remove('hidden');
        });

        backToLoginLink.addEventListener('click', (e) => {
            e.preventDefault();
            signUpForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
            backToLoginLink.classList.add('hidden');
            createAccountLink.classList.remove('hidden');
        });

        loginForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const name = document.getElementById('loginName').value;
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            if (name && email && password) {
                alert(`Welcome, ${name}! You have successfully logged in.`);
            } else {
                alert('Please fill in all the fields.');
            }
        });

        signUpForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const name = document.getElementById('signUpName').value;
            const email = document.getElementById('signUpEmail').value;
            const password = document.getElementById('signUpPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (name && email && password && confirmPassword) {
                if (password === confirmPassword) {
                    alert(`Account created successfully for ${name}!`);
                } else {
                    alert('Passwords do not match.');
                }
            } else {
                alert('Please fill in all the fields.');
            }
        });
    </script> -->
</body>

</html>