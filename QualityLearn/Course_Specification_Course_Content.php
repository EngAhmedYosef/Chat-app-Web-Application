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
    <title><?= $translations['Course Specification-Course Content'] ?></title>
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
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar button:hover {
            background-color: #0073e6;
            transform: translateY(-3px);
        }

        .content {
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
            padding: 10px;
            background: linear-gradient(to top, #f9f9f9, #e6eef8);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 95%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
        }

        table th,
        table td {
            border: 1px solid #003f8a;
            text-align: center;
            padding: 12px 15px;
            font-size: 14px;
            background-color: #f2f7fc;
        }

        table th {
            background-color: #003f8a;
            color: white;
        }

        .section-title {
            background-color: #d6d7d8;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border: 1px solid #003366;
        }

        .textarea-container {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .textarea-container textarea {
            width: 100%;
            height: 80px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            font-size: 14px;
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

            // تأكد من وجود بيانات مُرسلة عبر POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                if (isset($_POST['topics'])) {
                    // الحصول على البيانات المُرسلة
                    $topics = $_POST['topics'];

                    // التحقق من اكتمال البيانات
                    foreach ($topics as $topic) {
                        if (empty($topic['name']) || empty($topic['hours'])) {
                            die("Please fill all the fields before submitting.");
                        }
                    }

                    // تخزين البيانات في الجلسة
                    $_SESSION['course_content_new'] = $topics;

                    // تحويل البيانات إلى JSON وتخزينها في قاعدة البيانات
                    $data = json_encode($topics);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("INSERT INTO course_content (user_id, program_id, data) VALUES (?, ?, ?)");
                    $stmt->bind_param("iis", $user_id, $program_id, $data);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Records created successfully!';
                        header("location: Course_Specification_Course_Content.php?new=" . $program_name);
                        exit;
                    } else {
                        $_SESSION['message'] = 'Error occurred while inserting data.';
                    }
                } else {
                    $_SESSION['message'] = 'Please fill in all fields.';
                }
            }
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
                <div class="content">
                    <div class="header">
                        <img src="ql-removebg-preview (1).png" alt="Logo" width="200" style="margin-bottom: 20px;">
                        <h3><?= $translations['Course Specification'] ?></h3>
                        <a href="logout.php" class="button"><?= $translations['Log out'] ?></a>
                    </div>
                    <form method="post" id="coursesForm">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $translations[$_SESSION['message']];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <div class="table-container">
                            <h2><?= $translations['Course Content'] ?></h2>

                            <table id="listOfTopics">
                                <thead>
                                    <tr>
                                        <th><?= $translations['No'] ?></th>
                                        <th><?= $translations['List Of Topics'] ?></th>
                                        <th><?= $translations['Contact Hours'] ?></th>
                                        <th><?= $translations['Action'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // إذا كانت البيانات مخزنة في الجلسة
                                    if (isset($_SESSION['course_content_new']) && !empty($_SESSION['course_content_new'])) {
                                        $topics = $_SESSION['course_content_new'];
                                        foreach ($topics as $index => $topic) {
                                            // التأكد من أن $index هو عدد صحيح
                                            if (!is_int($index)) {
                                                $index = (int)$index; // تحويله إلى عدد صحيح
                                            }

                                            // التأكد من أن $topic['name'] و $topic['hours'] تحتويان على قيم صالحة
                                            $topic_name = isset($topic['name']) ? htmlspecialchars($topic['name']) : '';
                                            $topic_hours = isset($topic['hours']) ? htmlspecialchars($topic['hours']) : '';

                                            echo '<tr>';
                                            echo '<td>' . ($index + 1) . '</td>';
                                            echo '<td><input type="text" name="topics[' . $index . '][name]" value="' . $topic_name . '" /></td>';
                                            echo '<td><input type="text" name="topics[' . $index . '][hours]" value="' . $topic_hours . '" /></td>';
                                            echo '<td><button type="button" class="delete-button" onclick="deleteRow(this)">' . $translations['Delete'] . '</button></td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        // عند الدخول لأول مرة، اعرض صفًا واحدًا فقط
                                        echo '<tr><td>1</td><td><input type="text" name="topics[0][name]" /></td><td><input type="text" name="topics[0][hours]" /></td><td><button type="button" class="delete-button" onclick="deleteRow(this)">' . $translations['Delete'] . '</button></td></tr>';
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <button type="button" class="add-row-button" onclick="addRow('listOfTopics')"><?= $translations['Add Row'] ?></button>

                            <div class="navigation-buttons">

                                <button name="save" class="nav-button" type="submit"><?= $translations['Save'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Students_Assessment_Activities.php?new=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                                <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_Course_Learning_Outcomes.php?new=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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

                    for (let i = 0; i < 4; i++) {
                        const newCell = newRow.insertCell(i);
                        if (i === 0) {
                            newCell.textContent = newRowIndex;
                        } else if (i === 3) {
                            const deleteButton = document.createElement('button');
                            deleteButton.type = 'button';
                            deleteButton.className = 'delete-button';
                            deleteButton.textContent = '<?= $translations['Delete'] ?>';
                            deleteButton.onclick = () => deleteRow(deleteButton);
                            newCell.appendChild(deleteButton);
                        } else {
                            const input = document.createElement('input');
                            input.type = 'text';
                            input.name = `topics[${newRowIndex - 1}][${i === 1 ? 'name' : 'hours'}]`;
                            newCell.appendChild(input);
                        }
                    }
                }

                function deleteRow(button) {
                    const row = button.parentNode.parentNode;
                    const table = row.parentNode;
                    table.removeChild(row);

                    // Re-index rows
                    Array.from(table.rows).forEach((row, index) => {
                        row.cells[0].textContent = index + 1;
                    });
                    counter = table.rows.length + 1;
                }
            </script>

    <?php }
    } ?>

    <?php
    if (isset($_GET['edit']) && ($_GET['edit'] == 'IS' || $_GET['edit'] == 'CS')) {
        $program_name = $_GET['edit'];

        // جلب الـ program_id بناءً على اسم البرنامج
        $query_program = mysqli_query($conn, "SELECT id FROM programs WHERE program_name = '$program_name'");
        $row_program = mysqli_fetch_assoc($query_program);
        $program_id = $row_program["id"];

        // التحقق إذا كان المستخدم قد اختار أي عنصر للتعديل
        $edit_item = $_SESSION['edit_item_id'] ?? $_POST['edit_item'] ?? '';  // استخدام POST إذا كانت الجلسة فارغة

        // إذا كانت الطريقة هي POST وتم إرسال زر التعديل
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_row'])) {
            // التحقق من أن العنصر المختار موجود في قاعدة البيانات
            if (!empty($_POST['edit_item'])) {
                // حفظ الـ id في الجلسة
                $_SESSION['edit_item_id'] = $_POST['edit_item'];
                $edit_item = $_POST['edit_item']; // تحديث القيمة المحفوظة في الجلسة بالـ id الجديد

                // استعلام لجلب البيانات بناءً على الـ id المختار
                $query = mysqli_query($conn, "SELECT * FROM course_content WHERE id = '$edit_item' AND user_id = '$user_id'");
                if ($query && mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_assoc($query);
                    $data = json_decode($row['data'], true); // فك ترميز البيانات
                    // تخزين البيانات في الجلسة لتعديلها لاحقًا
                    $_SESSION['course_content_edit'] = $data;
                    $_SESSION['program_id'] = $program_id;
                } else {
                    $_SESSION['message'] = "Item not found or you don't have access.";
                }
            } else {
                $_SESSION['message'] = "Please select an item to edit.";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            // التأكد من أن البيانات مُرسلة من الفورم
            if (isset($_POST['topics']) && !empty($_POST['id'])) {
                $topics = $_POST['topics'];
                $update_id = $_POST['id'];

                // التحقق من أن كل الإدخالات مكتملة
                foreach ($topics as $topic) {
                    if (empty($topic['name']) || empty($topic['hours'])) {
                        $_SESSION['message'] = "Please fill all the fields before submitting.";
                        exit;
                    }
                }

                // تحويل البيانات إلى JSON
                $data = json_encode($topics);

                // تحديث البيانات في قاعدة البيانات
                $stmt = $conn->prepare("UPDATE course_content SET data = ? WHERE id = ? AND user_id = ?");
                $stmt->bind_param("sii", $data, $update_id, $user_id);

                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Record updated successfully!';
                    // تحديث البيانات في الجلسة أيضًا
                    $_SESSION['course_content_edit'] = $topics; // تحديث البيانات في الجلسة
                    header("location: Course_Specification_Course_Content.php?edit=" . $program_name);
                    exit;
                } else {
                    $_SESSION['message'] = 'Error occurred while updating data.';
                }
            } else {
                $_SESSION['message'] = "Please select an item to edit and fill all fields.";
            }
        }

        // عرض الصفحة
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
                    <h3><?= $translations['Course Specification'] ?></h3>
                    <a href="logout.php" class="button"><?= $translations['Log out'] ?></a>
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
                        // استعلام لجلب جميع الخيارات
                        $query = "SELECT * FROM course_content WHERE program_id = '$program_id' AND user_id = '$user_id'";
                        $result = mysqli_query($conn, $query);

                        // عرض الخيارات
                        while ($row_edit = mysqli_fetch_assoc($result)) {

                            $data = json_decode($row_edit['data'], true);

                            // التحقق إذا كانت البيانات موجودة
                            if (!empty($data) && is_array($data)) {
                                // أخذ أول عنصر من الكورسات
                                $first_course = $data[0];

                                // استخراج course_title لأول كورس
                                $name = $first_course['name'] ?? 'N/A';


                                $selected = ($row_edit['id'] == $edit_item) ? 'selected' : '';
                                echo "<option value='{$row_edit['id']}' $selected>{$name}</option>";
                            }
                        }
                        ?>
                    </select>

                    <button type="submit" class="button" name="edit_row"><?= $translations['Edit'] ?></button>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($edit_item ?? '') ?>">

                    <div class="table-container">
                        <h2><?= $translations['Course Content'] ?></h2>

                        <table id="listOfTopics">
                            <thead>
                                <tr>
                                    <th><?= $translations['No'] ?></th>
                                    <th><?= $translations['List Of Topics'] ?></th>
                                    <th><?= $translations['Contact Hours'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($_SESSION['course_content_edit'])) { ?>
                                    <?php foreach ($_SESSION['course_content_edit'] as $index => $topic) { ?>
                                        <tr>
                                            <td><?= (int)$index + 1 ?></td>
                                            <td>
                                                <input type="text" name="topics[<?= $index ?>][name]" value="<?= htmlspecialchars($topic['name']) ?>" />
                                            </td>
                                            <td>
                                                <input type="text" name="topics[<?= $index ?>][hours]" value="<?= htmlspecialchars($topic['hours']) ?>" />
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" name="topics[0][name]" /></td>
                                        <td><input type="text" name="topics[0][hours]" /></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                        <div class="navigation-buttons">

                            <button name="update" class="nav-button" type="submit"><?= $translations['Update'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Spesification_Students_Assessment_Activities.php?edit=<?= $program_name ?>')"><?= $translations['Next'] ?></button>
                            <button type="button" class="nav-button" onclick="handleNavigation('Course_Specification_Course_Learning_Outcomes.php?edit=<?= $program_name ?>')"><?= $translations['Back'] ?></button>
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