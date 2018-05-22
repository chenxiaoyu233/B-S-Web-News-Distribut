var welcomePic = document.querySelector('img#welcome-pic');
var authorMark = document.querySelector('div.author-mark');
var head = document.querySelector('nav.head'); 

// state
var mouseDownOnHeadFlag = 0;
var delDisY = 0;
var initPosY = 0;

function init() {
   welcomePic.style.height = '0px';
   welcomePic.style.width = '0px';
   authorMark.style.height = '0px';
   head.style.top = '0px';
   welcomePic.style.marginTop = '0px';
   welcomePic.style.marginBottom = '0px';
   initPosY = 0;

}
init();

function set_time(ti) {
   welcomePic.style.transitionDuration = ti + 's';
   authorMark.style.transitionDuration = ti + 's';
   head.style.transitionDuration = ti + 's';
}

head.addEventListener('mousedown', function () {
   mouseDownOnHeadFlag = 1;
   set_time(0);
});

window.addEventListener('mousedown', function (event) {
   delDisY = initPosY - event.pageY;
});

window.addEventListener('mouseup', function () {
   mouseDownOnHeadFlag = 0;
   set_time(1);
   init();
});

function min(a, b) {
   return a < b ? a : b;
}

document.addEventListener('mousemove', function (event) {
   //console.log(event.pageX, event.pageY);
   if (!mouseDownOnHeadFlag) return;
   var curHeight = delDisY + event.pageY;
   if(curHeight < 0) curHeight = 0;
   authorMark.style.height = curHeight + 'px';
   head.style.top = curHeight + 'px';
   welcomePic.style.width = min(window.innerWidth, curHeight) + 'px';
   welcomePic.style.height = min(window.innerWidth, curHeight) + 'px';
   welcomePic.style.marginTop = (curHeight - min(window.innerWidth, curHeight)) / 2 + 'px';
   welcomePic.style.marginBottom = (curHeight - min(window.innerWidth, curHeight)) / 2 + 'px';

   initPosY = curHeight;
});

