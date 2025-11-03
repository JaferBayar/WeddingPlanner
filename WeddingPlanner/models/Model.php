<?php
require_once __DIR__ . '/../database.php';

function getItemsData() {
    global $conn;
    $itemsData = [];

    $query = "SELECT c.name as category_name, s.name as service_name, s.price 
              FROM categories c 
              LEFT JOIN services s ON c.id = s.category_id 
              ORDER BY c.id, s.id";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $category = $row['category_name'];
        $service_name = $row['service_name'];
        $price = $row['price'];

        if (!isset($itemsData[$category])) {
            $itemsData[$category] = [];
        }

        if ($service_name) {
            $itemsData[$category][] = [
                'name' => $service_name,
                'price' => floatval($price)
            ];
        }
    }

    $stmt->close();
    return $itemsData;
}

function createUser($username, $email, $password) {
    global $conn;

    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    $username = htmlspecialchars(strip_tags($username));
    $email = htmlspecialchars(strip_tags($email));
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->bind_param("sss", $username, $email, $password_hash);
    $result = $stmt->execute();
    $user_id = $stmt->insert_id;
    $stmt->close();

    return $result ? $user_id : false;
}

function emailExists($email) {
    global $conn;

    $query = "SELECT id, username, password FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $password);
        $stmt->fetch();
        $stmt->close();
        return ['id' => $id, 'username' => $username, 'password' => $password];
    }

    $stmt->close();
    return false;
}

function usernameExists($username) {
    global $conn;

    $query = "SELECT id FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    $exists = $stmt->num_rows > 0;
    $stmt->close();

    return $exists;
}
?>
