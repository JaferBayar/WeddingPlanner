<?php
$host = "localhost";
$username = "root";
$password = "";
$db_name = "wedding_planner";

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8 COLLATE utf8_unicode_ci";
if (!$conn->query($sql)) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($db_name);

$users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_unicode_ci";

$categories_table = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_unicode_ci";

$services_table = "CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_unicode_ci";

$tables = [$users_table, $categories_table, $services_table];
foreach ($tables as $table_sql) {
    if (!$conn->query($table_sql)) {
        die("Error creating table: " . $conn->error);
    }
}

$categories = ['هۆل', 'خوارن', 'دیکۆرات', 'ستران بێژ', 'وێنەگر'];
foreach ($categories as $category) {
    $sql = "INSERT IGNORE INTO categories (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $stmt->close();
}

$services = [
    [1, 'کۆردستان هۆل', 1250000],
    [1, 'دوهوك هۆل', 1000000],
    [1, 'زاخو هۆل', 800000],
    [1, 'کۆرد هۆل', 600000],
    [2, 'کەباب', 15000],
    [2, 'برنج ۆ مريشک', 15000],
    [2, 'برنج ۆ گۆشت', 20000],
    [2, 'مريشکا بژارتي', 15000],
    [2, 'گۆشتێ بژارتي', 20000],
    [3, 'ئاسای', 80000],
    [3, 'ناڤنجي', 120000],
    [3, 'VIP', 250000],
    [4, 'عارف چۆپان', 1400000],
    [4, 'سەربەست مالتای', 1100000],
    [4, 'دیار حەسەن', 1000000],
    [4, 'عەبدللە هەرکی', 900000],
    [4, 'رۆمی هەرکی', 850000],
    [5, 'ستۆدیۆ دۆهۆک', 350000],
    [5, 'ستۆدیۆ زاخۆ', 400000],
    [5, 'ستۆدیۆ کۆرد', 800000]
];

foreach ($services as $service) {
    $sql = "INSERT IGNORE INTO services (category_id, name, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isd", $service[0], $service[1], $service[2]);
    $stmt->execute();
    $stmt->close();
}

$demo_password = password_hash('123456', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (username, email, password) VALUES ('demo_user', 'demo@test.com', ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $demo_password);
$stmt->execute();
$stmt->close();

$conn->set_charset("utf8");
?>
