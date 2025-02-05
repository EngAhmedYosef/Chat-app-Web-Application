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
    <title><?= $translations['Course Report-Reports']?></title>
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



        .header h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        }

        .form-container {
            width: 97%;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-container label {
            flex: 1 0 40%;
            margin-bottom: 5px;
        }

        .form-container input {
            flex: 2 0 50%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
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

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["save"])) {
                // تخزين البيانات المدخلة في $_SESSION['cource_report_reports_new']
                $_SESSION['cource_report_reports_new'] = $_POST;

                $course_title = $_POST['course_title'];
                $course_code = $_POST['course_code'];
                $program = $_POST['program'];
                $department = $_POST['department'];
                $college = $_POST['college'];
                $institution = $_POST['institution'];
                $academic_year = $_POST['academic_year'];
                $semester = $_POST['semester'];
                $course_instructor = $_POST['course_instructor'];
                $course_coordinator = $_POST['course_coordinator'];
                $num_students_start = $_POST['num_students_start'];
                $num_students_completed = $_POST['num_students_completed'];
                $report_date = $_POST['report_date'];
                $location = $_POST['location'];

                if (
                    !empty($course_title) && !empty($course_code) && !empty($program) && !empty($department)
                    && !empty($college) && !empty($institution) &&
                    !empty($academic_year) && !empty($semester) && !empty($course_instructor) && !empty($course_coordinator)
                    && !empty($num_students_start) && !empty($num_students_completed) &&
                    !empty($report_date) && !empty($location)
                ) {
                    // إدخال البيانات في قاعدة البيانات
                    $sql = "INSERT INTO reports (user_id, course_title, course_code, program, department, college, institution, academic_year, semester, course_instructor, course_coordinator, num_students_start, num_students_completed, report_date, location, program_id) 
                VALUES ('$user_id', '$course_title', '$course_code', '$program', '$department', '$college', '$institution', '$academic_year', '$semester', '$course_instructor', '$course_coordinator', '$num_students_start', '$num_students_completed', '$report_date', '$location', '$program_id')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Course_Report_Reports.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST['next'])) {
                header("location: Course_Report_Student_Results.php?new=" . $program_name);
                exit;
            }
            if (isset($_POST['back'])) {
                header("location: HomePage.php");
                exit;
            }


            $program_repeat =  $_SESSION['program_repeat'] ?? '' ;
            $department_repeat = $_SESSION['department_repeat'] ?? '';
            $college_repeat =  $_SESSION['college_repeat'] ?? '';
            $institution_repeat =  $_SESSION['institution_repeat'] ?? '';


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
                    <form method="POST" id="coursesForm">
                        <div id="programs" class="form-container">
                            <h2><?= $translations['Reports specification']?></h2>
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo $translations[$_SESSION['message']];
                                unset($_SESSION['message']);
                            }
                            ?>
                            <div class="form-group">
                                <label for="Course Title"><?= $translations['Course Title']?>:</label>
                                <input type="text" id="Course Title" name="course_title" placeholder="<?= $translations['Enter Course Title']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['course_title']) ? $_SESSION['cource_report_reports_new']['course_title'] : ''; ?>">

                                <label for="Course-code"><?= $translations['Course Code']?>:</label>
                                <input type="text" id="Course-code" name="course_code" placeholder="<?= $translations['Enter Course Code']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['course_code']) ? $_SESSION['cource_report_reports_new']['course_code'] : ''; ?>">

                                <label for="Program"><?= $translations['Program']?>:</label>
                                <input type="text" id="Program" name="program" placeholder="<?= $translations['Enter Program Name']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['program']) ? $_SESSION['cource_report_reports_new']['program'] : $program_repeat; ?>">

                                <label for="department"><?= $translations['Department']?>:</label>
                                <input type="text" id="department" name="department" placeholder="<?= $translations['Enter Department Name']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['department']) ? $_SESSION['cource_report_reports_new']['department'] : $department_repeat; ?>">

                                <label for="college"><?= $translations['College']?>:</label>
                                <input type="text" id="college" name="college" placeholder="<?= $translations['Enter College Name']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['college']) ? $_SESSION['cource_report_reports_new']['college'] : $college_repeat; ?>">

                                <label for="institution"><?= $translations['Institution']?>:</label>
                                <input type="text" id="institution" name="institution" placeholder="<?= $translations['Enter Institution Name']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['institution']) ? $_SESSION['cource_report_reports_new']['institution'] : $institution_repeat; ?>">

                                <label for="academic-year"><?= $translations['Academic Year']?>:</label>
                                <input type="text" id="academic-year" name="academic_year" placeholder="<?= $translations['Enter Academic Year']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['academic_year']) ? $_SESSION['cource_report_reports_new']['academic_year'] : ''; ?>">

                                <label for="Semester"><?= $translations['Semester']?>:</label>
                                <input type="text" id="semester" name="semester" placeholder="<?= $translations['Enter Semester']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['semester']) ? $_SESSION['cource_report_reports_new']['semester'] : ''; ?>">

                                <label for="Course Instructor"><?= $translations['Course Instructor']?>:</label>
                                <input type="text" id="Course Instructor" name="course_instructor" placeholder="<?= $translations['Enter Course Instructor Name']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['course_instructor']) ? $_SESSION['cource_report_reports_new']['course_instructor'] : ''; ?>">

                                <label for="Course Coordinator"><?= $translations['Course Coordinator']?>:</label>
                                <input type="text" id="Course Coordinator" name="course_coordinator" placeholder="<?= $translations['Enter Course Coordinator Name']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['course_coordinator']) ? $_SESSION['cource_report_reports_new']['course_coordinator'] : ''; ?>">

                                <label for="Number of Students (Starting the Course)"><?= $translations['Number of Students (Starting the Course)']?>:</label>
                                <input type="number" id="num_students_start" name="num_students_start" placeholder="<?= $translations['Enter Number of Students Starting the Course']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['num_students_start']) ? $_SESSION['cource_report_reports_new']['num_students_start'] : ''; ?>">

                                <label for="Number of Students (Completed the Course)"><?= $translations['Number of Students (Completed the Course)']?>:</label>
                                <input type="number" id="num_students_completed" name="num_students_completed" placeholder="<?= $translations['Enter Number of Students Completed the Course']?>" value="<?php echo isset($_SESSION['cource_report_reports_new']['num_students_completed']) ? $_SESSION['cource_report_reports_new']['num_students_completed'] : ''; ?>">

                                <label for="Report Date"><?= $translations['Report Date']?>:</label>
                                <input type="date" id="report_date" name="report_date" placeholder="Enter Report Date" value="<?php echo isset($_SESSION['cource_report_reports_new']['report_date']) ? $_SESSION['cource_report_reports_new']['report_date'] : ''; ?>">

                                <label><?= $translations['Location']?>:</label>
                                <input type="radio" id="main-campus" name="location" value="main" <?php echo isset($_SESSION['cource_report_reports_new']['location']) && $_SESSION['cource_report_reports_new']['location'] == 'main' ? 'checked' : ''; ?>>
                                <label for="main-campus"><?= $translations['Main campus']?></label>

                                <input type="radio" id="branch" name="location" value="branch" <?php echo isset($_SESSION['cource_report_reports_new']['location']) && $_SESSION['cource_report_reports_new']['location'] == 'branch' ? 'checked' : ''; ?>>
                                <label for="branch"><?= $translations['Branch']?></label>
                            </div>
                        </div>
                        <div class="navigation-buttons">
                            <button name="save" class="nav-button" type="submit"><?= $translations['Save']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Student_Results.php?new=<?= $program_name ?>')"><?= $translations['Next']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('HomePage.php')"><?= $translations['Back']?></button>
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
    }
    ?>


    <?php

    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق إذا كان المستخدم قد اختار أي عنصر للتعديل
        $edit_item = $_POST['edit_item'] ?? '';

        if ($edit_item) {
            // استعلام لتحميل البيانات من قاعدة البيانات بناءً على الـ ID المحدد
            $query = mysqli_query($conn, "SELECT * FROM reports WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);

            // تخزين البيانات في الجلسة
            $_SESSION['cource_report_reports_edit'] = $row;
        }

        // التعامل مع عملية التحديث عند الضغط على زر "Update"
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["update"])) {
            $course_title = $_POST['course_title'];
            $course_code = $_POST['course_code'];
            $program = $_POST['program'];
            $department = $_POST['department'];
            $college = $_POST['college'];
            $institution = $_POST['institution'];
            $academic_year = $_POST['academic_year'];
            $semester = $_POST['semester'];
            $course_instructor = $_POST['course_instructor'];
            $course_coordinator = $_POST['course_coordinator'];
            $num_students_start = $_POST['num_students_start'];
            $num_students_completed = $_POST['num_students_completed'];
            $report_date = $_POST['report_date'];
            $location = $_POST['location'];

            // التأكد من أن جميع الحقول مليئة بالبيانات
            if (
                !empty($course_title) && !empty($course_code) && !empty($program) && !empty($department)
                && !empty($college) && !empty($institution) &&
                !empty($academic_year) && !empty($semester) && !empty($course_instructor) && !empty($course_coordinator)
                && !empty($num_students_start) && !empty($num_students_completed) &&
                !empty($report_date) && !empty($location)
            ) {
                // التحديث في قاعدة البيانات باستخدام الـ ID المخزن في الجلسة
                $update_id = $_SESSION['cource_report_reports_edit']['id'];  // الحصول على الـ ID من الجلسة
                $sql = "UPDATE reports SET course_title = '$course_title', course_code = '$course_code', program = '$program', department = '$department',
            college = '$college', institution = '$institution', academic_year = '$academic_year',
            semester = '$semester', course_instructor = '$course_instructor', course_coordinator = '$course_coordinator',
            num_students_start = '$num_students_start', num_students_completed = '$num_students_completed', report_date = '$report_date', 
            location = '$location' WHERE id = '$update_id'";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] = 'Records updated successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }

                // بعد التحديث، نعيد تخزين البيانات المحدثة في الجلسة لتعديلها لاحقاً
                $_SESSION['cource_report_reports_edit'] = [
                    'id' => $update_id,
                    'course_title' => $course_title,
                    'course_code' => $course_code,
                    'program' => $program,
                    'department' => $department,
                    'college' => $college,
                    'institution' => $institution,
                    'academic_year' => $academic_year,
                    'semester' => $semester,
                    'course_instructor' => $course_instructor,
                    'course_coordinator' => $course_coordinator,
                    'num_students_start' => $num_students_start,
                    'num_students_completed' => $num_students_completed,
                    'report_date' => $report_date,
                    'location' => $location
                ];
            } else {
                $_SESSION['message'] = 'Please fill in all fields.';
            }

            // إعادة توجيه للصفحة نفسها بعد التحديث
            header("location: Course_Report_Reports.php?edit=" . $program_name);
            exit;
        }

        if (isset($_POST['next'])) {
            header("location: Course_Report_Student_Results.php?edit=" . $program_name);
            exit;
        }

        if (isset($_POST['back'])) {
            header("location: HomePage.php");
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
                <form method="POST" id="coursesForm">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <label><?= $translations['Select an item to edit']?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select']?></option>
                        <?php
                        // عرض الخيارات
                        $query = "SELECT * FROM reports WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                            echo "<option value='{$row_edit['id']}' $selected>{$row_edit['course_title']}</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit']?></button>

                    <div id="programs" class="form-container">
                        <h2><?= $translations['Reports specification']?></h2>
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= $_SESSION['cource_report_reports_edit']['id'] ?? '' ?>">

                            <label for="Course Title"><?= $translations['Course Title']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['course_title'] ?? '' ?>" type="text" id="Course Title" name="course_title">

                            <label for="Course-code"><?= $translations['Course Code']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['course_code'] ?? '' ?>" type="text" id="Course-code" name="course_code">

                            <label for="Program"><?= $translations['Program']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['program'] ?? '' ?>" type="text" id="Program" name="program">

                            <label for="department"><?= $translations['Department']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['department'] ?? '' ?>" type="text" id="department" name="department">

                            <label for="college"><?= $translations['College']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['college'] ?? '' ?>" type="text" id="college" name="college">

                            <label for="institution"><?= $translations['Institution']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['institution'] ?? '' ?>" type="text" id="institution" name="institution">

                            <label for="academic-year"><?= $translations['Academic Year']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['academic_year'] ?? '' ?>" type="text" id="academic-year" name="academic_year">

                            <label for="Semester"><?= $translations['Semester']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['semester'] ?? '' ?>" type="text" id="semester" name="semester">

                            <label for="Course Instructor"><?= $translations['Course Instructor']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['course_instructor'] ?? '' ?>" type="text" id="Course Instructor" name="course_instructor">

                            <label for="Course Coordinator"><?= $translations['Course Coordinator']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['course_coordinator'] ?? '' ?>" type="text" id="Course Coordinator" name="course_coordinator">

                            <label for="Number of Students (Starting the Course)"><?= $translations['Number of Students (Starting the Course)']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['num_students_start'] ?? '' ?>" type="number" id="num_students_start" name="num_students_start">

                            <label for="Number of Students (Completed the Course)"><?= $translations['Number of Students (Completed the Course)']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['num_students_completed'] ?? '' ?>" type="number" id="num_students_completed" name="num_students_completed">

                            <label for="Report Date"><?= $translations['Report Date']?>:</label>
                            <input value="<?= $_SESSION['cource_report_reports_edit']['report_date'] ?? '' ?>" type="date" id="report_date" name="report_date">

                            <label><?= $translations['Location']?>:</label>
                            <input value="main" type="radio" name="location" <?= ($_SESSION['cource_report_reports_edit']['location'] ?? '') == 'main' ? 'checked' : '' ?>>
                            <label for="main-campus"><?= $translations['Main campus']?></label>

                            <input value="branch" type="radio" name="location" <?= ($_SESSION['cource_report_reports_edit']['location'] ?? '') == 'branch' ? 'checked' : '' ?>>
                            <label for="branch"><?= $translations['Branch']?></label>
                        </div>
                    </div>

                    <div class="navigation-buttons">
                        <button name="update" class="nav-button" type="submit"><?= $translations['Update']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Course_Report_Student_Results.php?edit=<?= $program_name ?>')"><?= $translations['Next']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('HomePage.php')"><?= $translations['Back']?></button>
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