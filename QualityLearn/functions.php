<?php
function loadLanguage($lang = 'en') {
    $filePath = __DIR__ . "/lang/$lang.php";
    if (file_exists($filePath)) {
        return include $filePath;
    }
    return [];
}
