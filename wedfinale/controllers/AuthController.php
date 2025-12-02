
<?php
require_once __DIR__ . '/../models/Model.php';
function auth_construct(){ if(session_status()===PHP_SESSION_NONE) session_start(); }
function isLoggedIn(){ return isset($_SESSION['user_id']) || isGuest(); }
function isGuest(){ return isset($_SESSION['user_type']) && $_SESSION['user_type']==='guest'; }
function isSuperAdmin(){ return isset($_SESSION['role']) && $_SESSION['role']==='super_admin'; }
function isAdmin(){ return isset($_SESSION['role']) && ($_SESSION['role']==='admin' || $_SESSION['role']==='super_admin'); }
function guestLogin(){
    if(session_status()===PHP_SESSION_NONE) session_start();
    $_SESSION['user_type']='guest';
    $_SESSION['username']='Guest';
    $_SESSION['user_id']=null;
    unset($_SESSION['role']);
    header("Location: index.php");
    exit();
}
function login(){
    global $conn;
    require_once __DIR__ . '/../database.php';
    $email = isset($_POST['email'])?trim($_POST['email']):'';
    $password = isset($_POST['password'])?$_POST['password']:'';
    if($email==='' || $password==='') return 'Please fill all fields';
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->bind_result($id,$username,$hash,$role);
    if($stmt->fetch() && password_verify($password,$hash)){
        if(session_status()===PHP_SESSION_NONE) session_start();
        $_SESSION['user_id']=$id;
        $_SESSION['username']=$username;
        $_SESSION['user_type']='registered';
        $_SESSION['role']=$role;
        $stmt->close();
        header("Location: index.php");
        exit();
    }
    $stmt->close();
    return 'Invalid credentials';
}
function signup(){
    global $conn;
    require_once __DIR__ . '/../database.php';
    $username = isset($_POST['username'])?trim($_POST['username']):'';
    $email = isset($_POST['email'])?trim($_POST['email']):'';
    $password = isset($_POST['password'])?$_POST['password']:'';
    if($username==='' || $email==='' || $password==='') return 'Please fill all fields';
    $cnt = $conn->query("SELECT COUNT(*) c FROM users");
    $row = $cnt->fetch_assoc();
    $first = intval($row['c'])===0;
    $role = $first ? 'super_admin' : 'user';
    $exists = $conn->prepare("SELECT id FROM users WHERE email=?");
    $exists->bind_param("s",$email);
    $exists->execute();
    $exists->store_result();
    if($exists->num_rows>0){ $exists->close(); return 'Email already exists'; }
    $exists->close();
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $ins = $conn->prepare("INSERT INTO users(username,email,password,role) VALUES(?,?,?,?)");
    $ins->bind_param("ssss",$username,$email,$hash,$role);
    $ins->execute();
    $ins->close();
    header("Location: login.php");
    exit();
}
function logout(){
    if(session_status()===PHP_SESSION_NONE) session_start();
    if(isset($_SESSION['cart'])) unset($_SESSION['cart']);
    session_destroy();
    header("Location: login.php");
    exit();
}
