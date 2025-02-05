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
    <title><?= $translations['Annual Program Report-Program KPIs Table'] ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #b3c6d1;
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
            flex: 1;
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

        .logout-button {
            background-color: #003f8a;
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

        .form-container {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #003f8a;

        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 12px 15px;
        }

        th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 600;
        }

        td textarea,
        td input {
            width: 80%;
            padding: 5px;
            border-radius: 5px;
            font-size: 13px;
            border: 1px solid #ccc;
            resize: none;
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

        .form-container p {
            color: #003f8a;
            font-size: 15px;
            font-weight: 200;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);


        }

        td input[type="number"] {
            width: 60%;
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
                // الاتصال بقاعدة البيانات
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // استلام البيانات من الفورم
                $kpi_data = $_POST['kpi'] ?? [];
                $procedures = $_POST['procedures'] ?? '';  // استلام قيمة حقل Procedures

                // تخزين البيانات في الجلسة
                $_SESSION['kpis_new'] = $kpi_data;
                $_SESSION['procedures'] = $procedures;  // تخزين procedures في الجلسة

                $errors = [];

                // تحقق من صحة البيانات المدخلة
                foreach ($kpi_data as $index => $row) {
                    foreach (['kpi', 'targeted_value', 'actual_value', 'internal_benchmark', 'analysis', 'new_target'] as $field) {
                        if (empty(trim($row[$field] ?? ''))) {
                            $errors[] = "Row " . ($index + 1) . ": Field '{$field}' is required.";
                        }
                    }
                }

                // تحقق من صحة حقل procedures
                if (empty(trim($procedures))) {
                    $errors[] = "The 'Comments on the Program KPIs and Benchmarks results' field is required.";
                }

                if (empty($errors)) {
                    // تجميع البيانات المدخلة في مصفوفة واحدة
                    $kpi_data_json = json_encode($kpi_data); // تحويل البيانات إلى JSON

                    // إنشاء الاستعلام لإدخال البيانات في قاعدة البيانات
                    $sql = "INSERT INTO kpi_data (user_id, program_id, data, procedures) VALUES ('$user_id', '$program_id', '$kpi_data_json', '$procedures')";

                    // تنفيذ الاستعلام
                    if ($conn->query($sql)) {
                        // رسالة النجاح
                        $_SESSION['message'] = 'Records created successfully!';
                        header("location: Program_KPIs_Table.php?new=" . $program_name);
                        exit;
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    // عرض الأخطاء
                    echo "<pre>";
                    print_r($errors);
                    echo "</pre>";

                    $_SESSION['message'] = 'Please fill in all fields.';
                }
            }

            // تحميل البيانات المحفوظة من الجلسة
            $saved_data = $_SESSION['kpis_new'] ?? [];
            $saved_procedures = $_SESSION['procedures'] ?? ''; // استرجاع البيانات المخزنة لحقل procedures
    ?>
            <div class="container">
                <div class="sidebar">
                    <a href="Annual_Program_Report_Programs.php?new=<?php echo $program_name ?>"><button><?= $translations['Programs'] ?></button></a>
                    <a href="ProgramStatistics.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Statistics'] ?></button></a>
                    <a href="PLOs.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Assessment'] ?></button></a>
                    <a href="Program_KPIs_Table.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Key Performance Indicators (KPIs)'] ?></button></a>
                    <a href="Annual_Program_Report_Challenges&Difficulties.php?new=<?php echo $program_name ?>"><button><?= $translations['Challenges and Difficulties'] ?></button></a>
                    <a href="Annual_Program_Report_Program_Devalopment_Plan.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Development Plan'] ?></button></a>
                    <a href="Annual_Program_Report_Approval_Of_Annual_Program_Report.php?new=<?php echo $program_name ?>"><button><?= $translations['Approval of Annual Program Report'] ?></button></a>
                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Annual Program Report'] ?></h3>
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
                            <h2><?= $translations['Program Key Performance Indicators (KPIs)'] ?></h2>
                            <table id="KPI-table">
                                <thead>
                                    <tr>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['KPI'] ?></th>
                                        <th><?= $translations['Targeted Value'] ?></th>
                                        <th><?= $translations['Actual Value'] ?></th>
                                        <th><?= $translations['Internal Benchmark'] ?></th>
                                        <th><?= $translations['Analysis'] ?></th>
                                        <th><?= $translations['New Target'] ?></th>
                                        <th><?= $translations['Action'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;

                                    // إذا لم تكن هناك بيانات محفوظة، قم بإنشاء صف فارغ افتراضي
                                    if (empty($saved_data)) {
                                        $saved_data = [[]]; // صف واحد فارغ
                                    }

                                    foreach ($saved_data as $index => $row) {
                                        echo "<tr>";
                                        echo "<td>{$counter}</td>";
                                        foreach (['kpi', 'targeted_value', 'actual_value', 'internal_benchmark', 'analysis', 'new_target'] as $field) {
                                            $value = htmlspecialchars($row[$field] ?? '');
                                            echo "<td><textarea name=\"kpi[{$index}][{$field}]\">{$value}</textarea></td>";
                                        }
                                        echo "<td><button type=\"button\" class=\"delete-button\" onclick=\"deleteRow(this)\"> $translations[Delete]</button></td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                    ?>

                                </tbody>
                            </table>

                            <button type="button" class="add-row-button" onclick="addRow('KPI-table')"><?= $translations['Add Row'] ?></button>

                            <p><?= $translations['Comments on the Program KPIs and Benchmarks results'] ?>:</p>
                            <textarea id="Procedures" name="procedures" placeholder="<?= $translations['Enter details'] ?>..."><?= htmlspecialchars($saved_procedures ?? '') ?></textarea>

                            <div class="navigation-buttons">
                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Challenges&Difficulties.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Program_Assessment_Community_Partnership.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>



                        </div>




                    </form>
                    <script>
                        let counter = 2;

                        function addRow(sectionId) {
                            const table = document.getElementById(sectionId).getElementsByTagName('tbody')[0];
                            const rowCount = table.rows.length;

                            if (rowCount >= 20) {
                                alert("You can only add up to 20 rows.");
                                return;
                            }

                            const newRow = table.insertRow();
                            const newRowIndex = counter++;

                            for (let i = 0; i < 8; i++) {
                                const newCell = newRow.insertCell(i);
                                if (i === 0) {
                                    newCell.textContent = newRowIndex;
                                } else if (i === 7) {
                                    const deleteButton = document.createElement('button');
                                    deleteButton.className = 'delete-button';
                                    deleteButton.textContent = 'Delete';
                                    deleteButton.onclick = () => deleteRow(deleteButton);
                                    newCell.appendChild(deleteButton);
                                } else {
                                    const input = document.createElement('textarea');
                                    input.name = `kpi[${newRowIndex - 1}][${getFieldName(i)}]`; // إضافة index ديناميكي
                                    newCell.appendChild(input);
                                }
                            }
                        }

                        function getFieldName(index) {
                            const fields = ['kpi', 'targeted_value', 'actual_value', 'internal_benchmark', 'analysis', 'new_target'];
                            return fields[index - 1];
                        }

                        function deleteRow(button) {
                            const row = button.parentNode.parentNode;
                            const table = row.parentNode;
                            table.removeChild(row);

                            // إعادة ترتيب الصفوف
                            Array.from(table.rows).forEach((row, index) => {
                                row.cells[0].textContent = index + 1;
                            });
                            counter = table.rows.length + 1;
                        }

                        function showSection(sectionId) {
                            const sections = document.querySelectorAll('.form-container');
                            sections.forEach(section => section.style.display = 'none');
                            document.getElementById(sectionId).style.display = 'block';
                        }
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
        $edit_item = $_POST['edit_item'] ?? ($_SESSION['kpis_edit']['id'] ?? '');

        // التحقق من أن العنصر المختار موجود في قاعدة البيانات
        if ($edit_item && empty($_POST['update'])) {
            $query = mysqli_query($conn, "SELECT * FROM kpi_data WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);
            $_SESSION['kpis_edit'] = [
                'id' => $row['id'],
                'data' => json_decode($row['data'], true),
                'procedures' => $row['procedures'] ?? ''  // تخزين procedures في الجلسة
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $kpi_data = $_POST['kpi'] ?? [];
            $procedures = $_POST['procedures'] ?? '';  // استلام بيانات Procedures
            $errors = [];

            foreach ($kpi_data as $index => $row) {
                foreach (['kpi', 'targeted_value', 'actual_value', 'internal_benchmark', 'analysis', 'new_target'] as $field) {
                    if (empty(trim($row[$field] ?? ''))) {
                        $errors[] = "Row " . ($index + 1) . ": Field '{$field}' is required.";
                    }
                }
            }

            // التحقق من أن حقل Procedures غير فارغ
            if (empty(trim($procedures))) {
                $errors[] = "The 'Comments on the Program KPIs and Benchmarks results' field is required.";
            }

            if (empty($errors)) {
                $kpi_data_json = json_encode($kpi_data);

                if (!empty($_POST['id'])) {
                    $edit_item = $_POST['id'];

                    // تحديث بيانات الـ KPI مع الـ Procedures
                    $sql = "UPDATE kpi_data SET data = '$kpi_data_json', procedures = '$procedures' WHERE id = '$edit_item' AND user_id = '$user_id'";

                    if ($conn->query($sql)) {
                        $_SESSION['message'] = 'Records updated successfully!';
                        header("location: Program_KPIs_Table.php?edit=" . $program_name);
                        exit;
                    } else {
                        echo "<p>Error: " . $conn->error . "</p>";
                    }
                } else {
                    $sql = "INSERT INTO kpi_data (user_id, program_id, data, procedures) VALUES ('$user_id', '$program_id', '$kpi_data_json', '$procedures')";

                    if ($conn->query($sql)) {
                        $_SESSION['message'] = 'Records created successfully!';
                        header("location: Program_KPIs_Table.php?edit=" . $program_name);
                        exit;
                    } else {
                        echo "<p>Error: " . $conn->error . "</p>";
                    }
                }
            } else {
                echo "<pre>";
                print_r($errors);
                echo "</pre>";
            }
        }

    ?>

        <div class="container">
            <div class="sidebar">
                <a href="Annual_Program_Report_Programs.php?edit=<?php echo $program_name ?>"><button><?= $translations['Programs'] ?></button></a>
                <a href="ProgramStatistics.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Statistics'] ?></button></a>
                <a href="PLOs.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Assessment'] ?></button></a>
                <a href="Program_KPIs_Table.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Key Performance Indicators (KPIs)'] ?></button></a>
                <a href="Annual_Program_Report_Challenges&Difficulties.php?edit=<?php echo $program_name ?>"><button><?= $translations['Challenges and Difficulties'] ?></button></a>
                <a href="Annual_Program_Report_Program_Devalopment_Plan.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Development Plan'] ?></button></a>
                <a href="Annual_Program_Report_Approval_Of_Annual_Program_Report.php?edit=<?php echo $program_name ?>"><button><?= $translations['Approval of Annual Program Report'] ?></button></a>
            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Annual Program Report'] ?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                </div>
                <form method="post" id="coursesForm">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <label><?= $translations['Select an item to edit'] ?></label>
                    <select name="edit_item" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select'] ?></option>
                        <?php
                        $query = "SELECT * FROM kpi_data WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        while ($row_edit = mysqli_fetch_assoc($result)) {

                            $data = json_decode($row_edit['data'], true);

                            // التحقق إذا كانت البيانات موجودة
                            if (!empty($data) && is_array($data)) {
                                // أخذ أول عنصر من الكورسات
                                $first_course = $data[0];

                                // استخراج course_title لأول كورس
                                $kpi = $first_course['kpi'] ?? 'N/A';


                                $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$kpi}</option>";
                            }
                        }
                        ?>
                    </select>

                    <button class="button" type="submit"><?= $translations['Edit'] ?></button>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['kpis_edit']['id'] ?? '') ?>">

                    <div id="programs" class="form-container">
                        <h2><?= $translations['Program Key Performance Indicators (KPIs)'] ?></h2>
                        <table id="KPI-table">
                            <thead>
                                <tr>
                                    <th><?= $translations['No'] ?></th>
                                    <th><?= $translations['KPI'] ?></th>
                                    <th><?= $translations['Targeted Value'] ?></th>
                                    <th><?= $translations['Actual Value'] ?></th>
                                    <th><?= $translations['Internal Benchmark'] ?></th>
                                    <th><?= $translations['Analysis'] ?></th>
                                    <th><?= $translations['New Target'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $kpi_data = $_SESSION['kpis_edit']['data'] ?? []; ?>
                                <?php foreach ($kpi_data as $index => $row): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><textarea name="kpi[<?= $index ?>][kpi]"><?= htmlspecialchars($row['kpi'] ?? '') ?></textarea></td>
                                        <td><textarea name="kpi[<?= $index ?>][targeted_value]"><?= htmlspecialchars($row['targeted_value'] ?? '') ?></textarea></td>
                                        <td><textarea name="kpi[<?= $index ?>][actual_value]"><?= htmlspecialchars($row['actual_value'] ?? '') ?></textarea></td>
                                        <td><textarea name="kpi[<?= $index ?>][internal_benchmark]"><?= htmlspecialchars($row['internal_benchmark'] ?? '') ?></textarea></td>
                                        <td><textarea name="kpi[<?= $index ?>][analysis]"><?= htmlspecialchars($row['analysis'] ?? '') ?></textarea></td>
                                        <td><textarea name="kpi[<?= $index ?>][new_target]"><?= htmlspecialchars($row['new_target'] ?? '') ?></textarea></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <p><?= $translations['Comments on the Program KPIs and Benchmarks results'] ?>:</p>
                        <textarea id="Procedures" name="procedures"><?= htmlspecialchars($_SESSION['kpis_edit']['procedures'] ?? '') ?></textarea>
                        <div class="navigation-buttons">

                            <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Challenges&Difficulties.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Program_Assessment_Community_Partnership.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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