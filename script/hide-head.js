var atY = window.pageYOffset;
window.onscroll = function () { // 检测到用户在向下滚动页面的时候, 隐藏网站标题
    var newAtY = window.pageYOffset;
    if(newAtY > atY){
        var h2 = document.getElementById('h2');
        h2.style.display = 'none';
    } else {
        var h2 = document.getElementById('h2');
        h2.style.display = 'block';
    }
    atY = newAtY;
}