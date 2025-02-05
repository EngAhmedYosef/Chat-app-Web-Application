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
    <title><?= $translations['Course Report-Student Results']?></title>
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
            height: 115vh;
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

        label {
            font-size: 14px;
            /* حجم النص */
            display: block;
            /* النص فوق المربع */
            margin-bottom: 5px;
            /* مسافة صغيرة بين النص والمربع */
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
            margin-bottom: 0px;
        }

        .form-container h3 {
            margin-bottom: 0px;
        }

        .form-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-container label {
            flex: 1 0 30%;
        }

        .form-container input {
            flex: 2 0 60%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .table-container {
            margin-left: auto;
            margin-right: auto;
            padding: 50px;
            margin-top: 40px;
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

        th {

            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 400;
            padding: 5px;
            font-size: 10px;
            border: 1px solid #003f8a;

        }


        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        input {
            width: 40%;
            border: none;
            text-align: center;
            margin: 0px 0;
        }

        textarea {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        textarea {
            width: 95%;
            height: 80px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            font-size: 14px;
        }

        .logout-button {
            background: #003f8a;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #0057b7;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
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
                // تخزين القيم في الجلسة
                $_SESSION['cource_report_results_new'] = $_POST;

                $A_plus_students = $_POST['A_plus_students'];
                $A_students = $_POST['A_students'];
                $B_plus_students = $_POST['B_plus_students'];
                $B_students = $_POST['B_students'];
                $C_plus_students = $_POST['C_plus_students'];
                $C_students = $_POST['C_students'];
                $D_plus_students = $_POST['D_plus_students'];
                $D_students = $_POST['D_students'];
                $F_students = $_POST['F_students'];
                $Denied_Entry = $_POST['Denied_Entry'];
                $In_Progress = $_POST['In_Progress'];
                $Incomplete = $_POST['Incomplete'];
                $Pass = $_POST['Pass'];
                $Fail = $_POST['Fail'];
                $Withdrawn = $_POST['Withdrawn'];

                $A_plus_percentage = $_POST['A_plus_percentage'];
                $A_percentage = $_POST['A_percentage'];
                $B_plus_percentage = $_POST['B_plus_percentage'];
                $B_percentage = $_POST['B_percentage'];
                $C_plus_percentage = $_POST['C_plus_percentage'];
                $C_percentage = $_POST['C_percentage'];
                $D_plus_percentage = $_POST['D_plus_percentage'];
                $D_percentage = $_POST['D_percentage'];
                $F_percentage = $_POST['F_percentage'];
                $Denied_Entry_percentage = $_POST['Denied_Entry_percentage'];
                $In_Progress_percentage = $_POST['In_Progress_percentage'];
                $Incomplete_percentage = $_POST['Incomplete_percentage'];
                $Pass_percentage = $_POST['Pass_percentage'];
                $Fail_percentage = $_POST['Fail_percentage'];
                $Withdrawn_percentage = $_POST['Withdrawn_percentage'];

                $grade_comments = $_POST['grade_comments'];

                if (
                    !empty($A_plus_students) && !empty($A_students) && !empty($B_plus_students) && !empty($B_students) &&
                    !empty($C_plus_students) && !empty($C_students) && !empty($D_plus_students) && !empty($D_students) &&
                    !empty($F_students) && !empty($Denied_Entry) && !empty($In_Progress) && !empty($Incomplete) &&
                    !empty($Pass) && !empty($Fail) && !empty($Withdrawn) && !empty($A_plus_percentage) &&
                    !empty($A_percentage) && !empty($B_plus_percentage) && !empty($B_percentage) && !empty($C_plus_percentage) &&
                    !empty($C_percentage) && !empty($D_plus_percentage) && !empty($D_percentage) &&
                    !empty($F_percentage) && !empty($Denied_Entry_percentage) && !empty($In_Progress_percentage) && !empty($Incomplete_percentage) &&
                    !empty($Pass_percentage) && !empty($Fail_percentage) && !empty($Withdrawn_percentage)
                ) {
                    $sql = "INSERT INTO student_results (user_id, A_plus_students, A_students, B_plus_students, B_students, C_plus_students, C_students, D_plus_students, D_students, F_students, Denied_Entry, In_Progress, Incomplete, Pass, Fail, Withdrawn, A_plus_percentage, A_percentage, B_plus_percentage, B_percentage, C_plus_percentage, C_percentage, D_plus_percentage, D_percentage, F_percentage, Denied_Entry_percentage, In_Progress_percentage, Incomplete_percentage, Pass_percentage, Fail_percentage, Withdrawn_percentage, grade_comments, program_id)
                    VALUES ('$user_id', '$A_plus_students', '$A_students', '$B_plus_students', '$B_students', '$C_plus_students', '$C_students', '$D_plus_students', '$D_students', '$F_students', '$Denied_Entry', '$In_Progress', '$Incomplete', '$Pass', '$Fail', '$Withdrawn', '$A_plus_percentage', '$A_percentage', '$B_plus_percentage', '$B_percentage', '$C_plus_percentage', '$C_percentage', '$D_plus_percentage', '$D_percentage', '$F_percentage', '$Denied_Entry_percentage', '$In_Progress_percentage', '$Incomplete_percentage', '$Pass_percentage', '$Fail_percentage', '$Withdrawn_percentage', '$grade_comments', '$program_id')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Course_Report_Student_Results.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST['next'])) {
                header("location: Course_Report_Course_Learning_Outcomes.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST['back'])) {
                header("location: Course_Report_Reports.php?new=" . $program_name);
                exit;
            }
    ?>
            <div class="container">
                <div class="sidebar">
                    <div class="user-section">
                    </div>
                    <a href="Course_Report_Reports.php?new=<?php echo $program_name ?>"><button><?= $translations['Reports']?></button></a>
                    <a href="Course_Report_Student_Results.php?new=<?php echo $program_name ?>"><button><?= $translations['Student Results']?></button></a>
                    <a href="Course_Report_Course_Learning _Outcomes.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes (CLO)']?></button></a>
                    <a href="Course_Report_Topics_not_covered.php?new=<?php echo $program_name ?>"><button><?= $translations['Topics not covered']?></button></a>
                    <a href="Course_Report_Course_Improvement_Plan_if_any.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Improvement Plan (if any)']?></button></a>
                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Report']?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                        </div>
                    <div id="programs" class="form-container">
                        <h2><?= $translations['Student Results']?></h2>
                        <h3><?= $translations['Grade Distribution']?></h3>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>
                        <form method="POST" id="coursesForm">
                            <table>
                                <tr>
                                    <th rowspan="2"><?= $translations['Number of Students']?></th>
                                    <th><?= $translations['A+']?></th>
                                    <th><?= $translations['A']?></th>
                                    <th><?= $translations['B+']?></th>
                                    <th><?= $translations['B']?></th>
                                    <th><?= $translations['C+']?></th>
                                    <th><?= $translations['C']?></th>
                                    <th><?= $translations['D+']?></th>
                                    <th><?= $translations['D']?></th>
                                    <th><?= $translations['F']?></th>
                                    <th><?= $translations['Denied Entry']?></th>
                                    <th><?= $translations['In Progress']?></th>
                                    <th><?= $translations['Incomplete']?></th>
                                    <th><?= $translations['Pass']?></th>
                                    <th><?= $translations['Fail']?></th>
                                    <th><?= $translations['Withdrawn']?></th>
                                </tr>
                                <tr>
                                    <!-- Input fields for Number of Students -->
                                    <td><input type="number" name="A_plus_students" value="<?php echo isset($_SESSION['cource_report_results_new']['A_plus_students']) ? $_SESSION['cource_report_results_new']['A_plus_students'] : ''; ?>"></td>
                                    <td><input type="number" name="A_students" value="<?php echo isset($_SESSION['cource_report_results_new']['A_students']) ? $_SESSION['cource_report_results_new']['A_students'] : ''; ?>"></td>
                                    <td><input type="number" name="B_plus_students" value="<?php echo isset($_SESSION['cource_report_results_new']['B_plus_students']) ? $_SESSION['cource_report_results_new']['B_plus_students'] : ''; ?>"></td>
                                    <td><input type="number" name="B_students" value="<?php echo isset($_SESSION['cource_report_results_new']['B_students']) ? $_SESSION['cource_report_results_new']['B_students'] : ''; ?>"></td>
                                    <td><input type="number" name="C_plus_students" value="<?php echo isset($_SESSION['cource_report_results_new']['C_plus_students']) ? $_SESSION['cource_report_results_new']['C_plus_students'] : ''; ?>"></td>
                                    <td><input type="number" name="C_students" value="<?php echo isset($_SESSION['cource_report_results_new']['C_students']) ? $_SESSION['cource_report_results_new']['C_students'] : ''; ?>"></td>
                                    <td><input type="number" name="D_plus_students" value="<?php echo isset($_SESSION['cource_report_results_new']['D_plus_students']) ? $_SESSION['cource_report_results_new']['D_plus_students'] : ''; ?>"></td>
                                    <td><input type="number" name="D_students" value="<?php echo isset($_SESSION['cource_report_results_new']['D_students']) ? $_SESSION['cource_report_results_new']['D_students'] : ''; ?>"></td>
                                    <td><input type="number" name="F_students" value="<?php echo isset($_SESSION['cource_report_results_new']['F_students']) ? $_SESSION['cource_report_results_new']['F_students'] : ''; ?>"></td>
                                    <td><input type="number" name="Denied_Entry" value="<?php echo isset($_SESSION['cource_report_results_new']['Denied_Entry']) ? $_SESSION['cource_report_results_new']['Denied_Entry'] : ''; ?>"></td>
                                    <td><input type="number" name="In_Progress" value="<?php echo isset($_SESSION['cource_report_results_new']['In_Progress']) ? $_SESSION['cource_report_results_new']['In_Progress'] : ''; ?>"></td>
                                    <td><input type="number" name="Incomplete" value="<?php echo isset($_SESSION['cource_report_results_new']['Incomplete']) ? $_SESSION['cource_report_results_new']['Incomplete'] : ''; ?>"></td>
                                    <td><input type="number" name="Pass" value="<?php echo isset($_SESSION['cource_report_results_new']['Pass']) ? $_SESSION['cource_report_results_new']['Pass'] : ''; ?>"></td>
                                    <td><input type="number" name="Fail" value="<?php echo isset($_SESSION['cource_report_results_new']['Fail']) ? $_SESSION['cource_report_results_new']['Fail'] : ''; ?>"></td>
                                    <td><input type="number" name="Withdrawn" value="<?php echo isset($_SESSION['cource_report_results_new']['Withdrawn']) ? $_SESSION['cource_report_results_new']['Withdrawn'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <th><?= $translations['Percentage']?></th>
                                    <td><input type="number" name="A_plus_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['A_plus_percentage']) ? $_SESSION['cource_report_results_new']['A_plus_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="A_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['A_percentage']) ? $_SESSION['cource_report_results_new']['A_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="B_plus_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['B_plus_percentage']) ? $_SESSION['cource_report_results_new']['B_plus_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="B_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['B_percentage']) ? $_SESSION['cource_report_results_new']['B_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="C_plus_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['C_plus_percentage']) ? $_SESSION['cource_report_results_new']['C_plus_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="C_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['C_percentage']) ? $_SESSION['cource_report_results_new']['C_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="D_plus_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['D_plus_percentage']) ? $_SESSION['cource_report_results_new']['D_plus_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="D_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['D_percentage']) ? $_SESSION['cource_report_results_new']['D_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="F_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['F_percentage']) ? $_SESSION['cource_report_results_new']['F_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="Denied_Entry_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['Denied_Entry_percentage']) ? $_SESSION['cource_report_results_new']['Denied_Entry_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="In_Progress_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['In_Progress_percentage']) ? $_SESSION['cource_report_results_new']['In_Progress_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="Incomplete_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['Incomplete_percentage']) ? $_SESSION['cource_report_results_new']['Incomplete_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="Pass_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['Pass_percentage']) ? $_SESSION['cource_report_results_new']['Pass_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="Fail_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['Fail_percentage']) ? $_SESSION['cource_report_results_new']['Fail_percentage'] : ''; ?>"></td>
                                    <td><input type="number" name="Withdrawn_percentage" value="<?php echo isset($_SESSION['cource_report_results_new']['Withdrawn_percentage']) ? $_SESSION['cource_report_results_new']['Withdrawn_percentage'] : ''; ?>"></td>
                                </tr>
                            </table>

                            <h3><?= $translations['Comment on Student Grades']?></h3>
                            <textarea name="grade_comments"><?php echo isset($_SESSION['cource_report_results_new']['grade_comments']) ? $_SESSION['cource_report_results_new']['grade_comments'] : ''; ?></textarea>
                            <div class="navigation-buttons">

                                <button name="save" class="nav-button" type="submit"><?= $translations['Save']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Course_Learning _Outcomes.php?new=<?= $program_name ?>')"><?= $translations['Next']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Reports.php?new=<?= $program_name ?>')"><?= $translations['Back']?></button>
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

            // جلب البرنامج الخاص بالمستخدم
            $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row_program = mysqli_fetch_assoc($query_program);
            $program_id = $row_program["id"];

            // التحقق من إذا كان المستخدم قد اختار الـ id للتعديل عليه
            if (isset($_POST['edit_item']) && !empty($_POST['edit_item'])) {
                $edit_item = $_POST['edit_item'];

                // استعلام لجلب البيانات الخاصة بالـ id المختار
                $query = mysqli_query($conn, "SELECT * FROM student_results WHERE id = '$edit_item' AND program_id = '$program_id'");
                if (mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_assoc($query);
                    $_SESSION['cource_report_results_edit'] = $row;  // تخزين البيانات مع الـ id في الجلسة
                }
            }

            // تحديث البيانات في قاعدة البيانات بعد التعديل
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                $A_plus_students = $_POST['A_plus_students'];
                $A_students = $_POST['A_students'];
                $B_plus_students = $_POST['B_plus_students'];
                $B_students = $_POST['B_students'];
                $C_plus_students = $_POST['C_plus_students'];
                $C_students = $_POST['C_students'];
                $D_plus_students = $_POST['D_plus_students'];
                $D_students = $_POST['D_students'];
                $F_students = $_POST['F_students'];
                $Denied_Entry = $_POST['Denied_Entry'];
                $In_Progress = $_POST['In_Progress'];
                $Incomplete = $_POST['Incomplete'];
                $Pass = $_POST['Pass'];
                $Fail = $_POST['Fail'];
                $Withdrawn = $_POST['Withdrawn'];

                $A_plus_percentage = $_POST['A_plus_percentage'];
                $A_percentage = $_POST['A_percentage'];
                $B_plus_percentage = $_POST['B_plus_percentage'];
                $B_percentage = $_POST['B_percentage'];
                $C_plus_percentage = $_POST['C_plus_percentage'];
                $C_percentage = $_POST['C_percentage'];
                $D_plus_percentage = $_POST['D_plus_percentage'];
                $D_percentage = $_POST['D_percentage'];
                $F_percentage = $_POST['F_percentage'];
                $Denied_Entry_percentage = $_POST['Denied_Entry_percentage'];
                $In_Progress_percentage = $_POST['In_Progress_percentage'];
                $Incomplete_percentage = $_POST['Incomplete_percentage'];
                $Pass_percentage = $_POST['Pass_percentage'];
                $Fail_percentage = $_POST['Fail_percentage'];
                $Withdrawn_percentage = $_POST['Withdrawn_percentage'];

                $grade_comments = $_POST['grade_comments'];

                if (
                    !empty($A_plus_students) && !empty($A_students) && !empty($B_plus_students) && !empty($B_students) &&
                    !empty($C_plus_students) && !empty($C_students) && !empty($D_plus_students) && !empty($D_students) &&
                    !empty($F_students) && !empty($Denied_Entry) && !empty($In_Progress) && !empty($Incomplete) &&
                    !empty($Pass) && !empty($Fail) && !empty($Withdrawn) && !empty($A_plus_percentage) &&
                    !empty($A_percentage) && !empty($B_plus_percentage) && !empty($B_percentage) && !empty($C_plus_percentage) &&
                    !empty($C_percentage) && !empty($D_plus_percentage) && !empty($D_percentage) && !empty($F_percentage) &&
                    !empty($Denied_Entry_percentage) && !empty($In_Progress_percentage) && !empty($Incomplete_percentage) &&
                    !empty($Pass_percentage) && !empty($Fail_percentage) && !empty($Withdrawn_percentage)
                ) {
                    $update_id = $_SESSION['cource_report_results_edit']['id']; // الحصول على الـ id من البيانات المخزنة في الجلسة

                    $sql = "UPDATE student_results SET A_plus_students = '$A_plus_students',
            A_students = '$A_students', B_plus_students = '$B_plus_students', B_students = '$B_students',
            C_plus_students = '$C_plus_students', C_students = '$C_students', D_plus_students = '$D_plus_students',
            D_students = '$D_students', F_students = '$F_students', Denied_Entry = '$Denied_Entry', In_Progress = '$In_Progress',
            Incomplete = '$Incomplete', Pass = '$Pass', Fail = '$Fail',
            Withdrawn = '$Withdrawn', A_plus_percentage = '$A_plus_percentage', A_percentage = '$A_percentage',
            B_plus_percentage = '$B_plus_percentage', B_percentage = '$B_percentage', C_plus_percentage = '$C_plus_percentage',
            C_percentage = '$C_percentage', D_plus_percentage = '$D_plus_percentage', D_percentage = '$D_percentage',
            F_percentage = '$F_percentage', Denied_Entry_percentage = '$Denied_Entry_percentage', In_Progress_percentage = '$In_Progress_percentage',
            Incomplete_percentage = '$Incomplete_percentage', Pass_percentage = '$Pass_percentage', Fail_percentage = '$Fail_percentage', Withdrawn_percentage = '$Withdrawn_percentage', grade_comments = '$grade_comments' WHERE id = '$update_id'";

                    if ($conn->query($sql) === TRUE) {
                        // بعد التحديث، إعادة تحميل البيانات
                        $query = mysqli_query($conn, "SELECT * FROM student_results WHERE id = '$update_id'");
                        $_SESSION['cource_report_results_edit'] = mysqli_fetch_assoc($query); // تخزين البيانات المحدثة في الجلسة
                        $_SESSION['message'] = 'Records updated successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while updating data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Course_Report_Student_Results.php?edit=" . $program_name);
                exit;
            }

            // التعامل مع التنقل بين الصفحات
            if (isset($_POST['next'])) {
                header("location: Course_Report_Course_Learning_Outcomes.php?edit=" . $program_name);
                exit;
            }
            if (isset($_POST['back'])) {
                header("location: Course_Report_Reports.php?edit=" . $program_name);
                exit;
            }
        ?>

            <div class="container">
                <div class="sidebar">
                <a href="Course_Report_Reports.php?edit=<?php echo $program_name ?>"><button><?= $translations['Reports']?></button></a>
                    <a href="Course_Report_Student_Results.php?edit=<?php echo $program_name ?>"><button><?= $translations['Student Results']?></button></a>
                    <a href="Course_Report_Course_Learning _Outcomes.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes (CLO)']?></button></a>
                    <a href="Course_Report_Topics_not_covered.php?edit=<?php echo $program_name ?>"><button><?= $translations['Topics not covered']?></button></a>
                    <a href="Course_Report_Course_Improvement_Plan_if_any.php?edit=<?php echo $program_name ?>"><button><?= $translations['Course Improvement Plan (if any)']?></button></a>
                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Report']?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                        </div>
                    <div id="programs" class="form-container">
                        <h2><?= $translations['Student Results']?></h2>
                        <h3><?= $translations['Grade Distribution']?></h3>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>
                        <form method="POST" id="coursesForm">
                            <label><?= $translations['Select an item to edit']?></label>
                            <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                                <option value=""><?= $translations['Select']?></option>
                                <?php
                                $query = "SELECT * FROM student_results WHERE program_id = '$program_id'";
                                $result = mysqli_query($conn, $query);
                                while ($row_edit = mysqli_fetch_assoc($result)) {
                                    $selected = ($_SESSION['cource_report_results_edit']['id'] == $row_edit['id']) ? 'selected' : '';
                                    echo "<option value='{$row_edit['id']}' $selected>{$row_edit['grade_comments']}</option>";
                                }
                                ?>
                            </select>
                            <button type="submit" class="button" name="edit_row"><?= $translations['Edit']?></button>

                            <table>
                                <tr>
                                    <th rowspan="2"><?= $translations['Number of Students']?></th>
                                    <th><?= $translations['A+']?></th>
                                    <th><?= $translations['A']?></th>
                                    <th><?= $translations['B+']?></th>
                                    <th><?= $translations['B']?></th>
                                    <th><?= $translations['C+']?></th>
                                    <th><?= $translations['C']?></th>
                                    <th><?= $translations['D+']?></th>
                                    <th><?= $translations['D']?></th>
                                    <th><?= $translations['F']?></th>
                                    <th><?= $translations['Denied Entry']?></th>
                                    <th><?= $translations['In Progress']?></th>
                                    <th><?= $translations['Incomplete']?></th>
                                    <th><?= $translations['Pass']?></th>
                                    <th><?= $translations['Fail']?></th>
                                    <th><?= $translations['Withdrawn']?></th>
                                </tr>
                                <tr>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['A_plus_students'] ?? '') ?>" type="number" name="A_plus_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['A_students'] ?? '') ?>" type="number" name="A_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['B_plus_students'] ?? '') ?>" type="number" name="B_plus_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['B_students'] ?? '') ?>" type="number" name="B_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['C_plus_students'] ?? '') ?>" type="number" name="C_plus_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['C_students'] ?? '') ?>" type="number" name="C_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['D_plus_students'] ?? '') ?>" type="number" name="D_plus_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['D_students'] ?? '') ?>" type="number" name="D_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['F_students'] ?? '') ?>" type="number" name="F_students"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Denied_Entry'] ?? '') ?>" type="number" name="Denied_Entry"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['In_Progress'] ?? '') ?>" type="number" name="In_Progress"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Incomplete'] ?? '') ?>" type="number" name="Incomplete"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Pass'] ?? '') ?>" type="number" name="Pass"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Fail'] ?? '') ?>" type="number" name="Fail"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Withdrawn'] ?? '') ?>" type="number" name="Withdrawn"></td>
                                </tr>
                                <tr>
                                    <th><?= $translations['Percentage']?></th>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['A_plus_percentage'] ?? '') ?>" type="number" name="A_plus_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['A_percentage'] ?? '') ?>" type="number" name="A_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['B_plus_percentage'] ?? '') ?>" type="number" name="B_plus_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['B_percentage'] ?? '') ?>" type="number" name="B_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['C_plus_percentage'] ?? '') ?>" type="number" name="C_plus_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['C_percentage'] ?? '') ?>" type="number" name="C_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['D_plus_percentage'] ?? '') ?>" type="number" name="D_plus_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['D_percentage'] ?? '') ?>" type="number" name="D_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['F_percentage'] ?? '') ?>" type="number" name="F_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Denied_Entry_percentage'] ?? '') ?>" type="number" name="Denied_Entry_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['In_Progress_percentage'] ?? '') ?>" type="number" name="In_Progress_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Incomplete_percentage'] ?? '') ?>" type="number" name="Incomplete_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Pass_percentage'] ?? '') ?>" type="number" name="Pass_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Fail_percentage'] ?? '') ?>" type="number" name="Fail_percentage"></td>
                                    <td><input value="<?= htmlspecialchars($_SESSION['cource_report_results_edit']['Withdrawn_percentage'] ?? '') ?>" type="number" name="Withdrawn_percentage"></td>
                                </tr>
                            </table>

                            <h3><?= $translations['Comment on Student Grades']?></h3>
                            <textarea name="grade_comments"><?= htmlspecialchars($_SESSION['cource_report_results_edit']['grade_comments'] ?? '') ?></textarea>

                            <div class="navigation-buttons">
                                <button name="update" class="nav-button" type="submit"><?= $translations['Update']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Course_Learning _Outcomes.php?edit=<?= $program_name ?>')"><?= $translations['Next']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Reports.php?edit=<?= $program_name ?>')"><?= $translations['Back']?></button>
                            </div>
                        </form>

                    </div>
                </div>

                <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                        <p>You have unsaved data. Do you want to leave without saving?</p>
                        <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Leave</button>
                        <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Stay</button>
                    </div>
                </div>

            <?php }
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