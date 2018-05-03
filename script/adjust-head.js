var atY = window.pageYOffset;
var sum = 0;

function adjust_head_h2_css_margin(){ //调整标题的margin
    var navHeadH2 = document.querySelector('nav.head h2');
    /*console.log(sum); //Debug*/
    if(sum >= 0){
        var tmp = (60 - sum)/2;
        navHeadH2.style.margin = tmp + 'px';
    } else {
        navHeadH2.style.margin = '30px';
    }
}

function adjust_welcome_pic(){// 调整welcme-pic的大小
    var welcomePic = document.querySelector('img#welcome-pic');
    if(sum >= 0){
        var tmp = (60 - sum);
        if(tmp <= 40) tmp = 40;
        welcomePic.style.height = tmp + 'px';
        welcomePic.style.width = tmp + 'px';
    } else {
        welcomePic.style.height = '60px';
        welcomePic.style.width = '60px';
    }
}

window.onscroll = function () { // 检测到用户在向下滚动页面的时候, 隐藏网站标题
    var newAtY = window.pageYOffset;
    sum = sum + newAtY - atY;
    if(sum < 0) sum = 0;
    if(sum > 60) sum = 60;
    adjust_head_h2_css_margin();
    adjust_welcome_pic();
    atY = newAtY;
}
