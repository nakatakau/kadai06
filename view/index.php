<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">
  <title>暗算道場</title>
</head>

<body>
  <?php
  // ファイルを変数に格納
  $filename = '../data/data.csv';
  // fopenでファイルを開く（'r'は読み込みモードで開く）
  $fp = fopen($filename, 'r');
  ?>
  <header>
    <h1>暗算道場</h1>
    <p>不正解数が３問以上になったらゲームオーバー</p>
    <p>3秒以内に正解をタッチできないと不正解になるよ！</p>
  </header>

  <div class="flex position">
    <!-- 計算メインエリア -->
    <main>
      <h2>道場エリア</h2>
      <div id="calculation_area">
      </div>
    </main>
    <!-- ランキング -->
    <aside>
    </aside>
  </div>

  <!-- 実際の計算時 -->
  <div class="flex hidden">
    <!-- 計算メインエリア -->
    <main id="open">
      <div id="calculation_area1">
        <h2>道場エリア</h2>
        <div class=flex>
          <label for="user">名前<input type="text" name="user"></label>
          <button id="start" onclick="mondai()">スタート</button>
        </div>
        <div id="question_area">
          <h2 id="correct_num">正解数 : 0問</h2>
          <h2 id="miss_num"> 不正解数 : 0問</h2>
          <h2 id="countdown"></h2>
          <h2 id="question"></h2>
        </div>
        <div id="answer_area">
          <ul id="answer_list">
            <li id=""></li>
            <li id=""></li>
            <li id=""></li>
            <li id=""></li>
          </ul>
        </div>
      </div>
    </main>
    <!-- ランキング -->
    <aside>
      <h2>ランキング</h2>
      <div id="ranking_area">
          <?php
          echo
          "<table class='header'>
            <tr>
              <th>順位</th>
              <th>点数</th>
              <th>名前</th>
              <th>日付</th>
            </tr>";
          // whileで行末までループ処理
          $i = 1;
          while (!feof($fp)) {
            // fgetsでファイルを読み込み、変数に格納
            $csv = trim(fgets($fp));
            $array = explode(",", $csv);
            $key = (int)$array[2]; //数値に変換
            $sort[$key] = [$array[0], $array[1]];
          }
          krsort($sort);
          foreach ($sort as $key => $value) {
            echo "<tr><td>".$i."</td><td>".$key ."</td>"."<td>".$value[1]."</td>"."<td>".$value[0]."</td></tr>";
            $i ++;
          }
          // fcloseでファイルを閉じる
          fclose($fp);
          echo "</table>"
          ?>
      </div>
    </aside>
  </div>
  <!-- 結果の表示 -->
  <div id="modal">
    <div id="result">
      <img src="../img/end.svg" alt="閉じる" id="close">
      <form action="../data.php" method="post" id="post_form">
        <p id="name">名前</p>
        <input type="hidden" name="username" value="">
        <p id="correct_answers_num">正解数</p>
        <input type="hidden" name="correct_answers" value="">
        <input type="submit" value="送信" id="submit">
      </form>
    </div>
  </div>
  <footer>
  </footer>

  <script src="../JS/main.js"></script>
  <script>
    // ターゲットの取得
    const close = document.getElementById('close');
    const modal = document.getElementById('modal');
    const name = document.getElementById('name');
    const user = document.querySelector('input[name="user"]');
    const correct_answers_num = document.getElementById('correct_answers_num');
    const correct_answers = document.querySelector('input[name="correct_answers"]');
    const username = document.querySelector('input[name="username"]');
    const correct_num = document.getElementById('correct_num');
    const miss_num = document.getElementById('miss_num');
    const li_list = document.getElementsByTagName('li');
    for (let i = 0; i < li_list.length; i++) {
      li_list[i].addEventListener('click', function(e) {
        if (e.currentTarget.id == "") {
          mondai();
        } else {
          // クリックしたものが正解か不正解の判断
          if (e.currentTarget.id == correct) {
            //正解に加算
            counter++;
            correct_num.textContent = "正解数 : " + counter + "問";
            mondai();
          } else {
            // 不正解に加算
            miss_counter++;
            miss_num.textContent = "不正解数 : " + miss_counter + "問";
            mondai();
            if (miss_counter >= 3) {
              modal.style.display = "";
              name.textContent = "お名前 : " + user.value + "さん";
              correct_answers_num.textContent = "正解数 : " + counter + "問でした";
              username.value = user.value;
              correct_answers.value = counter;
            }
          }
        }
      })
    }
    // 罰ボタンの実装
    close.addEventListener('click', () => {
      modal.style.display = "none";
    })
    // リロード
    function start() {
      modal.style.display = "none";
    }
    start();
  </script>
</body>

</html>
