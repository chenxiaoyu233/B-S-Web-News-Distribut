var welcomePic = document.querySelector('img#welcome-pic');

welcomePic.addEventListener('mouseover', function () {
    welcomePic.style.height = '500px';
    welcomePic.style.width = '500px';
});

welcomePic.addEventListener('mouseout', function () {
    welcomePic.style.height = '40px';
    welcomePic.style.width = '40px';
});
