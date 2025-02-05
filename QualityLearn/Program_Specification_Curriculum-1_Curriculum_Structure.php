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
    <title><?= $translations['Program Specification-Curriculum-1 Curriculum Structure']?></title>
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
            height: 165vh;
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

        .header-text {
            text-align: center;
            /* يجعل النصوص في الوسط */
            margin-top: 0px;
            /* مسافة من الأعلى */
        }

        .header-text h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin-bottom: 5px;
        }

        .header-text p {
            color: #003f8a;
            font-size: 15px;
            font-weight: 200;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin: 0;
            /* يمنع أي مسافة إضافية */
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

        .form-group {
            margin-bottom: 20px;
            /* مسافة بين المجموعات */
        }

        .form-container label {
            flex: 1 0 30%;
            margin-bottom: 5px;
        }

        table {
            width: 80%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            margin-bottom: 20px;
            border-radius: 7px;
            overflow: hidden;

        }

        td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 7px;
            font-size: 15px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);

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

        input {
            width: 90%;
            padding: 3px;
            font-size: 12px;
        }

        textarea {
            width: 90%;
            height: 50px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
            background-color: #f9f9f9;
        }

        textarea:focus {
            outline: none;
            border-color: #003f8a;
            background-color: #fff;
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

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                $required_fields = [
                    'program_structure_1',
                    'no_of_courses_1',
                    'credit_hours_1',
                    'percentage_1',
                    'program_structure_2',
                    'no_of_courses_2',
                    'credit_hours_2',
                    'percentage_2',
                    'program_structure_3',
                    'no_of_courses_3',
                    'credit_hours_3',
                    'percentage_3',
                    'program_structure_4',
                    'no_of_courses_4',
                    'credit_hours_4',
                    'percentage_4',
                    'program_structure_5',
                    'no_of_courses_5',
                    'credit_hours_5',
                    'percentage_5',
                    'program_structure_6',
                    'no_of_courses_6',
                    'credit_hours_6',
                    'percentage_6',
                    'program_structure_7',
                    'no_of_courses_7',
                    'credit_hours_7',
                    'percentage_7',
                    'total_courses',
                    'total_credit_hours',
                    'total_percentage',
                    'course_specifications'
                ];

                // تخزين البيانات في $_SESSION['curriculum_1_new']
                $_SESSION['curriculum_1_new'] = $_POST;

                $missing_fields = [];
                foreach ($required_fields as $field) {
                    if (empty($_POST[$field])) {
                        $missing_fields[] = $field;
                    }
                }

                if (!empty($missing_fields)) {
                    $_SESSION['message'] = 'Please fill in all fields.';
                } else {
                    $stmt = $conn->prepare("INSERT INTO curriculum_structure (
                    user_id, program_structure_1, no_of_courses_1, credit_hours_1, percentage_1,
                    program_structure_2, no_of_courses_2, credit_hours_2, percentage_2,
                    program_structure_3, no_of_courses_3, credit_hours_3, percentage_3,
                    program_structure_4, no_of_courses_4, credit_hours_4, percentage_4,
                    program_structure_5, no_of_courses_5, credit_hours_5, percentage_5,
                    program_structure_6, no_of_courses_6, credit_hours_6, percentage_6,
                    program_structure_7, no_of_courses_7, credit_hours_7, percentage_7,
                    total_courses, total_credit_hours, total_percentage, course_specifications, program_id
                ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    $stmt->bind_param(
                        "isiiisiiisiiisiiisiiisiiisiiiiiisi",
                        $user_id,
                        $_POST['program_structure_1'],
                        $_POST['no_of_courses_1'],
                        $_POST['credit_hours_1'],
                        $_POST['percentage_1'],
                        $_POST['program_structure_2'],
                        $_POST['no_of_courses_2'],
                        $_POST['credit_hours_2'],
                        $_POST['percentage_2'],
                        $_POST['program_structure_3'],
                        $_POST['no_of_courses_3'],
                        $_POST['credit_hours_3'],
                        $_POST['percentage_3'],
                        $_POST['program_structure_4'],
                        $_POST['no_of_courses_4'],
                        $_POST['credit_hours_4'],
                        $_POST['percentage_4'],
                        $_POST['program_structure_5'],
                        $_POST['no_of_courses_5'],
                        $_POST['credit_hours_5'],
                        $_POST['percentage_5'],
                        $_POST['program_structure_6'],
                        $_POST['no_of_courses_6'],
                        $_POST['credit_hours_6'],
                        $_POST['percentage_6'],
                        $_POST['program_structure_7'],
                        $_POST['no_of_courses_7'],
                        $_POST['credit_hours_7'],
                        $_POST['percentage_7'],
                        $_POST['total_courses'],
                        $_POST['total_credit_hours'],
                        $_POST['total_percentage'],
                        $_POST['course_specifications'],
                        $program_id
                    );

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                }

                header("location: Program_Specification_Curriculum-1_Curriculum_Structure.php?new=" . $program_name);
                exit;
            }
    ?>

            <div class="container">
                <div class="sidebar">
                    <div class="user-section">
                    </div>
                    <a href="Program_Specification_Curriculum-1_Curriculum_Structure.php?new=<?php echo $program_name ?>"><button><?= $translations['Curriculum Structure'] ?></button></a>
                    <a href="Program_Specification_Curriculum-2_Program_Courses.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Courses'] ?></button></a>
                    <a href="Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?new=<?php echo $program_name ?>"><button><?= $translations['Program learning Outcomes Mapping Matrix'] ?></button></a>


                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <div class="header-text">
                            <h3><?= $translations['Program Specification'] ?></h3>

                            <?php $program_action = "new"  ?>

                            <p><?= $translations['Curriculum'] ?></p>
                        </div>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                    <form method="post" id="coursesForm">
                        <div id="programs" class="form-container">
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo $translations[$_SESSION['message']];
                                unset($_SESSION['message']);
                            }
                            ?>

                            <h2><?= $translations['Curriculum Structure'] ?></h2>
                            <table border="1" cellspacing="0" cellpadding="10">
                                <tr>
                                    <th><?= $translations['Program Structure'] ?></th>
                                    <th><?= $translations['Required/ Elective'] ?></th>
                                    <th><?= $translations['No. of Courses'] ?></th>
                                    <th><?= $translations['Credit Hours'] ?></th>
                                    <th><?= $translations['Percentage'] ?></th>
                                </tr>
                                <?php for ($i = 1; $i <= 7; $i++): ?>
                                    <tr>
                                        <td>
                                            <?= $i === 1 ? $translations['Institution Requirements'] : ($i === 2 ? $translations['College Requirements'] : ($i === 3 ? $translations['Program Requirements'] : ($i === 4 ? $translations['Capstone Course/Project'] : ($i === 5 ? $translations['Field Training/Internship'] : ($i === 6 ? $translations['Residency Year'] : ($i === 7 ? $translations['Others'] : "")))))) ?>
                                        </td>
                                        <td>
                                            <input type="text" name="program_structure_<?= $i ?>" id="program_structure_<?= $i ?>"
                                                value="<?= isset($_SESSION['curriculum_1_new']["program_structure_$i"]) ? htmlspecialchars($_SESSION['curriculum_1_new']["program_structure_$i"]) : '' ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="no_of_courses_<?= $i ?>" id="no_of_courses_<?= $i ?>" min="0"
                                                value="<?= isset($_SESSION['curriculum_1_new']["no_of_courses_$i"]) ? htmlspecialchars($_SESSION['curriculum_1_new']["no_of_courses_$i"]) : '' ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="credit_hours_<?= $i ?>" id="credit_hours_<?= $i ?>" min="0"
                                                value="<?= isset($_SESSION['curriculum_1_new']["credit_hours_$i"]) ? htmlspecialchars($_SESSION['curriculum_1_new']["credit_hours_$i"]) : '' ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="percentage_<?= $i ?>" id="percentage_<?= $i ?>"
                                                value="<?= isset($_SESSION['curriculum_1_new']["percentage_$i"]) ? htmlspecialchars($_SESSION['curriculum_1_new']["percentage_$i"]) : '' ?>">
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                                <tr>
                                    <td colspan="2"><?= $translations['Total'] ?></td>
                                    <td>
                                        <input type="number" name="total_courses" id="total_courses" min="0"
                                            value="<?= isset($_SESSION['curriculum_1_new']['total_courses']) ? htmlspecialchars($_SESSION['curriculum_1_new']['total_courses']) : '' ?>">
                                    </td>
                                    <td>
                                        <input type="number" name="total_credit_hours" id="total_credit_hours" min="0"
                                            value="<?= isset($_SESSION['curriculum_1_new']['total_credit_hours']) ? htmlspecialchars($_SESSION['curriculum_1_new']['total_credit_hours']) : '' ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="total_percentage" id="total_percentage"
                                            value="<?= isset($_SESSION['curriculum_1_new']['total_percentage']) ? htmlspecialchars($_SESSION['curriculum_1_new']['total_percentage']) : '' ?>">
                                    </td>
                                </tr>
                            </table>


                            <div class="form-group">
                                <label for="special-support"><?= $translations['Course Specifications'] ?></label>
                                <textarea id="special-support" name="course_specifications" placeholder="<?= $translations['Insert hyperlink for all course specifications using NCAAA template (T-104)'] ?>">
                                <?= isset($_SESSION['curriculum_1_new']['course_specifications']) ? htmlspecialchars($_SESSION['curriculum_1_new']['course_specifications']) : '' ?>
                                </textarea>
                            </div>

                            <div class="navigation-buttons">
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-2_Program_Courses.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save'] ?></button>
                            </div>
                        </div>
                    </form>


                </div>

            </div>
            <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?']?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave']?></button>
                    <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay']?></button>
                </div>
            </div>
    <?php }
    } ?>


    <?php

    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // جلب البرنامج ID
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program['id'];

        // جلب البيانات للسجل المحدد عند الضغط على Edit
        $edit_item = $_POST['edit_item'] ?? '';
        $curriculum_1_new = [];

        // إذا كان تم تحديد id و الضغط على Edit، يتم جلب البيانات من قاعدة البيانات
        if (!empty($edit_item)) {
            $query = mysqli_query($conn, "SELECT * FROM curriculum_structure WHERE id = '$edit_item' AND user_id = '$user_id'");
            $curriculum_1_new = mysqli_fetch_assoc($query);

            // حفظ البيانات في الجلسة مع الـ id
            $_SESSION['curriculum_1_edit'] = $curriculum_1_new;
            $_SESSION['curriculum_1_edit']['id'] = $edit_item;
        }

        // إذا كانت هناك بيانات محفوظة في الجلسة، يتم تحميلها
        if (isset($_SESSION['curriculum_1_edit'])) {
            $curriculum_1_new = $_SESSION['curriculum_1_edit'];
            $edit_item = $_SESSION['curriculum_1_edit']['id']; // التأكد من بقاء الـ id في الجلسة
        }

        // تحديث البيانات عند الضغط على Save
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $update_id = $_POST['id'];

            $stmt = $conn->prepare("UPDATE curriculum_structure SET 
        program_structure_1 = ?, no_of_courses_1 = ?, credit_hours_1 = ?, percentage_1 = ?,
        program_structure_2 = ?, no_of_courses_2 = ?, credit_hours_2 = ?, percentage_2 = ?,
        program_structure_3 = ?, no_of_courses_3 = ?, credit_hours_3 = ?, percentage_3 = ?,
        program_structure_4 = ?, no_of_courses_4 = ?, credit_hours_4 = ?, percentage_4 = ?,
        program_structure_5 = ?, no_of_courses_5 = ?, credit_hours_5 = ?, percentage_5 = ?,
        program_structure_6 = ?, no_of_courses_6 = ?, credit_hours_6 = ?, percentage_6 = ?,
        program_structure_7 = ?, no_of_courses_7 = ?, credit_hours_7 = ?, percentage_7 = ?,
        total_courses = ?, total_credit_hours = ?, total_percentage = ?, course_specifications = ? 
        WHERE id = ? AND user_id = ?");

            $stmt->bind_param(
                "siiisiiisiiisiiisiiisiiisiiiiiisii",
                $_POST['program_structure_1'],
                $_POST['no_of_courses_1'],
                $_POST['credit_hours_1'],
                $_POST['percentage_1'],
                $_POST['program_structure_2'],
                $_POST['no_of_courses_2'],
                $_POST['credit_hours_2'],
                $_POST['percentage_2'],
                $_POST['program_structure_3'],
                $_POST['no_of_courses_3'],
                $_POST['credit_hours_3'],
                $_POST['percentage_3'],
                $_POST['program_structure_4'],
                $_POST['no_of_courses_4'],
                $_POST['credit_hours_4'],
                $_POST['percentage_4'],
                $_POST['program_structure_5'],
                $_POST['no_of_courses_5'],
                $_POST['credit_hours_5'],
                $_POST['percentage_5'],
                $_POST['program_structure_6'],
                $_POST['no_of_courses_6'],
                $_POST['credit_hours_6'],
                $_POST['percentage_6'],
                $_POST['program_structure_7'],
                $_POST['no_of_courses_7'],
                $_POST['credit_hours_7'],
                $_POST['percentage_7'],
                $_POST['total_courses'],
                $_POST['total_credit_hours'],
                $_POST['total_percentage'],
                $_POST['course_specifications'],
                $update_id,
                $user_id
            );

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Record updated successfully!';
                // تحديث البيانات في الجلسة
                $_SESSION['curriculum_1_edit'] = $_POST;
            } else {
                $_SESSION['message'] = 'Error occurred while updating data.';
            }

            header("location: Program_Specification_Curriculum-1_Curriculum_Structure.php?edit=" . $program_name);
            exit;
        }

        if (isset($_POST['next'])) {
            header("location: Program_Specification_Curriculum-2_Program_Courses.php?edit=" . $program_name);
            exit;
        }

        if (isset($_POST['back'])) {
            header("location: Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?edit=" . $program_name);
            exit;
        }

    ?>

        <div class="container">
            <div class="sidebar">
                <div class="user-section">
                </div>
                <a href="Program_Specification_Curriculum-1_Curriculum_Structure.php?edit=<?php echo $program_name ?>"><button><?= $translations['Curriculum Structure'] ?></button></a>
                <a href="Program_Specification_Curriculum-2_Program_Courses.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Courses'] ?></button></a>
                <a href="Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program learning Outcomes Mapping Matrix'] ?></button></a>
            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <div class="header-text">
                        <h3><?= $translations['Program Specification'] ?></h3>

                        <?php $program_action = "edit"  ?>

                        <p><?= $translations['Curriculum'] ?></p>
                    </div>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>

                <form method="post" id="coursesForm">
                    <div id="programs" class="form-container">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <label for="editSelect"><?= $translations['Select an item to edit'] ?></label>
                        <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <?php
                            // استعلام لجلب جميع الخيارات
                            $query = "SELECT * FROM curriculum_structure WHERE program_id = '$program_id' AND user_id = '$user_id'";
                            $result = mysqli_query($conn, $query);
                            // عرض الخيارات
                            while ($row_edit = mysqli_fetch_assoc($result)) {
                                
                                $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$row_edit['program_structure_1']}</option>";
                            }
                            ?>
                        </select>

                        <button type="submit" class="button" name="edit_row" id="editRowButton"><?= $translations['Edit'] ?></button>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                        <h2><?= $translations['Curriculum Structure']?></h2>
                        <table border="1" cellpadding="5" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?= $translations['Program Structure'] ?></th>
                                    <th><?= $translations['Required/ Elective'] ?></th>
                                    <th><?= $translations['No. of Courses'] ?></th>
                                    <th><?= $translations['Credit Hours'] ?></th>
                                    <th><?= $translations['Percentage'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $structures = [

                                    $translations['Institution Requirements'],
                                    $translations['College Requirements'],
                                    $translations['Program Requirements'],
                                    $translations['Capstone Course/Project'],
                                    $translations['Field Training/Internship'],
                                    $translations['Residency Year'],
                                    $translations['Others'],


                                ];

                                for ($i = 1; $i <= count($structures); $i++) {
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($structures[$i - 1]) ?></td>
                                        <td><input type="text" name="program_structure_<?= $i ?>" id="program_structure_<?= $i ?>" value="<?= htmlspecialchars($curriculum_1_new["program_structure_$i"] ?? '') ?>"></td>
                                        <td><input type="number" name="no_of_courses_<?= $i ?>" id="no_of_courses_<?= $i ?>" min="0" value="<?= htmlspecialchars($curriculum_1_new["no_of_courses_$i"] ?? '') ?>"></td>
                                        <td><input type="number" name="credit_hours_<?= $i ?>" id="credit_hours_<?= $i ?>" min="0" value="<?= htmlspecialchars($curriculum_1_new["credit_hours_$i"] ?? '') ?>"></td>
                                        <td><input type="number" name="percentage_<?= $i ?>" id="percentage_<?= $i ?>" value="<?= htmlspecialchars($curriculum_1_new["percentage_$i"] ?? '') ?>"></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="2"><?= $translations['Total']?></td>
                                    <td><input type="number" name="total_courses" id="total_courses" min="0" value="<?= htmlspecialchars($curriculum_1_new['total_courses'] ?? '') ?>"></td>
                                    <td><input type="number" name="total_credit_hours" id="total_credit_hours" min="0" value="<?= htmlspecialchars($curriculum_1_new['total_credit_hours'] ?? '') ?>"></td>
                                    <td><input type="number" name="total_percentage" id="total_percentage" value="<?= htmlspecialchars($curriculum_1_new['total_percentage'] ?? '') ?>"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="form-group">
                            <label for="special-support"><?= $translations['Course Specifications']?></label>
                            <textarea id="special-support" name="course_specifications">
                    <?= htmlspecialchars($curriculum_1_new['course_specifications'] ?? '') ?>
                </textarea>
                        </div>

                        <div class="navigation-buttons">
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-2_Program_Courses.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            <button type="submit" name="update" class="button" id="updateButton"><?= $translations['Update']?></button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
        <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?']?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave']?></button>
                    <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay']?></button>
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