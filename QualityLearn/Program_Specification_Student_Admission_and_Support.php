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
    <title><?= $translations['Program Specification-Student Admission and Support'] ?></title>
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
            height: 136vh;
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

            // Check if the form is being submitted
            if (isset($_POST['save'])) {
                // Get form data
                $admission_requirements = $_POST['admission_requirements'];
                $orientation_programs = $_POST['orientation_programs'];
                $counseling_services = $_POST['counseling_services'];
                $special_support = $_POST['special_support'];

                // Save data to session for pre-filling form on next page load
                $_SESSION['admission_new'] = [
                    'admission_requirements' => $admission_requirements,
                    'orientation_programs' => $orientation_programs,
                    'counseling_services' => $counseling_services,
                    'special_support' => $special_support
                ];

                // Ensure all fields are filled out
                if (!empty($admission_requirements) && !empty($orientation_programs) && !empty($counseling_services) && !empty($special_support)) {
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Insert data into the database
                    $sql = "INSERT INTO student_admission_support (user_id, admission_requirements, orientation_programs, counseling_services, special_support, program_id)
                        VALUES ('$user_id', '$admission_requirements', '$orientation_programs', '$counseling_services', '$special_support', '$program_id')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Program_Specification_Student_Admission_and_Support.php?new=" . $program_name);
                exit;
            }

            // If "Next" button is clicked
            if (isset($_POST["next"])) {
                header("location: Program_Specification_Faculty_and_Administrative_Staff.php?new=" . $program_name);
                exit;
            }

            // If "Back" button is clicked
            if (isset($_POST["back"])) {
                header("location: Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?new=" . $program_name);
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

                        // Retrieve form data from session for pre-filling the inputs
                        $admission_new = isset($_SESSION['admission_new']) ? $_SESSION['admission_new'] : [];
                        ?>

                        <div id="programs" class="form-container">
                            <h2><?= $translations['Student Admission and Support'] ?></h2>

                            <div class="form-group">
                                <label for="admission-requirements"><?= $translations['Student Admission Requirements'] ?></label>
                                <textarea id="admission-requirements" name="admission_requirements" placeholder="<?= $translations['Enter details...'] ?>"><?php echo htmlspecialchars($admission_new['admission_requirements'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="orientation-programs"><?= $translations['Guidance and Orientation Programs for New Students'] ?></label>
                                <textarea id="orientation-programs" name="orientation_programs" placeholder="<?= $translations['Enter details...'] ?>"><?php echo htmlspecialchars($admission_new['orientation_programs'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="counseling-services"><?= $translations['Student Counseling Services'] ?></label>
                                <textarea id="counseling-services" name="counseling_services" placeholder="<?= $translations['Enter details...'] ?>"><?php echo htmlspecialchars($admission_new['counseling_services'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="special-support"><?= $translations['Special Support'] ?></label>
                                <textarea id="special-support" name="special_support" placeholder="<?= $translations['Enter details...'] ?>"><?php echo htmlspecialchars($admission_new['special_support'] ?? ''); ?></textarea>
                            </div>

                            <div class="navigation-buttons">
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Faculty_and_Administrative_Staff.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>

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
        $edit_item = $_POST['edit_item'] ?? '';

        if (isset($_POST['edit_item']) && !$edit_item) {
            // إذا تم الضغط على Edit ولم يكن هناك ID، اعرض البيانات القديمة من الجلسة
            $edit_item = $_SESSION['admission_edit']['edit_item'] ?? '';
        }

        if (isset($_POST['edit_item']) && $edit_item) {
            // استعلام لجلب البيانات الخاصة بالـ id المختار
            $query = mysqli_query($conn, "SELECT * FROM student_admission_support WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);

            // تعبئة الحقول بالقيم الموجودة في قاعدة البيانات
            $_SESSION['admission_edit'] = [
                'edit_item' => $edit_item, // حفظ id العنصر الذي تم اختياره
                'admission_requirements' => $row["admission_requirements"] ?? '',
                'orientation_programs' => $row["orientation_programs"] ?? '',
                'counseling_services' => $row["counseling_services"] ?? '',
                'special_support' => $row["special_support"] ?? ''
            ];
        }

        if (isset($_POST['update'])) {
            // الحصول على البيانات من الفورم
            $admission_requirements = $_POST['admission_requirements'];
            $orientation_programs = $_POST['orientation_programs'];
            $counseling_services = $_POST['counseling_services'];
            $special_support = $_POST['special_support'];

            // التحقق من وجود جميع الحقول
            if (!empty($admission_requirements) && !empty($orientation_programs) && !empty($counseling_services) && !empty($special_support)) {
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // التحقق من إذا كان سيتم إدخال أو تعديل البيانات
                if (!empty($edit_item)) {
                    // تحديث البيانات في قاعدة البيانات
                    $sql = "UPDATE student_admission_support SET
                    admission_requirements = '$admission_requirements',
                    orientation_programs = '$orientation_programs',
                    counseling_services = '$counseling_services',
                    special_support = '$special_support'
                    WHERE id = '$edit_item' AND user_id = '$user_id'";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['message'] = 'Record updated successfully!';
                        // تحديث البيانات في الـ session بعد التحديث
                        $_SESSION['admission_edit'] = [
                            'edit_item' => $edit_item,
                            'admission_requirements' => $admission_requirements,
                            'orientation_programs' => $orientation_programs,
                            'counseling_services' => $counseling_services,
                            'special_support' => $special_support
                        ];
                    } else {
                        $_SESSION['message'] = 'Error occurred while updating data.';
                    }
                }
            } else {
                echo "Please fill in all fields.";
            }

            header("location: Program_Specification_Student_Admission_and_Support.php?edit=" . $program_name);
            exit;
        }

        // باقي الكود الخاص بالـ navigation و redirect...

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

                <form method="post" id="coursesForm">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <!-- عرض الاختيارات من جدول البرامج -->
                    <label><?= $translations['Select an item to edit'] ?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select'] ?></option>
                        <?php
                        // عرض الخيارات
                        $query = "SELECT * FROM student_admission_support WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                            echo "<option value='{$row_edit['id']}' $selected>{$row_edit['admission_requirements']}</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>">

                    <div id="programs" class="form-container">
                        <h2><?= $translations['Student Admission and Support'] ?></h2>
                        <div class="form-group">
                            <label for="admission-requirements"><?= $translations['Student Admission Requirements'] ?></label>
                            <textarea id="admission-requirements" name="admission_requirements"><?= htmlspecialchars($_SESSION['admission_edit']['admission_requirements'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="orientation-programs"><?= $translations['Guidance and Orientation Programs for New Students'] ?></label>
                            <textarea id="orientation-programs" name="orientation_programs"><?= htmlspecialchars($_SESSION['admission_edit']['orientation_programs'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="counseling-services"><?= $translations['Student Counseling Services'] ?></label>
                            <textarea id="counseling-services" name="counseling_services"><?= htmlspecialchars($_SESSION['admission_edit']['counseling_services'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="special-support"><?= $translations['Special Support'] ?></label>
                            <textarea id="special-support" name="special_support"><?= htmlspecialchars($_SESSION['admission_edit']['special_support'] ?? '') ?></textarea>
                        </div>

                        <div class="navigation-buttons">
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Curriculum-3_Program_learning_Outcomes_Mapping_Matrix.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Program_Specification_Faculty_and_Administrative_Staff.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="submit" name="update" class="button"><?= $translations['Update'] ?></button>

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


    <?php
        // نهاية الكود...
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