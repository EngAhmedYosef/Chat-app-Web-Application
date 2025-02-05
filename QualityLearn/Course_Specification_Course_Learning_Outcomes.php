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
    <title><?= $translations['Course Specification - CLOs']?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap">
    <style>
        /* تنسيقات الصفحة العامة */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #001f5b, #d7dce9);
            transition: background 0.3s ease;
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
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .sidebar button:hover {
            background-color: #0073e6;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .content {
            width: 80%;
            padding: 20px;
            background: linear-gradient(to top, #d7dce9, #f0f4fa);
            overflow-y: auto;
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
            transition: background-color 0.3s;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        .add-row-button,
        .delete-button {
            background-color: #003f8a;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .add-row-button:hover,
        .delete-button:hover {
            background-color: #0057b7;
            transform: translateY(-3px);
        }

        .delete-button {
            background-color: #ff4d4d;
        }

        .delete-button:hover {
            background-color: #ff1a1a;
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

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
                // استخراج البيانات من الفورم
                $data = $_POST['data'] ?? [];

                // التأكد من أن جميع المدخلات تم ملؤها
                $isValid = true;
                foreach ($data as $tableData) {
                    foreach ($tableData as $rowData) {
                        if (in_array("", $rowData)) {
                            $isValid = false;
                            break;
                        }
                    }
                }

                if ($isValid) {
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // تحويل البيانات إلى JSON
                    $jsonData = json_encode($data);

                    // تحضير الاستعلام لإدخال البيانات في الجدول
                    $stmt = $conn->prepare("INSERT INTO course_specifications_clos (user_id, data, program_id) VALUES (?, ?, ?)");
                    $stmt->bind_param("isi", $user_id, $jsonData, $program_id);

                    // تنفيذ الاستعلام
                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }

                    // تخزين البيانات المدخلة في الـ session لإعادة استخدامها
                    $_SESSION['clos_new'] = $data;
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }
                header("location: Course_Specification_Course_Learning_Outcomes.php?new=" . $program_name);
                exit;
            }
    ?>
            <div class="container">
                <div class="sidebar">
                <a href="Course_Specification.php?new=<?php echo $program_name ?>"><button><?= $translations['Courses']?></button></a>
                    <a href="Course_Specification_General_Info_About_The_Course.php?new=<?php echo $program_name ?>"><button><?= $translations['General Information About The Course']?></button></a>
                    <a href="Course_Specification_Course_Learning_Outcomes.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes']?></button></a>
                    <a href="Course_Specification_Course_Content.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Content']?></button></a>
                    <a href="Course_Spesification_Students_Assessment_Activities.php?new=<?php echo $program_name ?>"><button><?= $translations['Student Assessment Activity']?></button></a>
                    <a href="Course_Spesification_Learning_Resources_and_Facilities.php?new=<?php echo $program_name ?>"><button><?= $translations['Learning Resources And Facilities']?></button></a>
                    <a href="Course_Spesification_Assessment_Of_Course_Quality.php?new=<?php echo $program_name ?>"><button><?= $translations['Assessment Of Course Quality']?></button></a>
                    <a href="Course_Spesification_Specification_Approval.php?new=<?php echo $program_name ?>"><button><?= $translations['Specification Approval']?></button></a>
                </div>
                <div class="content">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Specification']?></h3>
                        <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                        </div>
                    <form method="post" id="coursesForm">

                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <div class="table-container">
                            <h2><?= $translations['Course Learning Outcomes (CLOs), Teaching Strategies, and Assessment Methods']?></h2>

                            <h3><?= $translations['Knowledge and Understanding']?></h3>
                            <table id="knowledgeTable">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th><?= $translations['Program Learning Outcomes']?></th>
                                        <th><?= $translations['Code Of PLOs']?></th>
                                        <th><?= $translations['Teaching Strategies']?></th>
                                        <th><?= $translations['Assessment Methods']?></th>
                                        <th><?= $translations['Actions']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['clos_new']['knowledgeTable'])) {
                                        foreach ($_SESSION['clos_new']['knowledgeTable'] as $index => $rowData) {
                                            echo "<tr>";
                                            echo "<td>" . ($index + 1) . "</td>";
                                            for ($i = 0; $i < 4; $i++) {
                                                echo "<td><input type='text' name='data[knowledgeTable][$index][$i]' value='" . htmlspecialchars($rowData[$i]) . "'></td>";
                                            }
                                            echo "<td><button type='button' class='delete-button' onclick='deleteRow(this)'>Delete</button></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <button class="add-row-button" type="button" onclick="addRow('knowledgeTable')"><?= $translations['Add Row']?></button>

                            <h3><?= $translations['Skills']?></h3>
                            <table id="skillsTable">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th><?= $translations['Program Learning Outcomes']?></th>
                                        <th><?= $translations['Code Of PLOs']?></th>
                                        <th><?= $translations['Teaching Strategies']?></th>
                                        <th><?= $translations['Assessment Methods']?></th>
                                        <th><?= $translations['Actions']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['clos_new']['skillsTable'])) {
                                        foreach ($_SESSION['clos_new']['skillsTable'] as $index => $rowData) {
                                            echo "<tr>";
                                            echo "<td>" . ($index + 1) . "</td>";
                                            for ($i = 0; $i < 4; $i++) {
                                                echo "<td><input type='text' name='data[skillsTable][$index][$i]' value='" . htmlspecialchars($rowData[$i]) . "'></td>";
                                            }
                                            echo "<td><button type='button' class='delete-button' onclick='deleteRow(this)'>Delete</button></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <button class="add-row-button" type="button" onclick="addRow('skillsTable')"><?= $translations['Add Row']?></button>

                            <h3><?= $translations['Values']?></h3>
                            <table id="valuesTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?= $translations['Program Learning Outcomes']?></th>
                                        <th><?= $translations['Code Of PLOs']?></th>
                                        <th><?= $translations['Teaching Strategies']?></th>
                                        <th><?= $translations['Assessment Methods']?></th>
                                        <th><?= $translations['Actions']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['clos_new']['valuesTable'])) {
                                        foreach ($_SESSION['clos_new']['valuesTable'] as $index => $rowData) {
                                            echo "<tr>";
                                            echo "<td>" . ($index + 1) . "</td>";
                                            for ($i = 0; $i < 4; $i++) {
                                                echo "<td><input type='text' name='data[valuesTable][$index][$i]' value='" . htmlspecialchars($rowData[$i]) . "'></td>";
                                            }
                                            echo "<td><button type='button' class='delete-button' onclick='deleteRow(this)'>Delete</button></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <button class="add-row-button" type="button" onclick="addRow('valuesTable')"><?= $translations['Add Row']?></button>
                        </div>

                        <div class="navigation-buttons">
                            <button type="submit" name="save" class="nav-button"><?= $translations['Save']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_Course_Content.php?new=<?= $program_name ?>')"><?= $translations['Next']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_General_Info_About_The_Course_TABLES.php?new=<?= $program_name ?>')"><?= $translations['Back']?></button>
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

            <script>
                function addRow(tableId) {
                    const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
                    const newRow = table.insertRow();
                    const colCount = 5; // Columns excluding the Action column

                    const rowNumber = table.rows.length;
                    newRow.insertCell(0).textContent = rowNumber;

                    for (let i = 1; i < colCount + 1; i++) {
                        const cell = newRow.insertCell(i);
                        cell.innerHTML = (i === colCount) ?
                            '<button class="delete-button" onclick="deleteRow(this)"><?= $translations['Delete']?></button>' :
                            `<input type="text" name="data[${tableId}][${rowNumber - 1}][${i - 1}]">`;
                    }
                }

                function deleteRow(button) {
                    const row = button.parentNode.parentNode;
                    const table = row.parentNode;
                    table.removeChild(row);

                    [...table.rows].forEach((row, index) => {
                        row.cells[0].textContent = index + 1;
                    });
                }
            </script>

    <?php
        }
    }
    ?>







    <?php

    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // استعلام للبحث عن الـ program_id باستخدام البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق مما إذا كان قد تم اختيار الـ edit_item
        if (isset($_POST['edit_item']) && !empty($_POST['edit_item'])) {
            $edit_item = $_POST['edit_item']; // القيمة المرسلة من الفورم
            $query = mysqli_query($conn, "SELECT * FROM course_specifications_clos WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);

            if ($row) {
                // إذا تم العثور على البيانات
                $data = json_decode($row["data"], true);  // تحويل البيانات من JSON إلى مصفوفة
                $knowledge_data = $data['knowledgeTable'] ?? [];
                $skills_data = $data['skillsTable'] ?? [];
                $values_data = $data['valuesTable'] ?? [];

                // حفظ البيانات في الجلسة لتجنب مسحها بعد التحديث
                $_SESSION['clos_edit'] = [
                    'id' => $edit_item, // حفظ الـ id
                    'knowledgeTable' => $knowledge_data,
                    'skillsTable' => $skills_data,
                    'valuesTable' => $values_data
                ];
            } else {
                $_SESSION['message'] = "No data found for the selected ID.";
            }
        }

        // التحقق من إرسال البيانات للتحديث
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            $data = $_POST['data'] ?? [];

            // التأكد من أن جميع الحقول تم ملؤها
            $isValid = true;
            foreach ($data as $tableData) {
                foreach ($tableData as $rowData) {
                    if (in_array("", $rowData)) {
                        $isValid = false;
                        break;
                    }
                }
            }

            if ($isValid) {
                // تحويل البيانات إلى JSON
                $jsonData = json_encode($data);

                // تحديث البيانات في قاعدة البيانات
                $stmt = $conn->prepare("UPDATE course_specifications_clos SET data = ? WHERE id = ? AND user_id = ?");
                $stmt->bind_param("sii", $jsonData, $_SESSION['clos_edit']['id'], $user_id);

                // تنفيذ الاستعلام
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Records updated successfully!';
                    // تحديث البيانات في الجلسة بعد التحديث
                    $_SESSION['clos_edit']['knowledgeTable'] = $data['knowledgeTable'];
                    $_SESSION['clos_edit']['skillsTable'] = $data['skillsTable'];
                    $_SESSION['clos_edit']['valuesTable'] = $data['valuesTable'];
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }
            } else {
                $_SESSION['message'] = 'Please fill all inputs';
            }

            // إعادة تحميل الصفحة بعد التحديث
            header("location: Course_Specification_Course_Learning_Outcomes.php?edit=" . $program_name);
            exit;
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
            <div class="content">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Course Specification']?></h3>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>

                <form method="post" id="coursesForm">

                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <!-- Select the item to edit -->
                    <label><?= $translations['Select an item to edit']?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
    <option value=""><?= $translations['Select']?></option>
    <?php
    // استعلام للحصول على الـ ID للخيارات
    $query = "SELECT * FROM course_specifications_clos WHERE program_id = '$program_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    while ($row_edit = mysqli_fetch_assoc($result)) {
        // تحويل البيانات من JSON إلى مصفوفة
        $data = json_decode($row_edit["data"], true);
        $knowledge_data = $data['knowledgeTable'] ?? [];

        // التحقق إذا كان هناك بيانات داخل knowledgeTable
        if (isset($knowledge_data[0]) && is_array($knowledge_data[0]) && count($knowledge_data[0]) > 0) {
            // استخراج أول قيمة من المصفوفة الأولى في knowledgeTable
            $first_knowledge_value = $knowledge_data[0][0]; // أول قيمة في المصفوفة الأولى
        } else {
            $first_knowledge_value = 'N/A';  // في حالة عدم وجود بيانات
        }

        // التحقق مما إذا كان هذا العنصر هو المختار
        $selected = ($row_edit['id'] == $_SESSION['clos_edit']['id']) ? 'selected' : '';

        // عرض الـ option في القائمة
        echo "<option value='{$row_edit['id']}' $selected>{$first_knowledge_value}</option>";
    }
    ?>
</select>


                    <button class="button" type="submit" name="edit_row"><?= $translations['Edit']?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['clos_edit']['id'] ?? '') ?>" readonly>

                    <div class="table-container">

                        <?php
                        // افتراضياً، تعيين القيم الفارغة للمتغيرات إذا لم تكن هناك بيانات
                        $knowledge_data = $_SESSION['clos_edit']['knowledgeTable'] ?? [];
                        $skills_data = $_SESSION['clos_edit']['skillsTable'] ?? [];
                        $values_data = $_SESSION['clos_edit']['valuesTable'] ?? [];
                        ?>

                        <h2><?= $translations['Course Learning Outcomes (CLOs), Teaching Strategies, and Assessment Methods']?></h2>

                        <!-- Knowledge and Understanding Section -->
                        <h3><?= $translations['Knowledge and Understanding']?></h3>
                        <table id="knowledgeTable">
                            <thead>
                                <tr>
                                <th>#</th>
                                        <th><?= $translations['Program Learning Outcomes']?></th>
                                        <th><?= $translations['Code Of PLOs']?></th>
                                        <th><?= $translations['Teaching Strategies']?></th>
                                        <th><?= $translations['Assessment Methods']?></th>
                                        <th><?= $translations['Actions']?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($knowledge_data as $index => $row) { ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><input type="text" name="data[knowledgeTable][<?= $index ?>][0]" value="<?= htmlspecialchars($row[0]) ?>"></td>
                                        <td><input type="text" name="data[knowledgeTable][<?= $index ?>][1]" value="<?= htmlspecialchars($row[1]) ?>"></td>
                                        <td><input type="text" name="data[knowledgeTable][<?= $index ?>][2]" value="<?= htmlspecialchars($row[2]) ?>"></td>
                                        <td><input type="text" name="data[knowledgeTable][<?= $index ?>][3]" value="<?= htmlspecialchars($row[3]) ?>"></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Skills Section -->
                        <h3><?= $translations['Skills']?></h3>
                        <table id="skillsTable">
                            <thead>
                                <tr>
                                <th>#</th>
                                        <th><?= $translations['Program Learning Outcomes']?></th>
                                        <th><?= $translations['Code Of PLOs']?></th>
                                        <th><?= $translations['Teaching Strategies']?></th>
                                        <th><?= $translations['Assessment Methods']?></th>
                                        <th><?= $translations['Actions']?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($skills_data as $index => $row) { ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><input type="text" name="data[skillsTable][<?= $index ?>][0]" value="<?= htmlspecialchars($row[0]) ?>"></td>
                                        <td><input type="text" name="data[skillsTable][<?= $index ?>][1]" value="<?= htmlspecialchars($row[1]) ?>"></td>
                                        <td><input type="text" name="data[skillsTable][<?= $index ?>][2]" value="<?= htmlspecialchars($row[2]) ?>"></td>
                                        <td><input type="text" name="data[skillsTable][<?= $index ?>][3]" value="<?= htmlspecialchars($row[3]) ?>"></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Values Section -->
                        <h3><?= $translations['Values']?></h3>
                        <table id="valuesTable">
                            <thead>
                                <tr>
                                <th>#</th>
                                        <th><?= $translations['Program Learning Outcomes']?></th>
                                        <th><?= $translations['Code Of PLOs']?></th>
                                        <th><?= $translations['Teaching Strategies']?></th>
                                        <th><?= $translations['Assessment Methods']?></th>
                                        <th><?= $translations['Actions']?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($values_data as $index => $row) { ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><input type="text" name="data[valuesTable][<?= $index ?>][0]" value="<?= htmlspecialchars($row[0]) ?>"></td>
                                        <td><input type="text" name="data[valuesTable][<?= $index ?>][1]" value="<?= htmlspecialchars($row[1]) ?>"></td>
                                        <td><input type="text" name="data[valuesTable][<?= $index ?>][2]" value="<?= htmlspecialchars($row[2]) ?>"></td>
                                        <td><input type="text" name="data[valuesTable][<?= $index ?>][3]" value="<?= htmlspecialchars($row[3]) ?>"></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="navigation-buttons">
                        <button type="submit" name="update" class="nav-button"><?= $translations['Update']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_Course_Content.php?edit=<?= $program_name ?>')"><?= $translations['Next']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_General_Info_About_The_Course_TABLES.php?edit=<?= $program_name ?>')"><?= $translations['Back']?></button>
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