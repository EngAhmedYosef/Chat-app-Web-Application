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
            height: 170vh;
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
            margin-bottom: 40px;
        }

        .form-container h3 {
            margin-bottom: 0px;
        }

        .table-container {
            margin-left: auto;
            margin-right: auto;
            padding: 50px;
            margin-top: 40px;
        }

        table {
            width: 70%;
            /* تعديل التنسيق ليكون متسقًا مع الجدول الثاني */
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
            padding: 7px;
            /* تقليص التباعد داخل الخلايا */
            font-size: 15px;
            border: 1px solid #003f8a;
            text-align: center;
            margin: 20px 0;
        }


        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .section-header {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            color: #000;
        }

        .section-header td {
            text-align: center;
            font-size: 1.7rem;
        }


        button.remove_section {
            background-color: #003366;
            color: white;
            font-size: 1.2rem;
            width: 160px;
            outline: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            transform: translate(50%, 0);
        }

        input[type="text"] {
            width: 90%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #0056b3;
        }

        .custom-input {
            width: 200px;
            /* عرض صغير */
            height: 30px;
            /* ارتفاع صغير */
            margin-bottom: 10px;
            /* مسافة بين المربعات */
            display: block;
            /* عرض المربعات أسفل بعضها */
        }


        label {
            font-size: 14px;
            /* حجم النص */
            display: block;
            /* النص فوق المربع */
            margin-bottom: 5px;
            /* مسافة صغيرة بين النص والمربع */
        }

        table td:first-child,
        table th:first-child {
            width: 20%;
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

        .add_section {
            transform: translate(30%, 0);
        }

        .add_section {
            background-color: #003f8a;
            font-size: 1.2rem;
            color: white;
            border: none;
            outline: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $translations['Program Specification-Mission, Objectives, and Program Learning Outcomes'] ?></title>
    <!-- <link rel="stylesheet" href="css Program Specification-Mission/style.css"> -->
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
                // الحصول على البيانات من الفورم
                $program_mission = $_POST['ProgramMission'];
                $program_goals = $_POST['ProgramGoals'];

                // جمع كل "outcomes" حسب الأقسام (Knowledge, Skills, Values)
                $knowledge = $_POST['Knowledge'] ?? [];
                $skills = $_POST['Skills'] ?? [];
                $values = $_POST['Values'] ?? [];

                // تخزين البيانات المدخلة في الجلسة للاستخدام لاحقاً
                $_SESSION['mission_new'] = [
                    'ProgramMission' => $program_mission,
                    'ProgramGoals' => $program_goals,
                    'Knowledge' => $knowledge,
                    'Skills' => $skills,
                    'Values' => $values
                ];

                // التحقق من أن جميع الحقول تم تعبئتها
                if (empty($program_mission) || empty($program_goals)) {
                    $_SESSION['message'] = 'Please fill in all fields.';
                } elseif (empty($knowledge) || empty($skills) || empty($values)) {
                    $_SESSION['message'] = 'Please fill in all fields.';
                } else {
                    // تحويل البيانات إلى JSON
                    $data = json_encode([
                        'ProgramMission' => $program_mission,
                        'ProgramGoals' => $program_goals,
                        'Knowledge' => $knowledge,
                        'Skills' => $skills,
                        'Values' => $values
                    ]);

                    // استعلام لحفظ البيانات في قاعدة البيانات
                    $stmt = $conn->prepare("INSERT INTO program_mission (user_id, program_id, data) VALUES (?, ?, ?)");
                    $stmt->bind_param("iis", $user_id, $program_id, $data); // "iis" تعني: integer, integer, string

                    // تنفيذ الاستعلام
                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                }

                header("location: Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?new=" . $program_name);
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
                        <img src="ql-removebg-preview (1).png" alt=" Logo" width="200" style="margin-bottom: 20px;">
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
                            <h2><?= $translations['Mission, Objectives, and Program Learning Outcomes'] ?></h2>


                            <div class="form-group">
                                <label for="ProgramMission"><?= $translations['Program Mission'] ?>:</label>
                                <input type="text" name="ProgramMission" class="custom-input" value="<?php echo $_SESSION['mission_new']['ProgramMission'] ?? ''; ?>">

                                <label for="ProgramGoals"><?= $translations['Program Goals'] ?>:</label>
                                <input type="text" name="ProgramGoals" class="custom-input" value="<?php echo $_SESSION['mission_new']['ProgramGoals'] ?? ''; ?>">

                                <table class="program_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?= $translations['Program Learning Outcomes'] ?></th>
                                            <th><?= $translations['Actions'] ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Knowledge Section -->
                                        <tr class="section-header" data-section="Knowledge">
                                            <td colspan="3"><?= $translations['Knowledge and Understanding'] ?></td>
                                        </tr>
                                        <?php
                                        $knowledge = $_SESSION['mission_new']['Knowledge'] ?? [];
                                        foreach ($knowledge as $index => $value) {
                                            echo '<tr data-section="Knowledge">
                                        <td>k' . ($index + 1) . '</td>
                                        <td><input type="text" name="Knowledge[]" placeholder="Enter outcome..." value="' . $value . '"></td>
                                        <td><button type="button" class="remove_section">' . $translations['Delete'] . '</button></td>
                                      </tr>';
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3"><button type="button" class="add_section" data-section="Knowledge"><?= $translations['Add Row'] ?></button></td>
                                        </tr>

                                        <!-- Skills Section -->
                                        <tr class="section-header" data-section="Skills">
                                            <td colspan="3"><?= $translations['Skills'] ?></td>
                                        </tr>
                                        <?php
                                        $skills = $_SESSION['mission_new']['Skills'] ?? [];
                                        foreach ($skills as $index => $value) {
                                            echo '<tr data-section="Skills">
                                        <td>s' . ($index + 1) . '</td>
                                        <td><input type="text" name="Skills[]" placeholder="Enter outcome..." value="' . $value . '"></td>
                                        <td><button type="button" class="remove_section">' . $translations['Delete'] . '</button></td>
                                      </tr>';
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3"><button type="button" class="add_section" data-section="Skills"><?= $translations['Add Row'] ?></button></td>
                                        </tr>

                                        <!-- Values Section -->
                                        <tr class="section-header" data-section="Values">
                                            <td colspan="3"><?= $translations['Values, Autonomy, and Responsibility'] ?></td>
                                        </tr>
                                        <?php
                                        $values = $_SESSION['mission_new']['Values'] ?? [];
                                        foreach ($values as $index => $value) {
                                            echo '<tr data-section="Values">
                                        <td>v' . ($index + 1) . '</td>
                                        <td><input type="text" name="Values[]" placeholder="Enter outcome..." value="' . $value . '"></td>
                                        <td><button type="button" class="remove_section">' . $translations['Delete'] . '</button></td>
                                      </tr>';
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3"><button type="button" class="add_section" data-section="Values"><?= $translations['Add Row'] ?></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="navigation-buttons">
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-1_Curriculum_Structure.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Program_Identification_and_General_Information.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>

                        </div>
                    </form>

                    <script>
                        const counters = {
                            Knowledge: 0,
                            Skills: 0,
                            Values: 0
                        };

                        const tableBody = document.querySelector(".program_table tbody");

                        // Handle adding sections
                        document.querySelectorAll(".add_section").forEach(button => {
                            button.addEventListener("click", () => {
                                const section = button.getAttribute('data-section');
                                counters[section]++;

                                const newRow = document.createElement("tr");
                                newRow.setAttribute("data-section", section);

                                const cell1 = document.createElement("td");
                                cell1.textContent = `${section[0].toLowerCase()}${counters[section]}`;

                                const cell2 = document.createElement("td");
                                const input = document.createElement("input");
                                input.type = "text";
                                input.placeholder = "Enter outcome...";
                                input.name = `${section}[]`;
                                cell2.appendChild(input);

                                const cell3 = document.createElement("td");
                                const deleteButton = document.createElement("button");
                                deleteButton.classList.add("remove_section");
                                deleteButton.textContent = "<?= $translations['Delete'] ?>";
                                deleteButton.type = "button";

                                deleteButton.addEventListener("click", () => {
                                    newRow.remove();
                                    counters[section]--;
                                });

                                cell3.appendChild(deleteButton);
                                newRow.appendChild(cell1);
                                newRow.appendChild(cell2);
                                newRow.appendChild(cell3);

                                tableBody.insertBefore(newRow, button.closest("tr"));
                            });
                        });

                        // Handle removing sections
                        tableBody.addEventListener("click", (event) => {
                            if (event.target.classList.contains("remove_section")) {
                                const row = event.target.closest("tr");
                                const section = row.getAttribute("data-section");
                                row.remove();
                                counters[section]--;
                            }
                        });
                    </script>
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

        // استعلام لجلب id الخاص بالبرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق من إذا كان المستخدم قد اختار عنصر لتعديله
        $edit_item = $_POST['edit_item'] ?? $_SESSION['mission_edit']['id'] ?? '';  // استخدم الـ id من الجلسة إذا لم يتم تحديده

        // التحقق من أن العنصر المختار موجود في قاعدة البيانات
        if ($edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM program_mission WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);
            $update_id = $row["id"];

            // تحويل البيانات من JSON إلى مصفوفة لعرضها
            $data = json_decode($row["data"], true);

            // التأكد من أن المتغيرات ليست null أو غير معرفة
            $knowledge = $data['Knowledge'] ?? [];
            $skills = $data['Skills'] ?? [];
            $values = $data['Values'] ?? [];

            // تخزين البيانات في الجلسة
            $_SESSION['mission_edit'] = [
                'ProgramMission' => $data['ProgramMission'] ?? '',
                'ProgramGoals' => $data['ProgramGoals'] ?? '',
                'Knowledge' => $knowledge,
                'Skills' => $skills,
                'Values' => $values,
                'id' => $update_id // تخزين id في الجلسة
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            // الحصول على البيانات من الفورم
            $program_mission = $_POST['ProgramMission'];
            $program_goals = $_POST['ProgramGoals'];

            // جمع كل "outcomes" حسب الأقسام (Knowledge, Skills, Values)
            $knowledge = $_POST['Knowledge'] ?? [];
            $skills = $_POST['Skills'] ?? [];
            $values = $_POST['Values'] ?? [];

            // التحقق من أن جميع الحقول تم تعبئتها
            if (empty($program_mission) || empty($program_goals)) {
                $_SESSION['message'] = 'Please fill in all fields.';
            } elseif (empty($knowledge) || empty($skills) || empty($values)) {
                $_SESSION['message'] = 'Please fill in all fields.';
            } else {
                // تحويل البيانات إلى JSON
                $data = json_encode([
                    'ProgramMission' => $program_mission,
                    'ProgramGoals' => $program_goals,
                    'Knowledge' => $knowledge,
                    'Skills' => $skills,
                    'Values' => $values
                ]);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // استعلام لتحديث البيانات في قاعدة البيانات
                $stmt = $conn->prepare("UPDATE program_mission SET user_id = ?, program_id = ?, data = ? WHERE id = ?");
                $stmt->bind_param("iisi", $user_id, $program_id, $data, $_SESSION['mission_edit']['id']); // استخدام الـ id من الجلسة

                // تنفيذ الاستعلام
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Records updated successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }
            }

            // إعادة توجيه إلى الصفحة نفسها بعد التحديث
            header("location: Program_Specification_Mission_Objectives,_and_Program_Learning_Outcomes.php?edit=" . $program_name);
            exit;
        }
    ?>
        <div class="container">
            <div class="sidebar">
                <!-- Sidebar buttons and links -->
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
                        // استعلام للحصول على البيانات من جدول program_mission
                        $query = "SELECT * FROM program_mission WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);

                        // عرض كل صفوف البيانات في الـ select
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            // تحويل البيانات من JSON إلى مصفوفة لعرض البيانات
                            $data = json_decode($row_edit['data'], true);

                            // التحقق من وجود ProgramMission في البيانات
                            $program_mission = $data['ProgramMission'] ?? 'N/A';  // Default إذا لم توجد القيمة

                            // تحديد ما إذا كانت هذه هي القيمة المختارة بناءً على id
                            $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';

                            // عرض الخيارات في الـ select مع قيمة ProgramMission بدلاً من الـ id
                            echo "<option value='{$row_edit['id']}' $selected>{$program_mission}</option>";
                        }
                        ?>
                    </select>


                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>

                    <div id="programs" class="form-container">
                        <h2><?= $translations['Mission, Objectives, and Program Learning Outcomes'] ?></h2>

                        <div class="form-group">
                            <label for="ProgramMission"><?= $translations['Program Mission'] ?>:</label>
                            <input type="text" name="ProgramMission" class="custom-input" value="<?= htmlspecialchars($_SESSION['mission_edit']['ProgramMission'] ?? '') ?>">

                            <label for="ProgramGoals"><?= $translations['Program Goals'] ?>:</label>
                            <input type="text" name="ProgramGoals" class="custom-input" value="<?= htmlspecialchars($_SESSION['mission_edit']['ProgramGoals'] ?? '') ?>">

                            <table class="program_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?= $translations['Program Learning Outcomes'] ?></th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="section-header" data-section="Knowledge">
                                        <td colspan="3"><?= $translations['Knowledge and Understanding'] ?></td>
                                    </tr>
                                    <?php
                                    $counter = 1;
                                    if (!empty($_SESSION['mission_edit']['Knowledge'])) {
                                        foreach ($_SESSION['mission_edit']['Knowledge'] as $outcome) {
                                            echo "<tr data-section='Knowledge'>
                                        <td>k{$counter}</td>
                                        <td><input type='text' name='Knowledge[]' placeholder='Enter outcome...' value='{$outcome}' id='k{$counter}'></td>
                                      </tr>";
                                            $counter++;
                                        }
                                    }
                                    ?>

                                    <tr class="section-header" data-section="Skills">
                                        <td colspan="3"><?= $translations['Skills'] ?></td>
                                    </tr>
                                    <?php
                                    $counter = 1;
                                    if (!empty($_SESSION['mission_edit']['Skills'])) {
                                        foreach ($_SESSION['mission_edit']['Skills'] as $outcome) {
                                            echo "<tr data-section='Skills'>
                                        <td>s{$counter}</td>
                                        <td><input type='text' name='Skills[]' placeholder='Enter outcome...' value='{$outcome}' id='s{$counter}'></td>
                                      </tr>";
                                            $counter++;
                                        }
                                    }
                                    ?>

                                    <tr class="section-header" data-section="Values">
                                        <td colspan="3"><?= $translations['Values, Autonomy, and Responsibility'] ?></td>
                                    </tr>
                                    <?php
                                    $counter = 1;
                                    if (!empty($_SESSION['mission_edit']['Values'])) {
                                        foreach ($_SESSION['mission_edit']['Values'] as $outcome) {
                                            echo "<tr data-section='Values'>
                                        <td>v{$counter}</td>
                                        <td><input type='text' name='Values[]' placeholder='Enter outcome...' value='{$outcome}' id='v{$counter}'></td>
                                      </tr>";
                                            $counter++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="navigation-buttons">
                            <button type="submit" name="update" class="nav-button"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-1_Curriculum_Structure.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Program_Identification_and_General_Information.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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