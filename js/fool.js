document.addEventListener('DOMContentLoaded', function() {

    var matches;
    (function(doc) {
       matches =
          doc.matchesSelector ||
          doc.webkitMatchesSelector ||
          doc.mozMatchesSelector ||
          doc.oMatchesSelector ||
          doc.msMatchesSelector;
    })(document.documentElement);

    document.addEventListener('click', function(e){
        if ( matches.call(e.target, '#m-btn') ) {
            var fmenu = document.querySelector('.fool-menu');
            if (fmenu.style.display != 'block'){
                fmenu.style.display = 'block';
            }
            else{
                fmenu.style.display = '';
            }
        }
    }, false);

});
