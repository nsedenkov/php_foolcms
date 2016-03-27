</div><!-- wrapper -->
<footer class="footer">
<div class="copyright m-top m-bottom m-left">
<p><strong>&copy; <?php FoolCore::getInstance()->outParam('fool_year');echo ", ";FoolCore::getInstance()->outParam('fool_author'); ?></strong></p>
</div>
<div class="fright m-top m-bottom m-right">
<p>Powered by FoolCMS</p>
</div>
</footer>
<script type='text/javascript' src=<?php echo "\""; FoolCore::getInstance()->outDomName(); echo "js/jquery/jquery-1.11.3.min.js" . "\""?>></script>
<script type='text/javascript' src=<?php echo "\""; FoolCore::getInstance()->outDomName(); echo "js/jquery/jquery.validate.min.js" . "\""?>></script>
<script type='text/javascript' src=<?php echo "\""; FoolCore::getInstance()->outDomName(); echo "js/fool.js" . "\""?>></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter36370730 = new Ya.Metrika({
                    id:36370730,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/36370730" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
