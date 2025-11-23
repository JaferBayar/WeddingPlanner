<?php
if(session_status()===PHP_SESSION_NONE) session_start();

function getItemsData(){
    require __DIR__ . '/../database.php';
    $out = [];
    $res = $conn->query("SELECT id, title, price, category, icon FROM items WHERE is_bundle = 0 ORDER BY id ASC");
    if($res){ 
        while($r = $res->fetch_assoc()){ 
            $out[] = [
                'id' => intval($r['id']),
                'title' => $r['title'],
                'price' => floatval($r['price']),
                'category' => $r['category'],
                'icon' => $r['icon']
            ];
        } 
    }
    return $out;
}

function getBundlesData(){
    require __DIR__ . '/../database.php';
    $out = [];
    $res = $conn->query("SELECT id, title, price, category, icon FROM items WHERE is_bundle = 1 ORDER BY id ASC");
    if($res){ 
        while($r = $res->fetch_assoc()){ 
            $out[] = [
                'id' => intval($r['id']),
                'title' => $r['title'],
                'price' => floatval($r['price']),
                'category' => $r['category'],
                'icon' => $r['icon']
            ];
        } 
    }
    return $out;
}

function getAllItems(){
    require __DIR__ . '/../database.php';
    $out = [];
    $res = $conn->query("SELECT id, title, price, category, icon, is_bundle, created_at FROM items ORDER BY is_bundle ASC, id ASC");
    if($res){ 
        while($r = $res->fetch_assoc()){ 
            $out[] = $r;
        } 
    }
    return $out;
}

function addItem($title, $price, $category, $icon, $isBundle = 0){
    require __DIR__ . '/../database.php';
    $stmt = $conn->prepare("INSERT INTO items(title, price, category, icon, is_bundle) VALUES(?,?,?,?,?)");
    $stmt->bind_param("sdssi", $title, $price, $category, $icon, $isBundle);
    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();
    return $id;
}

function updateItem($id, $title, $price, $category, $icon, $isBundle){
    require __DIR__ . '/../database.php';
    $stmt = $conn->prepare("UPDATE items SET title=?, price=?, category=?, icon=?, is_bundle=? WHERE id=?");
    $stmt->bind_param("sdssii", $title, $price, $category, $icon, $isBundle, $id);
    $stmt->execute();
    $stmt->close();
}

function deleteItem($id){
    require __DIR__ . '/../database.php';
    $stmt = $conn->prepare("DELETE FROM items WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function getItemById($id){
    require __DIR__ . '/../database.php';
    $stmt = $conn->prepare("SELECT id, title, price, category, icon, is_bundle FROM items WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $item = $res->fetch_assoc();
    $stmt->close();
    return $item;
}
function addToCart($itemId){
    if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
    $item = getItemById($itemId);
    if($item && $item['is_bundle'] == 0){
        $k = (string)$itemId;
        $it = [
            'id' => intval($item['id']),
            'title' => $item['title'],
            'price' => floatval($item['price']),
            'category' => $item['category'],
            'icon' => $item['icon']
        ];
        if(!isset($_SESSION['cart'][$k])) $_SESSION['cart'][$k] = ['item'=>$it,'qty'=>1];
        else $_SESSION['cart'][$k]['qty'] += 1;
    }
}

function addBundleToCart($bundleId){
    if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
    $item = getItemById($bundleId);
    if($item && $item['is_bundle'] == 1){
        $k = 'b'.(string)$bundleId;
        $it = [
            'id' => intval($item['id']),
            'title' => $item['title'],
            'price' => floatval($item['price']),
            'category' => $item['category'],
            'icon' => $item['icon']
        ];
        if(!isset($_SESSION['cart'][$k])) $_SESSION['cart'][$k] = ['item'=>$it,'qty'=>1];
        else $_SESSION['cart'][$k]['qty'] += 1;
    }
}

function getCartCount(){
    if(!isset($_SESSION['cart'])) return 0;
    $c=0; foreach($_SESSION['cart'] as $r){ $c+=$r['qty']; } return $c;
}
function getCartItems(){ return isset($_SESSION['cart'])?array_values($_SESSION['cart']):[]; }
function cartTotal(){ $t=0; foreach(getCartItems() as $r){ $t+=$r['item']['price']*$r['qty']; } return $t; }
function clearCart(){ if(isset($_SESSION['cart'])) unset($_SESSION['cart']); }
function createOrder($name,$email){
    require __DIR__ . '/../database.php';
    $items = getCartItems();
    if(!count($items)) return false;
    $total = cartTotal();
    $uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $n = $name!=='' ? $name : (isset($_SESSION['username'])?$_SESSION['username']:'Guest');
    $e = $email!=='' ? $email : null;
    $stmt = $conn->prepare("INSERT INTO orders(user_id,customer_name,customer_email,total) VALUES(?,?,?,?)");
    $stmt->bind_param("issd",$uid,$n,$e,$total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();
    foreach($items as $r){
        $title = $r['item']['title'];
        $price = $r['item']['price'];
        $qty = $r['qty'];
        $st = $conn->prepare("INSERT INTO order_items(order_id,item_title,item_price,qty) VALUES(?,?,?,?)");
        $st->bind_param("isdi",$order_id,$title,$price,$qty);
        $st->execute();
        $st->close();
    }
    clearCart();
    return $order_id;
}
function getDashboardStats(){
    require __DIR__ . '/../database.php';
    $u=0;$a=0;$s=0;
    $q=$conn->query("SELECT role, COUNT(*) c FROM users GROUP BY role");
    if($q){ while($x=$q->fetch_assoc()){ if($x['role']==='user')$u=intval($x['c']); if($x['role']==='admin')$a=intval($x['c']); if($x['role']==='super_admin')$s=intval($x['c']); } }
    
    $itemCount=0;
    $ic=$conn->query("SELECT COUNT(*) c FROM items WHERE is_bundle=0");
    if($ic){ $itemCount=intval($ic->fetch_assoc()['c']); }
    
    $bundleCount=0;
    $bc=$conn->query("SELECT COUNT(*) c FROM items WHERE is_bundle=1");
    if($bc){ $bundleCount=intval($bc->fetch_assoc()['c']); }
    
    $orders=0;$rev=0.0;
    $qr=$conn->query("SELECT COUNT(*) c, IFNULL(SUM(total),0) r FROM orders");
    if($qr){ $row=$qr->fetch_assoc(); $orders=intval($row['c']); $rev=floatval($row['r']); }
    return ['users'=>$u,'admins'=>$a,'super_admins'=>$s,'items'=>$itemCount,'bundles'=>$bundleCount,'cart_count'=>getCartCount(),'cart_total'=>cartTotal(),'orders'=>$orders,'revenue'=>$rev];
}
function getRecentOrders($limit=20){
    require __DIR__ . '/../database.php';
    $out=[];
    $res=$conn->query("SELECT id,customer_name,customer_email,total,created_at FROM orders ORDER BY id DESC LIMIT ".intval($limit));
    if($res){ while($r=$res->fetch_assoc()){ $out[]=$r; } }
    return $out;
}

function getUserOrders($userId){
    require __DIR__ . '/../database.php';
    $out=[];
    $stmt = $conn->prepare("SELECT id, customer_name, customer_email, total, created_at FROM orders WHERE user_id = ? ORDER BY id DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $res = $stmt->get_result();
    while($r = $res->fetch_assoc()){ 
        $out[] = $r; 
    }
    $stmt->close();
    return $out;
}

function getOrderItems($orderId){
    require __DIR__ . '/../database.php';
    $out=[];
    $stmt = $conn->prepare("SELECT item_title, item_price, qty FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $res = $stmt->get_result();
    while($r = $res->fetch_assoc()){ 
        $out[] = $r; 
    }
    $stmt->close();
    return $out;
}