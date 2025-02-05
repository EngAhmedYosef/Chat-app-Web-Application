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
    <title><?= $translations['Program Specification-Program Identification and General Information'] ?></title>
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

        .form-container input {
            flex: 2 0 10%;
            padding: 1px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 70%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            margin-bottom: 20px;
            border-radius: 7px;
            overflow: hidden;
        }

        table th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 400;
            padding: 7px;
            /* تقليص التباعد داخل الخلايا */
            font-size: 15px;
            border: 1px solid #003f8a;
            text-align: center;
        }

        table td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 7px;
            font-size: 15px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        td input[type="text"],
        td input[type="number"] {
            width: 90%;
            /* جعل المربعات تأخذ 90% من عرض الخلية */
            padding: 4px;
            font-size: 12px;
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

            // جلب ID البرنامج
            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
                // تخزين البيانات المدخلة في الجلسة
                $_SESSION['Identification_new'] = $_POST;

                // التحقق من تعبئة جميع الحقول
                if (
                    !empty($_POST['main_location']) &&
                    !empty($_POST['branches_offering_program']) &&
                    !empty($_POST['partnerships']) &&
                    !empty($_POST['professions_jobs']) &&
                    !empty($_POST['occupational_sectors']) &&
                    !empty($_POST['total_credit_hours']) &&
                    !empty($_POST['major_tracks']) &&
                    !empty($_POST['exit_points'])
                ) {
                    // تجهيز البيانات
                    $main_location = $conn->real_escape_string($_POST['main_location']);
                    $branches_offering_program = $conn->real_escape_string($_POST['branches_offering_program']);
                    $partnerships = $conn->real_escape_string($_POST['partnerships']);
                    $professions_jobs = $conn->real_escape_string($_POST['professions_jobs']);
                    $occupational_sectors = $conn->real_escape_string($_POST['occupational_sectors']);
                    $total_credit_hours = $conn->real_escape_string($_POST['total_credit_hours']);
                    $major_tracks = json_encode($_POST['major_tracks']);
                    $exit_points = json_encode($_POST['exit_points']);

                    // إدخال البيانات
                    $sql = "INSERT INTO programs_identification (user_id, main_location, branches_offering_program, partnerships, professions_jobs, occupational_sectors, total_credit_hours, major_tracks, exit_points, program_id)
                        VALUES ('$user_id', '$main_location', '$branches_offering_program', '$partnerships', '$professions_jobs', '$occupational_sectors', '$total_credit_hours', '$major_tracks', '$exit_points', '$program_id')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Records created successfully!';
                        $_SESSION['Identification_new'] = $_POST;
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields!';
                    $_SESSION['Identification_new'] = $_POST;
                }
                header("location: Program_Specification_Program_Identification_and_General_Information.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST["next"])) {
                header("location: Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST["back"])) {
                header("location: ProgramSpecification.php?new=" . $program_name);
                exit;
            }

            // استعادة القيم المدخلة من الجلسة إذا كانت موجودة
            $Identification_new = $_SESSION['Identification_new'] ?? [];
    ?>

            <div class="container">
                <div class="sidebar">
                    <div class="user-section">
                    </div>
                    <a href="ProgramSpecification.php?new=<?php echo $program_name ?>"><button><?= $translations['Programs'] ?></button></a>
                    <a href="Program_Specification_Program_Identification_and_General_Information.php?new=<?php echo $program_name ?>"><button><?= $translations['Program idendification and genral information'] ?></button></a>
                    <a href="Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?new=<?php echo $program_name ?>"><button><?= $translations['Mission,Objectives and program learning outcomes'] ?></button></a>
                    <a href="Program_Specification_Curriculum-1_Curriculum_Structure.php?new=<?php echo $program_name ?>"><button><?= $translations['curiculum'] ?></button></a>
                    <a href="Program_Specification_Student_Admission_and_Support.php?new=<?php echo $program_name ?>"><button><?= $translations['student addmission and support'] ?></button></a>
                    <a href="Program_Specification_Faculty_and_Administrative_Staff.php?new=<?php echo $program_name ?>"><button><?= $translations['Fuculty and Adminstrativ Staff'] ?></button></a>
                    <a href="Program_Specification_Learning_Resources_Facilities_and_Equipment.php?new=<?php echo $program_name ?>"><button><?= $translations['Learning Resources,Facilities and Equipment'] ?></button></a>
                    <a href="Program_Specification_Program_Quality_Assurance.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Quality Assurance'] ?></button></a>
                    <a href="Program_Specification_Specification_Approval_Data.php?new=<?php echo $program_name ?>"><button><?= $translations['Specefication Approval Data'] ?></button></a>
                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">

                        <h3><?= $translations['Program Specification'] ?></h3>

                        <?php $program_action = "new"  ?>

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


                            <h2><?= $translations['Program Identification and General Information'] ?></h2>
                            <div class="form-group">
                                <label for="ProgramsMainLocation"><?= $translations['Program’s Main Location'] ?>:</label>
                                <input name="main_location" type="text" id="ProgramsMainLocation" value="<?php echo htmlspecialchars($Identification_new['main_location'] ?? ''); ?>">

                                <label for="BranchesOfferingtheProgram"><?= $translations['Branches Offering the Program (if any)'] ?>:</label>
                                <input name="branches_offering_program" type="text" id="BranchesOfferingtheProgram" value="<?php echo htmlspecialchars($Identification_new['branches_offering_program'] ?? ''); ?>">

                                <label for="Partnerships"><?= $translations['Partnerships with other parties (if any) and the nature of each'] ?>:</label>
                                <input name="partnerships" type="text" id="Partnerships" value="<?php echo htmlspecialchars($Identification_new['partnerships'] ?? ''); ?>">

                                <label for="ProfessionsJobs"><?= $translations['Professions/jobs for which students are qualified'] ?>:</label>
                                <input name="professions_jobs" type="text" id="ProfessionsJobs" value="<?php echo htmlspecialchars($Identification_new['professions_jobs'] ?? ''); ?>">

                                <label for="OccupationalSectors"><?= $translations['Relevant occupational/ Professional sectors'] ?>:</label>
                                <input name="occupational_sectors" type="text" id="OccupationalSectors" value="<?php echo htmlspecialchars($Identification_new['occupational_sectors'] ?? ''); ?>">

                                <label for="TotalCreditHours"><?= $translations['Total credit hours'] ?>:</label>
                                <input name="total_credit_hours" type="text" id="TotalCreditHours" value="<?php echo htmlspecialchars($Identification_new['total_credit_hours'] ?? ''); ?>">
                            </div>

                            <h3><?= $translations['Major Tracks/Pathways (if any)'] ?>:</h3>
                            <table>
                                <tr>
                                    <th><?= $translations['Exit Points/Awarded Degree'] ?></th>
                                    <th><?= $translations['Credit Hours (For each track)'] ?></th>
                                    <th><?= $translations['Professions/Jobs (For each track)'] ?></th>
                                </tr>
                                <tr>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][0] ?? ''); ?>"></td>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][1] ?? ''); ?>"></td>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][2] ?? ''); ?>"></td>
                                </tr>
                                <tr>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][3] ?? ''); ?>"></td>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][4] ?? ''); ?>"></td>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][5] ?? ''); ?>"></td>
                                </tr>
                                <tr>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][6] ?? ''); ?>"></td>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][7] ?? ''); ?>"></td>
                                    <td><input name="major_tracks[]" type="text" value="<?php echo htmlspecialchars($Identification_new['major_tracks'][8] ?? ''); ?>"></td>
                                </tr>
                            </table>

                            <h3><?= $translations['Exit Points/Awarded Degree (if any)'] ?>:</h3>
                            <table>
                                <tr>
                                    <th><?= $translations['Exit Points/Awarded Degree'] ?></th>
                                    <th><?= $translations['Credit Hours'] ?></th>
                                </tr>
                                <tr>
                                    <td><input name="exit_points[]" type="text" value="<?php echo htmlspecialchars($Identification_new['exit_points'][0] ?? ''); ?>"></td>
                                    <td><input name="exit_points[]" type="text" value="<?php echo htmlspecialchars($Identification_new['exit_points'][1] ?? ''); ?>"></td>
                                </tr>
                                <tr>
                                    <td><input name="exit_points[]" type="text" value="<?php echo htmlspecialchars($Identification_new['exit_points'][2] ?? ''); ?>"></td>
                                    <td><input name="exit_points[]" type="text" value="<?php echo htmlspecialchars($Identification_new['exit_points'][3] ?? ''); ?>"></td>
                                </tr>
                                <tr>
                                    <td><input name="exit_points[]" type="text" value="<?php echo htmlspecialchars($Identification_new['exit_points'][4] ?? ''); ?>"></td>
                                    <td><input name="exit_points[]" type="text" value="<?php echo htmlspecialchars($Identification_new['exit_points'][5] ?? ''); ?>"></td>
                                </tr>
                            </table>

                            <div class="navigation-buttons">
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('ProgramSpecification.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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

        // استرجاع الـ program_id بناءً على اسم البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // جلب الـ id للتعديل
        $edit_item = $_POST['edit_item'] ?? '';
        $program_specification_identification_edit = $_SESSION['program_specification_identification_edit'] ?? [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_row'])) {
            // جلب البيانات من قاعدة البيانات للتعديل
            if ($edit_item) {
                $query = mysqli_query($conn, "SELECT * FROM programs_identification WHERE id = '$edit_item' AND program_id = '$program_id' AND user_id = '$user_id'");
                $row = mysqli_fetch_assoc($query);

                // حفظ البيانات التي تم جلبها في الجلسة مع الـ id
                $_SESSION['program_specification_identification_edit'] = $row;
                $_SESSION['program_specification_identification_edit']['id'] = $edit_item;  // حفظ الـ id في الجلسة
                $program_specification_identification_edit = $row;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            // التحقق من تعبئة جميع الحقول
            if (
                !empty($_POST['main_location']) &&
                !empty($_POST['branches_offering_program']) &&
                !empty($_POST['partnerships']) &&
                !empty($_POST['professions_jobs']) &&
                !empty($_POST['occupational_sectors']) &&
                !empty($_POST['total_credit_hours']) &&
                !empty($_POST['major_tracks']) &&
                !empty($_POST['exit_points'])
            ) {
                // تجهيز البيانات
                $main_location = $conn->real_escape_string($_POST['main_location']);
                $branches_offering_program = $conn->real_escape_string($_POST['branches_offering_program']);
                $partnerships = $conn->real_escape_string($_POST['partnerships']);
                $professions_jobs = $conn->real_escape_string($_POST['professions_jobs']);
                $occupational_sectors = $conn->real_escape_string($_POST['occupational_sectors']);
                $total_credit_hours = $conn->real_escape_string($_POST['total_credit_hours']);
                $major_tracks = json_encode($_POST['major_tracks']);
                $exit_points = json_encode($_POST['exit_points']);

                // التحقق إذا كان التعديل أو الإدخال
                $edit_item = $_SESSION['program_specification_identification_edit']['id'] ?? $edit_item; // استخدام الـ id المحفوظ في الجلسة إذا كان موجودًا

                if ($edit_item) {
                    // تنفيذ تحديث البيانات
                    $sql = "UPDATE programs_identification SET 
                    main_location = '$main_location', 
                    branches_offering_program = '$branches_offering_program', 
                    partnerships = '$partnerships', 
                    professions_jobs = '$professions_jobs', 
                    occupational_sectors = '$occupational_sectors', 
                    total_credit_hours = '$total_credit_hours', 
                    major_tracks = '$major_tracks', 
                    exit_points = '$exit_points' 
                    WHERE id = '$edit_item' AND program_id = '$program_id' AND user_id = '$user_id'";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Data updated successfully!';
                        $_SESSION['program_specification_identification_edit'] = $_POST;  // تحديث الجلسة بالبيانات المعدلة
                        $_SESSION['program_specification_identification_edit']['id'] = $edit_item;  // الحفاظ على الـ id في الجلسة
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            } else {
                $_SESSION['message'] = 'Please fill in all fields!';
            }

            header("Location: Program_Specification_Program_Identification_and_General_Information.php?edit=" . $program_name);
            exit;
        }

        // عرض البيانات إذا كانت موجودة في الجلسة
        $program_specification_identification_edit = $_SESSION['program_specification_identification_edit'] ?? [];

        // تحويل البيانات إلى مصفوفات بشكل آمن
        $major_tracks = isset($program_specification_identification_edit['major_tracks']) && is_string($program_specification_identification_edit['major_tracks'])
            ? json_decode($program_specification_identification_edit['major_tracks'])
            : ($program_specification_identification_edit['major_tracks'] ?? []);

        $exit_points = isset($program_specification_identification_edit['exit_points']) && is_string($program_specification_identification_edit['exit_points'])
            ? json_decode($program_specification_identification_edit['exit_points'])
            : ($program_specification_identification_edit['exit_points'] ?? []);
    ?>

        <div class="container">
            <div class="sidebar">
                <a href="ProgramSpecification.php?edit=<?php echo $program_name ?>"><button><?= $translations['Programs'] ?></button></a>
                <a href="Program_Specification_Program_Identification_and_General_Information.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program idendification and genral information'] ?></button></a>
                <a href="Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?edit=<?php echo $program_name ?>"><button><?= $translations['Mission,Objectives and program learning outcomes'] ?></button></a>
                <a href="Program_Specification_Curriculum-1_Curriculum_Structure.php?edit=<?php echo $program_name ?>"><button><?= $translations['curiculum'] ?></button></a>
                <a href="Program_Specification_Student_Admission_and_Support.php?edit=<?php echo $program_name ?>"><button><?= $translations['student addmission and support'] ?></button></a>
                <a href="Program_Specification_Faculty_and_Administrative_Staff.php?edit=<?php echo $program_name ?>"><button><?= $translations['Fuculty and Adminstrativ Staff'] ?></button></a>
                <a href="Program_Specification_Learning_Resources_Facilities_and_Equipment.php?edit=<?php echo $program_name ?>"><button><?= $translations['Learning Resources,Facilities and Equipment'] ?></button></a>
                <a href="Program_Specification_Program_Quality_Assurance.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Quality Assurance'] ?></button></a>
                <a href="Program_Specification_Specification_Approval_Data.php?edit=<?php echo $program_name ?>"><button><?= $translations['Specefication Approval Data'] ?></button></a>
            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Program Specification'] ?></h3>
                    <?php $program_action = "edit"  ?>

                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>

                <form method="post">
                    <div id="programs" class="form-container">

                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <label><?= $translations['Select an item to edit'] ?></label>
                        <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <?php
                            $query = "SELECT * FROM programs_identification WHERE program_id = '$program_id' AND user_id = '$user_id'";
                            $result = mysqli_query($conn, $query);
                            while ($row_edit = mysqli_fetch_assoc($result)) {
                                $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$row_edit['main_location']}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>

                        <h2><?= $translations['Program Identification and General Information'] ?></h2>
                        <div class="form-group">



                            <label for="ProgramsMainLocation"><?= $translations['Program’s Main Location'] ?>:</label>
                            <input name="main_location" type="text" id="ProgramsMainLocation" value="<?= $program_specification_identification_edit['main_location'] ?? '' ?>">

                            <label for="BranchesOfferingtheProgram"><?= $translations['Branches Offering the Program (if any)'] ?>:</label>
                            <input name="branches_offering_program" type="text" id="BranchesOfferingtheProgram" value="<?= $program_specification_identification_edit['branches_offering_program'] ?? '' ?>">

                            <label for="Partnerships"><?= $translations['Partnerships with other parties (if any) and the nature of each'] ?>:</label>
                            <input name="partnerships" type="text" id="Partnerships" value="<?= $program_specification_identification_edit['partnerships'] ?? '' ?>">

                            <label for="ProfessionsJobs"><?= $translations['Professions/jobs for which students are qualified'] ?>:</label>
                            <input name="professions_jobs" type="text" id="ProfessionsJobs" value="<?= $program_specification_identification_edit['professions_jobs'] ?? '' ?>">

                            <label for="OccupationalSectors"><?= $translations['Relevant occupational/ Professional sectors'] ?>:</label>
                            <input name="occupational_sectors" type="text" id="OccupationalSectors" value="<?= $program_specification_identification_edit['occupational_sectors'] ?? '' ?>">

                            <label for="TotalCreditHours"><?= $translations['Total credit hours'] ?>:</label>
                            <input name="total_credit_hours" type="text" id="TotalCreditHours" value="<?= $program_specification_identification_edit['total_credit_hours'] ?? '' ?>">

                        </div>

                        <h3><?= $translations['Major Tracks/Pathways (if any)'] ?>:</h3>
                        <table>
                            <tr>
                                <th><?= $translations['Exit Points/Awarded Degree'] ?></th>
                                <th><?= $translations['Credit Hours (For each track)'] ?></th>
                                <th><?= $translations['Professions/Jobs (For each track)'] ?></th>
                            </tr>
                            <?php
                            $unique_major_tracks = array_unique($major_tracks); // إزالة التكرار
                            $chunks = array_chunk($unique_major_tracks, 3); // تقسيم إلى مجموعات من 3
                            foreach ($chunks as $chunk) {
                                echo "<tr>";
                                foreach ($chunk as $track) {
                                    echo "<td><input name='major_tracks[]' type='text' value='{$track}' /></td>";
                                }
                                // إضافة خلايا فارغة إذا كانت المجموعة أقل من 3
                                for ($i = count($chunk); $i < 3; $i++) {
                                    echo "<td><input name='major_tracks[]' type='text' value='' /></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </table>

                        <h3><?= $translations['Exit Points/Awarded Degree (if any)'] ?>:</h3>
                        <table>
                            <tr>
                                <th><?= $translations['Exit Points/Awarded Degree'] ?></th>
                                <th><?= $translations['Credit Hours'] ?></th>
                            </tr>
                            <?php
                            $chunks = array_chunk($exit_points, 2); // تقسيم إلى مجموعات من 2
                            foreach ($chunks as $chunk) {
                                echo "<tr>";
                                foreach ($chunk as $point) {
                                    echo "<td><input name='exit_points[]' type='text' value='{$point}' /></td>";
                                }
                                // إضافة خلايا فارغة إذا كانت المجموعة أقل من 2
                                for ($i = count($chunk); $i < 2; $i++) {
                                    echo "<td><input name='exit_points[]' type='text' value='' /></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </table>

                        <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('ProgramSpecification.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                        <button type="submit" class="button" name="update"><?= $translations['Update'] ?></button>
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