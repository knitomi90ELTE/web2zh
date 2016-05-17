<?php
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

function kivalaszt($id) {
    $alltweet = fajlbol_betolt('tweets.json');
    foreach ($alltweet as $t => $v ) {
        if($v['id'] == $id){
            $v['likeCount']++;
            unset($alltweet[$t]);
            $alltweet[] = $v;
            fajlba_ment('tweets.json', $alltweet);
            return $v['likeCount'];
        }
        return null;
    }
}

function getAll(){
    $alltweet = fajlbol_betolt('tweets.json');
    $likes = [];
    foreach ($alltweet as $t ) {
        $likes[$t['id']] = $t['likeCount'];
    }
    return $likes;
}

if(isset($_POST['id'])){
    if($_POST['id'] == 'all'){
        echo json_encode(getAll());
    } else {
        $id = $_POST['id'];
        $likes = kivalaszt($id);
        echo json_encode($likes);
    }
} else {
    echo 'hiba';
}
