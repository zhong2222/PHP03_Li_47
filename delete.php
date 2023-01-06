<?php

$id = $_GET['id'];

// //2. DB接続します
// //*** function化する！  *****************
// try {
//     $db_name = 'gs_db3'; //データベース名
//     $db_id   = 'root'; //アカウント名
//     $db_pw   = ''; //パスワード：MAMPは'root'
//     $db_host = 'localhost'; //DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
// }


require_once('funcs.php');
$pdo = db_conn();


//３．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM gs_bm_table WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    // $error = $stmt->errorInfo();
    // exit('SQLError:' . print_r($error, true));
    sql_error($stmt);
} else {
    //*** function化する！*****************
    // header('Location: select.php');
    // exit();
redirect('select.php');  
}