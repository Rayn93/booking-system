<?php

/*
     * Plugin Name: System rezerwacji dla Gertis
     * Plugin URI: http://www.robertsaternus.pl
     * Description: System rezerwacji na rejsy, dedykowany dla Gertis.
     * Author: Robert Saternus
     * Version: 1.0
     * Author URI: http://www.robertsaternus.pl
     */


require_once 'libs/Gertis_BookingSystem_Model.php';
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


//        $my_var = $this->model->getTableNameEvent();
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


    function printAdminPageEvent(){

        ?>

            <h1>Główna strona</h1>
        <?php
    }

    function printAdminPageGuest(){

        ?>

        <h1>Główna podstrona</h1>
        <?php
    }

}


$Gertis_booking_system = new Gertis_booking_system();

