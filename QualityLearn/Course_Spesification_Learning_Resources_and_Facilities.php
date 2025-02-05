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
    <title><?= $translations['Learning Resources And Facilities']?></title>
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


        .content-container {
            width: 98%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .content-container h2 {
            margin-bottom: 0px;
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


        .table {
            width: 95%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            margin-bottom: 20px;
            border-radius: 7px;
            overflow: hidden;

        }

        .table th,
        .table td {
            border: 1px solid #003f8a;
        }

        td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 3px;
            font-size: 15px;
            background-color: #f2f7fc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th {
            background: linear-gradient(to right, #003f8a, #0057b7);
            color: white;
            font-weight: 200;
            height: 40px;
            width: 30%;
            font-size: 15px;
            border: 1px solid #003f8a;
            text-align: center;
        }

        td input[type="text"] {
            width: 90%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
                // استلام البيانات من النموذج
                $essential_references = trim($_POST['essential_references']);
                $supportive_references = trim($_POST['supportive_references']);
                $electronic_materials = trim($_POST['electronic_materials']);
                $other_learning_materials = trim($_POST['other_learning_materials']);
                $facilities = trim($_POST['facilities']);
                $technology_equipment = trim($_POST['technology_equipment']);
                $other_equipment = trim($_POST['other_equipment']);

                // التحقق من أن جميع الحقول ممتلئة
                if (
                    !empty($essential_references) &&
                    !empty($supportive_references) &&
                    !empty($electronic_materials) &&
                    !empty($other_learning_materials) &&
                    !empty($facilities) &&
                    !empty($technology_equipment) &&
                    !empty($other_equipment)
                ) {
                    // تخزين البيانات في الـ SESSION
                    $_SESSION['specification_learning_resources_new'] = [
                        'essential_references' => $essential_references,
                        'supportive_references' => $supportive_references,
                        'electronic_materials' => $electronic_materials,
                        'other_learning_materials' => $other_learning_materials,
                        'facilities' => $facilities,
                        'technology_equipment' => $technology_equipment,
                        'other_equipment' => $other_equipment
                    ];

                    // التحقق من الاتصال
                    if ($conn->connect_error) {
                        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
                    }

                    // إدخال البيانات في الجدول
                    $stmt = $conn->prepare("
                    INSERT INTO learning_resources (
                        user_id, essential_references, supportive_references, electronic_materials, other_learning_materials,
                        facilities, technology_equipment, other_equipment, program_id
                    ) VALUES (?,?,?,?,?,?,?,?,?)
                ");
                    $stmt->bind_param(
                        "isssssssi",
                        $user_id,
                        $essential_references,
                        $supportive_references,
                        $electronic_materials,
                        $other_learning_materials,
                        $facilities,
                        $technology_equipment,
                        $other_equipment,
                        $program_id
                    );

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Course_Spesification_Learning_Resources_and_Facilities.php?new=" . $program_name);
                exit;
            }

            // عندما يتم تحميل الصفحة، استرجاع البيانات من الـ SESSION (إذا كانت موجودة)
            $specification_learning_resources_new = isset($_SESSION['specification_learning_resources_new']) ? $_SESSION['specification_learning_resources_new'] : [];

    ?>
            <div class="container">
                <div class="sidebar">
                <a href="Course_Specification.php?new=<?php echo $program_name ?>"><button><?= $translations['Courses'] ?></button></a>
                    <a href="Course_Specification_General_Info_About_The_Course.php?new=<?php echo $program_name ?>"><button><?= $translations['General Information About The Course'] ?></button></a>
                    <a href="Course_Specification_Course_Learning_Outcomes.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Learning Outcomes'] ?></button></a>
                    <a href="Course_Specification_Course_Content.php?new=<?php echo $program_name ?>"><button><?= $translations['Course Content'] ?></button></a>
                    <a href="Course_Spesification_Students_Assessment_Activities.php?new=<?php echo $program_name ?>"><button><?= $translations['Student Assessment Activity'] ?></button></a>
                    <a href="Course_Spesification_Learning_Resources_and_Facilities.php?new=<?php echo $program_name ?>"><button><?= $translations['Learning Resources And Facilities'] ?></button></a>
                    <a href="Course_Spesification_Assessment_Of_Course_Quality.php?new=<?php echo $program_name ?>"><button><?= $translations['Assessment Of Course Quality'] ?></button></a>
                    <a href="Course_Spesification_Specification_Approval.php?new=<?php echo $program_name ?>"><button><?= $translations['Specification Approval'] ?></button></a>
                </div>

                <div class="main">
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
                        <div class="content-container">
                            <h2><?= $translations['Learning Resources and Facilities']?></h2>
                            <h3><?= $translations['References and Learning Resources']?></h3>
                            <table class="table">

                                <tr>
                                    <th><?= $translations['Essential References']?></th>
                                    <td><input type="text" name="essential_references" value="<?php echo isset($specification_learning_resources_new['essential_references']) ? $specification_learning_resources_new['essential_references'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <th><?= $translations['Supportive References']?></th>
                                    <td><input type="text" name="supportive_references" value="<?php echo isset($specification_learning_resources_new['supportive_references']) ? $specification_learning_resources_new['supportive_references'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <th><?= $translations['Electronic Materials']?></th>
                                    <td><input type="text" name="electronic_materials" value="<?php echo isset($specification_learning_resources_new['electronic_materials']) ? $specification_learning_resources_new['electronic_materials'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <th><?= $translations['Other Learning Materials']?></th>
                                    <td><input type="text" name="other_learning_materials" value="<?php echo isset($specification_learning_resources_new['other_learning_materials']) ? $specification_learning_resources_new['other_learning_materials'] : ''; ?>"></td>
                                </tr>
                            </table>

                            <h3><?= $translations['Required Facilities and Equipment']?></h3>
                            <table class="table">
                                <tr>
                                    <th><?= $translations['Items']?></th>
                                    <th><?= $translations['Resources']?></th>
                                </tr>
                                <tr>
                                    <td><?= $translations['Facilities (Classrooms, laboratories, exhibition rooms, simulation rooms, etc.)']?></td>
                                    <td><input type="text" name="facilities" value="<?php echo isset($specification_learning_resources_new['facilities']) ? $specification_learning_resources_new['facilities'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Technology equipment (projector, smart board, software)']?></td>
                                    <td><input type="text" name="technology_equipment" value="<?php echo isset($specification_learning_resources_new['technology_equipment']) ? $specification_learning_resources_new['technology_equipment'] : ''; ?>"></td>
                                </tr>
                                <tr>
                                    <td><?= $translations['Other equipment (depending on the nature of the specialty)']?></td>
                                    <td><input type="text" name="other_equipment" value="<?php echo isset($specification_learning_resources_new['other_equipment']) ? $specification_learning_resources_new['other_equipment'] : ''; ?>"></td>
                                </tr>
                            </table>

                            <div class="navigation-buttons">
                                <button name="save" class="nav-button" type="submit"><?= $translations['Save']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Assessment_Of_Course_Quality.php?new=<?= $program_name ?>')"><?= $translations['Next']?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Students_Assessment_Activities.php?new=<?= $program_name ?>')"><?= $translations['Back']?></button>
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

        $edit_item = $_POST['edit_item'] ?? ($_SESSION['specification_learning_resources_edit']['id'] ?? '');

        // إذا تم اختيار عنصر من القائمة المنسدلة
        if (!empty($edit_item)) {
            $query = mysqli_query($conn, "SELECT * FROM learning_resources WHERE id = '$edit_item' AND user_id = '$user_id'");
            if ($query && mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);

                // تعبئة الحقول بالبيانات
                $essential_references = $row['essential_references'];
                $supportive_references = $row['supportive_references'];
                $electronic_materials = $row['electronic_materials'];
                $other_learning_materials = $row['other_learning_materials'];
                $facilities = $row['facilities'];
                $technology_equipment = $row['technology_equipment'];
                $other_equipment = $row['other_equipment'];

                // حفظ البيانات في $_SESSION لتظل موجودة بعد التعديل
                $_SESSION['specification_learning_resources_edit'] = [
                    'id' => $edit_item,
                    'essential_references' => $essential_references,
                    'supportive_references' => $supportive_references,
                    'electronic_materials' => $electronic_materials,
                    'other_learning_materials' => $other_learning_materials,
                    'facilities' => $facilities,
                    'technology_equipment' => $technology_equipment,
                    'other_equipment' => $other_equipment
                ];
            }
        }

        // عند تحديث البيانات
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            // استلام البيانات المعدلة
            $essential_references = trim($_POST['essential_references']);
            $supportive_references = trim($_POST['supportive_references']);
            $electronic_materials = trim($_POST['electronic_materials']);
            $other_learning_materials = trim($_POST['other_learning_materials']);
            $facilities = trim($_POST['facilities']);
            $technology_equipment = trim($_POST['technology_equipment']);
            $other_equipment = trim($_POST['other_equipment']);
            $edit_item = $_POST['id'];  // الحصول على الـ ID من الـ POST

            // التحقق من إدخال كل الحقول
            if (
                !empty($essential_references) &&
                !empty($supportive_references) &&
                !empty($electronic_materials) &&
                !empty($other_learning_materials) &&
                !empty($facilities) &&
                !empty($technology_equipment) &&
                !empty($other_equipment)
            ) {
                // تحديث الصف
                $stmt = $conn->prepare("
                UPDATE learning_resources
                SET
                    essential_references = ?,
                    supportive_references = ?,
                    electronic_materials = ?,
                    other_learning_materials = ?,
                    facilities = ?,
                    technology_equipment = ?,
                    other_equipment = ?
                WHERE id = ? AND user_id = ?
            ");
                $stmt->bind_param(
                    "ssssssssi",
                    $essential_references,
                    $supportive_references,
                    $electronic_materials,
                    $other_learning_materials,
                    $facilities,
                    $technology_equipment,
                    $other_equipment,
                    $edit_item,
                    $user_id
                );

                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Records updated successfully!';
                    // تحديث الـ session بعد التعديل
                    $_SESSION['specification_learning_resources_edit'] = [
                        'id' => $edit_item,
                        'essential_references' => $essential_references,
                        'supportive_references' => $supportive_references,
                        'electronic_materials' => $electronic_materials,
                        'other_learning_materials' => $other_learning_materials,
                        'facilities' => $facilities,
                        'technology_equipment' => $technology_equipment,
                        'other_equipment' => $other_equipment
                    ];
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }

                header("location: Course_Spesification_Learning_Resources_and_Facilities.php?edit=" . $program_name);
                exit;
            } else {
                $_SESSION['message'] = "Please fill in all fields.";
            }
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

            <div class="main">
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

                    <label><?= $translations['Select an item to edit']?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select']?></option>
                        <?php
                        // استعلام لجلب جميع الخيارات
                        $query = "SELECT * FROM learning_resources WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);

                        // عرض الخيارات
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                            echo "<option value='{$row_edit['id']}' $selected>{$row_edit['essential_references']}</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit']?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                    <div class="content-container">
                        <h2><?= $translations['Learning Resources and Facilities']?></h2>
                        <h3><?= $translations['References and Learning Resources']?></h3>
                        <table class="table">
                            <tr>
                                <th><?= $translations['Essential References']?></th>
                                <td><input type="text" value="<?= htmlspecialchars($essential_references ?? $_SESSION['specification_learning_resources_edit']['essential_references'] ?? '') ?>" name="essential_references"></td>
                            </tr>
                            <tr>
                                <th><?= $translations['Supportive References']?></th>
                                <td><input type="text" value="<?= htmlspecialchars($supportive_references ?? $_SESSION['specification_learning_resources_edit']['supportive_references'] ?? '') ?>" name="supportive_references"></td>
                            </tr>
                            <tr>
                                <th><?= $translations['Electronic Materials']?></th>
                                <td><input type="text" value="<?= htmlspecialchars($electronic_materials ?? $_SESSION['specification_learning_resources_edit']['electronic_materials'] ?? '') ?>" name="electronic_materials"></td>
                            </tr>
                            <tr>
                                <th><?= $translations['Other Learning Materials']?></th>
                                <td><input value="<?= htmlspecialchars($other_learning_materials ?? $_SESSION['specification_learning_resources_edit']['other_learning_materials'] ?? '') ?>" type="text" name="other_learning_materials"></td>
                            </tr>
                        </table>



                        <h3><?= $translations['Required Facilities and Equipment']?></h3>
                        <table class="table">
                            <tr>
                                <th><?= $translations['Items']?></th>
                                <th><?= $translations['Resources']?></th>
                            </tr>
                            <tr>
                                <td><?= $translations['Facilities (Classrooms, laboratories, exhibition rooms, simulation rooms, etc.)']?></td>
                                <td><input value="<?= htmlspecialchars($facilities ?? $_SESSION['specification_learning_resources_edit']['facilities'] ?? '') ?>" type="text" name="facilities"></td>
                            </tr>
                            <tr>
                                <td><?= $translations['Technology equipment (projector, smart board, software)']?></td>
                                <td><input value="<?= htmlspecialchars($technology_equipment ?? $_SESSION['specification_learning_resources_edit']['technology_equipment'] ?? '') ?>" type="text" name="technology_equipment"></td>
                            </tr>
                            <tr>
                                <td><?= $translations['Other equipment (depending on the nature of the specialty)']?></td>
                                <td><input value="<?= htmlspecialchars($other_equipment ?? $_SESSION['specification_learning_resources_edit']['other_equipment'] ?? '') ?>" type="text" name="other_equipment"></td>
                            </tr>
                        </table>

                        <div class="navigation-buttons">

                            <button name="update" class="nav-button" type="submit"><?= $translations['Update']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Assessment_Of_Course_Quality.php?edit=<?= $program_name ?>')"><?= $translations['Next']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Students_Assessment_Activities.php?edit=<?= $program_name ?>')"><?= $translations['Back']?></button>
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