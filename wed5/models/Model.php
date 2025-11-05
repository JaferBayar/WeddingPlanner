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
// Remember-me helpers
function rememberStoreToken($user_id, $token_hash, $ua_hash, $expires_at) {
    global $conn;
    $sql = "INSERT INTO remember_tokens (user_id, token_hash, user_agent_hash, expires_at) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $token_hash, $ua_hash, $expires_at);
    $stmt->execute();
    $stmt->close();
}

function rememberFindUserByToken($token_raw) {
    global $conn;
    $token_hash = hash('sha256', $token_raw);
    $ua_hash = isset($_SERVER['HTTP_USER_AGENT']) ? hash('sha256', $_SERVER['HTTP_USER_AGENT']) : null;
    $sql = "SELECT u.id, u.username FROM remember_tokens t JOIN users u ON u.id = t.user_id WHERE t.token_hash = ? AND t.expires_at > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    if ($row) {
        return $row;
    }
    return false;
}

function rememberDeleteToken($token_raw) {
    global $conn;
    $token_hash = hash('sha256', $token_raw);
    $sql = "DELETE FROM remember_tokens WHERE token_hash = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $stmt->close();
}
?>
