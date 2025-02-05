<?php
ob_start();
include_once "conn.php";
include_once("langSwitcher.php");

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
    <title><?= $translations['Annual Program Report'] ?></title>
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

        .title-logo {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* محاذاة النصوص إلى اليسار */
            color: #003f8a;
            /* لون النص */
        }

        .title-logo h1 {
            margin: 10;
            font-size: 24px;
            font-weight: bold;
        }

        .title-logo h2 {
            margin: 0;
            font-size: 16px;
            font-weight: normal;
            color: #6a7a8c;
            /* لون النص الفرعي */
        }

        .logo {
            width: 60px;
            /* حجم الشعار */
            height: 60px;
            border-radius: 50%;
            /* إذا أردت جعله دائريًا */
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

        .form-group h2 {
            margin-bottom: 20px;
            /* مسافة بين المجموعات */
        }

        .form-container label {
            flex: 1 0 30%;
            margin-bottom: 5px;
        }

        .form-container input {
            flex: 2 0 60%;
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

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                $program = $_POST['program'] ?? '';
                $program_code = $_POST['program_code'] ?? '';
                $qualification_level = $_POST['qualification_level'] ?? '';
                $department = $_POST['department'] ?? '';
                $college = $_POST['college'] ?? '';
                $institution = $_POST['institution'] ?? '';
                $academic_year = $_POST['academic_year'] ?? '';
                $main_location = $_POST['main_location'] ?? '';
                $user_id = $_SESSION['user_id'];

                // الاستعلام باستخدام mysqli
                if (
                    !empty($program) && !empty($program_code) && !empty($qualification_level) && !empty($department)
                    && !empty($college) && !empty($institution) && !empty($academic_year) && !empty($main_location)

                ) {

                    $query = "INSERT INTO program_specification (user_id, program_name, program_code, qualification_level, department, college, institution, academic_year, main_location, program_id)
                  VALUES ('$user_id', '$program', '$program_code', '$qualification_level', '$department', '$college', '$institution', '$academic_year', '$main_location', '$program_id')";

                    if (mysqli_query($conn, $query)) {
                        $_SESSION['message'] = 'Records created successfully!';
                        $_SESSION['specification_new'] = $_POST;
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please Insert All Fields.';
                    $_SESSION['specification_new'] = $_POST;
                }

                header("location: ProgramSpecification.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST["next"])) {
                header(header: "location: Program_Specification_Program_Identification_and_General_Information.php?new=" . $program_name);
                exit;
            }
            if (isset($_POST["back"])) {
                header(header: "location: HomePage.php?new=" . $program_name);
                exit;
            }
            $specification_new = $_SESSION['specification_new'] ?? [];

            if (isset($specification_new['program'])) {
                $_SESSION['program_repeat'] = $specification_new['program'];
            }

            if (isset($specification_new['department'])) {
                $_SESSION['department_repeat'] = $specification_new['department'];
            }

            if (isset($specification_new['college'])) {
                $_SESSION['college_repeat'] = $specification_new['college'];
            }

            if (isset($specification_new['institution'])) {
                $_SESSION['institution_repeat'] = $specification_new['institution'];
            }

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
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                    <div id="programs" class="form-container">
                        <?php



                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <h2><?= $translations['Program Specification'] ?></h2>
                        <?php $program_action = "new"  ?>
                        <form method="post" id="coursesForm">

                            <div class="form-group">



                                <label for="program"><?= $translations['Program'] ?>:</label>


                                <input value="<?php echo htmlspecialchars($specification_new['program'] ?? ''); ?>" name="program" type="text" id="program" placeholder="<?= $translations['Enter Program Name'] ?>">

                                <label for="program-code">:<?= $translations['Program Code'] ?></label>
                                <input value="<?php echo htmlspecialchars($specification_new['program_code'] ?? ''); ?>" name="program_code" type="text" id="program-code" placeholder="<?= $translations['Enter Program Code'] ?>">

                                <label for="qualification-level">:<?= $translations['Qualification Level'] ?></label>
                                <input value="<?php echo htmlspecialchars($specification_new['qualification_level'] ?? ''); ?>" name="qualification_level" type="text" id="qualification-level" placeholder="<?= $translations['Enter Qualification Level'] ?>">

                                <label for="department">:<?= $translations['Department'] ?></label>
                                <input value="<?php echo htmlspecialchars($specification_new['department'] ?? ''); ?>" name="department" type="text" id="department" placeholder="<?= $translations['Enter Department Name'] ?>">

                                <label for="college"><?= $translations['College'] ?>:</label>
                                <input value="<?php echo htmlspecialchars($specification_new['college'] ?? ''); ?>" name=" college" type="text" id="college" placeholder="<?= $translations['Enter College Name'] ?>">

                                <label for="institution"><?= $translations['Institution'] ?>:</label>
                                <input value="<?php echo htmlspecialchars($specification_new['institution'] ?? ''); ?>" name="institution" type="text" id="institution" placeholder="<?= $translations['Enter Institution Name'] ?>">

                                <label for="academic-year"><?= $translations['Program Specification'] ?>:</label>
                                <input value="<?php echo htmlspecialchars($specification_new['academic_year'] ?? ''); ?>" name="academic_year" type="text" id="academic-year" placeholder="<?= $translations['New or Update'] ?>">

                                <label for="main-location"><?= $translations['Last Review Date'] ?>:</label>
                                <input value="<?php echo htmlspecialchars($specification_new['main_location'] ?? ''); ?>" name="main_location" type="text" id="main-location" placeholder="<?= $translations['Enter the Main Location of the Program'] ?>">

                            </div>
                            <div class="navigation-buttons">
                                <button type="button" class="nav-button" onclick="handleNavigation('HomePage.php')"><?= $translations['Back'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Program_Identification_and_General_Information.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save'] ?></button>

                            </div>

                    </div>
                    </form>
                    <div id="statistics" class="form-container" style="display: none;">
                        <h2>Program Statistics</h2>
                        <p>Content for Program Statistics...</p>
                    </div>
                    <div id="assessment" class="form-container" style="display: none;">
                        <h2>Program Assessment</h2>
                        <p>Content for Program Assessment...</p>
                    </div>
                    <div id="kpis" class="form-container" style="display: none;">
                        <h2>Key Performance Indicators</h2>
                        <p>Content for KPIs...</p>
                    </div>
                    <div id="challenges" class="form-container" style="display: none;">
                        <h2>Challenges and Difficulties</h2>
                        <p>Content for Challenges...</p>
                    </div>
                    <div id="development" class="form-container" style="display: none;">
                        <h2>Program Development Plan</h2>
                        <p>Content for Program Development Plan...</p>
                    </div>
                    <div id="approval" class="form-container" style="display: none;">
                        <h2>Approval of Annual Program Report</h2>
                        <p>Content for Approval...</p>
                    </div>
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
    }
    ?>

    <?php
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        $edit_item = $_POST['edit_item'] ?? '';

        // حفظ الـ ID في الجلسة عند اختيار item من الـ select
        if (isset($_POST['edit_item'])) {
            $_SESSION['specification_edit']['id'] = $_POST['edit_item'];
        }

        // استرجاع الـ ID المحفوظ في الجلسة
        $edit_item = $_SESSION['specification_edit']['id'] ?? '';

        if ($edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM program_specification WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);
            $update_id = $row["id"];
        }

        // تنفيذ الـ UPDATE عند الضغط على زر الـ "Update"
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $program = $_POST['program'] ?? '';
            $program_code = $_POST['program_code'] ?? '';
            $qualification_level = $_POST['qualification_level'] ?? '';
            $department = $_POST['department'] ?? '';
            $college = $_POST['college'] ?? '';
            $institution = $_POST['institution'] ?? '';
            $academic_year = $_POST['academic_year'] ?? '';
            $main_location = $_POST['main_location'] ?? '';
            $user_id = $_SESSION['user_id'];

            // التحقق من ملء جميع الحقول
            if (
                !empty($program) && !empty($program_code) && !empty($qualification_level) && !empty($department)
                && !empty($college) && !empty($institution) && !empty($academic_year) && !empty($main_location)
            ) {
                // التحقق من أن الـ ID في الجلسة هو نفس الـ ID الذي يتم تعديله
                $update_id = $_SESSION['specification_edit']['id'] ?? '';
                if ($update_id) {
                    $query = "UPDATE program_specification SET program_name = '$program', program_code = '$program_code',
                    qualification_level = '$qualification_level', department = '$department',
                    college = '$college', institution = '$institution',
                    academic_year = '$academic_year', main_location = '$main_location'
                    WHERE id = '$update_id'";

                    if (mysqli_query($conn, $query)) {
                        $_SESSION['message'] = 'Records Updated successfully!';
                        $_SESSION['specification_edit'] = $_POST;
                    } else {
                        $_SESSION['message'] = 'Error occurred while updating data.';
                    }
                }
            } else {
                $_SESSION['message'] = 'Please Insert All Fields';
                $_SESSION['specification_edit'] = $_POST;
            }

            // إعادة التوجيه بعد التحديث
            header("location: ProgramSpecification.php?edit=" . $program_name);
            exit;
        }

        // إجراءات التنقل (back و next)
        if (isset($_POST["next"])) {
            header("location: Program_Specification_Program_Identification_and_General_Information.php?edit=" . $program_name);
            exit;
        }
        if (isset($_POST["back"])) {
            header("location: HomePage.php?edit=" . $program_name);
            exit;
        }

        // استرجاع البيانات المحفوظة في الجلسة (لتعبئة الحقول في النموذج)
        $specification_edit = $_SESSION['specification_edit'] ?? [];
    ?>
        <div class="container">
            <div class="sidebar">
                <div class="user-section">
                </div>
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
                    <h3>
                        <h2><?= $translations['Program Specification'] ?></h2>
                    </h3>
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

                        <h2>
                            <h2><?= $translations['Program Specification'] ?></h2>
                        </h2>

                        <?php
                        // استعلام لجلب جميع الخيارات
                        $query = "SELECT * FROM program_specification WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        ?>

                        <label>
                            <?= $translations['Select an item to edit'] ?>
                        </label>
                        <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select'] ?></option>
                            <?php
                            // عرض الخيارات
                            while ($row_edit = mysqli_fetch_assoc($result)) {
                                $selected = ($row_edit['id'] == $specification_edit['id']) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$row_edit['program_name']}</option>";
                            }
                            ?>
                        </select>

                        <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($specification_edit['id'] ?? '') ?>">

                        <div class="form-group">

                            <label for="program"><?= $translations['Program'] ?>:</label>
                            <input value="<?= isset($row['program_name']) ? htmlspecialchars($row['program_name']) : (isset($specification_edit['program']) ? htmlspecialchars($specification_edit['program']) : '') ?>" name="program" type="text" id="program">

                            <label for="program-code"><?= $translations['Program Code'] ?>:</label>
                            <input value="<?= isset($row['program_code']) ? htmlspecialchars($row['program_code']) : (isset($specification_edit['program_code']) ? htmlspecialchars($specification_edit['program_code']) : '') ?>" name="program_code" type="text" id="program-code">

                            <label for="qualification-level"><?= $translations['Qualification Level'] ?>:</label>
                            <input value="<?= isset($row['qualification_level']) ? htmlspecialchars($row['qualification_level']) : (isset($specification_edit['qualification_level']) ? htmlspecialchars($specification_edit['qualification_level']) : '') ?>" name="qualification_level" type="text" id="qualification-level">

                            <label for="department"><?= $translations['Department'] ?>:</label>
                            <input value="<?= isset($row['department']) ? htmlspecialchars($row['department']) : (isset($specification_edit['department']) ? htmlspecialchars($specification_edit['department']) : '') ?>" name="department" type="text" id="department">

                            <label for="college"><?= $translations['College'] ?>:</label>
                            <input value="<?= isset($row['college']) ? htmlspecialchars($row['college']) : (isset($specification_edit['college']) ? htmlspecialchars($specification_edit['college']) : '') ?>" name="college" type="text" id="college">

                            <label for="institution"><?= $translations['Institution'] ?>:</label>
                            <input value="<?= isset($row['institution']) ? htmlspecialchars($row['institution']) : (isset($specification_edit['institution']) ? htmlspecialchars($specification_edit['institution']) : '') ?>" name="institution" type="text" id="institution">

                            <label for="academic-year"><?= $translations['Program Specification'] ?>:</label>
                            <input value="<?= isset($row['academic_year']) ? htmlspecialchars($row['academic_year']) : (isset($specification_edit['academic_year']) ? htmlspecialchars($specification_edit['academic_year']) : '') ?>" name="academic_year" type="text" id="academic-year">

                            <label for="main-location"><?= $translations['Last Review Date'] ?>:</label>
                            <input value="<?= isset($row['main_location']) ? htmlspecialchars($row['main_location']) : (isset($specification_edit['main_location']) ? htmlspecialchars($specification_edit['main_location']) : '') ?>" name="main_location" type="text" id="main-location">
                        </div>
                        <div class="navigation-buttons">
                            <button type="button" class="nav-button" onclick="handleNavigation('HomePage.php')"><?= $translations['Back'] ?></button>
                            <button type="submit" name="update" class="button"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Program_Identification_and_General_Information.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>

                        </div>

                    </div>
                </form>
                <div id="statistics" class="form-container" style="display: none;">
                    <h2>Program Statistics</h2>
                    <p>Content for Program Statistics...</p>
                </div>
                <div id="assessment" class="form-container" style="display: none;">
                    <h2>Program Assessment</h2>
                    <p>Content for Program Assessment...</p>
                </div>
                <div id="kpis" class="form-container" style="display: none;">
                    <h2>Key Performance Indicators</h2>
                    <p>Content for KPIs...</p>
                </div>
                <div id="challenges" class="form-container" style="display: none;">
                    <h2>Challenges and Difficulties</h2>
                    <p>Content for Challenges...</p>
                </div>
                <div id="development" class="form-container" style="display: none;">
                    <h2>Program Development Plan</h2>
                    <p>Content for Program Development Plan...</p>
                </div>
                <div id="approval" class="form-container" style="display: none;">
                    <h2>Approval of Annual Program Report</h2>
                    <p>Content for Approval...</p>
                </div>
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