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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $translations['General Information - CS-2'] ?></title>
    <style>
        .button {
            display: inline-block;
            background: #003f8a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #001f5b, #d7dce9);
        }

        .container {
            display: flex;
            flex-direction: row;
            height: 130vh;
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

        .header h1 {
            color: #003f8a;
            font-size: 28px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header h3 {
            color: #003f8a;
            text-align: center;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        }

        .content-container {
            width: 97%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .content-container h2 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        form label {
            flex: 1 0 40%;
            margin-bottom: 5px;
        }

        form input[type="text"] {
            flex: 2 0 50%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .checkbox-group {
            grid-column: span 2;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .logout-button {
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .nav-button:hover {
            background-color: #003f8a;
            transform: translateY(-3px);
        }


        .content-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        .checkbox-group {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .checkbox-group label {
            display: inline-block;
            margin-right: 10px;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
        }

        button.nav-button {
            background-color: #003f8a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button.nav-button:hover {
            background-color: #0056b3;
        }







        .edit-selection {
    display: flex;
    align-items: center; /* محاذاة العناصر في نفس الخط */
    gap: 10px; /* مسافة بين العناصر */
}

.edit-label {
    font-weight: bold;
    white-space: nowrap; /* منع الانتقال لسطر جديد */
}

.edit-selection select {
    width: 150px;
    height: 36px;
    border-radius: 5px;
    padding: 5px;
}

.edit-selection .button {
    height: 36px;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px 15px;
    cursor: pointer;
}

.edit-selection .button:hover {
    background-color: #0056b3;
}

    </style>
</head>

<body>

    <?php

    if (isset($_GET['new']) && ($_GET['new'] == 'IS' || $_GET['new'] == 'CS')) {
        $program_name = $_GET['new'];

        $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row = mysqli_fetch_assoc($id_query);
        $program_id = $row["id"];

        // حفظ البيانات في الجلسة إذا تم إرسال النموذج
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
            // التحقق من أن جميع الحقول تم ملؤها
            if (
                !empty($_POST['credit_hours']) &&
                !empty($_POST['course_description']) &&
                !empty($_POST['course_level']) &&
                !empty($_POST['course_objectives']) &&
                !empty($_POST['course_type'])
            ) {
                // جلب البيانات من الفورم
                $_SESSION['general_information_new'] = [
                    'credit_hours' => $_POST['credit_hours'],
                    'course_description' => $_POST['course_description'],
                    'course_level' => $_POST['course_level'],
                    'co_requisites' => $_POST['co_requisites'],
                    'pre_requisites' => $_POST['pre_requisites'],
                    'course_objectives' => $_POST['course_objectives'],
                    'course_type' => isset($_POST['course_type']) ? implode(", ", $_POST['course_type']) : '',
                ];

                // إدخال البيانات في الجدول
                $sql = "INSERT INTO general_information (user_id, credit_hours, course_description, course_level, co_requisites, pre_requisites, course_objectives, course_type, program_id)
                VALUES ('$user_id', '{$_SESSION['general_information_new']['credit_hours']}', '{$_SESSION['general_information_new']['course_description']}', '{$_SESSION['general_information_new']['course_level']}', '{$_SESSION['general_information_new']['co_requisites']}', '{$_SESSION['general_information_new']['pre_requisites']}', '{$_SESSION['general_information_new']['course_objectives']}', '{$_SESSION['general_information_new']['course_type']}', '$program_id')";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] = 'Records created successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while inserting data.';
                }
            } else {
                $_SESSION['message'] = "Please fill in all fields.";
            }

            header("location: Course_Specification_General_Info_About_The_Course.php?new=" . $program_name);
            exit;
        }

        // إذا كانت البيانات موجودة في الجلسة، استخدمها
        $general_information_new = isset($_SESSION['general_information_new']) ? $_SESSION['general_information_new'] : [];
    ?>
        <div class="container">
            <div class="sidebar">
                <a href="Course_Specification.php?new=<?php echo $program_name ?>"><button><?= $translations['Courses'] ?></button></a>
                <a href="Course_Specification_General_Info_About_The_Course.php?new=<?php echo $program_name ?>"><button><?= $translations['General Information About The Course'] ?></button></a>
                <a href="Course_Specification_Course_Learning_Outcomes.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes'] ?></button></a>
                <a href="Course_Specification_Course_Content.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Content'] ?></button></a>
                <a href="Course_Spesification_Students_Assessment_Activities.php?new=<?php echo $program_name ?>"><button><?= $translations['Student Assessment Activity'] ?></button></a>
                <a href="Course_Spesification_Learning_Resources_and_Facilities.php?new=<?php echo $program_name ?>"><button><?= $translations['Learning Resources And Facilities'] ?></button></a>
                <a href="Course_Spesification_Assessment_Of_Course_Quality.php?new=<?php echo $program_name ?>"><button><?= $translations['Assessment Of Course Quality'] ?></button></a>
                <a href="Course_Spesification_Specification_Approval.php?new=<?php echo $program_name ?>"><button><?= $translations['Specification Approval'] ?></button></a>
            </div>

            <!-- Main Content -->
            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Course Specification'] ?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>

                <form method="post" id="coursesForm">


                    <div class="content-container">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>
                        <br>

                        <h2><?= $translations['General Information about the Course'] ?></h2>

                        <label><?= $translations['Credit hours'] ?>:</label>
                        <input name="credit_hours" type="text" placeholder="<?= $translations['Enter credit hours'] ?>" value="<?php echo isset($general_information_new['credit_hours']) ? htmlspecialchars($general_information_new['credit_hours']) : ''; ?>">

                        <label><?= $translations['Course General Description'] ?>:</label>
                        <input name="course_description" type="text" placeholder="<?= $translations['Enter course description'] ?>" value="<?php echo isset($general_information_new['course_description']) ? htmlspecialchars($general_information_new['course_description']) : ''; ?>">

                        <label><?= $translations['Level/year at which this course is offered'] ?>:</label>
                        <input name="course_level" type="text" placeholder="<?= $translations['Enter level/year'] ?>" value="<?php echo isset($general_information_new['course_level']) ? htmlspecialchars($general_information_new['course_level']) : ''; ?>">

                        <label><?= $translations['Co-requisites for this course (if any)'] ?>:</label>
                        <input name="co_requisites" type="text" placeholder="<?= $translations['Enter co-requisites'] ?>" value="<?php echo isset($general_information_new['co_requisites']) ? htmlspecialchars($general_information_new['co_requisites']) : ''; ?>">

                        <label><?= $translations['Pre-requisites for this course (if any)'] ?>:</label>
                        <input name="pre_requisites" type="text" placeholder="<?= $translations['Enter pre-requisites'] ?>" value="<?php echo isset($general_information_new['pre_requisites']) ? htmlspecialchars($general_information_new['pre_requisites']) : ''; ?>">

                        <label><?= $translations['Course Main Objective(s)'] ?>:</label>
                        <input name="course_objectives" type="text" placeholder="<?= $translations['Enter main objectives'] ?>" value="<?php echo isset($general_information_new['course_objectives']) ? htmlspecialchars($general_information_new['course_objectives']) : ''; ?>">

                        <div class="checkbox-group">
                            <label><?= $translations['Course Type'] ?> :</label>
                            <label><input type="checkbox" name="course_type[]" value="University" <?php echo (isset($general_information_new['course_type']) && strpos($general_information_new['course_type'], 'University') !== false) ? 'checked' : ''; ?>> <?= $translations['University'] ?></label>
                            <label><input type="checkbox" name="course_type[]" value="College" <?php echo (isset($general_information_new['course_type']) && strpos($general_information_new['course_type'], 'College') !== false) ? 'checked' : ''; ?>> <?= $translations['College'] ?></label>
                            <label><input type="checkbox" name="course_type[]" value="Department" <?php echo (isset($general_information_new['course_type']) && strpos($general_information_new['course_type'], 'Department') !== false) ? 'checked' : ''; ?>> <?= $translations['Department'] ?></label>
                            <label><input type="checkbox" name="course_type[]" value="Track" <?php echo (isset($general_information_new['course_type']) && strpos($general_information_new['course_type'], 'Track') !== false) ? 'checked' : ''; ?>> <?= $translations['Track'] ?></label>
                            <label><input type="checkbox" name="course_type[]" value="Others" <?php echo (isset($general_information_new['course_type']) && strpos($general_information_new['course_type'], 'Others') !== false) ? 'checked' : ''; ?>> <?= $translations['Others'] ?></label>
                        </div>


                        <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_General_Info_About_The_Course_TABLES.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                    </div>
            </div>
            </form>

        </div>
        </div>

        <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                <p><?= $translations['You have unsaved data. Do you want to leave without saving?'] ?></p>
                <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave'] ?></button>
                <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay'] ?></button>
            </div>
        </div>

    <?php }
    ?>










    <?php
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // جلب ID البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // إعداد المتغيرات الافتراضية
        $edit_item = $_POST['edit_item'] ?? '';
        $credit_hours = '';
        $course_description = '';
        $course_level = '';
        $co_requisites = '';
        $pre_requisites = '';
        $course_objectives = '';
        $course_type = [];

        // استرجاع البيانات عند اختيار ID
        if (isset($_POST['edit_row']) && $edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM general_information WHERE id = '$edit_item' AND user_id = '$user_id'");
            if ($row = mysqli_fetch_assoc($query)) {
                // حفظ البيانات في الـ $_SESSION لتعديلها لاحقاً
                $_SESSION['general_information_edit'] = [
                    'id' => $row['id'],  // إضافة الـ ID
                    'credit_hours' => $row['credit_hours'],
                    'course_description' => $row['course_description'],
                    'course_level' => $row['course_level'],
                    'co_requisites' => $row['co_requisites'],
                    'pre_requisites' => $row['pre_requisites'],
                    'course_objectives' => $row['course_objectives'],
                    'course_type' => explode(", ", $row['course_type']),
                ];
            }
        }

        // حفظ البيانات (Insert أو Update)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if (
                !empty($_POST['credit_hours']) &&
                !empty($_POST['course_description']) &&
                !empty($_POST['course_level']) &&
                !empty($_POST['course_objectives']) &&
                !empty($_POST['course_type'])
            ) {
                $credit_hours = $conn->real_escape_string($_POST['credit_hours']);
                $course_description = $conn->real_escape_string($_POST['course_description']);
                $course_level = $conn->real_escape_string($_POST['course_level']);
                $co_requisites = $conn->real_escape_string($_POST['co_requisites']);
                $pre_requisites = $conn->real_escape_string($_POST['pre_requisites']);
                $course_objectives = $conn->real_escape_string($_POST['course_objectives']);
                $course_type = implode(", ", $_POST['course_type']);

                $id = $_SESSION['general_information_edit']['id'];  // استرجاع الـ ID من الـ session

                if ($id) {
                    // تحديث البيانات
                    $sql = "UPDATE general_information SET 
                    credit_hours = '$credit_hours',
                    course_description = '$course_description',
                    course_level = '$course_level',
                    co_requisites = '$co_requisites',
                    pre_requisites = '$pre_requisites',
                    course_objectives = '$course_objectives',
                    course_type = '$course_type'
                    WHERE id = '$id' AND user_id = '$user_id'";
                } else {
                    // إدخال بيانات جديدة
                    $sql = "INSERT INTO general_information (user_id, credit_hours, course_description, course_level, co_requisites, pre_requisites, course_objectives, course_type, program_id)
                    VALUES ('$user_id', '$credit_hours', '$course_description', '$course_level', '$co_requisites', '$pre_requisites', '$course_objectives', '$course_type', '$program_id')";
                }

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] = 'Records Updated successfully!';
                    // حفظ البيانات المحدثة في الـ session
                    $_SESSION['general_information_edit'] = [
                        'id' => $id,  // إضافة الـ ID
                        'credit_hours' => $credit_hours,
                        'course_description' => $course_description,
                        'course_level' => $course_level,
                        'co_requisites' => $co_requisites,
                        'pre_requisites' => $pre_requisites,
                        'course_objectives' => $course_objectives,
                        'course_type' => explode(", ", $course_type),
                    ];
                } else {
                    $_SESSION['message'] = 'Error occurred: ' . $conn->error;
                }

                header("location: Course_Specification_General_Info_About_The_Course.php?edit=" . $program_name);
                exit;
            } else {
                $_SESSION['message'] = "Please fill in all fields.";
            }
        }

        if (isset($_POST["next"])) {
            header("location: Course_Specification_General_Info_About_The_Course_TABLES.php?edit=" . $program_name);
            exit;
        }

        if (isset($_POST["back"])) {
            header("location: Course_Specification.php.php?edit=" . $program_name);
            exit;
        }
    ?>


        <div class="container">
            <div class="sidebar">
                <a href="Course_Specification.php?edit=<?php echo $program_name ?>"><button><?= $translations['Courses'] ?></button></a>
                <a href="Course_Specification_General_Info_About_The_Course.php?edit=<?php echo $program_name ?>"><button><?= $translations['General Information About The Course'] ?></button></a>
                <a href="Course_Specification_Course_Learning_Outcomes.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes'] ?></button></a>
                <a href="Course_Specification_Course_Content.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Content'] ?></button></a>
                <a href="Course_Spesification_Students_Assessment_Activities.php?edit=<?php echo $program_name ?>"><button><?= $translations['Student Assessment Activity'] ?></button></a>
                <a href="Course_Spesification_Learning_Resources_and_Facilities.php?edit=<?php echo $program_name ?>"><button><?= $translations['Learning Resources And Facilities'] ?></button></a>
                <a href="Course_Spesification_Assessment_Of_Course_Quality.php?edit=<?php echo $program_name ?>"><button><?= $translations['Assessment Of Course Quality'] ?></button></a>
                <a href="Course_Spesification_Specification_Approval.php?edit=<?php echo $program_name ?>"><button><?= $translations['Specification Approval'] ?></button></a>
            </div>

            <!-- Main Content -->
            <div class="main">
                <div class="header">

                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Course Specification'] ?></h3>

                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>


                <form method="post" id="coursesForm">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <div class="edit-selection">
                        <label><?= $translations['Select an item to edit'] ?></label>
                        <select name="edit_item" id="editSelect">
                            <option value=""><?= $translations['Select'] ?></option>
                            <?php
                            $query = "SELECT * FROM general_information WHERE program_id = '$program_id' AND user_id = '$user_id'";
                            $result = mysqli_query($conn, $query);
                            while ($row_edit = mysqli_fetch_assoc($result)) {
                                $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$row_edit['course_description']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button style="margin-bottom: 20px;" type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                    <div class="content-container">
                        <h2><?= $translations['General Information about the Course'] ?></h2>

                        <label><?= $translations['Credit hours'] ?>:</label>
                        <input name="credit_hours" type="text" value="<?= htmlspecialchars($_SESSION['general_information_edit']['credit_hours'] ?? '') ?>">

                        <label><?= $translations['Course General Description'] ?>:</label>
                        <input name="course_description" type="text" value="<?= htmlspecialchars($_SESSION['general_information_edit']['course_description'] ?? '') ?>">

                        <label><?= $translations['Level/year at which this course is offered'] ?>:</label>
                        <input name="course_level" type="text" value="<?= htmlspecialchars($_SESSION['general_information_edit']['course_level'] ?? '') ?>">

                        <label><?= $translations['Co-requisites for this course (if any)'] ?>:</label>
                        <input name="co_requisites" type="text" value="<?= htmlspecialchars($_SESSION['general_information_edit']['co_requisites'] ?? '') ?>">

                        <label><?= $translations['Pre-requisites for this course (if any)'] ?>:</label>
                        <input name="pre_requisites" type="text" value="<?= htmlspecialchars($_SESSION['general_information_edit']['pre_requisites'] ?? '') ?>">

                        <label><?= $translations['Course Main Objective(s)'] ?>:</label>
                        <input name="course_objectives" type="text" value="<?= htmlspecialchars($_SESSION['general_information_edit']['course_objectives'] ?? '') ?>">

                        <div class="checkbox-group">
                            <label><?= $translations['Course Type'] ?>:</label>
                            <?php
                            // $types = ['University', 'College', 'Department', 'Track', 'Others'];
                            $types = [
                                $translations['University'],
                                $translations['College'],
                                $translations['Department'],
                                $translations['Track'],
                                $translations['Others']
                            ];

                            $selectedCourseTypes = array_map(function ($type) use ($translations) {
                                return $translations[$type] ?? $type; // Translate session values if possible
                            }, $_SESSION['general_information_edit']['course_type'] ?? []);

                            foreach ($types as $type) {
                                $checked = in_array($type, $selectedCourseTypes) ? 'checked' : '';
                                echo "<label><input type='checkbox' name='course_type[]' value='" . htmlspecialchars($type) . "' $checked> " . htmlspecialchars($type) . "</label>";
                            }
                            ?>
                        </div>

                        <div class="navigation-buttons">

                            <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_General_Info_About_The_Course_TABLES.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                <p><?= $translations['You have unsaved data. Do you want to leave without saving?'] ?></p>
                <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave'] ?></button>
                <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay'] ?></button>
            </div>
        </div>
    <?php } ?>


    <script>
        let unsavedData = false;
        const form = document.getElementById('coursesForm');
        const modal = document.getElementById('customModal');
        let nextPageUrl = "";

        // Check for unsaved data when any input is modified
        form.addEventListener('input', () => {
            unsavedData = true;
        });

        function handleNavigation(url) {
            if (unsavedData) {
                nextPageUrl = url;
                showCustomModal();
            } else {
                window.location.href = url;
            }
        }

        function showCustomModal() {
            modal.style.display = 'block';
        }

        function hideCustomModal() {
            modal.style.display = 'none';
        }

        function proceedToNextPage() {
            unsavedData = false;
            window.location.href = nextPageUrl;
        }
    </script>
</body>

</html>