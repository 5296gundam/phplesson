<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>暇な奴のためのサイト</title>
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="css/styles.css"/>
    <!-- <style> 
      h1 {
       color: red;
      }
    </style> --> 
</head>

<?php
/*サーバーに接続、テーブルを作成*/
    /*接続*/
    $dsn='データベース';
    $user='ユーザー名';
    $password='パスワード';
    $pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    /*テーブル作成*/
    $sql = "CREATE TABLE IF NOT EXISTS papa"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date DATETIME,"
    ."password TEXT"
    .");";
    $stmt = $pdo->query($sql);
?>
<header>
      
        <div class="info">
          <h1>やまうち君が作ったしょうもないサイト</h1>
           <ul>            
           　<li>あなたたちIPPONグランプリの見過ぎかもしれませんよ？</li>
             <li>レベルの高すぎる回答は受け付けてません。。</li>
           </ul>
        </div>
      </div>
</header>


<body>




<section class="corona">
      <h>アホが暇なときにみるサイト</h>
        <p>やまうち君はコロナ禍で周りが騒いでいる中、時間が有り余っていたので一生誰の役にも立たないであろう、しょうもないホームページを作成しました。流行りに便乗してどうぶつの森するとかつまんないインスタライブするとかよりはなんとなくいい気がしてます。</p>
    </section>

    <section class="jiman">
      <h>何の生産性もないサイトへようこそ</h>
        <ul>
          <li>こんなページを開いて何をしておられるのでしょうか。もしかして暇なのでしょうか。</li>
          <li>僕は大した努力もせずに不労所得等でお金を稼ぎたいです。</li>
          <li>ここに来るようなどうしようもない共々は僕の楽して名誉とお金を十分に手に入れるという夢を応援してください。</li>
          <li>本日、サイトを立ち上げました10月2日は、山瀬まみさん、浜崎あゆみさん、タイガー福田さんのお誕生日です。おめでとう。</li>
          <li>やまうち君が死んだらやまうち君のことを永遠に祭り上げてててください。</li>
          <li>それでいってみましょう</li>
        </ul>
     </section>

    <section class="rakushitai">
      <h>このページ開くの本当時間の無駄だと思います。</h>
        <p>それでも下をスクロールする方は、掲示板に書き込んでください。それが条件です。</p>
        <p>日本の未来は（ハンマーカンマ―）</p>
        
      <ul>
        <div class="hageteru">
          <li>
            <a href="https://www.instagram.com/yamauchikun_insta/?hl=ja">
              <img src="gaozou/insta.png" width="100" height="100" alt="インスタのリンクだと思った？">
            </a>
          </li>
          <li>
           <a href="https://twitter.com/yamauchikun_twi">
              <img src="gaozou/twitter.png" width="100" height="100" alt="ツイッターね。">
            </a>
          </li>
          <p>↓こんなサイトないぞ。</p>
        </div>
      </ul>
      <p>(c) yamauchikun_website.com</p>
      <p>【お題】「この動画...バズっても収益化できないぞ...」どんな動画？</p>
    </section>
    <footer>
          <?php
/*ifで新規投稿、削除を分岐*/
if(!empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["password2"]) && !empty($_POST["button1"])){
    /*フォームからと、dateで時間を取得*/
    $name = $_POST["name"];
    $str = $_POST["str"];
    $formPassword = $_POST["password2"];
    $date = date("Y-m-d H:i:s");

    /*新規投稿か編集か*/
    if(empty($_POST["hiddenEdit"])){
        /*新規投稿の場合*/
        /*書き込み*/
        $sql = $pdo -> prepare("INSERT INTO papa (name, comment ,date ,password) VALUES (:name, :comment, :date, :password)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $str, PDO::PARAM_STR);
        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
        $sql -> bindParam(':password', $formPassword, PDO::PARAM_STR);
        $sql -> execute();

        /*編集の場合*/
    }else{
        /*編集*/
        $id = $_POST["hiddenEdit"]; //変更する投稿番号
        $sql = "UPDATE papa SET name=:name,comment=:comment,password=:password WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
        $stmt -> bindParam(':comment', $str, PDO::PARAM_STR);
        $stmt -> bindParam(':password', $formPassword, PDO::PARAM_STR);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
    }
}

/*削除の処理*/
if(!empty($_POST["delete"]) && !empty($_POST["deletePassword"]) && !empty($_POST["button2"])){
    /*削除対象番号とパスワードを変数へ*/
    $delete = $_POST["delete"];
    $password3 = $_POST["deletePassword"];

    /*削除対象番号、パスワードを取り出してフォームから入力されたものと比べる*/
    /*データベースから取り出す*/
    $sql = "SELECT * FROM papa";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        /*削除対象番号とパスワードが一致した場合削除*/
        $deleteID = $row['id'];
        $deletePassword = $row['password'];
        if($deleteID == $delete && $deletePassword == $password3){
            $id = $deleteID;
            $sql = "delete from papa where id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            break;
        }
    }    

}

/*編集フォームの処理(編集の場合に繋げる)*/
if(!empty($_POST["edit"]) && !empty($_POST["editPassword"]) && !empty($_POST["button3"])){
    /*編集対象番号とパスワードを変数へ*/
    $edit=$_POST["edit"];
    $password3=$_POST["editPassword"];

    /*編集対象番号、パスワードを取り出してフォームから入力されたものと比べる*/
    /*データベースから取り出す*/
    $sql = "SELECT * FROM papa";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        /*編集対象番号、パスワードが一致した場合、名前、コメント、隠し編集番号を定義してフォームに表示された状態にする*/
        $editID = $row['id'];
        $editPassword = $row['password'];
        if($editID == $edit && $editPassword == $password3){
            $editNum = $row['id'];
            $editName = $row['name'];
            $editComment =$row['comment'];
           break;
        }
    }
    

}

/*表示*/
$sql = "SELECT * FROM papa";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
?>  

<?php
    foreach ($results as $row){ /*htmlentitiesはXSS対策、&nbsp;は空白入れるため*/
        echo htmlentities($row['id'], ENT_QUOTES, 'UTF-8').'&nbsp;';
        echo htmlentities($row['name'], ENT_QUOTES, 'UTF-8').'&nbsp;';
        echo htmlentities($row['comment'], ENT_QUOTES, 'UTF-8').'&nbsp;';
        echo htmlentities($row['date'], ENT_QUOTES, 'UTF-8').'<br>';
        echo "<hr>";
    }
?>

<!--投稿フォーム-->
     <form action="" method="post">
    <!--名前フォーム-->
    <input type="text" 
    value="<?php
        if(!empty($_POST["edit"]) && !empty($_POST["editPassword"]) && !empty($_POST["button3"])){
            if($editID == $edit && $editPassword == $password3){
                echo $editName;
            }
        }?>" 
    placeholder="名前" name="name"><br>
    <!--コメントフォーム-->
    <input type="text" 
    value="<?php
        if(!empty($_POST["edit"]) && !empty($_POST["editPassword"]) && !empty($_POST["button3"])){
            if($editID == $edit && $editPassword == $password3){
                echo $editComment;
            }
        }?>"  
    placeholder="コメント" name="str"><br>
    <!--パスワード-->
    <input type="text" placeholder="編集、削除用パスワードを登録" name="password2"><br>
    <!--隠し編集番号-->
    <input type="hidden" 
    value="<?php
        if(!empty($_POST["edit"]) && !empty($_POST["editPassword"]) && !empty($_POST["button3"])){
            if($editID == $edit && $editPassword == $password3){
                echo $editNum;
            }
        }?>"  
    name="hiddenEdit">
    <!--送信ボタン-->
    <input type="submit" value="送信" name="button1">
    </form> 
    <!--削除フォーム-->
<form action="" method="post">
    <input type="number" placeholder="削除対象番号" name="delete"><br>
    <!--パスワード-->
    <input type="text" placeholder="パスワードを入力" name="deletePassword"><br>
    <!--送信ボタン-->
    <input type="submit" value="削除" name="button2">
</form>

<!--編集フォーム-->
<form action="" method="post">
    <input type="number" placeholder="編集対象番号" name="edit"><br>
    <!--パスワード-->
    <input type="text" placeholder="パスワードを入力" name="editPassword"><br>
    <!--送信ボタン-->
    <input type="submit" value="編集" name="button3">
</form>
    </footer>
  </body>
 </html>
</html>

</body>
</html>