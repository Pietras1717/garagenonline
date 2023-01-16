<footer>
    <div class="container">
        <section class="footer-wrapper">
            <div class="footer-column first">
                <a href="/"><img class="logo" src="https://pietras17.ct8.pl/wp-content/uploads/2023/01/garagen_logo_white.png" alt="Garagentore aus Polen"></a>
                <p class="info-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab pariatur vel laboriosam provident eaque temporibus harum placeat aspernatur, dolorem aliquam? Nostrum quia vero optio ex fugit deserunt delectus et id.</p>
            </div>
            <div class="footer-column">
                <h3>Our Company</h3>
                <nav class="footer-menu">
                    <ul>
                        <li>
                            <a href="/agb">
                                Agb
                            </a>
                        </li>
                        <li>
                            <a href="/montagefilme">
                                Montagefilme
                            </a>
                        </li>
                        <li>
                            <a href="/montageanleitungen">
                                Montageanleitungen
                            </a>
                        </li>
                        <li>
                            <a href="/zahlungsmoglichkeiten">
                                Zahlungsmöglichkeiten
                            </a>
                        </li>
                        <li>
                            <a href="/uber-uns">
                                Über Uns
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="footer-column">
                <h3>Information</h3>
                <nav class="footer-menu">
                    <ul>
                        <li>
                            <a href="/disclaimer">
                                Disclaimer
                            </a>
                        </li>
                        <li>
                            <a href="/lieferbedingungen">
                                Lieferbedingungen
                            </a>
                        </li>
                        <li>
                            <a href="/lieferzeiten">
                                Lieferzeiten
                            </a>
                        </li>
                        <li>
                            <a href="/haufig-gestelle-fragen">
                                Häufig gestelle fragen
                            </a>
                        </li>
                        <li>
                            <a href="/datenschutzerklarung">
                                Datenschutzerklärung
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="footer-column">
                <h3>Static Block</h3>
                <nav class="footer-menu">
                    <ul>
                        <li>
                            <a href="/">
                                Startseite
                            </a>
                        </li>
                        <li>
                            <a href="/referenzen">
                                Referenzen
                            </a>
                        </li>
                        <li>
                            <a href="/blog">
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="/mein-konto">
                                Mein konto
                            </a>
                        </li>
                        <li>
                            <a href="/kontakt">
                                Kontakt
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="footer-column last">
                <h3>Store information</h3>
                <div class="information-block">
                    <div class="single-information">
                        <i class="fa fa-location-pin"></i><span>60 29th Street San Francisco, CA 94110 507-Union Trade Center, United States of America</span>
                    </div>
                    <div class="single-information">
                        <i class="fa fa-phone"></i><a href="tel:03096615487">030 / 966 15 487</a>
                    </div>
                    <div class="single-information">
                        <i class="fa fa-envelope"></i><a href="mailto:">info@garagenonline.eu</a>
                    </div>
                    <div class="single-information">
                        <i class="fa fa-clock"></i>
                        <span>Beratung und Verkauf: Montag – Freitag 08:00 – 14:30</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</footer>
<section class="copyright">
    <div class="container">
        <div class="copyright-wrapper">
            <p>Copyright &copy; <?php echo date("Y") ?> <?php echo get_option('blogname') ?></p>
            <div class="payments-method">
                <img width="100px" src="https://pietras17.ct8.pl/wp-content/uploads/2023/01/paypal.png" alt="paypal">
            </div>
        </div>
    </div>
</section>
<?php wp_footer(); ?>
<!-- Messenger Wtyczka czatu Code -->
<div id="fb-root"></div>

<!-- Your Wtyczka czatu code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "106612032329563");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v15.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/de_DE/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>