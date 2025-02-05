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
    <title><?= $translations['Annual Program Report-Programs']?></title>

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
            height: 250vh;
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

        .sidebar button:hover,
        .sidebar button.active {
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

        .header-text {
            text-align: center;
            margin-top: 0px;
        }

        .header-text h3 {
            color: #003f8a;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin-bottom: 5px;
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

        .form-container {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-container label {
            flex: 1 0 30%;
        }

        .form-container input {
            flex: 2 0 60%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .logout-button {
            background: #003f8a;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #0057b7;
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

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
                // استلام المدخلات
                $_SESSION['programs_new'] = [
                    'program' => trim($_POST['program']),
                    'program_code' => trim($_POST['program_code']),
                    'qualification_level' => trim($_POST['qualification_level']),
                    'department' => trim($_POST['department']),
                    'college' => trim($_POST['college']),
                    'institution' => trim($_POST['institution']),
                    'academic_year' => trim($_POST['academic_year']),
                    'main_location' => trim($_POST['main_location']),
                    'branches' => trim($_POST['branches']),
                ];

                // التحقق من أن جميع الحقول غير فارغة
                if (
                    !empty($_SESSION['programs_new']['program']) && !empty($_SESSION['programs_new']['program_code']) && !empty($_SESSION['programs_new']['qualification_level']) &&
                    !empty($_SESSION['programs_new']['department']) && !empty($_SESSION['programs_new']['college']) && !empty($_SESSION['programs_new']['institution']) &&
                    !empty($_SESSION['programs_new']['academic_year']) && !empty($_SESSION['programs_new']['main_location']) && !empty($_SESSION['programs_new']['branches'])
                ) {
                    // التحقق من الاتصال
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $annual_program_name = $_SESSION['programs_new']['program']; // التأكد من أن القيمة غير فارغة
                    if (empty($annual_program_name)) {
                        $_SESSION['message'] = 'Program Name cannot be empty';
                        header("location: Annual_Program_Report_Programs.php?new=" . $program_name);
                        exit;
                    }

                    // إدخال البيانات
                    $stmt = $conn->prepare("INSERT INTO annunal_programs (user_id, program_name, program_code, qualification_level, department, college, institution, academic_year, main_location, branches, program_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssssssssi", $user_id, $annual_program_name, $_SESSION['programs_new']['program_code'], $_SESSION['programs_new']['qualification_level'], $_SESSION['programs_new']['department'], $_SESSION['programs_new']['college'], $_SESSION['programs_new']['institution'], $_SESSION['programs_new']['academic_year'], $_SESSION['programs_new']['main_location'], $_SESSION['programs_new']['branches'], $program_id);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Annual_Program_Report_Programs.php?new=" . $program_name);
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
                    <a href="Annual_Program_Report_Programs.php?new=<?php echo $program_name ?>"><button><?= $translations['Programs']?></button></a>
                    <a href="ProgramStatistics.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Statistics']?></button></a>
                    <a href="PLOs.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Assessment']?></button></a>
                    <a href="Program_KPIs_Table.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Key Performance Indicators (KPIs)']?></button></a>
                    <a href="Annual_Program_Report_Challenges&Difficulties.php?new=<?php echo $program_name ?>"><button><?= $translations['Challenges and Difficulties']?></button></a>
                    <a href="Annual_Program_Report_Program_Devalopment_Plan.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Development Plan']?></button></a>
                    <a href="Annual_Program_Report_Approval_Of_Annual_Program_Report.php?new=<?php echo $program_name ?>"><button><?= $translations['Approval of Annual Program Report']?></button></a>
                </div>

                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Annual Program Report']?></h3>

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
                            <h2><?= $translations['Program Specification']?></h2>
                            <div class="form-group">
                                <label for="program"><?= $translations['Program']?>:</label>
                                <input type="text" id="program" name="program" placeholder="<?= $translations['Enter Program Name']?>" value="<?php echo isset($_SESSION['programs_new']['program']) ? $_SESSION['programs_new']['program'] : $program_repeat; ?>">

                                <label for="program-code"><?= $translations['Program Code']?>:</label>
                                <input type="text" id="program-code" name="program_code" placeholder="<?= $translations['Enter Program Code']?>" value="<?php echo isset($_SESSION['programs_new']['program_code']) ? $_SESSION['programs_new']['program_code'] : ''; ?>">

                                <label for="qualification-level"><?= $translations['Qualification Level']?>:</label>
                                <input type="text" id="qualification-level" name="qualification_level" placeholder="<?= $translations['Enter Qualification Level']?>" value="<?php echo isset($_SESSION['programs_new']['qualification_level']) ? $_SESSION['programs_new']['qualification_level'] : ''; ?>">

                                <label for="department"><?= $translations['Department']?>:</label>
                                <input type="text" id="department" name="department" placeholder="<?= $translations['Enter Department Name']?>" value="<?php echo isset($_SESSION['programs_new']['department']) ? $_SESSION['programs_new']['department'] : $department_repeat; ?>">

                                <label for="college"><?= $translations['College']?>:</label>
                                <input type="text" id="college" name="college" placeholder="<?= $translations['Enter College Name']?>" value="<?php echo isset($_SESSION['programs_new']['college']) ? $_SESSION['programs_new']['college'] : $college_repeat; ?>">

                                <label for="institution"><?= $translations['Institution']?>:</label>
                                <input type="text" id="institution" name="institution" placeholder="<?= $translations['Enter Institution Name']?>" value="<?php echo isset($_SESSION['programs_new']['institution']) ? $_SESSION['programs_new']['institution'] : $institution_repeat; ?>">

                                <label for="academic-year"><?= $translations['Academic Year']?>:</label>
                                <input type="text" id="academic-year" name="academic_year" placeholder="<?= $translations['Enter the Academic Year of the Report']?>" value="<?php echo isset($_SESSION['programs_new']['academic_year']) ? $_SESSION['programs_new']['academic_year'] : ''; ?>">

                                <label for="main-location"><?= $translations['Main Location']?>:</label>
                                <input type="text" id="main-location" name="main_location" placeholder="<?= $translations['Enter the Main Location of the Program']?>" value="<?php echo isset($_SESSION['programs_new']['main_location']) ? $_SESSION['programs_new']['main_location'] : ''; ?>">

                                <label for="branches"><?= $translations['Branches Offering the Program']?>:</label>
                                <input type="text" id="branches" name="branches" placeholder="<?= $translations['Enter Branches Offering the Program']?>" value="<?php echo isset($_SESSION['programs_new']['branches']) ? $_SESSION['programs_new']['branches'] : ''; ?>">
                            </div>

                        </div>

                        <div class="navigation-buttons">
                            <button name="save" class="nav-button" type="submit"><?= $translations['Save']?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('ProgramStatistics.php?new=<?= $program_name ?>')"><?= $translations['Next']?></button>
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
    } ?>



    <?php
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // جلب معرف البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // استعلام للحصول على جميع الخيارات في القائمة
        $query = "SELECT * FROM annunal_programs WHERE program_id = '$program_id' AND user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        // معالجة اختيار عنصر للتعديل
        if (isset($_POST['edit_row']) && !empty($_POST['edit_item'])) {
            $edit_item = $_POST['edit_item'];

            // جلب البيانات الخاصة بالعنصر المختار
            $query = "SELECT * FROM annunal_programs WHERE id = '$edit_item' AND user_id = '$user_id'";
            $result_item = mysqli_query($conn, $query);

            if ($row = mysqli_fetch_assoc($result_item)) {
                // وضع البيانات في الجلسة ليتم عرضها في الفورم
                $_SESSION['programs_edit'] = [
                    'id' => $row['id'], // تأكد من تضمين الـ id هنا
                    'program' => $row['program_name'],
                    'program_code' => $row['program_code'],
                    'qualification_level' => $row['qualification_level'],
                    'department' => $row['department'],
                    'college' => $row['college'],
                    'institution' => $row['institution'],
                    'academic_year' => $row['academic_year'],
                    'main_location' => $row['main_location'],
                    'branches' => $row['branches']
                ];
            } else {
                $_SESSION['message'] = 'No data found for the selected item.';
            }
        }

        // معالجة تحديث البيانات
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            $edit_item = $_POST['id']; // معرف العنصر المراد تعديله

            // استلام المدخلات
            $program = trim($_POST['program']);
            $program_code = trim($_POST['program_code']);
            $qualification_level = trim($_POST['qualification_level']);
            $department = trim($_POST['department']);
            $college = trim($_POST['college']);
            $institution = trim($_POST['institution']);
            $academic_year = trim($_POST['academic_year']);
            $main_location = trim($_POST['main_location']);
            $branches = trim($_POST['branches']);

            // التحقق من أن جميع الحقول غير فارغة
            if (
                !empty($program) && !empty($program_code) && !empty($qualification_level) &&
                !empty($department) && !empty($college) && !empty($institution) &&
                !empty($academic_year) && !empty($main_location) && !empty($branches)
            ) {
                // استعلام التحديث
                $stmt = $conn->prepare("UPDATE annunal_programs SET program_name = ?, program_code = ?, qualification_level = ?, department = ?, college = ?, institution = ?, academic_year = ?, main_location = ?, branches = ? WHERE id = ?");
                $stmt->bind_param("sssssssssi", $program, $program_code, $qualification_level, $department, $college, $institution, $academic_year, $main_location, $branches, $edit_item);

                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Record updated successfully!';
                } else {
                    $_SESSION['message'] = 'Error occurred while updating the record.';
                }

                // بعد التحديث، إعادة تعيين الجلسة لتحتفظ بالبيانات المعدلة
                $_SESSION['programs_edit'] = [
                    'id' => $edit_item, // تأكد من الاحتفاظ بالـ id
                    'program' => $program,
                    'program_code' => $program_code,
                    'qualification_level' => $qualification_level,
                    'department' => $department,
                    'college' => $college,
                    'institution' => $institution,
                    'academic_year' => $academic_year,
                    'main_location' => $main_location,
                    'branches' => $branches
                ];

                // التوجيه لصفحة التعديل مع الحفاظ على البيانات في الجلسة
                header("location: Annual_Program_Report_Programs.php?edit=" . $program_name);
                exit;
            } else {
                $_SESSION['message'] = 'Please fill in all fields.';
            }
        }
    ?>

        <div class="container">
            <div class="sidebar">
                <div class="user-section">
                </div>
                <a href="Annual_Program_Report_Programs.php?edit=<?php echo $program_name ?>"><button><?= $translations['Programs']?></button></a>
                    <a href="ProgramStatistics.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Statistics']?></button></a>
                    <a href="PLOs.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Assessment']?></button></a>
                    <a href="Program_KPIs_Table.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Key Performance Indicators (KPIs)']?></button></a>
                    <a href="Annual_Program_Report_Challenges&Difficulties.php?edit=<?php echo $program_name ?>"><button><?= $translations['Challenges and Difficulties']?></button></a>
                    <a href="Annual_Program_Report_Program_Devalopment_Plan.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Development Plan']?></button></a>
                    <a href="Annual_Program_Report_Approval_Of_Annual_Program_Report.php?edit=<?php echo $program_name ?>"><button><?= $translations['Approval of Annual Program Report']?></button></a>
            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <h3><?= $translations['Annual Program Report']?></h3>

                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                <form method="post">

                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <!-- استعلام لجلب جميع الخيارات -->
                    <label><?= $translations['Select an item to edit']?></label>
                    <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                        <option value=""><?= $translations['Select']?></option>
                        <?php
                        while ($row_edit = mysqli_fetch_assoc($result)) {
                            $selected = ($row_edit['id'] == $_SESSION['programs_edit']['id']) ? 'selected' : '';
                            echo "<option value='{$row_edit['id']}' $selected>{$row_edit['program_name']}</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit']?></button>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['programs_edit']['id'] ?? '') ?>">

                    <div id="coursesForm" class="form-container">
                        <h2><?= $translations['Program Specification']?></h2>
                        <div class="form-group">
                            <label for="program"><?= $translations['Program']?>:</label>
                            <input type="text" id="program" name="program" value="<?= htmlspecialchars($_SESSION['programs_edit']['program'] ?? '') ?>">

                            <label for="program-code"><?= $translations['Program Code']?>:</label>
                            <input type="text" id="program-code" name="program_code" value="<?= htmlspecialchars($_SESSION['programs_edit']['program_code'] ?? '') ?>">

                            <label for="qualification-level"><?= $translations['Qualification Level']?>:</label>
                            <input type="text" id="qualification-level" name="qualification_level" value="<?= htmlspecialchars($_SESSION['programs_edit']['qualification_level'] ?? '') ?>" >

                            <label for="department"><?= $translations['Department']?>:</label>
                            <input type="text" id="department" name="department" value="<?= htmlspecialchars($_SESSION['programs_edit']['department'] ?? '') ?>">

                            <label for="college"><?= $translations['College']?>:</label>
                            <input type="text" id="college" name="college" value="<?= htmlspecialchars($_SESSION['programs_edit']['college'] ?? '') ?>" >

                            <label for="institution"><?= $translations['Institution']?>:</label>
                            <input type="text" id="institution" name="institution" value="<?= htmlspecialchars($_SESSION['programs_edit']['institution'] ?? '') ?>" >

                            <label for="academic-year"><?= $translations['Academic Year']?>:</label>
                            <input type="text" id="academic-year" name="academic_year" value="<?= htmlspecialchars($_SESSION['programs_edit']['academic_year'] ?? '') ?>" >

                            <label for="main-location"><?= $translations['Main Location']?>:</label>
                            <input type="text" id="main-location" name="main_location" value="<?= htmlspecialchars($_SESSION['programs_edit']['main_location'] ?? '') ?>" >

                            <label for="branches"><?= $translations['Branches Offering the Program']?>:</label>
                            <input type="text" id="branches" name="branches" value="<?= htmlspecialchars($_SESSION['programs_edit']['branches'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="navigation-buttons">
                        <button name="update" class="nav-button" type="submit"><?= $translations['Update']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('ProgramStatistics.php?edit=<?= $program_name ?>')"><?= $translations['Next']?></button>
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