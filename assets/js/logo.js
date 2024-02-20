document.addEventListener('DOMContentLoaded', function () {
    var logoContainer = document.getElementById('logoContainer');
    var whiteLogo = document.getElementById('whiteLogo');
    var darkLogo = document.getElementById('darkLogo');

    window.addEventListener('scroll', function () {
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
            whiteLogo.style.display = 'none';
            darkLogo.style.display = 'block';
        } else {
            whiteLogo.style.display = 'block';
            darkLogo.style.display = 'none';
        }
    });
});
