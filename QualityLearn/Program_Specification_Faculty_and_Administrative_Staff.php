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
    <title><?= $translations['Program Specification-Faculty and Administrative Staff'] ?></title>
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

        table {
            width: 40%;
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

            // حفظ البيانات في الجلسة بعد إرسال النموذج
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                // استرجاع المدخلات من النموذج
                $data = [
                    'prof_specialty_general' => $_POST['prof_specialty_general'],
                    'prof_specialty_specific' => $_POST['prof_specialty_specific'],
                    'prof_special_requirements' => $_POST['prof_special_requirements'],
                    'prof_male' => $_POST['prof_male'],
                    'prof_female' => $_POST['prof_female'],
                    'prof_total' => $_POST['prof_total'],
                    'assoc_prof_specialty_general' => $_POST['assoc_prof_specialty_general'],
                    'assoc_prof_specialty_specific' => $_POST['assoc_prof_specialty_specific'],
                    'assoc_prof_special_requirements' => $_POST['assoc_prof_special_requirements'],
                    'assoc_prof_male' => $_POST['assoc_prof_male'],
                    'assoc_prof_female' => $_POST['assoc_prof_female'],
                    'assoc_prof_total' => $_POST['assoc_prof_total'],
                    'assist_prof_specialty_general' => $_POST['assist_prof_specialty_general'],
                    'assist_prof_specialty_specific' => $_POST['assist_prof_specialty_specific'],
                    'assist_prof_special_requirements' => $_POST['assist_prof_special_requirements'],
                    'assist_prof_male' => $_POST['assist_prof_male'],
                    'assist_prof_female' => $_POST['assist_prof_female'],
                    'assist_prof_total' => $_POST['assist_prof_total'],
                    'lecturer_specialty_general' => $_POST['lecturer_specialty_general'],
                    'lecturer_specialty_specific' => $_POST['lecturer_specialty_specific'],
                    'lecturer_special_requirements' => $_POST['lecturer_special_requirements'],
                    'lecturer_male' => $_POST['lecturer_male'],
                    'lecturer_female' => $_POST['lecturer_female'],
                    'lecturer_total' => $_POST['lecturer_total'],
                    'teach_assist_specialty_general' => $_POST['teach_assist_specialty_general'],
                    'teach_assist_specialty_specific' => $_POST['teach_assist_specialty_specific'],
                    'teach_assist_special_requirements' => $_POST['teach_assist_special_requirements'],
                    'teach_assist_male' => $_POST['teach_assist_male'],
                    'teach_assist_female' => $_POST['teach_assist_female'],
                    'teach_assist_total' => $_POST['teach_assist_total'],
                    'tech_lab_assist_specialty_general' => $_POST['tech_lab_assist_specialty_general'],
                    'tech_lab_assist_specialty_specific' => $_POST['tech_lab_assist_specialty_specific'],
                    'tech_lab_assist_special_requirements' => $_POST['tech_lab_assist_special_requirements'],
                    'tech_lab_assist_male' => $_POST['tech_lab_assist_male'],
                    'tech_lab_assist_female' => $_POST['tech_lab_assist_female'],
                    'tech_lab_assist_total' => $_POST['tech_lab_assist_total'],
                    'admin_support_specialty_general' => $_POST['admin_support_specialty_general'],
                    'admin_support_specialty_specific' => $_POST['admin_support_specialty_specific'],
                    'admin_support_special_requirements' => $_POST['admin_support_special_requirements'],
                    'admin_support_male' => $_POST['admin_support_male'],
                    'admin_support_female' => $_POST['admin_support_female'],
                    'admin_support_total' => $_POST['admin_support_total'],
                    'others_specialty_general' => $_POST['others_specialty_general'],
                    'others_specialty_specific' => $_POST['others_specialty_specific'],
                    'others_special_requirements' => $_POST['others_special_requirements'],
                    'others_male' => $_POST['others_male'],
                    'others_female' => $_POST['others_female'],
                    'others_total' => $_POST['others_total']
                ];

                // التحقق من وجود أي حقل فارغ
                foreach ($data as $key => $value) {
                    if (empty($value)) {
                        $_SESSION['message'] = 'Please fill in all fields.';
                        header("location: Program_Specification_Faculty_and_Administrative_Staff.php?new=" . $program_name);
                        exit;
                    }
                }

                // تخزين البيانات في الجلسة
                $_SESSION['administrative_new'] = $data;

                // تحويل البيانات إلى JSON
                $data_json = json_encode($data);

                // التحقق من الاتصال
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // استعلام لإدخال البيانات
                $stmt = $conn->prepare("INSERT INTO faculty_and_administrative_staff (user_id, data, program_id) VALUES (?, ?, ?)");
                $stmt->bind_param("isi", $user_id, $data_json, $program_id); // ربط المعلمات (user_id, data, program_id)

                // تنفيذ الاستعلام
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Records created successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while inserting data.';
                }

                header("location: Program_Specification_Faculty_and_Administrative_Staff.php?new=" . $program_name);
                exit;
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
                    <form method="post" id="coursesForm">

                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <div id="programs" class="form-container">
                            <h2><?= $translations['Faculty and Administrative Staff'] ?></h2>
                            <h3><?= $translations['Needed Teaching and Administrative Staff'] ?></h3>
                            <table border="1" style="border-collapse: collapse; width: 100%; text-align: center;">
                                <thead>
                                    <tr>
                                        <th rowspan="2"><?= $translations['Academic Rank'] ?></th>
                                        <th colspan="2"><?= $translations['Specialty'] ?></th>
                                        <th rowspan="2"><?= $translations['Special Requirements / Skills (if any)'] ?></th>
                                        <th colspan="3"><?= $translations['Required Numbers'] ?></th>
                                    </tr>
                                    <tr>
                                        <th><?= $translations['General'] ?></th>
                                        <th><?= $translations['Specific'] ?></th>
                                        <th><?= $translations['Male'] ?></th>
                                        <th><?= $translations['Female'] ?></th>
                                        <th><?= $translations['Total'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $translations['Professors'] ?></td>
                                        <td><input type="text" name="prof_specialty_general" value="<?= isset($_SESSION['administrative_new']['prof_specialty_general']) ? $_SESSION['administrative_new']['prof_specialty_general'] : '' ?>"></td>
                                        <td><input type="text" name="prof_specialty_specific" value="<?= isset($_SESSION['administrative_new']['prof_specialty_specific']) ? $_SESSION['administrative_new']['prof_specialty_specific'] : '' ?>"></td>
                                        <td><input type="text" name="prof_special_requirements" value="<?= isset($_SESSION['administrative_new']['prof_special_requirements']) ? $_SESSION['administrative_new']['prof_special_requirements'] : '' ?>"></td>
                                        <td><input type="number" name="prof_male" value="<?= isset($_SESSION['administrative_new']['prof_male']) ? $_SESSION['administrative_new']['prof_male'] : '' ?>"></td>
                                        <td><input type="number" name="prof_female" value="<?= isset($_SESSION['administrative_new']['prof_female']) ? $_SESSION['administrative_new']['prof_female'] : '' ?>"></td>
                                        <td><input type="number" name="prof_total" value="<?= isset($_SESSION['administrative_new']['prof_total']) ? $_SESSION['administrative_new']['prof_total'] : '' ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Associate Professors'] ?></td>
                                        <td><input type="text" name="assoc_prof_specialty_general" value="<?= isset($_SESSION['administrative_new']['assoc_prof_specialty_general']) ? $_SESSION['administrative_new']['assoc_prof_specialty_general'] : '' ?>"></td>
                                        <td><input type="text" name="assoc_prof_specialty_specific" value="<?= isset($_SESSION['administrative_new']['assoc_prof_specialty_specific']) ? $_SESSION['administrative_new']['assoc_prof_specialty_specific'] : '' ?>"></td>
                                        <td><input type="text" name="assoc_prof_special_requirements" value="<?= isset($_SESSION['administrative_new']['assoc_prof_special_requirements']) ? $_SESSION['administrative_new']['assoc_prof_special_requirements'] : '' ?>"></td>
                                        <td><input type="number" name="assoc_prof_male" value="<?= isset($_SESSION['administrative_new']['assoc_prof_male']) ? $_SESSION['administrative_new']['assoc_prof_male'] : '' ?>"></td>
                                        <td><input type="number" name="assoc_prof_female" value="<?= isset($_SESSION['administrative_new']['assoc_prof_female']) ? $_SESSION['administrative_new']['assoc_prof_female'] : '' ?>"></td>
                                        <td><input type="number" name="assoc_prof_total" value="<?= isset($_SESSION['administrative_new']['assoc_prof_total']) ? $_SESSION['administrative_new']['assoc_prof_total'] : '' ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Assistant Professors'] ?></td>
                                        <td><input type="text" name="assist_prof_specialty_general" value="<?= isset($_SESSION['administrative_new']['assist_prof_specialty_general']) ? $_SESSION['administrative_new']['assist_prof_specialty_general'] : '' ?>"></td>
                                        <td><input type="text" name="assist_prof_specialty_specific" value="<?= isset($_SESSION['administrative_new']['assist_prof_specialty_specific']) ? $_SESSION['administrative_new']['assist_prof_specialty_specific'] : '' ?>"></td>
                                        <td><input type="text" name="assist_prof_special_requirements" value="<?= isset($_SESSION['administrative_new']['assist_prof_special_requirements']) ? $_SESSION['administrative_new']['assist_prof_special_requirements'] : '' ?>"></td>
                                        <td><input type="number" name="assist_prof_male" value="<?= isset($_SESSION['administrative_new']['assist_prof_male']) ? $_SESSION['administrative_new']['assist_prof_male'] : '' ?>"></td>
                                        <td><input type="number" name="assist_prof_female" value="<?= isset($_SESSION['administrative_new']['assist_prof_female']) ? $_SESSION['administrative_new']['assist_prof_female'] : '' ?>"></td>
                                        <td><input type="number" name="assist_prof_total" value="<?= isset($_SESSION['administrative_new']['assist_prof_total']) ? $_SESSION['administrative_new']['assist_prof_total'] : '' ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Lecturers'] ?></td>
                                        <td><input type="text" name="lecturer_specialty_general" value="<?= isset($_SESSION['administrative_new']['lecturer_specialty_general']) ? $_SESSION['administrative_new']['lecturer_specialty_general'] : '' ?>"></td>
                                        <td><input type="text" name="lecturer_specialty_specific" value="<?= isset($_SESSION['administrative_new']['lecturer_specialty_specific']) ? $_SESSION['administrative_new']['lecturer_specialty_specific'] : '' ?>"></td>
                                        <td><input type="text" name="lecturer_special_requirements" value="<?= isset($_SESSION['administrative_new']['lecturer_special_requirements']) ? $_SESSION['administrative_new']['lecturer_special_requirements'] : '' ?>"></td>
                                        <td><input type="number" name="lecturer_male" value="<?= isset($_SESSION['administrative_new']['lecturer_male']) ? $_SESSION['administrative_new']['lecturer_male'] : '' ?>"></td>
                                        <td><input type="number" name="lecturer_female" value="<?= isset($_SESSION['administrative_new']['lecturer_female']) ? $_SESSION['administrative_new']['lecturer_female'] : '' ?>"></td>
                                        <td><input type="number" name="lecturer_total" value="<?= isset($_SESSION['administrative_new']['lecturer_total']) ? $_SESSION['administrative_new']['lecturer_total'] : '' ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Teaching Assistants'] ?></td>
                                        <td><input type="text" name="teach_assist_specialty_general" value="<?= isset($_SESSION['administrative_new']['teach_assist_specialty_general']) ? $_SESSION['administrative_new']['teach_assist_specialty_general'] : '' ?>"></td>
                                        <td><input type="text" name="teach_assist_specialty_specific" value="<?= isset($_SESSION['administrative_new']['teach_assist_specialty_specific']) ? $_SESSION['administrative_new']['teach_assist_specialty_specific'] : '' ?>"></td>
                                        <td><input type="text" name="teach_assist_special_requirements" value="<?= isset($_SESSION['administrative_new']['teach_assist_special_requirements']) ? $_SESSION['administrative_new']['teach_assist_special_requirements'] : '' ?>"></td>
                                        <td><input type="number" name="teach_assist_male" value="<?= isset($_SESSION['administrative_new']['teach_assist_male']) ? $_SESSION['administrative_new']['teach_assist_male'] : '' ?>"></td>
                                        <td><input type="number" name="teach_assist_female" value="<?= isset($_SESSION['administrative_new']['teach_assist_female']) ? $_SESSION['administrative_new']['teach_assist_female'] : '' ?>"></td>
                                        <td><input type="number" name="teach_assist_total" value="<?= isset($_SESSION['administrative_new']['teach_assist_total']) ? $_SESSION['administrative_new']['teach_assist_total'] : '' ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Technical Lab Assistants'] ?></td>
                                        <td><input type="text" name="tech_lab_assist_specialty_general" value="<?= isset($_SESSION['administrative_new']['tech_lab_assist_specialty_general']) ? $_SESSION['administrative_new']['tech_lab_assist_specialty_general'] : '' ?>"></td>
                                        <td><input type="text" name="tech_lab_assist_specialty_specific" value="<?= isset($_SESSION['administrative_new']['tech_lab_assist_specialty_specific']) ? $_SESSION['administrative_new']['tech_lab_assist_specialty_specific'] : '' ?>"></td>
                                        <td><input type="text" name="tech_lab_assist_special_requirements" value="<?= isset($_SESSION['administrative_new']['tech_lab_assist_special_requirements']) ? $_SESSION['administrative_new']['tech_lab_assist_special_requirements'] : '' ?>"></td>
                                        <td><input type="number" name="tech_lab_assist_male" value="<?= isset($_SESSION['administrative_new']['tech_lab_assist_male']) ? $_SESSION['administrative_new']['tech_lab_assist_male'] : '' ?>"></td>
                                        <td><input type="number" name="tech_lab_assist_female" value="<?= isset($_SESSION['administrative_new']['tech_lab_assist_female']) ? $_SESSION['administrative_new']['tech_lab_assist_female'] : '' ?>"></td>
                                        <td><input type="number" name="tech_lab_assist_total" value="<?= isset($_SESSION['administrative_new']['tech_lab_assist_total']) ? $_SESSION['administrative_new']['tech_lab_assist_total'] : '' ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Administrative Support'] ?></td>
                                        <td><input type="text" name="admin_support_specialty_general" value="<?= isset($_SESSION['administrative_new']['admin_support_specialty_general']) ? $_SESSION['administrative_new']['admin_support_specialty_general'] : '' ?>"></td>
                                        <td><input type="text" name="admin_support_specialty_specific" value="<?= isset($_SESSION['administrative_new']['admin_support_specialty_specific']) ? $_SESSION['administrative_new']['admin_support_specialty_specific'] : '' ?>"></td>
                                        <td><input type="text" name="admin_support_special_requirements" value="<?= isset($_SESSION['administrative_new']['admin_support_special_requirements']) ? $_SESSION['administrative_new']['admin_support_special_requirements'] : '' ?>"></td>
                                        <td><input type="number" name="admin_support_male" value="<?= isset($_SESSION['administrative_new']['admin_support_male']) ? $_SESSION['administrative_new']['admin_support_male'] : '' ?>"></td>
                                        <td><input type="number" name="admin_support_female" value="<?= isset($_SESSION['administrative_new']['admin_support_female']) ? $_SESSION['administrative_new']['admin_support_female'] : '' ?>"></td>
                                        <td><input type="number" name="admin_support_total" value="<?= isset($_SESSION['administrative_new']['admin_support_total']) ? $_SESSION['administrative_new']['admin_support_total'] : '' ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?= $translations['Others'] ?></td>
                                        <td><input type="text" name="others_specialty_general" value="<?= isset($_SESSION['administrative_new']['others_specialty_general']) ? $_SESSION['administrative_new']['others_specialty_general'] : '' ?>"></td>
                                        <td><input type="text" name="others_specialty_specific" value="<?= isset($_SESSION['administrative_new']['others_specialty_specific']) ? $_SESSION['administrative_new']['others_specialty_specific'] : '' ?>"></td>
                                        <td><input type="text" name="others_special_requirements" value="<?= isset($_SESSION['administrative_new']['others_special_requirements']) ? $_SESSION['administrative_new']['others_special_requirements'] : '' ?>"></td>
                                        <td><input type="number" name="others_male" value="<?= isset($_SESSION['administrative_new']['others_male']) ? $_SESSION['administrative_new']['others_male'] : '' ?>"></td>
                                        <td><input type="number" name="others_female" value="<?= isset($_SESSION['administrative_new']['others_female']) ? $_SESSION['administrative_new']['others_female'] : '' ?>"></td>
                                        <td><input type="number" name="others_total" value="<?= isset($_SESSION['administrative_new']['others_total']) ? $_SESSION['administrative_new']['others_total'] : '' ?>"></td>
                                    </tr>

                                </tbody>
                            </table>


                            <div class="navigation-buttons">
                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Learning_Resources_Facilities_and_Equipment.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Student_Admission_and_Support.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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


    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق إذا كان المستخدم قد اختار أي عنصر للتعديل
        if (isset($_POST['edit_item'])) {
            $_SESSION['edit_item'] = $_POST['edit_item'];  // تخزين ID العنصر المختار في الجلسة
        }

        $edit_item = $_SESSION['edit_item'] ?? '';  // استخدام ID العنصر المخزن في الجلسة

        // التحقق من أن العنصر المختار موجود في قاعدة البيانات
        if ($edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM faculty_and_administrative_staff WHERE id = '$edit_item' AND program_id = '$program_id'");
            $row = mysqli_fetch_assoc($query);
            if ($row) {
                // تخزين البيانات في الجلسة لاستخدامها في الحقول
                $_SESSION['administrative_edit'] = json_decode($row['data'], true);
                $_SESSION['administrative_edit']['id'] = $row['id'];  // إضافة الـ ID إلى الـ SESSION
            }
        }

        // التحقق من وجود بيانات في الـ SESSION وتخزينها فيها عند التعديل
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $edit_item = $_POST['id']; // معرف العنصر المراد تعديله

            // استرجاع المدخلات من النموذج
            $data = [
                'id' => $edit_item, // إضافة الـ ID إلى البيانات
                'prof_specialty_general' => $_POST['prof_specialty_general'],
                'prof_specialty_specific' => $_POST['prof_specialty_specific'],
                'prof_special_requirements' => $_POST['prof_special_requirements'],
                'prof_male' => $_POST['prof_male'],
                'prof_female' => $_POST['prof_female'],
                'prof_total' => $_POST['prof_total'],
                'assoc_prof_specialty_general' => $_POST['assoc_prof_specialty_general'],
                'assoc_prof_specialty_specific' => $_POST['assoc_prof_specialty_specific'],
                'assoc_prof_special_requirements' => $_POST['assoc_prof_special_requirements'],
                'assoc_prof_male' => $_POST['assoc_prof_male'],
                'assoc_prof_female' => $_POST['assoc_prof_female'],
                'assoc_prof_total' => $_POST['assoc_prof_total'],
                'assist_prof_specialty_general' => $_POST['assist_prof_specialty_general'],
                'assist_prof_specialty_specific' => $_POST['assist_prof_specialty_specific'],
                'assist_prof_special_requirements' => $_POST['assist_prof_special_requirements'],
                'assist_prof_male' => $_POST['assist_prof_male'],
                'assist_prof_female' => $_POST['assist_prof_female'],
                'assist_prof_total' => $_POST['assist_prof_total'],
                'lecturer_specialty_general' => $_POST['lecturer_specialty_general'],
                'lecturer_specialty_specific' => $_POST['lecturer_specialty_specific'],
                'lecturer_special_requirements' => $_POST['lecturer_special_requirements'],
                'lecturer_male' => $_POST['lecturer_male'],
                'lecturer_female' => $_POST['lecturer_female'],
                'lecturer_total' => $_POST['lecturer_total'],
                'teach_assist_specialty_general' => $_POST['teach_assist_specialty_general'],
                'teach_assist_specialty_specific' => $_POST['teach_assist_specialty_specific'],
                'teach_assist_special_requirements' => $_POST['teach_assist_special_requirements'],
                'teach_assist_male' => $_POST['teach_assist_male'],
                'teach_assist_female' => $_POST['teach_assist_female'],
                'teach_assist_total' => $_POST['teach_assist_total'],
                'tech_lab_assist_specialty_general' => $_POST['tech_lab_assist_specialty_general'],
                'tech_lab_assist_specialty_specific' => $_POST['tech_lab_assist_specialty_specific'],
                'tech_lab_assist_special_requirements' => $_POST['tech_lab_assist_special_requirements'],
                'tech_lab_assist_male' => $_POST['tech_lab_assist_male'],
                'tech_lab_assist_female' => $_POST['tech_lab_assist_female'],
                'tech_lab_assist_total' => $_POST['tech_lab_assist_total'],
                'admin_support_specialty_general' => $_POST['admin_support_specialty_general'],
                'admin_support_specialty_specific' => $_POST['admin_support_specialty_specific'],
                'admin_support_special_requirements' => $_POST['admin_support_special_requirements'],
                'admin_support_male' => $_POST['admin_support_male'],
                'admin_support_female' => $_POST['admin_support_female'],
                'admin_support_total' => $_POST['admin_support_total'],
                'others_specialty_general' => $_POST['others_specialty_general'],
                'others_specialty_specific' => $_POST['others_specialty_specific'],
                'others_special_requirements' => $_POST['others_special_requirements'],
                'others_male' => $_POST['others_male'],
                'others_female' => $_POST['others_female'],
                'others_total' => $_POST['others_total']
            ];

            // تخزين البيانات في الـ SESSION
            $_SESSION['administrative_edit'] = $data;

            // تحويل البيانات إلى JSON
            $data_json = json_encode($data);

            if ($edit_item) {
                // استعلام لتحديث البيانات
                $stmt = $conn->prepare("UPDATE faculty_and_administrative_staff SET data = ? WHERE id = ?");
                $stmt->bind_param("si", $data_json, $edit_item); // ربط المعلمات

                // تنفيذ الاستعلام
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Data Updated successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while saving data.';
                }
            }

            header("location: Program_Specification_Faculty_and_Administrative_Staff.php?edit=" . $program_name);
            exit;
        }

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
                    <h3><?= $translations['Program Specification'] ?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>

                <h3><?= $translations['Program Specification'] ?></h3>
                <form method="post" id="coursesForm">
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
                        $query = "SELECT * FROM faculty_and_administrative_staff WHERE program_id = '$program_id'";
                        $result = mysqli_query($conn, $query);
                        while ($row_edit = mysqli_fetch_assoc($result)) {

                            // تحويل البيانات من JSON إلى مصفوفة لعرض البيانات
                            $data = json_decode($row_edit['data'], true);

                            // التحقق من وجود ProgramMission في البيانات
                            $prof = $data['prof_specialty_general'] ?? 'N/A';  // Default إذا لم توجد القيمة


                            $selected = (isset($_SESSION['edit_item']) && $_SESSION['edit_item'] == $row_edit['id']) ? 'selected' : ''; // تحديد العنصر المحدد
                            echo "<option value='{$row_edit['id']}' $selected>{$prof}</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">
                    <div id="programs" class="form-container">
                        <h2><?= $translations['Faculty and Administrative Staff'] ?></h2>
                        <h3><?= $translations['Needed Teaching and Administrative Staff'] ?></h3>
                        <table border="1" style="border-collapse: collapse; width: 100%; text-align: center;">
                            <thead>
                                <tr>
                                    <th rowspan="2"><?= $translations['Academic Rank'] ?></th>
                                    <th colspan="2"><?= $translations['Specialty'] ?></th>
                                    <th rowspan="2"><?= $translations['Special Requirements / Skills (if any)'] ?></th>
                                    <th colspan="3"><?= $translations['Required Numbers'] ?></th>
                                </tr>
                                <tr>
                                    <th><?= $translations['General'] ?></th>
                                    <th><?= $translations['Specific'] ?></th>
                                    <th><?= $translations['Male'] ?></th>
                                    <th><?= $translations['Female'] ?></th>
                                    <th><?= $translations['Total'] ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td><strong><?= $translations['Professors'] ?></strong></td>
                                    <td><input type="text" name="prof_specialty_general" value="<?= $_SESSION['administrative_edit']['prof_specialty_general'] ?? '' ?>"></td>
                                    <td><input type="text" name="prof_specialty_specific" value="<?= $_SESSION['administrative_edit']['prof_specialty_specific'] ?? '' ?>"></td>
                                    <td><input type="text" name="prof_special_requirements" value="<?= $_SESSION['administrative_edit']['prof_special_requirements'] ?? '' ?>"></td>
                                    <td><input type="number" name="prof_male" value="<?= $_SESSION['administrative_edit']['prof_male'] ?? '' ?>"></td>
                                    <td><input type="number" name="prof_female" value="<?= $_SESSION['administrative_edit']['prof_female'] ?? '' ?>"></td>
                                    <td><input type="number" name="prof_total" value="<?= $_SESSION['administrative_edit']['prof_total'] ?? '' ?>"></td>
                                </tr>

                                <!-- Associate Professors Row -->
                                <tr>
                                    <td><strong><?= $translations['Associate Professors'] ?></strong></td>
                                    <td><input type="text" name="assoc_prof_specialty_general" value="<?= $_SESSION['administrative_edit']['assoc_prof_specialty_general'] ?? '' ?>"></td>
                                    <td><input type="text" name="assoc_prof_specialty_specific" value="<?= $_SESSION['administrative_edit']['assoc_prof_specialty_specific'] ?? '' ?>"></td>
                                    <td><input type="text" name="assoc_prof_special_requirements" value="<?= $_SESSION['administrative_edit']['assoc_prof_special_requirements'] ?? '' ?>"></td>
                                    <td><input type="number" name="assoc_prof_male" value="<?= $_SESSION['administrative_edit']['assoc_prof_male'] ?? '' ?>"></td>
                                    <td><input type="number" name="assoc_prof_female" value="<?= $_SESSION['administrative_edit']['assoc_prof_female'] ?? '' ?>"></td>
                                    <td><input type="number" name="assoc_prof_total" value="<?= $_SESSION['administrative_edit']['assoc_prof_total'] ?? '' ?>"></td>
                                </tr>

                                <!-- Assistant Professors Row -->
                                <tr>
                                    <td><strong><?= $translations['Assistant Professors'] ?></strong></td>
                                    <td><input type="text" name="assist_prof_specialty_general" value="<?= $_SESSION['administrative_edit']['assist_prof_specialty_general'] ?? '' ?>"></td>
                                    <td><input type="text" name="assist_prof_specialty_specific" value="<?= $_SESSION['administrative_edit']['assist_prof_specialty_specific'] ?? '' ?>"></td>
                                    <td><input type="text" name="assist_prof_special_requirements" value="<?= $_SESSION['administrative_edit']['assist_prof_special_requirements'] ?? '' ?>"></td>
                                    <td><input type="number" name="assist_prof_male" value="<?= $_SESSION['administrative_edit']['assist_prof_male'] ?? '' ?>"></td>
                                    <td><input type="number" name="assist_prof_female" value="<?= $_SESSION['administrative_edit']['assist_prof_female'] ?? '' ?>"></td>
                                    <td><input type="number" name="assist_prof_total" value="<?= $_SESSION['administrative_edit']['assist_prof_total'] ?? '' ?>"></td>
                                </tr>

                                <!-- Lecturers Row -->
                                <tr>
                                    <td><strong><?= $translations['Lecturers'] ?></strong></td>
                                    <td><input type="text" name="lecturer_specialty_general" value="<?= $_SESSION['administrative_edit']['lecturer_specialty_general'] ?? '' ?>"></td>
                                    <td><input type="text" name="lecturer_specialty_specific" value="<?= $_SESSION['administrative_edit']['lecturer_specialty_specific'] ?? '' ?>"></td>
                                    <td><input type="text" name="lecturer_special_requirements" value="<?= $_SESSION['administrative_edit']['lecturer_special_requirements'] ?? '' ?>"></td>
                                    <td><input type="number" name="lecturer_male" value="<?= $_SESSION['administrative_edit']['lecturer_male'] ?? '' ?>"></td>
                                    <td><input type="number" name="lecturer_female" value="<?= $_SESSION['administrative_edit']['lecturer_female'] ?? '' ?>"></td>
                                    <td><input type="number" name="lecturer_total" value="<?= $_SESSION['administrative_edit']['lecturer_total'] ?? '' ?>"></td>
                                </tr>

                                <!-- Teaching Assistants Row -->
                                <tr>
                                    <td><strong><?= $translations['Teaching Assistants'] ?></strong></td>
                                    <td><input type="text" name="teach_assist_specialty_general" value="<?= $_SESSION['administrative_edit']['teach_assist_specialty_general'] ?? '' ?>"></td>
                                    <td><input type="text" name="teach_assist_specialty_specific" value="<?= $_SESSION['administrative_edit']['teach_assist_specialty_specific'] ?? '' ?>"></td>
                                    <td><input type="text" name="teach_assist_special_requirements" value="<?= $_SESSION['administrative_edit']['teach_assist_special_requirements'] ?? '' ?>"></td>
                                    <td><input type="number" name="teach_assist_male" value="<?= $_SESSION['administrative_edit']['teach_assist_male'] ?? '' ?>"></td>
                                    <td><input type="number" name="teach_assist_female" value="<?= $_SESSION['administrative_edit']['teach_assist_female'] ?? '' ?>"></td>
                                    <td><input type="number" name="teach_assist_total" value="<?= $_SESSION['administrative_edit']['teach_assist_total'] ?? '' ?>"></td>
                                </tr>

                                <!-- Technical Lab Assistants Row -->
                                <tr>
                                    <td><strong><?= $translations['Technical Lab Assistants'] ?></strong></td>
                                    <td><input type="text" name="tech_lab_assist_specialty_general" value="<?= $_SESSION['administrative_edit']['tech_lab_assist_specialty_general'] ?? '' ?>"></td>
                                    <td><input type="text" name="tech_lab_assist_specialty_specific" value="<?= $_SESSION['administrative_edit']['tech_lab_assist_specialty_specific'] ?? '' ?>"></td>
                                    <td><input type="text" name="tech_lab_assist_special_requirements" value="<?= $_SESSION['administrative_edit']['tech_lab_assist_special_requirements'] ?? '' ?>"></td>
                                    <td><input type="number" name="tech_lab_assist_male" value="<?= $_SESSION['administrative_edit']['tech_lab_assist_male'] ?? '' ?>"></td>
                                    <td><input type="number" name="tech_lab_assist_female" value="<?= $_SESSION['administrative_edit']['tech_lab_assist_female'] ?? '' ?>"></td>
                                    <td><input type="number" name="tech_lab_assist_total" value="<?= $_SESSION['administrative_edit']['tech_lab_assist_total'] ?? '' ?>"></td>
                                </tr>

                                <!-- Administrative Support Row -->
                                <tr>
                                    <td><strong><?= $translations['Administrative Support'] ?></strong></td>
                                    <td><input type="text" name="admin_support_specialty_general" value="<?= $_SESSION['administrative_edit']['admin_support_specialty_general'] ?? '' ?>"></td>
                                    <td><input type="text" name="admin_support_specialty_specific" value="<?= $_SESSION['administrative_edit']['admin_support_specialty_specific'] ?? '' ?>"></td>
                                    <td><input type="text" name="admin_support_special_requirements" value="<?= $_SESSION['administrative_edit']['admin_support_special_requirements'] ?? '' ?>"></td>
                                    <td><input type="number" name="admin_support_male" value="<?= $_SESSION['administrative_edit']['admin_support_male'] ?? '' ?>"></td>
                                    <td><input type="number" name="admin_support_female" value="<?= $_SESSION['administrative_edit']['admin_support_female'] ?? '' ?>"></td>
                                    <td><input type="number" name="admin_support_total" value="<?= $_SESSION['administrative_edit']['admin_support_total'] ?? '' ?>"></td>
                                </tr>

                                <!-- Others Row -->
                                <tr>
                                    <td><strong><?= $translations['Others'] ?></strong></td>
                                    <td><input type="text" name="others_specialty_general" value="<?= $_SESSION['administrative_edit']['others_specialty_general'] ?? '' ?>"></td>
                                    <td><input type="text" name="others_specialty_specific" value="<?= $_SESSION['administrative_edit']['others_specialty_specific'] ?? '' ?>"></td>
                                    <td><input type="text" name="others_special_requirements" value="<?= $_SESSION['administrative_edit']['others_special_requirements'] ?? '' ?>"></td>
                                    <td><input type="number" name="others_male" value="<?= $_SESSION['administrative_edit']['others_male'] ?? '' ?>"></td>
                                    <td><input type="number" name="others_female" value="<?= $_SESSION['administrative_edit']['others_female'] ?? '' ?>"></td>
                                    <td><input type="number" name="others_total" value="<?= $_SESSION['administrative_edit']['others_total'] ?? '' ?>"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="navigation-buttons">
                            <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Learning_Resources_Facilities_and_Equipment.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Student_Admission_and_Support.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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