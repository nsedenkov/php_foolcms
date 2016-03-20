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

    $('#contact_form').validate({
        rules: {
            cname: {
                required: true,
                minlength: 2
            },
            cemail: {
                required: true,
                email: true
            },
            ccomment: {
                required: true,
            }
        },
        messages: {
            cname: {
                required: 'Укажите имя',
                minlength: 'Вы китаец? Серьезно?'
            },
            cemail: {
                required: 'Укажите email',
                email: 'Введите верный email'
            },
            ccomment: {
                required: 'Кажется, Вы собирались оставить сообщение?',
            }
        },
        submitHandler: function() {
            var form_data = {
                action:$('#commentsAct').val(),
                subject:$('#commentsTheme').val(),
                name:$('#commentsName').val(),
                email:$('#commentsEmail').val(),
                message:$('#commentsText').val()
                };
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: form_data,
                success: function( resp ){
                    $('#contact_form').trigger('reset');
                    var resar = JSON.parse(resp);
                    $('#sendRes').append('<p>Спасибо! Вашему обращению присвоен №' + resar.q_id + '</p>');
                    console.log('AJAX status: ' + resar.status);
                },
                error: function( xhr, status, errorThrown) {
                    console.log( 'ERROR: ' + errorThrown );
                    console.log( 'Status: ' + status );
                    console.dir( xhr );
                }
            });
        }
    }); //Contact form validation
});
