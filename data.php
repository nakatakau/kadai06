<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <p>送信完了しました</p>
  <?php
  function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }
  $username = $_POST["username"];
  $correct_answers = $_POST["correct_answers"];
  $c = ",";
  echo h($username . "さん" . "<br>");
  echo h($correct_answers . "問正解" . "<br>");
  date_default_timezone_set('Asia/Tokyo');
  //文字作成
  $str = date("Y-m-d") . $c . h($username) . $c . h($correct_answers);
  //File書き込み
  $file = fopen("data/data.csv", "a");  // ファイル読み込み
  fwrite($file, $str . "\n");
  fclose($file);
  ?>

  <a href="view/index.php">戻る</a>
</body>

</html>
