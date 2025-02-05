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
            height: 120vh;
        }

        img {
            width: 200px;
            margin-bottom: 20px;
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

        table {
            width: 90%;
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

        input {
            width: 100%;
            border: none;
            outline: none;
            padding: 5px;
            font-size: 14px;
            box-sizing: border-box;
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



        .add_section {
            background-color: rgba(6, 61, 132, 0.871);
            font-size: 1.2rem;
            padding: 8px;
            margin: 0 10px;
            border-radius: 9px;
            color: white;
            cursor: pointer;
        }

        .remove_section {
            background-color: rgba(6, 61, 132, 0.871);
            font-size: 1.2rem;
            padding: 8px;
            margin: 0px 10px;
            border-radius: 9px;
            color: white;
            cursor: pointer;
            float: right;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $translations['Program Specification-Program Quality Assurance'] ?></title>
    <!-- <link rel="stylesheet" href="css program Specification-Program/style.css"> -->
</head>

<body>

    <?php

    if (isset($_GET['new'])) {
        if ($_GET['new'] == 'IS' || $_GET['new'] == 'CS') {
            $program_name = $_GET['new'];

            $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
            $row = mysqli_fetch_assoc($id_query);
            $program_id = $row["id"];

            // التحقق من إرسال البيانات
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
                // جمع بيانات الـ KPI وتصفية الصفوف الفارغة
                $kpis = [];
                $kpi_count = count($_POST) / 6; // عدد الـ KPIs في النموذج
                for ($i = 1; $i <= $kpi_count; $i++) {
                    $kpi_code = $_POST["kpi_code_$i"] ?? '';
                    $kpi = $_POST["kpi_$i"] ?? '';
                    $target_level = $_POST["target_level_$i"] ?? '';
                    $measurement_methods = $_POST["measurement_methods_$i"] ?? '';
                    $measurement_time = $_POST["measurement_time_$i"] ?? '';

                    // إضافة الـ KPI فقط إذا كانت جميع الحقول مليئة
                    if (!empty($kpi_code) && !empty($kpi) && !empty($target_level) && !empty($measurement_methods) && !empty($measurement_time)) {
                        $kpis[] = [
                            'kpi_code' => $kpi_code,
                            'kpi' => $kpi,
                            'target_level' => $target_level,
                            'measurement_methods' => $measurement_methods,
                            'measurement_time' => $measurement_time
                        ];
                    }
                }

                // جمع بيانات التقييم
                $evaluation = [];
                for ($i = 1; $i <= 4; $i++) { // نعتبر أن لدينا 4 مدخلات للتقييم
                    $evaluation_area = $_POST["evaluation_area_$i"] ?? '';
                    $evaluation_sources = $_POST["evaluation_sources_$i"] ?? '';
                    $evaluation_methods = $_POST["evaluation_methods_$i"] ?? '';
                    $evaluation_time = $_POST["evaluation_time_$i"] ?? '';

                    // إضافة التقييم فقط إذا كانت جميع الحقول مليئة
                    if (!empty($evaluation_area) && !empty($evaluation_sources) && !empty($evaluation_methods) && !empty($evaluation_time)) {
                        $evaluation[] = [
                            'evaluation_area' => $evaluation_area,
                            'evaluation_sources' => $evaluation_sources,
                            'evaluation_methods' => $evaluation_methods,
                            'evaluation_time' => $evaluation_time
                        ];
                    }
                }

                // إعداد البيانات لتخزينها في الـ JSON
                $formData = json_encode([
                    'kpis' => $kpis,
                    'evaluation' => $evaluation
                ]);

                // تخزين البيانات في الـ SESSION
                $_SESSION['assurance_new'] = [
                    'kpis' => $kpis,
                    'evaluation' => $evaluation
                ];

                // إدخال البيانات في قاعدة البيانات
                if (!empty($formData)) {
                    $stmt = $conn->prepare("INSERT INTO program_quality_assurance (user_id, data, program_id) VALUES (?, ?, ?)");
                    $stmt->bind_param("isi", $user_id, $formData, $program_id);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }
                header("location: Program_Specification_Program_Quality_Assurance.php?new=" . $program_name);
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
                        <img src="images/ql-removebg-preview (1).png" alt="logo">
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
                            <h2><?= $translations['Program Quality Assurance'] ?></h2>
                            <h3><?= $translations['Program KPIs'] ?>*</h3>
                            <table class="kpi-table">
                                <thead>
                                    <tr>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['KPIs Code'] ?></th>
                                        <th><?= $translations['KPIs'] ?></th>
                                        <th><?= $translations['Targeted Level'] ?></th>
                                        <th><?= $translations['Measurement Methods'] ?></th>
                                        <th><?= $translations['Measurement Time'] ?></th>
                                        <th><?= $translations['Actions'] ?></th>
                                    </tr>
                                </thead>
                                <tbody class="kpi-table-body">
                                    <?php
                                    if (isset($_SESSION['assurance_new']['kpis'])) {
                                        $kpis = $_SESSION['assurance_new']['kpis'];
                                        $count = 1;
                                        foreach ($kpis as $kpi) {
                                            echo "
                                <tr>
                                    <td>{$count}</td>
                                    <td><input type='text' name='kpi_code_{$count}' value='{$kpi['kpi_code']}' required></td>
                                    <td><input type='text' name='kpi_{$count}' value='{$kpi['kpi']}' required></td>
                                    <td><input type='text' name='target_level_{$count}' value='{$kpi['target_level']}' required></td>
                                    <td><input type='text' name='measurement_methods_{$count}' value='{$kpi['measurement_methods']}' required></td>
                                    <td><input type='text' name='measurement_time_{$count}' value='{$kpi['measurement_time']}' required></td>
                                    <td><button class='but remove_section'>Delete Section</button></td>
                                </tr>";
                                            $count++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="button_controll">
                                <button type="button" class="but add_section"><?= $translations['Add Row'] ?></button>
                            </div>

                            <h3><?= $translations['Program Evaluation Matrix'] ?></h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['Evaluation Areas/Aspects'] ?></th>
                                        <th><?= $translations['Evaluation Sources/References'] ?></th>
                                        <th><?= $translations['Evaluation Methods'] ?></th>
                                        <th><?= $translations['Evaluation Time'] ?></th>
                                    </tr>
                                </thead>
                                <tbody class="evaluation-table-body">
                                    <?php
                                    if (isset($_SESSION['assurance_new']['evaluation'])) {
                                        $evaluation = $_SESSION['assurance_new']['evaluation'];
                                        $count_eval = 1;
                                        foreach ($evaluation as $eval) {
                                            echo "
                                <tr>
                                    <td><input type='text' name='evaluation_area_{$count_eval}' value='{$eval['evaluation_area']}' required></td>
                                    <td><input type='text' name='evaluation_sources_{$count_eval}' value='{$eval['evaluation_sources']}' required></td>
                                    <td><input type='text' name='evaluation_methods_{$count_eval}' value='{$eval['evaluation_methods']}' required></td>
                                    <td><input type='text' name='evaluation_time_{$count_eval}' value='{$eval['evaluation_time']}' required></td>
                                </tr>";
                                            $count_eval++;
                                        }
                                    } else {
                                        // هذا الجزء يضمن أن الجدول يظهر حتى بدون بيانات موجودة في الجلسة
                                        for ($i = 1; $i <= 4; $i++) {
                                            echo "
                                <tr>
                                    <td><input type='text' name='evaluation_area_{$i}' required></td>
                                    <td><input type='text' name='evaluation_sources_{$i}' required></td>
                                    <td><input type='text' name='evaluation_methods_{$i}' required></td>
                                    <td><input type='text' name='evaluation_time_{$i}' required></td>
                                </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <div class="navigation-buttons">
                                <button name="save" type="submit" class="nav-button"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Specification_Approval_Data.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Learning_Resources_Facilities_and_Equipment.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>
                        </div>
                    </form>

                    <script>
                        let table_container = document.querySelector(".kpi-table");
                        let body_table = document.querySelector(".kpi-table-body");
                        let add_section = document.querySelector(".add_section");

                        let count = <?php echo isset($_SESSION['assurance_new']['kpis']) ? count($_SESSION['assurance_new']['kpis']) : 0; ?>;

                        function addRow() {
                            let table_row = document.createElement("tr");
                            table_row.innerHTML = `
                    <td>${++count}</td>
                    <td><input type="text" name="kpi_code_${count}" required></td>
                    <td><input type="text" name="kpi_${count}" required></td>
                    <td><input type="text" name="target_level_${count}" required></td>
                    <td><input type="text" name="measurement_methods_${count}" required></td>
                    <td><input type="text" name="measurement_time_${count}" required></td>
                    <td><button class="but remove_section">Delete Section</button></td>
                `;

                            table_row.querySelector(".remove_section").addEventListener("click", () => {
                                table_row.remove();
                                updateCount();
                            });

                            body_table.appendChild(table_row);
                        }

                        function updateCount() {
                            count = body_table.children.length;
                            Array.from(body_table.children).forEach((row, index) => {
                                row.firstElementChild.textContent = index + 1;
                            });
                        }

                        add_section.addEventListener("click", addRow);
                    </script>

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
        $edit_item = $_POST['edit_item'] ?? ($_SESSION['edit_item'] ?? '');
        $kpis_data = [];
        $evaluation_data = [];

        // التحقق إذا تم تحديد ID للتعديل
        if ($edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM program_quality_assurance WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);
            if ($row) {
                $kpis_data = json_decode($row['data'], true);
            }

            // حفظ البيانات في $_SESSION
            $_SESSION['form_data'] = [
                'id' => $edit_item,
                'kpis' => $kpis_data['kpis'] ?? [],
                'evaluation' => $kpis_data['evaluation'] ?? []
            ];
        }

        // التحقق من إرسال البيانات عند الضغط على زر Save (Update)
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            // جمع بيانات الـ KPI وتصفية الصفوف الفارغة
            $kpis = [];
            $kpi_count = count($_POST) / 6; // عدد الـ KPIs في النموذج
            for ($i = 1; $i <= $kpi_count; $i++) {
                $kpi_code = $_POST["kpi_code_$i"] ?? '';
                $kpi = $_POST["kpi_$i"] ?? '';
                $target_level = $_POST["target_level_$i"] ?? '';
                $measurement_methods = $_POST["measurement_methods_$i"] ?? '';
                $measurement_time = $_POST["measurement_time_$i"] ?? '';

                // إضافة الـ KPI فقط إذا كانت جميع الحقول مليئة
                if (!empty($kpi_code) && !empty($kpi) && !empty($target_level) && !empty($measurement_methods) && !empty($measurement_time)) {
                    $kpis[] = [
                        'kpi_code' => $kpi_code,
                        'kpi' => $kpi,
                        'target_level' => $target_level,
                        'measurement_methods' => $measurement_methods,
                        'measurement_time' => $measurement_time
                    ];
                }
            }

            // جمع بيانات التقييم
            $evaluation = [];
            for ($i = 1; $i <= 4; $i++) { // نعتبر أن لدينا 4 مدخلات للتقييم
                $evaluation_area = $_POST["evaluation_area_$i"] ?? '';
                $evaluation_sources = $_POST["evaluation_sources_$i"] ?? '';
                $evaluation_methods = $_POST["evaluation_methods_$i"] ?? '';
                $evaluation_time = $_POST["evaluation_time_$i"] ?? '';

                // إضافة التقييم فقط إذا كانت جميع الحقول مليئة
                if (!empty($evaluation_area) && !empty($evaluation_sources) && !empty($evaluation_methods) && !empty($evaluation_time)) {
                    $evaluation[] = [
                        'evaluation_area' => $evaluation_area,
                        'evaluation_sources' => $evaluation_sources,
                        'evaluation_methods' => $evaluation_methods,
                        'evaluation_time' => $evaluation_time
                    ];
                }
            }

            // إعداد البيانات لتخزينها في الـ JSON
            $formData = json_encode([
                'kpis' => $kpis,
                'evaluation' => $evaluation
            ]);

            if (!empty($formData)) {
                // إجراء التحديث بدلاً من الإضافة (UPDATE)
                $stmt = $conn->prepare("UPDATE program_quality_assurance SET data = ?, program_id = ? WHERE id = ?");
                $stmt->bind_param("sii", $formData, $program_id, $edit_item);

                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Records updated successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }
            } else {
                $_SESSION['message'] = 'Please fill in all fields.';
            }
            header("Location: Program_Specification_Program_Quality_Assurance.php?edit=" . $program_name);
            exit;
        }

        // حفظ الـ ID في الجلسة بحيث يبقى في الـ select
        $_SESSION['edit_item'] = $edit_item;
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
                    <img src="images/ql-removebg-preview (1).png" alt="logo">
                    <h3><?= $translations['Program Specification'] ?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>

                <form id="coursesForm" method="post">
                    <?php if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    } ?>

                    <label><?= $translations['Select an item to edit'] ?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select'] ?></option>
                        <?php
                        // استعلام لجلب جميع الخيارات
                        $query = "SELECT * FROM program_quality_assurance WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            // فك تشفير الـ JSON الموجود في عمود data
                            $kpis_data = json_decode($row_edit['data'], true);

                            // التأكد من أن الـ kpis موجودة في الـ data
                            if (isset($kpis_data['kpis']) && !empty($kpis_data['kpis'])) {
                                // اختيار أول kpi_code فقط
                                $first_kpi = $kpis_data['kpis'][0]; // الحصول على أول عنصر
                                $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                // عرض أول kpi_code في الـ <option>
                                echo "<option value='{$row_edit['id']}' $selected>{$first_kpi['kpi_code']}</option>";
                            }
                        }
                        ?>
                    </select>



                    <button type="submit" class="button"><?= $translations['Edit'] ?></button>

                    <input type="text" name="id" value="<?= htmlspecialchars($_SESSION['edit_item'] ?? '') ?>" readonly>

                    <div id="programs" class="form-container">
                        <h2><?= $translations['Program Quality Assurance'] ?></h2>
                        <h3><?= $translations['Program KPIs'] ?>*</h3>
                        <table class="kpi-table">
                            <thead>
                                <tr>
                                    <th><?= $translations['No'] ?></th>
                                    <th><?= $translations['KPIs Code'] ?></th>
                                    <th><?= $translations['KPIs'] ?></th>
                                    <th><?= $translations['Targeted Level'] ?></th>
                                    <th><?= $translations['Measurement Methods'] ?></th>
                                    <th><?= $translations['Measurement Time'] ?></th>
                                    <th><?= $translations['Actions'] ?></th>
                                </tr>
                            </thead>
                            <tbody class="kpi-table-body">
                                <?php
                                if (!empty($_SESSION['form_data']['kpis'])) {
                                    foreach ($_SESSION['form_data']['kpis'] as $index => $kpi) {
                                        echo "<tr>
                                    <td class='number_column'>" . ($index + 1) . "</td>
                                    <td><input type='text' name='kpi_code_" . ($index + 1) . "' value='" . htmlspecialchars($kpi['kpi_code']) . "'></td>
                                    <td><input type='text' name='kpi_" . ($index + 1) . "' value='" . htmlspecialchars($kpi['kpi']) . "'></td>
                                    <td><input type='text' name='target_level_" . ($index + 1) . "' value='" . htmlspecialchars($kpi['target_level']) . "'></td>
                                    <td><input type='text' name='measurement_methods_" . ($index + 1) . "' value='" . htmlspecialchars($kpi['measurement_methods']) . "'></td>
                                    <td><input type='text' name='measurement_time_" . ($index + 1) . "' value='" . htmlspecialchars($kpi['measurement_time']) . "'></td>
                                  </tr>";
                                    }
                                } else {
                                    echo "<tr>
                                <td class='number_column'>1</td>
                                <td><input type='text' name='kpi_code_1'></td>
                                <td><input type='text' name='kpi_1'></td>
                                <td><input type='text' name='target_level_1'></td>
                                <td><input type='text' name='measurement_methods_1'></td>
                                <td><input type='text' name='measurement_time_1'></td>
                              </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <h3><?= $translations['Program Evaluation Matrix'] ?></h3>
                        <table>
                            <thead>
                                <tr>
                                    <th><?= $translations['Evaluation Areas/Aspects'] ?></th>
                                    <th><?= $translations['Evaluation Sources/References'] ?></th>
                                    <th><?= $translations['Evaluation Methods'] ?></th>
                                    <th><?= $translations['Evaluation Time'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($_SESSION['form_data']['evaluation'])) {
                                    foreach ($_SESSION['form_data']['evaluation'] as $index => $eval) {
                                        echo "<tr>
                                    <td><input type='text' name='evaluation_area_" . ($index + 1) . "' value='" . htmlspecialchars($eval['evaluation_area']) . "'></td>
                                    <td><input type='text' name='evaluation_sources_" . ($index + 1) . "' value='" . htmlspecialchars($eval['evaluation_sources']) . "'></td>
                                    <td><input type='text' name='evaluation_methods_" . ($index + 1) . "' value='" . htmlspecialchars($eval['evaluation_methods']) . "'></td>
                                    <td><input type='text' name='evaluation_time_" . ($index + 1) . "' value='" . htmlspecialchars($eval['evaluation_time']) . "'></td>
                                  </tr>";
                                    }
                                } else {
                                    for ($i = 1; $i <= 4; $i++) {
                                        echo "<tr>
                                    <td><input type='text' name='evaluation_area_$i'></td>
                                    <td><input type='text' name='evaluation_sources_$i'></td>
                                    <td><input type='text' name='evaluation_methods_$i'></td>
                                    <td><input type='text' name='evaluation_time_$i'></td>
                                  </tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="navigation-buttons">
                            <button name="update" type="submit" class="nav-button"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Specification_Approval_Data.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Learning_Resources_Facilities_and_Equipment.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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