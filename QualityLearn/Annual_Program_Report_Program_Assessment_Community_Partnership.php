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
    <title><?= $translations['Annual Program Report-Program Assessment-5.Community Partnership']?></title>
    <style>
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
            height: 130vh;
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


        .table-container h2 {
            margin-bottom: 20px;
        }

        .table-container .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
            /* مسافة بين المجموعات */
        }

        .table-container label {
            flex: 1 0 30%;
            margin-bottom: 5px;
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
            text-align: center;
        }

        td {
            width: 90%;
            /* جعل المربعات تأخذ 90% من عرض الخلية */
            padding: 4px;
            font-size: 12px;
        }

        input {
            width: 90%;
            text-align: center;
            padding: 4px;
            font-size: 12px;
        }

        p {
            color: #9fa0a1;
            font-size: 15px;
            font-weight: 200;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            margin: 0;
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

        .discussion-box {
            margin-top: 20px;
        }

        textarea {
            width: 90%;
            height: 100px;
            padding: 10px;
            border: 1px solid #003f8a;
            border-radius: 5px;
            resize: none;
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
    if (isset($_GET['new']) && ($_GET['new'] == 'IS' || $_GET['new'] == 'CS')) {
        $program_name = $_GET['new'];

        // جلب program_id بناءً على اسم البرنامج
        $id_query = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row = mysqli_fetch_assoc($id_query);
        $program_id = $row["id"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // معالجة الزر 'Save'
            if (isset($_POST['save'])) {
                // جمع البيانات المدخلة
                $data = "";
                for ($i = 1; $i <= 5; $i++) {
                    if (!empty($_POST['activities']["activities_implemented$i"]) && !empty($_POST['brief']["brief_description$i"])) {
                        $activity = $conn->real_escape_string($_POST['activities']["activities_implemented$i"]);
                        $brief = $conn->real_escape_string($_POST['brief']["brief_description$i"]);
                        $data .= "$activity: $brief, ";
                    }
                }
                $data = rtrim($data, ", "); // إزالة الفاصلة الأخيرة
                $comment = $conn->real_escape_string($_POST['comment']);

                // تخزين البيانات المدخلة في الجلسة
                $_SESSION['community_partenership_new'] = [
                    'activities' => $_POST['activities'],
                    'brief' => $_POST['brief'],
                    'comment' => $comment
                ];

                if (!empty($data)) {
                    // إدخال البيانات في قاعدة البيانات
                    $stmt = $conn->prepare("INSERT INTO community_partnership (user_id, data, comment, program_id) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("issi", $user_id, $data, $comment, $program_id);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }

                    $stmt->close();
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }

                header("location: Annual_Program_Report_Program_Assessment_Community_Partnership.php?new=" . $program_name);
                exit;
            }

            // معالجة أزرار التنقل
            if (isset($_POST['next'])) {
                header("location: Program_KPIs_Table.php?new=" . $program_name);
                exit;
            }

            if (isset($_POST['back'])) {
                header("location: Students_Evaluation_of_progrm_Q.php?new=" . $program_name);
                exit;
            }
        }
    ?>
        <div class="container">
            <!-- Sidebar -->
            <div class="sidebar">
            <a href="PLOs.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Program Assessment']?></button>
                    </a>
                    <a href="PLOs.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Program Learning Outcomes']?></button>
                    </a>
                    <a href="StudentEv.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Courses']?></button>
                    </a>
                    <a href="Students_Evaluation_of_progrm_Q.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Program Quality']?></button>
                    </a>
                    <a href="Scientific_research_and_innovation.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Scientific Research And Innovation']?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Community Partnership']?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Other_Evaluation.php?new=<?php echo $program_name ?>">
                        <button><?= $translations['Other Evaluation']?></button>
                    </a>
            </div>

            <!-- Main Content -->
            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <div class="header-text">
                        <h3><?= $translations['Annual Program Report']?></h3>
                        <p><?= $translations['Program Assessment']?></p>
                    </div>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                <div class="content">
                    <h2>5. <?= $translations['Community Partnership']?></h2>
                    <?php if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    } ?>
                    <form method="post" id="coursesForm">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['Activities Implemented']?></th>
                                        <th><?= $translations['Brief Description']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <tr>
                                            <td><input type="text" name="activities[activities_implemented<?= $i ?>]" placeholder="<?= $translations['Enter Activity']?>" value="<?php echo isset($_SESSION['community_partenership_new']['activities']["activities_implemented$i"]) ? $_SESSION['community_partenership_new']['activities']["activities_implemented$i"] : ''; ?>"></td>
                                            <td><input type="text" name="brief[brief_description<?= $i ?>]" placeholder="<?= $translations['Enter Brief Description']?>" value="<?php echo isset($_SESSION['community_partenership_new']['brief']["brief_description$i"]) ? $_SESSION['community_partenership_new']['brief']["brief_description$i"] : ''; ?>"></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                        <label><?= $translations['Comment on community partnership activities']?>:</label>
                        <textarea name="comment" placeholder="<?= $translations['Write your comments here...']?>"><?php echo isset($_SESSION['community_partenership_new']['comment']) ? $_SESSION['community_partenership_new']['comment'] : ''; ?></textarea>
                        <div>
                            **<?= $translations['Including overall evaluation of the programs performance in these activities (if any)']?>.
                        </div>

                        <button name="save" class="nav-button" type="submit"><?= $translations['Save']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Program_Assessment_Other_Evaluation.php?new=<?= $program_name ?>')"><?= $translations['Next']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Scientific_research_and_innovation.php?new=<?= $program_name ?>')"><?= $translations['Back']?></button>
                    </form>
                </div>
            </div>
        </div>

        <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?']?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave']?></button>
                    <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay']?></button>
                </div>


    <?php } ?>

    <?php
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // جلب program_id بناءً على اسم البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        $edit_item = $_POST['edit_item'] ?? '';

        // إذا تم اختيار عنصر للتحرير
        if ($edit_item) {
            $query = mysqli_query($conn, "SELECT * FROM community_partnership WHERE id = '$edit_item' AND user_id = '$user_id'");
            $row = mysqli_fetch_assoc($query);

            // تقسيم البيانات المخزنة في عمود "data" إلى أجزاء
            $data = [];
            if (!empty($row['data'])) {
                $data_parts = explode(", ", $row['data']);
                foreach ($data_parts as $index => $part) {
                    list($activity, $brief) = explode(": ", $part);
                    $data["activities_implemented" . ($index + 1)] = trim($activity);
                    $data["brief_description" . ($index + 1)] = trim($brief);
                }
            }

            $comment = $row['comment'];

            // حفظ البيانات في الـ Session
            $_SESSION['community_partenership_edit'] = [
                'activities' => $data,
                'comment' => $comment,
                'edit_item' => $edit_item
            ];
        }

        // عند تحديث البيانات
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            // الحصول على البيانات القديمة من الجلسة
            $old_data = $_SESSION['community_partenership_edit']['activities'] ?? [];
            $data = "";

            // دمج البيانات الجديدة مع القديمة
            for ($i = 1; $i <= 5; $i++) {
                $new_activity = !empty($_POST['activities']["activities_implemented$i"]) ? $_POST['activities']["activities_implemented$i"] : $old_data["activities_implemented$i"];
                $new_brief = !empty($_POST['brief']["brief_description$i"]) ? $_POST['brief']["brief_description$i"] : $old_data["brief_description$i"];

                if ($new_activity && $new_brief) {
                    $data .= "$new_activity: $new_brief, ";
                }
            }
            $data = rtrim($data, ", "); // إزالة الفاصلة الأخيرة
            $comment = $conn->real_escape_string($_POST['comment']);
            $update_id = $_SESSION['community_partenership_edit']['edit_item']; // الحصول على الـ ID من الـ session

            // تحديث البيانات في قاعدة البيانات
            $sql = "UPDATE community_partnership SET data = '$data', comment = '$comment' WHERE id = '$update_id'";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = 'Records Updated successfully!';
            } else {
                $_SESSION['message'] = 'Error occurred while updating data.';
            }

            // تحديث البيانات في الـ session بعد التحديث
            $_SESSION['community_partenership_edit'] = [
                'activities' => $_POST['activities'] ?? $old_data,
                'comment' => $_POST['comment'] ?? $comment,
                'edit_item' => $update_id
            ];

            header("location: Annual_Program_Report_Program_Assessment_Community_Partnership.php?edit=" . $program_name);
            exit;
        }

        if (isset($_POST['next'])) {
            header("location: Next_Page.php?edit=" . $program_name);
            exit;
        }

        if (isset($_POST['back'])) {
            header("location: Previous_Page.php?edit=" . $program_name);
            exit;
        }
    ?>

        <div class="container">
            <div class="sidebar">
            <a href="PLOs.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Program Assessment']?></button>
                    </a>
                    <a href="PLOs.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Program Learning Outcomes']?></button>
                    </a>
                    <a href="StudentEv.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Courses']?></button>
                    </a>
                    <a href="Students_Evaluation_of_progrm_Q.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Students Evaluation Of Program Quality']?></button>
                    </a>
                    <a href="Scientific_research_and_innovation.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Scientific Research And Innovation']?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Community_Partnership.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Community Partnership']?></button>
                    </a>
                    <a href="Annual_Program_Report_Program_Assessment_Other_Evaluation.php?edit=<?php echo $program_name ?>">
                        <button><?= $translations['Other Evaluation']?></button>
                    </a>
            </div>

            <div class="main">
                <div class="header">
                    <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                    <div class="header-text">
                        <h3><?= $translations['Annual Program Report']?></h3>
                        <p><?= $translations['Program Assessment']?></p>
                    </div>
                    <a href="logout.php" class="logout-button"><?= $translations['Log out'] ?></a>
                    </div>
                <div class="content">
                    <h2>5. <?= $translations['Community Partnership']?></h2>
                    <?php if (isset($_SESSION['message'])) {
                        echo $translations[$_SESSION['message']];
                        unset($_SESSION['message']);
                    } ?>
                    <form method="post" id="coursesForm">

                        <label><?= $translations['Select an item to edit']?>:</label>
                        <select name="edit_item" style="width: 150px; height: 40px; border-radius: 5px;">
                            <option value=""><?= $translations['Select']?></option>
                            <?php
                            $query = "SELECT * FROM community_partnership WHERE program_id = '$program_id' AND user_id = '$user_id'";
                            $result = mysqli_query($conn, $query);
                            while ($row_edit = mysqli_fetch_assoc($result)) {
                                $selected = ($row_edit['id'] == $_SESSION['community_partenership_edit']['edit_item']) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$row_edit['comment']}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="button" name="edit_row"><?= $translations['Edit']?></button>

                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th><?= $translations['Activities Implemented']?></th>
                                        <th><?= $translations['Brief Description']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <tr>
                                            <td><input type="text" name="activities[activities_implemented<?= $i ?>]" value="<?= htmlspecialchars($_SESSION['community_partenership_edit']['activities']["activities_implemented$i"] ?? '') ?>"></td>
                                            <td><input type="text" name="brief[brief_description<?= $i ?>]" value="<?= htmlspecialchars($_SESSION['community_partenership_edit']['activities']["brief_description$i"] ?? '') ?>"></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                        <label><?= $translations['Comment on community partnership activities']?>:</label>
                        <textarea name="comment"><?= htmlspecialchars($_SESSION['community_partenership_edit']['comment'] ?? '') ?></textarea>
                        <div>
                            **<?= $translations['Including overall evaluation of the programs performance in these activities (if any)']?>.
                        </div>
                        <button name="update" class="nav-button" type="submit"><?= $translations['Update']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Annual_Program_Report_Program_Assessment_Other_Evaluation.php?edit=<?= $program_name ?>')"><?= $translations['Next']?></button>
                        <button type="button" class="nav-button" onclick="handleNavigation('Scientific_research_and_innovation.php?edit=<?= $program_name ?>')"><?= $translations['Back']?></button>
                    </form>
                </div>
            </div>
        </div>

        <div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:10px; text-align:center; width:300px;">
                    <p><?= $translations['You have unsaved data. Do you want to leave without saving?']?></p>
                    <button onclick="proceedToNextPage()" style="background: #0057b7; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Leave']?></button>
                    <button onclick="hideCustomModal()" style="background: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"><?= $translations['Stay']?></button>
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