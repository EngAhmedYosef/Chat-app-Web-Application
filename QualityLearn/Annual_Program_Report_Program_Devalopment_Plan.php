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
    <title><?= $translations['Annual Program Report-Program Development Plan'] ?></title>
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

        /* Container Layout */
        .container {
            display: flex;
            flex-direction: row;
            height: 250vh;
        }

        /* Sidebar Styling */
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

        /* Main Content */
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

        .header-text p {
            color: #003f8a;
            font-size: 15px;
            font-weight: 200;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin: 0;
            /* يمنع أي مسافة إضافية */
        }

        .table-container {
            width: 100%;
            margin-top: 30px;
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 90%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            margin-bottom: 20px;
            border-radius: 7px;
            overflow: hidden;
            text-align: center;
        }

        table th,
        table td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 10px;
            font-size: 14px;
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

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table td input {
            width: 95%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            text-align: center;
        }

        table td input:focus {
            border-color: #00509e;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 80, 158, 0.5);
        }

        .notes {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
            line-height: 1.6;
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

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                // الحصول على المدخلات من الفورم
                $priorities = $_POST['priorities']; // مصفوفة تحتوي على الأولويات
                $actions = $_POST['actions']; // مصفوفة تحتوي على الإجراءات
                $responsibilities = $_POST['responsibilities']; // مصفوفة تحتوي على المسؤوليات

                // تأكد من أن جميع الحقول قد تم ملؤها
                if (count($priorities) == 6 && count($actions) == 6 && count($responsibilities) == 6) {
                    // تحويل البيانات إلى JSON
                    $data = json_encode([
                        'priorities' => $priorities,
                        'actions' => $actions,
                        'responsibilities' => $responsibilities
                    ]);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // إدخال البيانات في قاعدة البيانات
                    $stmt = $conn->prepare("INSERT INTO program_development_plan (user_id, program_id, data) VALUES (?, ?, ?)");
                    $stmt->bind_param("iis", $user_id, $program_id, $data); // تأكد من ملء $user_id و $program_id بالقيم المناسبة
                    $stmt->execute();

                    $_SESSION['message'] = 'Records created successfully!';
                    unset($_SESSION['plane_new']); // Clear the form data from session after successful save
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                // Store form data in session to retain it for repopulating the inputs
                $_SESSION['plane_new'] = [
                    'priorities' => $priorities,
                    'actions' => $actions,
                    'responsibilities' => $responsibilities
                ];

                header("location: Annual_Program_Report_Program_Devalopment_Plan.php?new=" . $program_name);
                exit;
            }

            // Fetch the form data from session if available
            $plane_new = isset($_SESSION['plane_new']) ? $_SESSION['plane_new'] : [
                'priorities' => ['', '', '', '', '', ''],
                'actions' => ['', '', '', '', '', ''],
                'responsibilities' => ['', '', '', '', '', '']
            ];
    ?>

            <div class="container">
                <!-- Sidebar -->
                <div class="sidebar">
                    <a href="Annual_Program_Report_Programs.php?new=<?php echo $program_name ?>"><button><?= $translations['Programs'] ?></button></a>
                    <a href="ProgramStatistics.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Statistics'] ?></button></a>
                    <a href="PLOs.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Assessment'] ?></button></a>
                    <a href="Program_KPIs_Table.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Key Performance Indicators (KPIs)'] ?></button></a>
                    <a href="Annual_Program_Report_Challenges&Difficulties.php?new=<?php echo $program_name ?>"><button><?= $translations['Challenges and Difficulties'] ?></button></a>
                    <a href="Annual_Program_Report_Program_Devalopment_Plan.php?new=<?php echo $program_name ?>"><button><?= $translations['Program Development Plan'] ?></button></a>
                    <a href="Annual_Program_Report_Approval_Of_Annual_Program_Report.php?new=<?php echo $program_name ?>"><button><?= $translations['Approval of Annual Program Report'] ?></button></a>
                </div>
                <!-- Main Content -->
                <div class="main">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <div class="header-text">
                            <h3><?= $translations['Annual Program Report'] ?></h3>
                        </div>
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
                            <h2><?= $translations['Program Development Plan'] ?></h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['Priorities for Improvement'] ?></th>
                                        <th><?= $translations['Actions'] ?></th>
                                        <th><?= $translations['Action Responsibility'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < 6; $i++) {
                                        echo "<tr>";
                                        echo "<td>" . ($i + 1) . "</td>";
                                        echo '<td><input type="text" name="priorities[]" value="' . htmlspecialchars($plane_new['priorities'][$i]) . '" placeholder="' . htmlspecialchars($translations['Enter priority']) . '"></td>';
                                        echo '<td><input type="text" name="actions[]" value="' . htmlspecialchars($plane_new['actions'][$i]) . '" placeholder="' . htmlspecialchars($translations['Enter action']) . '"></td>';
                                        echo '<td><input type="text" name="responsibilities[]" value="' . htmlspecialchars($plane_new['responsibilities'][$i]) . '" placeholder="' . htmlspecialchars($translations['Enter responsibility']) . '"></td>';
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="notes">
                                <p>• <?= $translations['Attach any unachieved improvement plans from the previous report'] ?>.</p>
                                <p>• <?= $translations['The annual program report needs to be discussed in the department council'] ?>.</p>
                            </div>
                            <div class="navigation-buttons">
                                <button type="submit" name="save" class="nav-button"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Approval_Of_Annual_Program_Report.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Challenges&Difficulties.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
                            </div>
                        </div>
                    </form>

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
            // التحقق من وجود متغير 'edit' في URL
            if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
                $program_name = $_GET['edit'];

                // استعلام للحصول على معرّف البرنامج بناءً على اسمه
                $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
                $row_program = mysqli_fetch_assoc($query_program);
                $program_id = $row_program["id"];

                // التحقق إذا كان المستخدم قد اختار العنصر للتعديل
                $edit_item = $_POST['edit_item'] ?? '';

                // إذا تم اختيار عنصر لتعديله
                if ($edit_item) {
                    $query = mysqli_query($conn, "SELECT * FROM program_development_plan WHERE id = '$edit_item' AND program_id = '$program_id'");
                    $row = mysqli_fetch_assoc($query);
                    $existing_data = json_decode($row["data"], true);  // فك البيانات المخزنة بصيغة JSON
                    $update_id = $row["id"];

                    // حفظ البيانات في الجلسة لتستخدمها لاحقًا
                    $_SESSION['plane_edit'] = [
                        'id' => $update_id,
                        'priorities' => $existing_data['priorities'],
                        'actions' => $existing_data['actions'],
                        'responsibilities' => $existing_data['responsibilities']
                    ];
                }

                // التحقق إذا كان المستخدم قد ضغط على زر التحديث
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                    // الحصول على المدخلات من الفورم
                    $priorities = $_POST['priorities'];
                    $actions = $_POST['actions'];
                    $responsibilities = $_POST['responsibilities'];

                    // التأكد من أن جميع الحقول قد تم ملؤها
                    if (count($priorities) == 6 && count($actions) == 6 && count($responsibilities) == 6) {
                        // تحويل البيانات إلى JSON
                        $data = json_encode([
                            'priorities' => $priorities,
                            'actions' => $actions,
                            'responsibilities' => $responsibilities
                        ]);

                        // استعلام لتحديث البيانات في قاعدة البيانات
                        $stmt = $conn->prepare("UPDATE program_development_plan SET data = ? WHERE id = ?");
                        $stmt->bind_param("si", $data, $_SESSION['plane_edit']['id']); // تأكد من ملء $update_id
                        $stmt->execute();

                        // تحديث بيانات الجلسة بعد التحديث
                        $_SESSION['plane_edit']['priorities'] = $priorities;
                        $_SESSION['plane_edit']['actions'] = $actions;
                        $_SESSION['plane_edit']['responsibilities'] = $responsibilities;

                        $_SESSION['message'] = 'Records updated successfully!';
                        header("location: Annual_Program_Report_Program_Devalopment_Plan.php?edit=" . $program_name);
                        exit;
                    } else {
                        $_SESSION['message'] = 'Please fill in all the fields.';
                    }
                }

            ?>

                <div class="container">
                    <!-- Sidebar -->
                    <div class="sidebar">
                        <a href="Annual_Program_Report_Programs.php?edit=<?php echo $program_name ?>"><button><?= $translations['Programs'] ?></button></a>
                        <a href="ProgramStatistics.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Statistics'] ?></button></a>
                        <a href="PLOs.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Assessment'] ?></button></a>
                        <a href="Program_KPIs_Table.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Key Performance Indicators (KPIs)'] ?></button></a>
                        <a href="Annual_Program_Report_Challenges&Difficulties.php?edit=<?php echo $program_name ?>"><button><?= $translations['Challenges and Difficulties'] ?></button></a>
                        <a href="Annual_Program_Report_Program_Devalopment_Plan.php?edit=<?php echo $program_name ?>"><button><?= $translations['Program Development Plan'] ?></button></a>
                        <a href="Annual_Program_Report_Approval_Of_Annual_Program_Report.php?edit=<?php echo $program_name ?>"><button><?= $translations['Approval of Annual Program Report'] ?></button></a>
                    </div>

                    <!-- Main Content -->
                    <div class="main">
                        <div class="header">
                            <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                            <div class="header-text">
                                <h3><?= $translations['Annual Program Report'] ?></h3>
                            </div>
                            <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                        </div>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>
                        <form method="post" id="coursesForm">
                            <label><?= $translations['Select an item to edit'] ?></label>
                            <select name="edit_item" id="editSelect" style="width: 100px; height: 40px; border-radius: 5px;">
                                <option value=""><?= $translations['Select'] ?></option>
                                <?php
                                // استعلام لجلب الخيارات من قاعدة البيانات
                                $query = "SELECT * FROM program_development_plan WHERE program_id = '$program_id' AND user_id = '$user_id'";
                                $result = mysqli_query($conn, $query);

                                // عرض الخيارات في الـ Select
                                while ($row_edit = mysqli_fetch_assoc($result)) {
                                    // فك البيانات المخزنة بصيغة JSON للحصول على الأولويات
                                    $existing_data = json_decode($row_edit["data"], true);
                                    $first_priority = isset($existing_data['priorities'][0]) ? $existing_data['priorities'][0] : '';

                                    // تحديد الخيار المحدد
                                    $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';

                                    // عرض الأولوية الأولى في الـ option
                                    echo "<option value='{$row_edit['id']}' $selected>$first_priority</option>";
                                }
                                ?>
                            </select>


                            <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item) ?>" readonly>

                            <div class="table-container">
                                <h2><?= $translations['Program Development Plan'] ?></h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th><?= $translations['No'] ?></th>
                                            <th><?= $translations['Priorities for Improvement'] ?></th>
                                            <th><?= $translations['Actions'] ?></th>
                                            <th><?= $translations['Action Responsibility'] ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // عرض البيانات في الحقول إذا كانت موجودة للتعديل
                                        for ($i = 0; $i < 6; $i++) {
                                            $priority = $_SESSION['plane_edit']['priorities'][$i] ?? '';
                                            $action = $_SESSION['plane_edit']['actions'][$i] ?? '';
                                            $responsibility = $_SESSION['plane_edit']['responsibilities'][$i] ?? '';
                                            echo "
                            <tr>
                                <td>" . ($i + 1) . "</td>
                                <td><input type='text' name='priorities[]' value='$priority'></td>
                                <td><input type='text' name='actions[]' value='$action' ></td>
                                <td><input type='text' name='responsibilities[]' value='$responsibility'></td>
                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="notes">
                                    <p>• <?= $translations['Attach any unachieved improvement plans from the previous report'] ?>.</p>
                                    <p>• <?= $translations['The annual program report needs to be discussed in the department council'] ?>.</p>
                                </div>
                                <div class="navigation-buttons">
                                    <button type="submit" name="update" class="nav-button"><?= $translations['Update'] ?></button>
                                    <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Approval_Of_Annual_Program_Report.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                    <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Challenges&Difficulties.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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