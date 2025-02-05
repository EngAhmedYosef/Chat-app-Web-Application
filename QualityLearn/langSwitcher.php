<?php
function loadLanguage($lang = 'en') {
    $filePath = __DIR__ . "/lang/$lang.php";
    if (file_exists($filePath)) {
        return include $filePath;
    }
    return [];
}

// التحقق من اختيار اللغة وتخزينها في الجلسة
session_start();
if (isset($_POST['lang'])) {
    $_SESSION['lang'] = $_POST['lang'];
}

// تحديد اللغة الافتراضية إذا لم يتم تحديد لغة في الجلسة
$lang = $_SESSION['lang'] ?? 'en';

// تحميل النصوص بناءً على اللغة المختارة
$translations = loadLanguage($lang);
?>
