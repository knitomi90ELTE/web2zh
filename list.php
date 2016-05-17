<?php 
/*Készíts egy oldalt, ahol az üzeneteket egymás alá kilistázod. 
A megjelenítendő üzenetekben a hashtageket (pl. #iot) és az felhasználókat (pl. @adamtarcsi) 
az 1. feladat leírása szerinti hivatkozásokká kell tenni. 
Legyen lehetőség kategóriákra és beküldő nevére szűrni az oldalon!*/

require_once('fileio.php');

function szures($tweetek, $category, $tweeter) {
    if($category == '' && $tweeter == '') {
        return $tweetek;
    }
    
    $szurt = [];
    foreach($tweetek as $tw) {
        if($tw['category'] === $category){
            $szurt[] = $tw;
            continue;
        }
        if($tw['tweeter'] === $tweeter){
            $szurt[] = $tw;
            continue;
        }
    }
    return $szurt;
}


$alltweet = fajlbol_betolt('tweets.json');
$cat = isset($_GET['category']) ? $_GET['category'] : '';
$twe = isset($_GET['tweeter']) ? $_GET['tweeter'] : '';
$tweets = szures($alltweet, $cat,$twe);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tweet lista</title>
</head>
<body>
    <h1>Tweet lista</h1>
    <form action="" method="get">
        Kategória: 
        <select name="category">
            <option value=""></option>
            <option value="fontos">Fontos</option>
            <option value="erdekes">Érdekes</option>
            <option value="vicces">Vicces</option>
            <option value="kotelezo">Kötelező</option>
        </select>
        Beküldő:
        <input type="text" name="tweeter">
        <input type="submit" value="Szűr">
    </form>
    <div id="tweetList">
        <?php foreach($tweets as $t) : ?>
            <div>
                <?php 
                $patterns = array();
                $patterns[0] = '/(^|\s)(#[a-z\d-]+)/i';
                $patterns[1] = '/(^|\s)(@[a-z\d-]+)/i';
                $replacements = array();
                $replacements[1] = '$1<a href="https://twitter.com/$2">$2</a>';
                $replacements[0] = '$1<a href="https://twitter.com/$2">$2</a>';
                $formatted =  preg_replace($patterns, $replacements, $t['tweet']);
                $formatted =  str_replace("https://twitter.com/#", "https://twitter.com/", $formatted);
                $formatted =  str_replace("https://twitter.com/@", "https://twitter.com/", $formatted);
                echo $formatted;
                ?>
                <br><button data-id="<?= $t['id'] ?>"><?= $t['likeCount'] ?> LIKE</button>
            </div><br>
        <?php endforeach ?>
    </div>
    <script src="ajax.js"></script>
    <script src="like.js"></script>
</body>
</html>