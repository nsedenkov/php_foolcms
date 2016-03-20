<h2>Используйте удобный для Вас вид связи:</h2>
<p>Email: info@sedenkov.xyz</p>
<p>Либо направьте сообщение непосредственно с этой страницы:</p>
<form class="contact-form" id="contact_form">
    <div class="contact-left">
        <div class="contact-name">
             <input id="commentsName" type="text" placeholder="Ваше имя" name="cname" />
        </div>
        <div class="contact-email">
             <input id="commentsEmail" type="text" placeholder="Ваш email" name="cemail" />
        </div>
        <div class="contact-theme">
             <input id="commentsTheme" type="text" placeholder="Тема" name="ctheme" />
        </div>
    </div>
    <div class="contact-right">
        <div class="contact-textarea">
             <textarea placeholder="Сообщение" name="ccomment" id="commentsText" rows="12" cols="56"></textarea>
        </div>
        <button type="contsubmit" id="c_submit" class="contact-submit">Отправить</button>
        <input type="hidden" name="action" id="commentsAct" value="new_qstn" />
    </div>
    <div class="cf"></div>
    <div id="sendRes"></div>
</form><!-- End of contact form -->
