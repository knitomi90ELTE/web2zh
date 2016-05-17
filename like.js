function $(selector) {
    return document.querySelector(selector);
}

function $$(selector) {
    return document.querySelectorAll(selector);
}

$('#tweetList').addEventListener('click',onLike,false);

function onLike(e){
    if(e.target.matches('button[data-id]')) {
        var id = e.target.getAttribute('data-id');
        console.log(id);
        ajax({
           url: 'like.php',
           mod: 'post',
           postadat: `id=${id}`,
           siker: function(xhr, data){
               var likeCount = JSON.parse(data);
               console.log(likeCount);
               e.target.innerHTML = likeCount + ' LIKE';
           } 
        });
    }
}

var updateLikes = function(){
    ajax({
        url: 'like.php',
        mod: 'post',
        postadat: 'id=all',
        siker: function(xhr, data){
            var likeCounts = JSON.parse(data);
            console.log(JSON.stringify(likeCounts));
            var buttons = $$('[data-id]');
            for(var i = 0; i < buttons.length; i++){
                buttons[i].innerHTML = likeCounts[buttons[i].getAttribute('data-id')] + ' LIKE';
            }
        } 
    });
};

setInterval(updateLikes, 2000);