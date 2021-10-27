// 計算の関数
function keisan(a, b, target) {
  let question = null;
  let flg = Math.ceil(Math.random() * 4); // 1~4のフラグ
  //四則演算のランダム
  if (flg == 1) {
     // 掛け算
    question = a * b;
    target.textContent = a + "×" + b + "=";
  } else if (flg == 2 && a % b == 0) {
     // 割り算（割り切れる時のみ）
    question = a / b;
    target.textContent = a + "÷" + b + "=";
  } else if (flg == 3) {
    // 引き算（解が負にならない場合のみ）
    question = a - b;
    target.textContent = a + "-" + b + "=";
  } else {
    // 足し算
    question = a + b;
    target.textContent = a + "+" + b + "=";
  }
  return question;
}
// 計算の答え
function answer(c) {
  const answer = c;
  return answer;
}
//ミスの答え
function miss_answer(d) {
  // 絶対値が1以上になる計算
  const miss = function () {
    let i = Math.ceil(Math.random() * 16); // 1~6
    const posi_nega = Math.ceil(Math.random() * 2); //1~2
    // 正負をランダムで出力
    if (posi_nega == 1) {
      i = i;
    } else {
      i = -i;
    }
    return i;
  }
  const m = miss();
  const answer = d + m;
  return answer;
}

// 総まとめ
let counter = 0; //正解数
let miss_counter = 0; //ミスした回数のカウント
let correct = null;

function mondai() {
  // カウンタの確認(３回以下ならゲーム続行)
  if (miss_counter < 3) {
    countDown(3);
    // ターゲットの取得
    const q = document.getElementById('question');
    countDown(3);
    // 問題エリア
    const flg = Math.ceil(Math.random() * 2); // 1〜2
    let a = 0;
    let b = 0;
    if (flg == 1) {
      a = ((Math.floor(Math.random() * 2) + 1) * 10) + Math.ceil(Math.random() * 9) ; // 11~29
      b = Math.ceil(Math.random() * 6) + 3; // 4~9
    } else {
      b = ((Math.floor(Math.random() * 2) + 1) * 10) + Math.ceil(Math.random() * 9) ; // 11~29
      a = Math.ceil(Math.random() * 6) + 3; // 4~9
    }
    const question = keisan(a, b, q);
    const answer1 = answer(question);
    // 正解の値はグローバルへ
    correct = answer1;
    const miss1 = miss_answer(question);
    const miss2 = miss_answer(question);
    const miss3 = miss_answer(question);
    let array = [];
    array = [answer1, miss1, miss2, miss3];

    // ターゲットの取得
    const array_list = document.querySelector('#answer_list');
    // 配列の並びをシャッフルする
    for (let i = (array.length - 1); 0 <= i; i--){
      let num = Math.floor(Math.random() * (i + 1)); //0~3
      let copy = array[num];
      array[num] = array[i];
      array[i] = copy;
    }
    // 正解のジャッジ
    for (let i = 0; i < array.length; i++){
      const li = array_list.children[i];
      li.id = array[i];
      li.textContent = array[i];
    }
  }
}

// カウントダウン
let zero = 0;
let time = new Array;
function countDown(i) {
    // 初期化
    clearInterval(time.shift());
    // ターゲットの取得
    const countdown = document.getElementById('countdown');
    countdown.textContent = 3;
    let reset = null;
    // 0.1秒ごとにマイナス１をする
    time.push(setInterval(() => {
      //
      i = Math.floor((i-0.09)*10) / 10;
      reset = i;
      // カウントダウンの項目に挿入
      countdown.textContent = reset;
      // 0秒になったらやめる
      if (reset <= 0) {
        clearInterval(time);
        // 0秒になったらリセット
        miss_counter++;
        miss_num.textContent = "不正解数 : " + miss_counter + "問";
        if (miss_counter >= 3) {
          modal.style.display = "";
          correct_answers_num.textContent = "正解数 : " + counter + "問でした";
          correct_answers.value = counter;
        } else {
          mondai();
        }
      }
    }, 100));
  }
