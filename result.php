<?php

//セッション開始
session_start();

//対象ファイルの読み込み
require_once('config/status_codes.php');

//ユーザーの回答データの取得((answer_code)正解コード(option)ユーザーの回答コード)
$answer_code = htmlspecialchars($_POST['answer_code'], ENT_QUOTES);
$option = htmlspecialchars($_POST['option'], ENT_QUOTES);

//前回以前の問題リスト
$answer_record_code = htmlspecialchars($_POST['answer_record_code'], ENT_QUOTES);

//回答履歴の更新(今回の正解と前回以前のリストを、（カンマ）で区切る)
if ($answer_record_code) {
  $list_record_code = $answer_code . ',' . $answer_record_code;
} else {
  $list_record_code = $answer_code;
}

//未選択時のエラーハンドリング
if (!$option) {
  header('Location: index.php');
}

//正誤判定のロジック((status_code)から正解コードに一致するデータを探し（$code)と($description)を取得
foreach ($status_codes as $status_code) {
  if ($status_code['code'] === $answer_code) {
    $code = $status_code['code'];
    $description = $status_code['description'];
  }
}

$result = $option === $code;  //ユーザーの選択肢($option)が正解コード($code)と一致するか比較して、結果を($result)に格納

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
  <link rel="stylesheet" href="css/result.css">
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
    <div class="result__content">
      <div class="result">
        <?php if ($result): ?>
          <h2 class="result__text--correct">正解</h2>
        <?php else: ?>
          <h2 class="result__text--incorrect">不正解</h2>
        <?php endif; ?>
      </div>
      <div class="answer-table">
        <table class="answer-table__inner">
          <tr class="answer-table__row">
            <th class="answer-table__header">ステータスコード</th>
            <td class="answer-table__text">
              <?php echo htmlspecialchars($code, ENT_QUOTES); ?>
            </td>
          </tr>
          <tr class="answer-table__row">
            <th class="answer-table__header">説明</th>
            <td class="answer-table__text">
              <?php echo htmlspecialchars($description, ENT_QUOTES); ?>
            </td>
          </tr>
        </table>
      </div>

      <?php if ($result): ?>
        <form action="index.php" method="post">
          <input type="hidden" name="answer_record_code" value="<?php echo $list_record_code ?>">
          <div class="quiz-form__button">
            <button class="quiz-form__button-submit" type="submit">
              次の問題へ
            </button>
          </div>
        </form>
      <?php endif; ?>
    </div>

  </main>
</body>


</html>