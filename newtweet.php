<?php 

var_dump($_GET);
var_dump($_POST);

require_once('validation.php');
require_once('fileio.php');

function save_tweet($tweeter, $email, $category, $tweet){
    $tweetek = fajlbol_betolt('tweets.json');
    $tweetek[] = [
        'tweeter'   => $tweeter,
        'email'     => $email,
        'category'  => $category,
        'tweet'     => $tweet,
        'likeCount' => 0,
        'id'        => time(),
    ];
    fajlba_ment('tweets.json', $tweetek);
}

$data = [];
$errors = [];

if($_POST){
    $rules = [
      'category'  => [
          'filter' => FILTER_DEFAULT,
      ],
      'tweeter'  => [
          'filter' => FILTER_DEFAULT,
          'errormsg' => 'Nem adott meg nevet!',
      ],
      'email'  => [
          'filter' => FILTER_VALIDATE_EMAIL,
          'errormsg' => 'Rossz email!',
      ],
      'tweet'  => [
          'filter' => FILTER_DEFAULT,
          'errormsg' => 'Nem tweeteltél!',
      ],
    ];
    if(validate($_POST, $rules, $data, $errors)){
        $tweeter = $data['tweeter'];
        $email = $data['email'];
        $category = $data['category'];
        $tweet = $data['tweet'];
        save_tweet($tweeter, $email, $category, $tweet);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Tweet</title>
</head>
<body>
    <h1>New Tweet</h1>
    <?php if ($errors) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="" method="post">
        Kategória: <br>
        <select name="category" id="category" required>
            <option value="fontos" selected>Fontos</option>
            <option value="erdekes">Érdekes</option>
            <option value="vicces">Vicces</option>
            <option value="kotelezo">Kötelező</option>
        </select><br>
        Beküldő: <br>
        <input type="text" name="tweeter" id="tweeter"><br>
        Email: <br>
        <input type="text" name="email" id="email"><br>
        Tweet: <br>
        <textarea id="tweet" name="tweet" cols="80" rows="7" style="border: 1px solid black"></textarea><br>
        <input type="submit" value="Küldés" name="kuldes">
    </form>
</body>
</html>