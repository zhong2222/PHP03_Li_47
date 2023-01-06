<html>

    <head>
        <meta charset="utf-8">
        <title>登録内容一覧</title>
        <!-- <link rel="stylesheet" href="css/bm.css"> -->
        
    </head>

    <body>
        <h1 id="notice"> ～1日30分でも自分を変える”行動読書”!～</h1>
        <p><a class="navbar-brand" href="index.php">新しいデータ登録</a></p>
        <table border="2" style="border-collapse: collapse ;border-color:black">

            <?php
            echo "<tr>\n";
            // echo "<th>ID</th>
            echo '<th 修正></th>                  
                    <th>書名</th>
                    <th>著者</th>
                    <th>開始日</th>
                    <th>終了日</th>
                    <th>評価</th>
                    <th>この本を読んだ目的、ねらい</th>
                    <th>読んで良かったこと、感じたこと</th>
                    <th>この本を読んで、自分は今から何をするか</th>
                    <th>3か月後に何をするか、どうなっていたいか</th>
                    <th>URL</th>
                    <th 削除></th>'; //表の見出し
            echo "</tr>\n";

            // XSS対策関数-->関数化
            // function h($str)
            // {
            //     return htmlspecialchars($str, ENT_QUOTES);
            // }

            //1.  DB接続します
            // try {
            //     //Password:MAMP='root',XAMPP=''
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

            //２．データ取得SQL作成
            $stmt = $pdo->prepare('SELECT * FROM gs_bm_table;');
            $status = $stmt->execute();

            //３．データ表示
            $view = '';
            if ($status == false) {
                //execute（SQL実行時にエラーがある場合）
                // $error = $stmt->errorInfo();
                // exit('ErrorQuery:' . $error[2]);
                sql_error($stmt);
            } else {
                //elseの中は、SQL実行成功した場合
                //Selectデータの数だけ自動でループしてくれる
                //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // echo '<pre>';
                    // var_dump($result);
                    // echo '</pre>';

                    $id = $result['id'];
                    $title = h($result['title']);
                    $author = h($result['author']);
                    // $start = $result['start'];
                    // $end = $result['end'];
                    // $evaluate = $result['evaluate'];
                    $purpuse = h($result['purpuse']);
                    $thoughts = h($result['thoughts']);
                    $action = h($result['action']);
                    $plan = h($result['plan']);
                    $url = h($result['url']);

                    echo "<tr>\n";
                    // echo "<td>$result[id]</td>
                    echo '<td> <a href="detail.php?id=' . $id .'"> 修正 </a> </td>';
                    echo "
                            <td>$title</td>
                            <td>$author</td>
                            <td>$result[start]</td>
                            <td>$result[end]</td>
                            <td>$result[evaluate]</td>
                            <td>$purpuse</td>
                            <td>$thoughts</td>
                            <td>$action</td>
                            <td>$plan</td>
                            <td>$url</td>";
                    echo '<td> <a href="delete.php?id=' . $id.'"> 削除 </a> </td>';
                    echo "</tr>\n";
                }
            }
            ?>
        </table>
    </body>
</html>

<!-- ・ダブルクオート "" で囲むことで、文字列・変数結合のためにピリオドやシングルクオートを使う必要がなくなる
・変数は中括弧{}で囲う必要がある
・ダブルクオート内で変数に対し関数を利用することはできない。あらかじめ、ダブルクオートの外で変数を定義しておく必要がある(①) -->

<!-- 【Before：授業のコード34行目まわりを例に】
$view .=  '<p>' . $result['id'] . '/' . h($result['name']) . '/' . h($result['email'])  .'</p>';
【After】
    $name = h($result['name']);  // ①
    $email = h($result['email']);

    $view .= "<p> {$result['id']} / {$name} / {$email} </p>"; -->