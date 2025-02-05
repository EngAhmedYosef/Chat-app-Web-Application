<?php
ob_start();
include_once "conn.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location:login.php');
    exit;
} ?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $translations['Home Page']?></title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #001f5b, #d7dce9);
        }

        .container {
            display: flex;
            flex-direction: row;
            height: 132vh;
        }

        .sidebar {
            background: linear-gradient(to bottom, #003f8a, #0057b7);
            width: 20%;
            padding: 20px;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar button {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            background-color: #0057b7;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            text-align: left;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar button:hover {
            background-color: #0073e6;
            transform: translateY(-3px);
        }

        .main {
            width: 80%;
            padding: 20px;
            background: linear-gradient(to top, #d7dce9, #f0f4fa);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #003f8a;
        }

        .header h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        }

        .form-container {
            width: 100%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-container label {
            flex: 1 0 30%;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        .form-container select .S1 {
            flex: 2 0 30%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .logout-button {
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(244, 241, 241, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .logout-button:hover {
            background-color: #002244;
            transform: translateY(-3px);
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .nav-button {
            background-color: #003f8a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .nav-button:hover {
            background-color: #0057b7;
            transform: translateY(-3px);
        }

        .button {
            display: inline-block;
            background: rgb(238, 239, 239);
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['find'])) {
        $action = $_POST['action'] ?? '';
        $program = $_POST['program'] ?? '';
        $section = $_POST['selected_section'] ?? '';
        $edit_item = $_POST['edit_item'] ?? '';

        $routes = [
            'Program Specification' => 'ProgramSpecification.php',
            'Annual Program Report' => 'Annual_Program_Report_Programs.php',
            'Course Report' => 'Course_Report_Reports.php',
            'Course Specification' => 'Course_Specification.php'
        ];

        if (!empty($action) && !empty($program) && !empty($section) && isset($routes[$section])) {
            $destination = $routes[$section] . "?$action=$program";
            header("location: $destination");
            exit;
        } else {
            $_SESSION['message'] = 'Invalid selection.';
        }
    }

    ?>
    <form method="POST" action="">
        <select name="lang" id="language" style="width: 100px; height: 40px; border-radius: 5px;">
            <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
            <option value="ar" <?= $lang === 'ar' ? 'selected' : '' ?>>العربية</option>
        </select>
        <button class="button" type="submit"><?= $translations['language'] ?></button>
    </form>

    <div class="container">


        <div class="sidebar">

            <form method="POST">


                <input type="hidden" id="selected-section" name="selected_section">
                <button type="button" onclick="selectSection('Program Specification')">
                    <?= $translations['Program Specification'] ?>

                </button>
                <button type="button" onclick="selectSection('Annual Program Report')">
                    <?= $translations['Annual Program Report'] ?>

                </button>
                <button type="button" onclick="selectSection('Course Report')">
                    <?= $translations['Course Report'] ?>

                </button>
                <button type="button" onclick="selectSection('Course Specification')">
                    <?= $translations['Course Specification'] ?>

                </button>

            </form>
            <a href="dashboard.php"><button><?= $translations['Dashboard']?></button></a>

        </div>

        <div class="main">

            <div class="header">
                <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                <h3><?= $translations['welcome'] ?></h3>
                <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>

            </div>

            <div class="form-container">
                <?php

                if (isset($_SESSION['message'])) {
                    echo "<p>" . $_SESSION['message'] . "</p>";
                    unset($_SESSION['message']);
                }

                ?>
                <h2>
                    <?= $translations['You need to determine what kind of program you want'] ?>
                </h2>
                <form method="POST">
                    <div class="form-group">
                        <label><?= $translations['Create a new'] ?> <span id="program-name"><?= $translations['program'] ?></span> <?= $translations['or edit an older one'] ?></label>
                        <select name="action" required id="S1" style="width: 100px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <option value="new"><?= $translations['New'] ?></option>
                            <option value="edit"><?= $translations['Edit'] ?></option>
                        </select>
                        <label><?= $translations['Select a program'] ?></label>
                        <select name="program" required id="S2" style="width: 100px; height: 40px;border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <option value="IS"><?= $translations['IS'] ?></option>
                            <option value="CS"><?= $translations['CS'] ?></option>
                        </select>

                        <div class="navigation-buttons">
                            <button type="submit" name="find" class="nav-button"><?= $translations['Find'] ?></button>
                        </div>
                    </div>
                    <input type="hidden" id="hidden-section" name="selected_section">
                </form>
            </div>
        </div>
    </div>

    <script>
        const translations = <?= json_encode($translations); ?>;

        let selectedSection = "";

        function selectSection(section) {
            selectedSection = section;

            // تغيير القيمة المخفية
            document.getElementById("hidden-section").value = section;

            // تغيير النص داخل span باستخدام الترجمة
            document.getElementById("program-name").textContent = translations[section] || section;
        }
    </script>

</body>

</html>