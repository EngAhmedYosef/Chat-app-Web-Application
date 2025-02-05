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
            height: 150vh;
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


        .content-container {
            width: 98%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .content-container h2 {
            margin-bottom: 0px;
        }

        .form-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
            /* مسافة بين المجموعات */
        }

        .form-container label {
            flex: 1 0 30%;
            margin-bottom: 5px;
        }

        table {
            width: 95%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            margin-bottom: 20px;
            border-radius: 7px;
            overflow: hidden;
        }

        table,
        th,
        td {
            border: 1px solid #003f8a;
        }

        th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 400;
            padding: 7px;
            /* تقليص التباعد داخل الخلايا */
            font-size: 15px;
            border: 1px solid #003f8a;
            text-align: center;
        }

        td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 7px;
            font-size: 15px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        td input[type="text"] {
            width: 90%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .table-title {
            font-weight: bold;
            text-align: left;
            margin-top: 30px;
            color: #003f8a;
        }

        .btn {
            padding: 10px 20px;
            background-color: #003f8a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #0057b7;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
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
            background-color: #0057b7;
            transform: translateY(-3px);
        }
    </style>
    <script>
        function saveData() {
            alert("Input data has been saved successfully!");
        }
    </script>
</head>

<body>

    <?php

    if (isset($_GET['new'])) {
        if ($_GET['new'] == 'IS' || $_GET['new'] == 'CS') {
            $program_name = $_GET['new'];

            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            // إذا كانت الجلسة تحتوي على بيانات تم إدخالها مسبقًا، استخدمها
            if (!isset($_SESSION['course_specification_general_info_new'])) {
                $_SESSION['course_specification_general_info_new'] = [];
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
                // التحقق من إدخال الحقول
                $errors = [];
                $data = [];

                // التحقق من الحقول الأولى (Teaching mode)
                $teaching_modes = ['Traditional classroom', 'E-Learning', 'Hybrid', 'Distance learning'];
                foreach ($teaching_modes as $index => $mode) {
                    $no1 = $_POST["teaching_mode_{$index}_1"] ?? null;
                    $no2 = $_POST["teaching_mode_{$index}_2"] ?? null;

                    if (!$no1 || !$no2) {
                        $_SESSION['message']  = "Please fill in all fields.";
                    }

                    $data['teaching_modes'][] = [
                        'mode' => $mode,
                        'no1' => $no1,
                        'no2' => $no2,
                    ];
                }

                // التحقق من الحقول الثانية (Activity and Contact Hours)
                $activities = ['Lectures', 'Laboratory/Studio', 'Field', 'Tutorial', 'Others'];
                foreach ($activities as $index => $activity) {
                    $hours = $_POST["activity_hours_$index"] ?? null;

                    if (!$hours) {
                        $_SESSION['message']  = "Please fill in all fields.";
                    }

                    $data['activities'][] = [
                        'activity' => $activity,
                        'hours' => $hours,
                    ];
                }

                // إذا كان هناك أخطاء
                if (!empty($_SESSION['message'])) {
                    // قم بتخزين الأخطاء في الجلسة لعرضها
                    $_SESSION['message']  = "Please fill in all fields.";
                    header("location: Course_Specification_General_Info_About_The_Course_TABLES.php?new=" . $program_name);
                    exit;
                } else {
                    // تحديث البيانات في الجلسة
                    $_SESSION['course_specification_general_info_new'] = $data;

                    // تحويل البيانات إلى JSON
                    $json_data = json_encode($data);

                    if ($conn->connect_error) {
                        die('Connection failed: ' . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("INSERT INTO general_information_table (user_id, program_id, data) VALUES (?, ?, ?)");
                    $stmt->bind_param('iis', $user_id, $program_id, $json_data);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                        header("location: Course_Specification_General_Info_About_The_Course_TABLES.php?new=" . $program_name);
                        exit;
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                        header("location: Course_Specification_General_Info_About_The_Course_TABLES.php?new=" . $program_name);
                        exit;
                    }
                }
            }

            // تحميل البيانات الموجودة في الجلسة إذا كانت موجودة
            $course_specification_general_info_new = $_SESSION['course_specification_general_info_new'] ?? [];



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

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Specification'] ?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>

                    <form method="post" id="coursesForm">
                        <?php if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        } ?>

                        <div class="content-container">
                            <h2><?= $translations['General Information about the Course'] ?></h2>

                            <!-- Table for Teaching Mode -->
                            <div class="table-title"><?= $translations['Teaching mode'] ?></div>
                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['Mode of Instruction'] ?></th>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['No'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $teaching_modes = [$translations['Traditional classroom'], $translations['E-Learning'], $translations['Hybrid'] . '<br>•' . $translations['Traditional classroom'] . '<br>•' . $translations['E-Learning'], $translations['Distance learning']];
                                    foreach ($teaching_modes as $index => $mode) {
                                        $no1 = $course_specification_general_info_new['teaching_modes'][$index]['no1'] ?? '';
                                        $no2 = $course_specification_general_info_new['teaching_modes'][$index]['no2'] ?? '';
                                        echo "
                                <tr>
                                    <td>" . ($index + 1) . "</td>
                                    <td>$mode</td>
                                    <td><input type='text' name='teaching_mode_{$index}_1' value='$no1'></td>
                                    <td><input type='text' name='teaching_mode_{$index}_2' value='$no2'></td>
                                </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Table for Activity and Contact Hours -->
                            <div class="table-title"><?= $translations['Activity and Contact Hours'] ?></div>
                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['Activity'] ?></th>
                                        <th><?= $translations['Contact Hours'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $activities = [$translations['Lectures'], $translations['Laboratory'] . '/' . $translations['Studio'], $translations['Field'], $translations['Tutorial'], $translations['Others']];

                                    foreach ($activities as $index => $activity) {
                                        $hours = $course_specification_general_info_new['activities'][$index]['hours'] ?? '';
                                        echo "
                                <tr>
                                    <td>" . ($index + 1) . "</td>
                                    <td>$activity</td>
                                    <td><input type='text' name='activity_hours_$index' value='$hours'></td>
                                </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <div class="navigation-buttons">


                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_Course_Learning_Outcomes.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_General_Info_About_The_Course.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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
    } ?>


    <?php
    $teaching_modes = [$translations['Traditional classroom'], $translations['E-Learning'], $translations['Hybrid'] . '<br>•' . $translations['Traditional classroom'] . '<br>•' . $translations['E-Learning'], $translations['Distance learning']];
    $activities = [$translations['Lectures'], $translations['Laboratory'] . '/' . $translations['Studio'], $translations['Field'], $translations['Tutorial'], $translations['Others']];

    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق إذا كان المستخدم قد اختار عنصر للتعديل
        $edit_item = $_POST['edit_item'] ?? $_SESSION['selected_item'] ?? ''; // إذا كان موجود في الجلسة استخدمه
        $data = [];

        if (!empty($edit_item)) {
            // جلب البيانات المرتبطة بالـ ID من قاعدة البيانات
            $query = mysqli_query($conn, "SELECT * FROM general_information_table WHERE id = '$edit_item' AND user_id = '$user_id'");
            if ($row = mysqli_fetch_assoc($query)) {
                $data = json_decode($row['data'], true); // فك تشفير JSON إلى مصفوفة
                $_SESSION['course_specification_general_info_edit'] = [
                    'id' => $row['id'],
                    'data' => $data
                ];
            }
        } else if (isset($_SESSION['course_specification_general_info_edit']) && $_SESSION['course_specification_general_info_edit']['id'] == $edit_item) {
            // في حالة التعديل، استرجاع البيانات المحفوظة في الجلسة
            $data = $_SESSION['course_specification_general_info_edit']['data'];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            if (isset($_POST['update'])) {
                // التحقق من إدخال الحقول
                $errors = [];
                $data = [];

                // الحقول الأولى (Teaching mode)
                foreach ($teaching_modes as $index => $mode) {
                    $no1 = $_POST["teaching_mode_{$index}_1"] ?? null;
                    $no2 = $_POST["teaching_mode_{$index}_2"] ?? null;

                    if (!$no1 || !$no2) {
                        $errors[] = "Please fill all fields for teaching mode $mode.";
                    }

                    $data['teaching_modes'][] = [
                        'mode' => $mode,
                        'no1' => $no1,
                        'no2' => $no2,
                    ];
                }

                // الحقول الثانية (Activity and Contact Hours)
                foreach ($activities as $index => $activity) {
                    $hours = $_POST["activity_hours_$index"] ?? null;

                    if (!$hours) {
                        $errors[] = "Please fill contact hours for $activity.";
                    }

                    $data['activities'][] = [
                        'activity' => $activity,
                        'hours' => $hours,
                    ];
                }

                if (!empty($errors)) {
                    echo '<ul>';
                    foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    }
                    echo '</ul>';
                } else {
                    // حفظ البيانات المعدلة في الجلسة لتظل موجودة عند التحديث
                    $_SESSION['course_specification_general_info_edit'] = [
                        'id' => $edit_item,
                        'data' => $data
                    ];

                    // تحديث البيانات في قاعدة البيانات
                    $json_data = json_encode($data);

                    $stmt = $conn->prepare("UPDATE general_information_table SET data = ? WHERE id = ? AND user_id = ?");
                    $stmt->bind_param('sii', $json_data, $edit_item, $user_id);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Record updated successfully!';
                        // لا تقم بإعادة توجيه المستخدم هنا لتظل الـ id والبيانات في الـ select.
                        // سيتم تحديث الجلسة مع البيانات المعدلة.
                    } else {
                        $_SESSION['message'] = 'Error occurred while updating data.';
                    }
                }
            }
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

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Course Specification'] ?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>

                <form method="post" id="coursesForm">




                    <label><?= $translations['Select an item to edit'] ?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select'] ?></option>
                        <?php
                        // استعلام لجلب جميع الخيارات
                        $query = "SELECT * FROM general_information_table WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);

                        while ($row_edit = mysqli_fetch_assoc($result)) {

                            
                            // تحديد الـ id المختار حالياً بناءً على الجلسة
                            $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                            echo "<option value='{$row_edit['id']}' $selected>{$row_edit['id']}</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                    <?php if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    } ?>


                    <div class="content-container">
                        <h2><?= $translations['General Information about the Course'] ?></h2>

                        <!-- Table for Teaching Mode -->
                        <div class="table-title"><?= $translations['Teaching mode'] ?></div>
                        <table>
                            <thead>
                                <tr>
                                    <th><?= $translations['No'] ?></th>
                                    <th><?= $translations['Mode of Instruction'] ?></th>
                                    <th><?= $translations['No'] ?></th>
                                    <th><?= $translations['No'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($teaching_modes as $index => $mode) {
                                    $no1 = $data['teaching_modes'][$index]['no1'] ?? '';
                                    $no2 = $data['teaching_modes'][$index]['no2'] ?? '';
                                    echo "
                            <tr>
                                <td>" . ($index + 1) . "</td>
                                <td>$mode</td>
                                <td><input type='text' name='teaching_mode_{$index}_1' value='$no1' ></td>
                                <td><input type='text' name='teaching_mode_{$index}_2' value='$no2'></td>
                            </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- Table for Activity and Contact Hours -->
                        <div class="table-title"><?= $translations['Activity and Contact Hours'] ?></div>
                        <table>
                            <thead>
                                <tr>
                                    <th><?= $translations['No'] ?></th>
                                    <th><?= $translations['Activity'] ?></th>
                                    <th><?= $translations['Contact Hours'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($activities as $index => $activity) {
                                    $hours = $data['activities'][$index]['hours'] ?? '';
                                    echo "
                            <tr>
                                <td>" . ($index + 1) . "</td>
                                <td>$activity</td>
                                <td><input type='text' name='activity_hours_$index' value='$hours' ></td>
                            </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="navigation-buttons">
                            <button name="update" type="submit" class="nav-button"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_Course_Learning_Outcomes.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_General_Info_About_The_Course.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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


    <?php
    }
    ?>


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