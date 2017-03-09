<?php

ob_start(); //http://www.lessthanweb.com/blog/wordpress-and-wp_redirect-function-problem
session_start();

/*
     * Plugin Name: System rezerwacji dla Gertis
     * Plugin URI: http://www.robertsaternus.pl
     * Description: System rezerwacji na rejsy, dedykowany dla Gertis.
     * Author: Robert Saternus
     * Version: 1.0
     * Author URI: http://www.robertsaternus.pl
     */


require_once 'libs/Gertis_BookingSystem_Model.php';
require_once 'libs/Request.php';
require_once 'libs/shortcodes.php';


class Gertis_booking_system{

    private static $plugin_id = 'gertis-book-system';
    private $plugin_version = '1.0.0';
    private $user_capability = 'manage_options';
    private $model;
    private $action_token = 'gertis-bs-action';
    private $pagination_limit = 5;


    function __construct() {
        $this->model = new Gertis_BookingSystem_Model();

        //uruchamianie podczas aktywacji
        register_activation_hook(__FILE__, array($this, 'onActivate'));

        //rejestracja przycisku w menu
        add_action('admin_menu', array($this, 'createAdminMenu'));


//        $my_var = $this->getAdminGuestUrl();
//        var_dump($my_var);

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


    function createAdminMenu(){

        add_menu_page('Gertis System Rezerwacji', 'System rezerwacji', $this->user_capability, static::$plugin_id, array($this, 'printAdminPageEvent'), '', 66);
        add_submenu_page(static::$plugin_id, 'Lista rejsów', 'Lista rejsów', $this->user_capability, static::$plugin_id, array($this, 'printAdminPageEvent'));
        add_submenu_page(static::$plugin_id, 'Zapisani uczestnicy', 'Uczestnicy', $this->user_capability, static::$plugin_id.'-guests', array($this, 'printAdminPageGuest'));

    }

    //Kontroler dla strony z listą z rejsami
    function printAdminPageEvent(){

        $request = Request::instance();
        $view = $request->getQuerySingleParam('view', 'events');

        switch ($view) {
            case 'events':
                $this->renderEvent('events');
                break;

            case 'event-form':
                $this->renderEvent('event-form');
                break;

            default:
                $this->renderEvent('404');
                break;
        }



    }

    //Funkcja służąca do renderowania widoków dla sekcji z rejsami
    private function renderEvent($view, array $args = array()){

        //extract($args);
        $tmpl_dir = plugin_dir_path(__FILE__).'templates/';
        $view = $tmpl_dir.$view.'.php';
        require_once $tmpl_dir.'layout-event.php';

    }

    //Kontroler dla strony z listą uczestników
    function printAdminPageGuest(){

        ?>

        <h1>Główna podstrona</h1>
        <?php
    }




    public function getAdminEventUrl(array $params = array()){
        $admin_url = admin_url('admin.php?page='.static::$plugin_id);
        $admin_url = add_query_arg($params, $admin_url);

        return $admin_url;
    }

    public function getAdminGuestUrl(array $params = array()){
        $admin_url = admin_url('admin.php?page='.static::$plugin_id.'-guests');
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

}


$Gertis_booking_system = new Gertis_booking_system();

ob_flush();