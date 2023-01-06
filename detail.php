<?php

ini_set('display_errors', 'On'); // ここ：エラーを表示させるようにしてください
error_reporting(E_ALL); //ここ：全てのレベルのエラーを表示してください

/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */

$id = $_GET['id'];

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


$stmt = $pdo->prepare('SELECT * FROM gs_bm_table WHERE id = :id;');
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意
$status = $stmt->execute();

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    // $error = $stmt->errorInfo();
    // exit('SQLError:' . print_r($error, true));
    sql_error($stmt);
} else {
    // データが取得できた場合の処理
    $result = $stmt->fetch();
}
?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <script src="js/jquery-2.1.3.min.js"></script>
    <link rel="stylesheet" href="css/bm.css">
    <title>ACTION READING</title>

</head>

<body>
    <header>
        <h1>新しい本の使い方</h1>
    </header>
    <main>
        <h2>ACTION READING</h2>
        <h3>～1日30分でも自分を変える”行動読書”！～ </h3>
        <h4><a class="navbar-brand" href="index.php">新しいデータ登録</a></h4>

        <h4 class="navbar-header"><a class="navbar-brand" href="select.php">登録内容一覧</a></h4>
        
        <form action="update.php" method="post">

        <label> 書名：  <input id="title" type="text" class="box" name="title" value="<?= h($result['title'])?>"></label><br>
        <label> 著者：  <input id="author" type="text" class="box" name="author" value="<?= h($result['author'])?>"></label><br>
        <label> URL :   <input id="url" type="text" class="box" name="url" value="<?= h($result['url'])?>"></label><br>       
        <label> 開始日: <input id="start" type="date" class="box"  name="start" value="<?= $result['start']?>"></label><br>
        <label> 完了日: <input id="end" type="date" class="box"  name="end" value="<?= $result['end']?>"></label><br>
        <label> 評価：  <select id="evaluate" class="box" name="evaluate">
                                <option value="◎" <?= $result['evaluate'] == '◎' ? 'selected' : "" ?>>◎</option>
                                <option value="◯" <?= $result['evaluate'] == '◯' ? 'selected' : "" ?>>◯</option>
                                <option value="△" <?= $result['evaluate'] == '△' ? 'selected' : "" ?>>△</option>
                                <option value="✕" <?= $result['evaluate'] == '✕' ? 'selected' : "" ?>>✕</option>
                        </select>
                        </label><br>
                <ul class="list">
                        <div class="option"> ◎：非常によい </div>
                        <div class="option"> ◯：よい。だめではないが今一つ</div>
                        <div class="option"> △：微妙。買わなければよかった、読まなければよかった</div>
                        <div class="option"> ✕：最悪。ひどい本、あきれた</div>
                </ul>

                        <!-- 画像表示 -->
                        <div id="thumbnail"></div>

                <h4>↓↓↓アクション↓↓↓</h4>

                <p id="purpuse">1.　この本を読んだ目的、ねらい</p>
                    <textArea name="purpuse" rows="8" cols="40"><?= $result['purpuse']?></textArea><br>
                <p id="thoughts">2.　読んで良かったこと、感じたこと</p>
                    <textArea name="thoughts" rows="8" cols="40"><?= $result['thoughts']?></textArea><br>
                <p id="action">3.　この本を読んで、自分は今から何をするか</p>
                    <textArea name="action" rows="8" cols="40"><?= $result['action']?></textArea><br>
                <p id="plan">4.　3か月後に何をするか、どうなっていたいか</p>
                    <textArea name="plan" rows="8" cols="40"><?= $result['plan']?></textArea><br>
                <input type="hidden" name="id" value="<?= $result['id']?>">    
                <input type="submit" value="修正">

        </form>

    </main>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
<script src="js/bm.js"></script>

</body>
</html>
