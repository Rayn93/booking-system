<?php
/*
Template Name: Po rejestracji
*/
session_start();

global $post,
       $mk_options;
$page_layout = get_post_meta( $post->ID, '_layout', true );
$padding = get_post_meta( $post->ID, '_padding', true );


if ( empty( $page_layout ) ) {
    $page_layout = 'full';
}
$padding = ($padding == 'true') ? 'no-padding' : '';

//if(isset($_SESSION['new_guest_name'])){

get_header();

?>
    <div id="theme-page">
        <div class="mk-main-wrapper-holder">
            <div id="mk-page-id" class="theme-page-wrapper mk-main-wrapper mk-grid vc_row-fluid confirmation_page">
                <div class="theme-content <?php echo $padding; ?>" itemprop="mainContentOfPage">
                    <h1>Cześć <?php echo $_SESSION['new_guest_name'] ?></h1>

                    <?php if ( have_posts() ) while ( have_posts() ) : the_post();?>
                        <?php the_content();?>
                        <div class="clearboth"></div>
                        <?php wp_link_pages( 'before=<div id="mk-page-links">'.__( 'Pages:', 'mk_framework' ).'&after=</div>' ); ?>
                    <?php endwhile; ?>
                </div>


<!--                <h2>Pomyślnie zarejestrowałeś się na obóz żeglarski z Gertis. Czeka Cię wspaniały czas! Na dole znajdziesz kilka informacji co dalej.</h2>-->
<!--                <br /><br />-->
<!--                <p>Ze względów bezpieczeństwa tą stronę ujżysz tylko raz. Jednak nie martw się. <strong> Na adres email: --><?php //echo $_SESSION['email'] ?><!--  otrzymasz niedługo potwierdzenie rejestracji,</strong> razem z najważniejszymi informacjami</p>-->
<!--                <p>Miejsce zostaje zarezerwowane na <strong>5 dni roboczych</strong>. Aby potwierdzić rezerwację należy dokonać wpłaty <strong>zaliczki w wysokości 600 zł </strong>. Zaliczkę możesz wykonać korzystając z poniższego przycisku (płatność za pośrednictwem PayPal). </p>-->
<!---->
<!---->
<!--                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">-->
<!--                    <input type="hidden" name="cmd" value="_s-xclick">-->
<!--                    <input type="hidden" name="hosted_button_id" value="66KKJCHJLR99C">-->
<!--                    <input class="paypal_button" type="image" src="https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal – Płać wygodnie i bezpiecznie">-->
<!--                    <img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">-->
<!--                </form>-->
<!---->
<!---->
<!---->
<!---->
<!--                <p>Zaliczkę możesz również uregulować poprzez przelew bankowy na konto:</p>-->
<!--                <p><strong>-->
<!--                    Gertis - Marek Makowski <br />-->
<!--                    Nr konta bankowego: 52 938123823 129389123 12830123<br />-->
<!--                    Tytułem: --><?php //echo $_SESSION['new_guest_name'] ?><!--. Zaliczka za obóz: --><?php //echo $_SESSION['event_turn'] ?><!--</strong>-->
<!--                </p>-->
<!---->
<!--                <p>Pozostałe płatności należy dokonać <strong>do 21 dni przed imprezą lub zgodnie z ustaleniami indywidualnymi.</strong></p>-->
<!--                <p>W razie jakichkolwiek pytań służymy pomocą. Wszelkie dane kontaktowe znajdziesz w zakładce: <a href="--><?php //echo get_site_url().'/kontakt' ?><!--"> kontakt</a></p>-->
<!--                <p>-->
<!--                    Do zobaczenia pod żaglami ;) <br />-->
<!--                    <strong>Zespół Gertis. </strong>-->
<!--                </p>-->

            </div>
        </div>
    </div>

<?php

unset($_SESSION['new_guest_name']);
get_footer();

//}
//else{
//    header("Location: http://localhost/system-rezerwacji");
//    exit;
//}


