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
    <title><?= $translations['Program Specification- Learning Resources, Facilities, and Equipment'] ?></title>
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
                // تحقق من وجود جميع الحقول
                if (
                    !empty($_POST['resources']) &&
                    !empty($_POST['facilities_equipment']) &&
                    !empty($_POST['procedures'])
                ) {

                    // تحقق من الاتصال
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // إعداد البيانات للإدخال
                    $resources = $conn->real_escape_string($_POST['resources']);
                    $facilities_equipment = $conn->real_escape_string($_POST['facilities_equipment']);
                    $procedures = $conn->real_escape_string($_POST['procedures']);

                    // تخزين البيانات في الجلسة
                    $_SESSION['facilities_new'] = [
                        'resources' => $resources,
                        'facilities_equipment' => $facilities_equipment,
                        'procedures' => $procedures
                    ];

                    // إدخال البيانات في قاعدة البيانات
                    $sql = "INSERT INTO learning_resources_facilities (user_id, resources, facilities_equipment, procedures, program_id)
                            VALUES ('$user_id', '$resources', '$facilities_equipment', '$procedures', '$program_id')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    $conn->close();
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Program_Specification_Learning_Resources_Facilities_and_Equipment.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST["next"])) {
                header(header: "location: Program_Specification_Program_Quality_Assurance.php?new=" . $program_name);
                exit;
            }
            if (isset($_POST["back"])) {
                header(header: "location: Program_Specification_Faculty_and_Administrative_Staff.php?new=" . $program_name);
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

                        <?php $program_action = "new"  ?>

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
                            <h2><?= $translations['Learning Resources,Facilities And Equipment'] ?></h2>
                            <div class="form-group">
                                <label for="Resources"><?= $translations['Learning Resources'] ?></label>
                                <textarea id="Resources" name="resources" placeholder="<?= $translations['Enter details...'] ?>"><?php echo isset($_SESSION['facilities_new']['resources']) ? $_SESSION['facilities_new']['resources'] : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Facilities-Equipment"><?= $translations['Facilities and Equipment'] ?></label>
                                <textarea id="Facilities-Equipment" name="facilities_equipment" placeholder="<?= $translations['Enter details...'] ?>"><?php echo isset($_SESSION['facilities_new']['facilities_equipment']) ? $_SESSION['facilities_new']['facilities_equipment'] : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Procedures"><?= $translations['Procedures to ensure a healthy and safe learning environment'] ?></label>
                                <textarea id="Procedures" name="procedures" placeholder="<?= $translations['Enter details...'] ?>"><?php echo isset($_SESSION['facilities_new']['procedures']) ? $_SESSION['facilities_new']['procedures'] : ''; ?></textarea>
                            </div>

                            <div class="navigation-buttons">
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Faculty_and_Administrative_Staff.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Program_Quality_Assurance.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save'] ?></button>

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

        // تحديد الـ id الذي سيتم تعديله
        $edit_item = $_POST['edit_item'] ?? ($_SESSION['facilities_edit']['id'] ?? ''); // استخدام القيمة المخزنة في الجلسة إذا كانت موجودة
        $row = null;

        // إذا كان هناك ID مختار للتعديل
        if (isset($_POST['edit_row']) && $_POST['edit_row'] === 'edit' && $edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM learning_resources_facilities WHERE id = '$edit_item' AND user_id = '$user_id'");
            if (mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                // تخزين البيانات في $_SESSION بعد جلبها من قاعدة البيانات
                $_SESSION['facilities_edit'] = $row;
                $_SESSION['facilities_edit']['id'] = $edit_item; // تخزين الـ id في الجلسة
            } else {
                $_SESSION['message'] = "No data found for the selected ID.";
            }
        }

        // التعامل مع التحديث
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            if (
                !empty($_POST['resources']) &&
                !empty($_POST['facilities_equipment']) &&
                !empty($_POST['procedures'])
            ) {
                $resources = $conn->real_escape_string($_POST['resources']);
                $facilities_equipment = $conn->real_escape_string($_POST['facilities_equipment']);
                $procedures = $conn->real_escape_string($_POST['procedures']);

                if (!empty($_POST['id'])) {
                    $update_id = intval($_POST['id']);
                    $sql = "UPDATE learning_resources_facilities 
                        SET resources = '$resources', facilities_equipment = '$facilities_equipment', procedures = '$procedures'
                        WHERE id = '$update_id' AND user_id = '$user_id'";

                    $message = ($conn->query($sql) === TRUE) ? 'Record updated successfully!' : 'Error updating record.';
                }

                $_SESSION['message'] = $message;
                // تخزين البيانات في $_SESSION بعد التحديث
                $_SESSION['facilities_edit'] = [
                    'resources' => $resources,
                    'facilities_equipment' => $facilities_equipment,
                    'procedures' => $procedures,
                    'id' => $update_id // تخزين الـ id في الجلسة
                ];

                header("location: Program_Specification_Learning_Resources_Facilities_and_Equipment.php?edit=" . $program_name);
                exit;
            } else {
                $_SESSION['message'] = 'All fields are required.';
            }
        }

        if (isset($_POST["next"])) {
            header("location: Program_Specification_Program_Quality_Assurance.php?edit=" . $program_name);
            exit;
        }
        if (isset($_POST["back"])) {
            header("location: Program_Specification_Faculty_and_Administrative_Staff.php?edit=" . $program_name);
            exit;
        }
    ?>

        <div class="container">
            <div class="sidebar">
                <div class="user-section"></div>
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

                    <label><?= $translations['Select an item to edit'] ?>:</label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select'] ?></option>
                        <?php
                        $query = "SELECT * FROM learning_resources_facilities WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                            echo "<option value='{$row_edit['id']}' $selected>{$row_edit['resources']}</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" name="edit_row" value="edit" class="button"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                    <div id="programs" class="form-container">
                        <h2><?= $translations['Learning Resources,Facilities And Equipment'] ?></h2>
                        <div class="form-group">
                            <label for="Resources"><?= $translations['Learning Resources'] ?></label>
                            <textarea id="Resources" name="resources" placeholder="<?= $translations['Enter details...'] ?>"><?= htmlspecialchars($_SESSION['facilities_edit']['resources'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Facilities-Equipment"><?= $translations['Facilities and Equipment'] ?></label>
                            <textarea id="Facilities-Equipment" name="facilities_equipment" placeholder="<?= $translations['Enter details...'] ?>"><?= htmlspecialchars($_SESSION['facilities_edit']['facilities_equipment'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Procedures"><?= $translations['Procedures to ensure a healthy and safe learning environment'] ?></label>
                            <textarea id="Procedures" name="procedures" placeholder="<?= $translations['Enter details...'] ?>"><?= htmlspecialchars($_SESSION['facilities_edit']['procedures'] ?? '') ?></textarea>
                        </div>

                        <div class="navigation-buttons">
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Faculty_and_Administrative_Staff.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Program_Quality_Assurance.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="submit" name="update" class="nav-button"><?= $translations['Update'] ?></button>
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