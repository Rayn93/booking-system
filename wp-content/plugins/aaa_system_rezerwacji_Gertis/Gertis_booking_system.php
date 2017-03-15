<?php

ob_start(); //http://www.lessthanweb.com/blog/wordpress-and-wp_redirect-function-problem
session_start();

/*
     * Plugin Name: System rezerwacji dla Gertis
     * Plugin URI: http://www.robertsaternus.pl
     * Description: System rezerwacji na rejsy, dedykowany dla Gertis.
     * Author: Robert Saternus
     * Version: 1.1
     * Author URI: http://www.robertsaternus.pl
     */


require_once 'libs/Gertis_BookingSystem_Model.php';
require_once 'libs/Gertis_EventEntry.php';
require_once 'libs/Gertis_GuestEntry.php';
require_once 'libs/Gertis_Pagination.php';
require_once 'libs/Request.php';
require_once 'libs/shortcodes.php';


class Gertis_booking_system{

    private static $plugin_id = 'gertis-book-system';
    private $plugin_version = '1.1.0';
    private $user_capability = 'manage_options';
    private $model;
    private $action_token = 'gertis-bs-action';
    private $pagination_limit = 10;



    function __construct() {
        $this->model = new Gertis_BookingSystem_Model();

        //uruchamianie podczas aktywacji
        register_activation_hook(__FILE__, array($this, 'onActivate'));

        //rejestracja przycisku w menu
        add_action('admin_menu', array($this, 'createAdminMenu'));

        //rejestracja styli i skryptów dla frontendu
        add_action('wp_enqueue_scripts', array($this, 'addPageScripts'));

        //rejestracja styli i skryptów dla admina
        add_action('admin_enqueue_scripts', array($this, 'addAdminScripts'));

        //akcja obsługi formularza na frontendzie
        add_action('init', array($this, 'handleGertisMainForm'));




//        $guest_for_confirm = new Gertis_GuestEntry(8);
//        $guest_email = $guest_for_confirm->getField('email');
//        var_dump($guest_email);

    }


    function onActivate(){
        $ver_opt = static::$plugin_id.'-version';
        $installed_version = get_option($ver_opt, NULL);

        if($installed_version == NULL){

            $this->model->createDbTableGuest();
            $this->model->createDbTableEvent();
            update_option($ver_opt, $this->plugin_version);

        }else{

            switch (version_compare($installed_version, $this->plugin_version)) {
                case 0:
                    //zainstalowana wersja jest identyczna z tą
                    break;

                case 1:
                    //zainstalowana wersja jest nowsza niż ta
                    break;

                case -1:
                    //zainstalowana wersja jest starsza niż ta
                    break;
            }
        }
    }

    //Podpięcie styli css i skryptów js WAŻNE! Upewnić się czy tytuł strony się zgadza
    function addPageScripts(){

        wp_register_script('gertis-bootstrap-script', plugins_url('/js/bootstrap.min.js', __FILE__), array('jquery'));
        wp_register_script('bootstrap-validation', plugins_url('/js/bootstrap-validation.js', __FILE__), array('jquery', 'gertis-bootstrap-script'));
        wp_register_script('recaptha-google', 'https://www.google.com/recaptcha/api.js', array('jquery', 'gertis-bootstrap-script', 'bootstrap-validation'));

        wp_register_style('bootstrap-style', plugins_url('/css/bootstrap.min.css', __FILE__));
        wp_register_style('gertis-custom-style', plugins_url('/css/style.css', __FILE__));


        if(is_page('A System rezerwacji')){

            wp_enqueue_script('jquery');
            wp_enqueue_script('gertis-bootstrap-script');
            wp_enqueue_script('bootstrap-validation');
            wp_enqueue_script('recaptha-google');

            wp_enqueue_style('bootstrap-style');

        }

        wp_enqueue_style('gertis-custom-style');
    }

    function addAdminScripts(){

        wp_register_script('gertis-export-excel', plugins_url('/js/jquery.table2excel.js', __FILE__), array('jquery'));
        wp_register_script('gertis-custom-script', plugins_url('/js/custom-scripts.js', __FILE__), array('jquery', 'gertis-export-excel'));

        wp_register_style('gertis-admin-style', plugins_url('/css/style-admin.css', __FILE__));

        if(get_current_screen()->id == 'toplevel_page_'.static::$plugin_id || get_current_screen()->id == 'system-rezerwacji_page_'.static::$plugin_id.'-guests'){

            wp_enqueue_script('jquery');
            wp_enqueue_script('gertis-export-excel');
            wp_enqueue_script('gertis-custom-script');

            wp_enqueue_style('gertis-admin-style');
        }
    }

    function createAdminMenu(){

        add_menu_page('Gertis System Rezerwacji', 'System rezerwacji', $this->user_capability, static::$plugin_id, array($this, 'printAdminPageEvent'), 'dashicons-calendar-alt', 66);
        add_submenu_page(static::$plugin_id, 'Obozy żeglarskie', 'Obozy żeglarskie', $this->user_capability, static::$plugin_id, array($this, 'printAdminPageEvent'));
        add_submenu_page(static::$plugin_id, 'Zapisani uczestnicy', 'Uczestnicy', $this->user_capability, static::$plugin_id.'-guests', array($this, 'printAdminPageGuest'));

    }

    //Kontroler dla strony z listą z rejsami
    function printAdminPageEvent(){

        $request = Request::instance();
        $view = $request->getQuerySingleParam('view', 'events');
        $action = $request->getQuerySingleParam('action');
        $eventid = (int)$request->getQuerySingleParam('eventid');

        switch ($view) {
            case 'events':

                if($action == 'delete'){

                    $token_name = $this->action_token.$eventid;
                    $wpnonce = $request->getQuerySingleParam('_wpnonce', NULL);

                    if(wp_verify_nonce($wpnonce, $token_name)){

                        if($this->model->deleteRow($eventid, 'event') !== FALSE){
                            $this->setFlashMsg('Poprawnie usunięto wydarzenie!');
                        }
                        else{
                            $this->setFlashMsg('Nie udało się usunąć wydarzenia', 'error');
                        }
                    }
                    else{
                        $this->setFlashMsg('Nie poprawny token akcji', 'error');
                    }

                    $this->redirect($this->getAdminPageUrl());

                }
                else if($action == 'bulk'){

                    if ($request->isMethod('POST') && check_admin_referer($this->action_token . 'bulk')) {

                        $bulk_action = (isset($_POST['bulkaction'])) ? $_POST['bulkaction'] : NULL;
                        $bulk_check = (isset($_POST['bulkcheck'])) ? $_POST['bulkcheck'] : array();

                        if (count($bulk_check) < 1) {
                            $this->setFlashMsg('Brak wydarzeń do zmiany', 'error');
                        }
                        else {
                            if ($bulk_action == 'delete') {

                                if ($this->model->bulkDelete($bulk_check, 'event') !== FALSE) {
                                    $this->setFlashMsg('Poprawnie usunięto zaznaczone wydarzenia!');
                                }
                                else {
                                    $this->setFlashMsg('Nie udało się usunąć zaznaczonych wydarzeń', 'error');
                                }
                            }
                            else if ($bulk_action == 'actual' || $bulk_action == 'no_actual') {

                                if ($this->model->bulkChangeStatus($bulk_check, $bulk_action , 'event') !== FALSE) {
                                    $this->setFlashMsg('Poprawnie zmieniono status wydarzeń');
                                }
                                else {
                                    $this->setFlashMsg('Nie udało się zmienić statusu zaznaczonych wydarzeń', 'error');
                                }
                            }
                        }
                    }
                    $this->redirect($this->getAdminPageUrl());
                }

                $curr_page = (int)$request->getQuerySingleParam('paged', 1);
                $order_by = $request->getQuerySingleParam('orderby', 'id');
                $order_dir = $request->getQuerySingleParam('orderdir', 'asc');

                $pagination = $this->model->getEventPagination($curr_page, $this->pagination_limit, $order_by, $order_dir);


                $this->renderEvent('events', array('Pagination' => $pagination));
                break;

            case 'event-form':

                if($eventid > 0){
                    $EventEntry = new Gertis_EventEntry($eventid);

                    if(!$EventEntry->exist()){
                        $this->setFlashMsg('Brak takiego wydarzenia', 'error');
                        $this->redirect($this->getAdminPageUrl());
                    }
                }
                else{
                    $EventEntry = new Gertis_EventEntry();
                }


                if($action == 'save' && $request->isMethod('POST') && $_POST['entry']){

                    //Sprawdzenie czy token akcji  formularza jest poprawny
                    if(check_admin_referer($this->action_token)){

                        $EventEntry->setFields($_POST['entry']);

                        if($EventEntry->validate()){

                            $entry_id = $this->model->saveEventEntry($EventEntry);

                            if($entry_id != FALSE){
                                if($EventEntry->hasId()){
                                    $this->setFlashMsg('Poprawnie zmodyfikowano wydarzenie');
                                }
                                else{
                                    $this->setFlashMsg('Poprawnie dodano nowe wydarzenie');
                                }
                                $this->redirect($this->getAdminPageUrl('', array('view' => 'event-form', 'eventid' => $entry_id)));
                            }
                            else{
                                $this->setFlashMsg('Nie udało się dodać/edytować wydarzenia. Sprawdź czy dokonałeś/aś jakiś zmian w formularzu.', 'error');
                            }
                        }
                        else{
                            $this->setFlashMsg('Popraw pola formularza', 'error');
                        }
                    }
                    else{
                        $this->setFlashMsg('Błędny token formularza', 'error');
                    }
                }

                $this->renderEvent('event-form', array('Event' => $EventEntry));
                break;

            default:
                $this->renderEvent('404');
                break;
        }
    }


    //Kontroler dla strony z listą uczestników + obsługa formularza uczestników
    function printAdminPageGuest(){

        $request = Request::instance();
        $view = $request->getQuerySingleParam('view', 'guests');
        $action = $request->getQuerySingleParam('action');
        $guestid = (int)$request->getQuerySingleParam('guestid');
        $event_turn = $request->getQuerySingleParam('event_turn');

        switch ($view) {
            case 'guests':

                if($action == 'delete'){

                    $token_name = $this->action_token.$guestid;
                    $wpnonce = $request->getQuerySingleParam('_wpnonce', NULL);

                    if(wp_verify_nonce($wpnonce, $token_name)){

                        if($this->model->deleteRow($guestid, 'guest') !== FALSE){
                            $this->setFlashMsg('Poprawnie usunięto uczestnika!');
                        }
                        else{
                            $this->setFlashMsg('Nie udało się usunąć uczestnika', 'error');
                        }
                    }
                    else{
                        $this->setFlashMsg('Nie poprawny token akcji', 'error');
                    }

                    $this->redirect($this->getAdminPageUrl('-guests'));

                }
                else if($action == 'confirm'){

                    $token_name = $this->action_token.$guestid;
                    $wpnonce = $request->getQuerySingleParam('_wpnonce', NULL);

                    if(wp_verify_nonce($wpnonce, $token_name)){

                        if($this->model->confirmGuest($guestid) !== FALSE){

                            $guest_for_confirm = new Gertis_GuestEntry($guestid);
                            $guest_conf_email = $guest_for_confirm->getField('email');
                            $this->sendEmail('confirm_guest', $guest_conf_email);
                            $this->setFlashMsg('Poprawnie potwierdzono uczestnictwo i wysłano mail do uczestnika z potwierdzeniem.');
                        }
                        else{
                            $this->setFlashMsg('Nie udało się potwierdzić uczestnictwo tego uczestnika.', 'error');
                        }
                    }
                    else{
                        $this->setFlashMsg('Nie poprawny token akcji. Spróbuj jeszcze raz.', 'error');
                    }

                    $this->redirect($this->getAdminPageUrl('-guests'));

                }
                else if($action == 'cancel'){

                    $token_name = $this->action_token.$guestid;
                    $wpnonce = $request->getQuerySingleParam('_wpnonce', NULL);

                    if(wp_verify_nonce($wpnonce, $token_name)){

                        if($this->model->cancelGuest($guestid) !== FALSE){

                            $guest_for_confirm = new Gertis_GuestEntry($guestid);
                            $guest_conf_email = $guest_for_confirm->getField('email');
                            $this->sendEmail('cancel_guest', $guest_conf_email);
                            $this->setFlashMsg('Poprawnie anulowano uczestnictwo i wysłano mail do uczestnika z wiadomością o anulowaniu.');
                        }
                        else{
                            $this->setFlashMsg('Nie udało się anulować tego uczestnika.', 'error');
                        }
                    }
                    else{
                        $this->setFlashMsg('Nie poprawny token akcji. Spróbuj jeszcze raz.', 'error');
                    }

                    $this->redirect($this->getAdminPageUrl('-guests'));

                }
                else if($action == 'bulk'){

                    if ($request->isMethod('POST') && check_admin_referer($this->action_token . 'bulk')) {

                        $bulk_action = (isset($_POST['bulkaction'])) ? $_POST['bulkaction'] : NULL;
                        $bulk_check = (isset($_POST['bulkcheck'])) ? $_POST['bulkcheck'] : array();

                        if (count($bulk_check) < 1) {
                            $this->setFlashMsg('Brak uczestników do zmiany', 'error');
                        }
                        else {
                            if ($bulk_action == 'delete') {

                                if ($this->model->bulkDelete($bulk_check, 'guest') !== FALSE) {
                                    $this->setFlashMsg('Poprawnie usunięto zaznaczonych uczestników!');
                                }
                                else {
                                    $this->setFlashMsg('Nie udało się usunąć zaznaczonych uczestników', 'error');
                                }
                            }
                            else if ($bulk_action == 'resign' || $bulk_action == 'old' || $bulk_action == 'waiting') {

                                if ($this->model->bulkChangeStatus($bulk_check, $bulk_action , 'guest') !== FALSE) {
                                    $this->setFlashMsg('Poprawnie zmieniono status wybranych uczestników');
                                }
                                else {
                                    $this->setFlashMsg('Nie udało się zmienić statusu zaznaczonych uczestników', 'error');
                                }
                            }
                        }
                    }
                    $this->redirect($this->getAdminPageUrl('-guests'));
                }

                $curr_page = (int)$request->getQuerySingleParam('paged', 1);
                $order_by = $request->getQuerySingleParam('orderby', 'id');
                $order_dir = $request->getQuerySingleParam('orderdir', 'asc');
                //$event_turn = $request->getQuerySingleParam('event_turn');

                //Generowanie listy uczestników dla poszczególnego turnusu
                if($action == 'members'){
                    $pagination = $this->model->getGuestPagination($curr_page, 100, $order_by, $order_dir, $event_turn);
                }
                else{
                    $pagination = $this->model->getGuestPagination($curr_page, $this->pagination_limit, $order_by, $order_dir);
                }

                $this->renderGuest('guests', array('Pagination' => $pagination));
                break;

            case 'guest-form':

                if($guestid > 0){
                    $GuestEntry = new Gertis_GuestEntry($guestid);

                    if(!$GuestEntry->exist()){
                        $this->setFlashMsg('Brak takiego uczestnika', 'error');
                        $this->redirect($this->getAdminPageUrl('-guests'));
                    }
                }
                else{
                    $GuestEntry = new Gertis_GuestEntry();
                }


                if($action == 'save' && $request->isMethod('POST') && $_POST['entry']){

                    //Sprawdzenie czy token akcji w formularza jest poprawny
                    if(check_admin_referer($this->action_token)){

                        $GuestEntry->setFields($_POST['entry']);

                        if($GuestEntry->validate()){

                            $entry_id = $this->model->saveGuestEntry($GuestEntry);

                            if($entry_id != FALSE){
                                if($GuestEntry->hasId()){
                                    $this->setFlashMsg('Poprawnie zmodyfikowano dane uczestnika');
                                }
                                else{
                                    $this->setFlashMsg('Poprawnie dodano nowego uczestnika');
                                }
                                $this->redirect($this->getAdminPageUrl('-guests', array('view' => 'guest-form', 'guestid' => $entry_id)));
                            }
                            else{
                                $this->setFlashMsg('Nie udało się dodać/edytować uczestnika. Sprawdź czy dokonałeś/aś jakiś zmian w formularzu.', 'error');
                            }
                        }
                        else{
                            $this->setFlashMsg('Popraw pola formularza', 'error');
                        }
                    }
                    else{
                        $this->setFlashMsg('Błędny token formularza', 'error');
                    }
                }

                $this->renderGuest('guest-form', array('Guest' => $GuestEntry));
                break;

            default:
                $this->renderGuest('404');
                break;
        }
    }

    //Funkcja obsługująca formularz w frondendzie.
    function handleGertisMainForm(){


        if (isset($_POST['front_entry'])){

            //Sprawdzenie Recaptchy
            $recaptcha_secret = '6LcesSATAAAAAEbSpdql0Q8_rx8m7utCEIgcnfUu';
            $check_recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$recaptcha_secret.'&response='.$_POST['g-recaptcha-response']);
            $feedback_recaptcha = json_decode($check_recaptcha);

            //Gdy recaptcha jest poprawna
            if($feedback_recaptcha->success){

                $GuestEntry = new Gertis_GuestEntry();

                if(check_admin_referer($this->action_token)) {

                    $GuestEntry->setFields($_POST['front_entry']);

                    if ($GuestEntry->validate()) {

                        $entry_id = $this->model->saveGuestEntry($GuestEntry);

                        if ($entry_id != FALSE) {

                            //Mail do admina o nowym uczestniku (wysłać $entry_id) oraz do uczestnika
                            $mail_params = array(
                                'guest_name' => $GuestEntry->getField('guest_name'),
                                'event_turn' => $GuestEntry->getField('event_turn'),
                                'id' => $GuestEntry->getField('id'),
                                'email' => $GuestEntry->getField('email'),
                            );
                            $this->sendEmail('registration_guest', $GuestEntry->getField('email'), $mail_params);
                            $this->sendEmail('registration_admin', $this->getAdminEmail(), $mail_params);

                            $_SESSION['new_guest_name'] = $GuestEntry->getField('guest_name');
                            $_SESSION['event_turn'] = $GuestEntry->getField('event_turn');
                            $_SESSION['email'] = $GuestEntry->getField('email');
                            $this->redirect(get_site_url().'/a-po-rejestracji');

                        }
                        else {
                            //Przekirowanie na stronę z formularzem z informacją że rejestracja się nie powiodła
                            $_SESSION['form_error'] = 'Błąd bazy danych. Spróbuj ponownie za jakiś czas lub skontaktuj się z nami.';
                            $this->redirect(get_site_url().'/a-system-rezerwacji/');
                        }
                    }
                    else {
                        //Przekirowanie na stronę z formularzem z informacją że nie przeszło walidacji
                        $_SESSION['form_error'] = 'Formularz nie został poprawnie wypełniony. Wypełnij formularz ponownie';
                        $this->redirect(get_site_url().'/a-system-rezerwacji/');
                    }
                }
                else{
                    //Przekirowanie na stronę z formularzem z informacją że błędny token
                    $_SESSION['form_error'] = 'Błąd tokena. Wyczyść pliki przeglądarki i spróbuj ponownie!';
                    $this->redirect(get_site_url().'/a-system-rezerwacji/');
                }
            }
            else{
                //Przekirowanie na stronę z formularzem z informacją że recaptcha jest błędna
                $_SESSION['form_error'] = 'Błąd weryfikacji recaptch-y. Spróbuj jeszcze raz jeżeli nie jesteś botem :)';
                $this->redirect(get_site_url().'/a-system-rezerwacji/');
            }
        }
    }


    //Funkcja służąca do renderowania widoków dla sekcji z rejsami
    private function renderEvent($view, array $args = array()){

        extract($args);
        $tmpl_dir = plugin_dir_path(__FILE__).'templates/';
        $view = $tmpl_dir.$view.'.php';
        require_once $tmpl_dir.'layout-event.php';

    }

    //Funkcja służąca do renderowania widoków dla sekcji z uczestnikami
    private function renderGuest($view, array $args = array()){

        extract($args);
        $tmpl_dir = plugin_dir_path(__FILE__).'templates/';
        $view = $tmpl_dir.$view.'.php';
        require_once $tmpl_dir.'layout-guest.php';

    }



    //Zwraca link do pluginu (parametr $page dla uczestników powinien mieć wartość '-guests')
    public function getAdminPageUrl($page ='', array $params = array()){
        $admin_url = admin_url('admin.php?page='.static::$plugin_id.$page);
        $admin_url = add_query_arg($params, $admin_url);

        return $admin_url;
    }


    public function setFlashMsg($message, $status = 'updated'){
        $_SESSION[__CLASS__]['message'] = $message;
        $_SESSION[__CLASS__]['status'] = $status;
    }

    public function getFlashMsg(){
        if(isset($_SESSION[__CLASS__]['message'])){
            $msg = $_SESSION[__CLASS__]['message'];
            unset($_SESSION[__CLASS__]);
            return $msg;
        }

        return NULL;
    }

    public function getFlashMsgStatus(){
        if(isset($_SESSION[__CLASS__]['status'])){
            return $_SESSION[__CLASS__]['status'];
        }

        return NULL;
    }

    public function hasFlashMsg(){
        return isset($_SESSION[__CLASS__]['message']);
    }

    public function redirect($location){
        wp_safe_redirect($location);
        exit;
    }

    //Return emails form admin and redactor
    function getAdminEmail(){
        $blogusers = get_users(array('role__in' => array('Administrator', 'Editor')));
        $admin_emails = array();

        foreach ($blogusers as $user) {
           // echo $user->user_email;
            $admin_emails[]= $user->user_email;
        }
        return $admin_emails;
    }

    public function sendEmail($type_message, $to, $mail_params = array() ){

        $message = '';
        $subject = 'Gertis - Obozy żeglarskie: ';


        switch ($type_message){

            case 'registration_guest':

                $subject .= 'potwierdzenie rejestracji';
                $message .= '<h1>Cześć '.$mail_params['guest_name'].'</h1>';
                $message .= '<p>Gratulujemy! Właśnie poprawnie złożyłaś rejestrację na obóz żeglarski z Gertis</p>';

                $message .= '<p>Miejsce zostaje zarezerwowane na <strong>5 dni roboczych</strong>. Aby potwierdzić rezerwację należy dokonać wpłaty <strong>zaliczki wysokości 600 zł </strong>. Zaliczkę możesz wykonać korzystając z poniższego przycisku (płatność za pośrednictwem PayPal). </p>';

                $message .= '<p>
                                <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=66KKJCHJLR99C">
                                    <img src="https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_paynowCC_LG.gif" border="0" alt="PayPal – Płać wygodnie i bezpiecznie">" 
                                </a>
                            </p>';


                $message .= '<p>Zaliczkę możesz również uregulować poprzez przelew bankowy na konto:</p>';
                $message .= '<p><strong>
                                Gertis - Marek Makowski <br />
                                Nr konta bankowego: 52 938123823 129389123 12830123<br />
                                Tytułem: '.$mail_params['guest_name'].'. Zaliczka za obóz:'.$mail_params['event_turn'].' </strong>
                            </p>';

                $message .= '<p>Pozostałe płatności należy dokonać <strong>do 21 dni przed imprezą lub zgodnie z ustaleniami indywidualnymi.</strong></p>';
                $message .= '<p>W razie jakichkolwiek pytań służymy pomocą. Wszelkie dane kontaktowe znajdziesz tutaj: http://www.obozy-zeglarskie.pl/kontakt/</p>
';
                $message .= '<p>
                                Do zobaczenia pod żaglami ;) <br />
                                <strong>Zespół Gertis. </strong>
                            </p>';

                break;

            case 'registration_admin':

                $subject .= 'rejestracja nowego uczestnika obozu!';
                $message .= '<h1>Cześć</h1>';
                $message .= '<p>Właśnie zarejestrował się nowy uczestnik na obóz żeglarski o kodzie: <strong>'.$mail_params['guest_name'].'</strong></p>';
                $message .= '<p>Podstawowe dane uczestnika: </p>';
                $message .= '<ul>
                                <li>Imię i nazwisko: '.$mail_params['guest_name'].'</li>
                                <li>Email: '.$mail_params['email'].'</li>
                                <li>ID w systemie rezerwacji: '.$mail_params['id'].'</li>
                             </ul>';
                $message .= '<p>W systemie rezerwacji możesz znaleść więcej informacji o nowej rejestracji</p>';
                $message .= '<p>Udanego dnia <br /> System rezerwacji Gertis</p>';


                break;

            case 'confirm_guest':

                $subject .= 'potwierdzenie rezerwacji na obozie!';
                $message .= '<h1>Cześć</h1>';
                $message .= '<p>Mamy dla Ciebie dobrą wiadomość! Otrzymaliśmy od Ciebie przelew i tym samym oficjalnie jesteś na obozie Żeglarskim Gertis. Gratulacje!</p>';
                $message .= '<p>Przypominamy, że jeżeli jeszcze nie wpłaciłeś całej kwoty za obóz, to pozostałe płatności należy dokonać <strong>do 21 dni przed imprezą lub zgodnie z ustaleniami indywidualnymi.</strong></p>';
                $message .= '<p>Widzimy się już niedługo pod Żeglami!</p>';
                $message .= '<p><strong>Zespół Gertis. </strong></p>';

                break;

            case 'cancel_guest':
                $subject .= 'anulowanie uczestnictwa!';
                $message .= '<h1>Cześć</h1>';
                $message .= '<p>Anulowaliśmy Twoje uczestnictwo w obozie żeglarskim</p>';
                $message .= '<p>Jeżeli masz jakieś wątpliwości lub proces anulowania jest według Ciebie bezpodstawny, skontaktuj się z nami jak najszybciej</p>';
                $message .= '<p>Pozdrawiamy</p>';
                $message .= '<p><strong>Zespół Gertis.</strong></p>';

                break;

            default:
                break;
        }


        return (wp_mail($to, $subject, $message));

    }

}



$Gertis_booking_system = new Gertis_booking_system();

ob_flush();