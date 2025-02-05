<?php

// セッション開始
session_start();

//対象ファイルの読み込み
require_once('config/status_codes.php');

// 過去に出題された問題のIDを保存する（初回アクセス時には初期化）
if (!isset($_SESSION['answered_ids'])) {
  $_SESSION['answered_ids'] = [];
}
//過去の回答履歴を取得（前回の回答履歴(answer_record_code)を取得し$answer_record_codeに格納）
$answer_record_code = "";
if (isset($_POST['answer_record_code'])) {
  $answer_record_code = htmlspecialchars($_POST['answer_record_code'], ENT_QUOTES);
}

// 未出題の問題だけを抽出（status_codes.phpから全ての問題を取得し、出題済みのID（answered_ids)を除外した未出題の問題を抽出
$remaining_questions = array_filter($status_codes, function ($status_code) {
  return !in_array($status_code['id'], $_SESSION['answered_ids']);
});

// 全問出題済みなら履歴をリセット（$remaining_questionが空の場合に$_SESSION['answered_ids']を空にする）
if (empty($remaining_questions)) {
  $_SESSION['answered_ids'] = [];
  $remaining_questions = $status_codes;
}

// ランダムに1問を選択
$remaining_questions = array_values($remaining_questions);  // (array_filter）後の連番インデックスを再構成する
$question = $remaining_questions[array_rand($remaining_questions)]; //ランダムに1つの問題を選択して（$question）に格納する

// 出題済みのIDを記録
$_SESSION['answered_ids'][] = $question['id']; //選択された問題のIDを($_SESSION['answered_ids'])に追加し出題時に同じ問題が出題されないようにする

$options = [$question]; // 正解を含める

// 不正解の選択肢を追加
$incorrect_options = array_filter($status_codes, function ($code) use ($question) {
  return $code['id'] !== $question['id'];  //正解のIDと一致しない問題を（incorrect_option）として取得
});

$incorrect_options = array_values($incorrect_options);  //(array_rand)でランダムなキーを取得し、(min(3,count($incorrect_options))で選択肢が足りない場合でもエラーが出ないようにする
$random_incorrect_keys = array_rand($incorrect_options, min(3, count($incorrect_options)));

if (is_array($random_incorrect_keys)) {  //(is_array)で($random_incorrect_keys)が配列かを確認し、配列なら複数の不正解選択肢を取得し、($options)に追加し、($incorrect_options[$index])で不正解の選択肢を取得
  foreach ($random_incorrect_keys as $index) {
    $options[] = $incorrect_options[$index];
  }
} else {
  $options[] = $incorrect_options[$random_incorrect_keys];
}

// 選択肢をシャッフル
shuffle($options);
?>






<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Code Quiz</title>
  <link rel="stylesheet" href="css/sanitize.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/">
        Status Code Quiz
      </a>
    </div>
  </header>

  <main>
    <div class="quiz__content">
      <p>
        前回の問題:
        <?php echo $answer_record_code ?>
      </p>
      <div class="question">
        <p class="question__text">Q. 以下の内容に当てはまるステータスコードを選んでください</p>
        <p class="question__text">
          <?php echo $question['description'] ?>
        </p>
      </div>
      <form class="quiz-form" action="result.php" method="post">
        <input type="hidden" name="answer_record_code" value="<?php echo htmlspecialchars($answer_record_code, ENT_QUOTES); ?>">
        <input type="hidden" name="answer_code" value="<?php echo htmlspecialchars($question['code'], ENT_QUOTES); ?>">
        <div class="quiz-form__item">
          <?php foreach ($options as $option): ?>
            <div class="quiz-form__group">
              <input class="quiz-form__radio" id="<?php echo $option['code'] ?>" type="radio" name="option" value="<?php echo htmlspecialchars($option['code'], ENT_QUOTES); ?>">
              <label class="quiz-form__label" for="<?php echo $option['code'] ?>">
                <?php echo htmlspecialchars($option['code'], ENT_QUOTES); ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="quiz-form__button">
          <button class="quiz-form__button-submit" type="submit">
            回答
          </button>
        </div>
      </form>
    </div>
  </main>
</body>

</html>