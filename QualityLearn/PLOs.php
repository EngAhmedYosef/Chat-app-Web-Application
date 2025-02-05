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
    <title><?= $translations['Annual Program Report-Program Assessment-1.PLOs'] ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap">
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
            height: 100vh;
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

        .content {
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
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        }

        .header button {
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

        .header button:hover {
            background-color: #002244;
            transform: translateY(-3px);
        }

        .table-container {
            width: 100%;
            margin-top: 30px;
            padding: 20px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
        }

        table th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 600;
            padding: 12px 15px;
            border: 1px solid #003f8a;
            text-align: center;
        }

        table td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 12px 15px;
            font-size: 16px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        p {
            color: #003f8a;
            font-size: 15px;
            font-weight: 200;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin: 0;
        }

        .add-row-button {
            background-color: #003f8a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .add-row-button:hover {
            background-color: #0057b7;
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

        .delete-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .delete-button:hover {
            background-color: #ff1a1a;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <?php


    if (isset($_GET['new'])) {
        if ($_GET['new'] == 'IS' || $_GET['new'] == 'CS') {
            $program_name = $_GET['new'];

            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
                // الحصول على البيانات من الفورم
                $programLearningOutcomes = $_POST['program_learning_outcome'];
                $assessmentMethods = $_POST['assessment_method'];
                $targetedPerformances = $_POST['targeted_performance'];
                $assessmentResults = $_POST['assessment_result'];

                // تأكد من أن جميع الحقول مملوءة
                if (!empty($programLearningOutcomes) && !empty($assessmentMethods) && !empty($targetedPerformances) && !empty($assessmentResults)) {
                    // حفظ البيانات في الـ session لجميع الصفوف
                    $_SESSION['plos_new'] = [
                        'Knowledge_and_Understanding' => [],
                        'Skills' => [],
                        'Values_Autonomy_Responsibility' => []
                    ];

                    $index = 0;
                    // حفظ البيانات حسب الأقسام
                    for ($i = 0; $i < count($programLearningOutcomes); $i++) {
                        if ($i < 3) {
                            $section = 'Knowledge_and_Understanding';
                        } elseif ($i < 6) {
                            $section = 'Skills';
                        } else {
                            $section = 'Values_Autonomy_Responsibility';
                        }

                        $_SESSION['plos_new'][$section][] = [
                            'program_learning_outcome' => $programLearningOutcomes[$i],
                            'assessment_method' => $assessmentMethods[$i],
                            'targeted_performance' => $targetedPerformances[$i],
                            'assessment_result' => $assessmentResults[$i]
                        ];
                    }

                    // تحويل المصفوفة إلى JSON
                    $jsonData = json_encode($_SESSION['plos_new']);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("INSERT INTO plos_assestment (user_id, data, program_id) VALUES (?, ?, ?)");
                    $stmt->bind_param("isi", $user_id, $jsonData, $program_id);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all the fields.';
                }

                header("location: PLOs.php?new=" . $program_name);
                exit;
            }
    ?>

            <div class="container">
                <div class="sidebar">
                    <a href="PLOs.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Program Assessment'] ?></button>
                    </a>
                    <a href="PLOs.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Program Learning Outcomes'] ?></button>
                    </a>
                    <a href="StudentEv.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Courses'] ?></button>
                    </a>
                    <a href="Students_Evaluation_of_progrm_Q.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Program Quality'] ?></button>
                    </a>
                    <a href="Scientific_research_and_innovation.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Scientific Research And Innovation'] ?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Community Partnership'] ?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Other_Evaluation.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Other Evaluation'] ?></button>
                    </a>
                </div>
                <div class="content">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <div class="header-text">
                            <h3><?= $translations['Annual Program Report'] ?></h3>
                            <p><?= $translations['Program Assessment'] ?></p>
                        </div>
                        <a href="logout.php" class="button"><?= $translations['Log out'] ?></a>
                    </div>
                    <form method="post" id="coursesForm">

                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <div class="table-container">
                            <table id="PLOs">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?= $translations['Program Learning Outcomes'] ?></th>
                                        <th><?= $translations['Assessment Methods'] ?></th>
                                        <th><?= $translations['Targeted Performance (%)'] ?></th>
                                        <th><?= $translations['Assessment Results'] ?></th>
                                        <th><?= $translations['Action'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Section 1: Knowledge and Understanding -->
                                    <tr class="section-header">
                                        <td colspan="6"><?= $translations['Knowledge and Understanding'] ?></td>
                                    </tr>
                                    <?php
                                    $section = 'Knowledge_and_Understanding';
                                    if (isset($_SESSION['plos_new'][$section])) {
                                        foreach ($_SESSION['plos_new'][$section] as $index => $data) {
                                            echo "<tr data-section='$section'>
                                            <td>" . ($index + 1) . "</td>
                                            <td><input type='text' name='program_learning_outcome[]' value='" . $data['program_learning_outcome'] . "'></td>
                                            <td><input type='text' name='assessment_method[]' value='" . $data['assessment_method'] . "'></td>
                                            <td><input type='number' min='0' max='100' name='targeted_performance[]' value='" . $data['targeted_performance'] . "'></td>
                                            <td><input type='number' min='0' max='100' name='assessment_result[]' value='" . $data['assessment_result'] . "'></td>
                                            <td><button type='button' class='delete-button' onclick='deleteRow(this)'>Delete</button></td>
                                          </tr>";
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="6">
                                            <button type="button" class="add-row-button" onclick="addRow(this, 'Knowledge and Understanding')"><?= $translations['Add Row'] ?></button>
                                        </td>
                                    </tr>

                                    <!-- Section 2: Skills -->
                                    <tr class="section-header">
                                        <td colspan="6"><?= $translations['Skills'] ?></td>
                                    </tr>
                                    <?php
                                    $section = 'Skills';
                                    if (isset($_SESSION['plos_new'][$section])) {
                                        foreach ($_SESSION['plos_new'][$section] as $index => $data) {
                                            echo "<tr data-section='$section'>
                                            <td>" . ($index + 1) . "</td>
                                            <td><input type='text' name='program_learning_outcome[]' value='" . $data['program_learning_outcome'] . "'></td>
                                            <td><input type='text' name='assessment_method[]' value='" . $data['assessment_method'] . "'></td>
                                            <td><input type='number' min='0' max='100' name='targeted_performance[]' value='" . $data['targeted_performance'] . "'></td>
                                            <td><input type='number' min='0' max='100' name='assessment_result[]' value='" . $data['assessment_result'] . "'></td>
                                            <td><button type='button' class='delete-button' onclick='deleteRow(this)'>Delete</button></td>
                                          </tr>";
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="6">
                                            <button type="button" class="add-row-button" onclick="addRow(this, 'Skills')"><?= $translations['Add Row'] ?></button>
                                        </td>
                                    </tr>

                                    <!-- Section 3: Values, Autonomy, and Responsibility -->
                                    <tr class="section-header">
                                        <td colspan="6"><?= $translations['Values, Autonomy, and Responsibility'] ?></td>
                                    </tr>
                                    <?php
                                    $section = 'Values_Autonomy_Responsibility';
                                    if (isset($_SESSION['plos_new'][$section])) {
                                        foreach ($_SESSION['plos_new'][$section] as $index => $data) {
                                            echo "<tr data-section='$section'>
                                            <td>" . ($index + 1) . "</td>
                                            <td><input type='text' name='program_learning_outcome[]' value='" . $data['program_learning_outcome'] . "'></td>
                                            <td><input type='text' name='assessment_method[]' value='" . $data['assessment_method'] . "'></td>
                                            <td><input type='number' min='0' max='100' name='targeted_performance[]' value='" . $data['targeted_performance'] . "'></td>
                                            <td><input type='number' min='0' max='100' name='assessment_result[]' value='" . $data['assessment_result'] . "'></td>
                                            <td><button type='button' class='delete-button' onclick='deleteRow(this)'>Delete</button></td>
                                          </tr>";
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="6">
                                            <button type="button" class="add-row-button" onclick="addRow(this, 'Values, Autonomy, and Responsibility')"><?= $translations['Add Row'] ?></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="submit-button">
                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('StudentEv.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('ProgramStatistics.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>
                        </div>
                </div>
                </form>
            </div>


            <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?'] ?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave'] ?></button>
                    <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay'] ?></button>
                </div>


                <script>
                    function addRow(button, section) {
                        const sectionRow = button.closest("tr");
                        const tableBody = sectionRow.closest("tbody");
                        const newRow = document.createElement("tr");

                        newRow.innerHTML = `
            <td></td>
            <td><input type="text" name="program_learning_outcome[]"></td>
            <td><input type="text" name="assessment_method[]"></td>
            <td><input type="number" min="0" max="100" name="targeted_performance[]"></td>
            <td><input type="number" min="0" max="100" name="assessment_result[]"></td>
            <td><button type="button" class="delete-button" onclick="deleteRow(this)"><?= $translations['Delete'] ?></button></td>
        `;
                        tableBody.insertBefore(newRow, sectionRow);
                    }

                    function deleteRow(button) {
                        button.closest("tr").remove();
                    }
                </script>

        <?php
        }
    }
        ?>


        <?php

        if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
            $program_name = $_GET['edit'];

            // استعلام لجلب الـ id الخاص بالبرنامج
            $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row_program = mysqli_fetch_assoc($query_program);
            $program_id = $row_program["id"];

            // التحقق إذا كان المستخدم قد اختار أي عنصر للتعديل
            $edit_item = $_POST['edit_item'] ?? '';

            // استعلام لجلب البيانات إذا تم اختيار عنصر للتعديل
            if ($edit_item) {
                $query = mysqli_query($conn, "SELECT * FROM plos_assestment WHERE id = '$edit_item' AND user_id = '$user_id'");
                $row = mysqli_fetch_assoc($query);
                $update_id = $row["id"];
                $data = json_decode($row["data"], true); // تحويل البيانات من JSON إلى مصفوفة

                // تخزين البيانات في الـ session بحيث يمكن التعديل عليها
                $_SESSION['plos_edit'] = $data;
                $_SESSION['edit_id'] = $edit_item;  // تخزين الـ id في الـ session
            }

            // التحقق من التعديل
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
                // الحصول على البيانات من الفورم
                $programLearningOutcomes = $_POST['program_learning_outcome'];
                $assessmentMethods = $_POST['assessment_method'];
                $targetedPerformances = $_POST['targeted_performance'];
                $assessmentResults = $_POST['assessment_result'];

                // التأكد من أن جميع المدخلات موجودة
                if (!empty($programLearningOutcomes) && !empty($assessmentMethods) && !empty($targetedPerformances) && !empty($assessmentResults)) {
                    // تنظيم البيانات في مصفوفة
                    $data = [];
                    for ($i = 0; $i < count($programLearningOutcomes); $i++) {
                        $data[] = [
                            'program_learning_outcome' => $programLearningOutcomes[$i],
                            'assessment_method' => $assessmentMethods[$i],
                            'targeted_performance' => $targetedPerformances[$i],
                            'assessment_result' => $assessmentResults[$i],
                        ];
                    }

                    // تحويل المصفوفة إلى JSON
                    $jsonData = json_encode($data);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // التحقق إذا كان يوجد صف موجود للتعديل أو لا
                    if ($_SESSION['edit_id']) {
                        // تحديث البيانات في قاعدة البيانات
                        $stmt = $conn->prepare("UPDATE plos_assestment SET data = ? WHERE id = ? AND user_id = ?");
                        $stmt->bind_param("sii", $jsonData, $_SESSION['edit_id'], $user_id);
                    } else {
                        // إدخال البيانات إذا كانت جديدة
                        $stmt = $conn->prepare("INSERT INTO plos_assestment (user_id, data, program_id) VALUES (?, ?, ?)");
                        $stmt->bind_param("isi", $user_id, $jsonData, $program_id);
                    }

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records updated successfully!';
                        // تحديث الـ session بعد التحديث
                        $_SESSION['plos_edit'] = $data;
                    } else {
                        $_SESSION['message'] = 'Error occurred while updating data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: PLOs.php?edit=" . $program_name);
                exit;
            }
        ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Program Assessment<?= $translations['curiculumr'] ?></title>
                <style>
                    /* يمكن إضافة بعض الأنماط هنا */
                </style>
            </head>

            <body>
                <div class="container">
                    <div class="sidebar">
                        <a href="PLOs.php?edit=<?php echo $program_name ?>">
                            <button><?= $translations['Program Assessment'] ?></button>
                        </a>
                        <a href="PLOs.php?edit=<?php echo $program_name ?>">
                            <button><?= $translations['Program Learning Outcomes'] ?></button>
                        </a>
                        <a href="StudentEv.php?edit=<?php echo $program_name ?>">
                            <button><?= $translations['Students Evaluation Of Courses'] ?></button>
                        </a>
                        <a href="Students_Evaluation_of_progrm_Q.php?edit=<?php echo $program_name ?>">
                            <button><?= $translations['Students Evaluation Of Program Quality'] ?></button>
                        </a>
                        <a href="Scientific_research_and_innovation.php?edit=<?php echo $program_name ?>">
                            <button><?= $translations['Scientific Research And Innovation'] ?></button>
                        </a>
                        <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php?edit=<?php echo $program_name ?>">
                            <button><?= $translations['Community Partnership'] ?></button>
                        </a>
                        <a href="Annual_Program_Report_Program_Assessment_Other_Evaluation.php?edit=<?php echo $program_name ?>">
                            <button><?= $translations['Other Evaluation'] ?></button>
                        </a>
                    </div>

                    <div class="content">
                        <div class="header">
                            <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                            <div class="header-text">
                                <h3><?= $translations['Annual Program Report'] ?></h3>
                                <p><?= $translations['Program Assessment'] ?></p>

                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo $translations[$_SESSION['message']];
                                    unset($_SESSION['message']);
                                }
                                ?>
                            </div>
                            <a href="logout.php" class="button"><?= $translations['Log out'] ?></a>
                        </div>

                        <form method="post" id="coursesForm">
                            <!-- Select item to edit -->
                            <label><?= $translations['Select an item to edit'] ?></label>
                            <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                                <option value=""><?= $translations['Select'] ?></option>
                                <?php
                                // استعلام لجلب جميع الخيارات
                                $query = "SELECT * FROM plos_assestment WHERE program_id = '$program_id' AND user_id = '$user_id'";
                                $result = mysqli_query($conn, $query);

                                // عرض الخيارات
                                while ($row_edit = mysqli_fetch_assoc($result)) {

                                    $data = json_decode($row_edit['data'], true);

                                    // التحقق إذا كانت البيانات موجودة
                                    if (!empty($data) && is_array($data)) {
                                        // أخذ أول عنصر من الكورسات
                                        $first_course = $data[0];

                                        // استخراج course_title لأول كورس
                                        $program_learning_outcome = $first_course['program_learning_outcome'] ?? 'N/A';


                                        $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                        echo "<option value='{$row_edit['id']}' $selected>{$program_learning_outcome}</option>";
                                    }
                                }
                                ?>
                            </select>
                            <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>

                            <!-- Table to edit/insert -->
                            <div class="table-container">
                                <table id="PLOs">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?= $translations['Program Learning Outcomes'] ?></th>
                                            <th><?= $translations['Assessment Methods'] ?></th>
                                            <th><?= $translations['Targeted Performance (%)'] ?></th>
                                            <th><?= $translations['Assessment Results'] ?></th>
                                            <th><?= $translations['Action'] ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Section 1: Knowledge and Understanding -->
                                        <tr class="section-header">
                                            <td colspan="6"><?= $translations['Knowledge and Understanding'] ?></td>
                                        </tr>
                                        <?php
                                        if (isset($_SESSION['plos_edit'])) {
                                            foreach ($_SESSION['plos_edit'] as $item) {
                                                echo "<tr>";
                                                echo "<td></td>";
                                                echo "<td><input type='text' name='program_learning_outcome[]' value='" . htmlspecialchars($item['program_learning_outcome']) . "'></td>";
                                                echo "<td><input type='text' name='assessment_method[]' value='" . htmlspecialchars($item['assessment_method']) . "'></td>";
                                                echo "<td><input type='number' min='0' max='100' name='targeted_performance[]' value='" . htmlspecialchars($item['targeted_performance']) . "'></td>";
                                                echo "<td><input type='number' min='0' max='100' name='assessment_result[]' value='" . htmlspecialchars($item['assessment_result']) . "'></td>";
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <div class="navigation-buttons">
                                    <button name="update" type="submit" class="nav-button"><?= $translations['Update'] ?></button>

                                    <button type="button" class="nav-button" onclick="handleNavigation('StudentEv.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                    <button type="button" class="nav-button" onclick="handleNavigation('ProgramStatistics.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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