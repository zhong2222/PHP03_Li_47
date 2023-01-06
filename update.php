<?php

// function h($val){
//     return htmlspecialchars($val,ENT_QUOTES);
// }

// ini_set('display_errors', 'On'); // ここ：エラーを表示させるようにしてください
// error_reporting(E_ALL); //ここ：全てのレベルのエラーを表示してください

//1. POSTデータ取得

$title = $_POST['title'];
$author = $_POST['author'];
$url = $_POST['url'];
$start = $_POST['start'];
$end = $_POST['end'];
$evaluate = $_POST['evaluate'];
$purpuse = $_POST['purpuse'];
$thoughts = $_POST['thoughts'];
$action = $_POST['action'];
$plan = $_POST['plan'];
$id = $_POST['id'];

// if(isset($_POST['ta1'])) {
//     $ta1 = $_POST['ta1'];
//     echo '選択1A：' . $ta1 . '<br>';
// } else {
//     echo '問１Aが選択されていません。<br>';
// }

//2. DB接続します

// try {
//     //ID:'root', Password: xamppは 空白 ''
//     $pdo = new PDO(
//         'mysql:dbname=action_reading_db;charset=utf8;host=localhost',
//         'root',
//         ''
//     );
// } catch (PDOException $e) {
//     exit('DBConnectError:' . $e->getMessage());
// }

//関数化
require_once 'funcs.php';
$pdo = db_conn();

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare('UPDATE gs_bm_table SET 
                        title = :title, 
                        author = :author, 
                        url = :url, 
                        start = :start, 
                        end = :end, 
                        evaluate = :evaluate, 
                        purpuse = :purpuse,
                        thoughts = :thoughts,
                        action = :action,
                        plan = :plan,
                        update_at = sysdate() 
                        WHERE id = :id;
                        ');

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':author', $author, PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':start', $start, PDO::PARAM_STR);
$stmt->bindValue(':end', $end, PDO::PARAM_STR);
$stmt->bindValue(':evaluate', $evaluate, PDO::PARAM_STR);
$stmt->bindValue(':purpuse', $purpuse, PDO::PARAM_STR);
$stmt->bindValue(':thoughts', $thoughts, PDO::PARAM_STR);
$stmt->bindValue(':action', $action, PDO::PARAM_STR);
$stmt->bindValue(':plan', $plan, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if ($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    // $error = $stmt->errorInfo();
    // exit('ErrorMessage:' . $error[2]);
    sql_error($stmt);
} else {
    //５．index.phpへリダイレクト
    // header('Location: select.php');
    redirect('select.php');
}
?>

