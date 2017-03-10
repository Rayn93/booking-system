<?php


class Gertis_BookingSystem_Model{

    private $table_guest = 'gertis_booking_system_guest';
    private $table_event = 'gertis_booking_system_event';
    private $wpdb;


    function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    function getTableNameGuest(){
        return $this->wpdb->prefix.$this->table_guest;
    }

    function getTableNameEvent(){
        return $this->wpdb->prefix.$this->table_event;
    }

    function createDbTableGuest(){

        $table_name = $this->getTableNameGuest();

        $sql = '
            CREATE TABLE IF NOT EXISTS '.$table_name.'(
                id INT NOT NULL AUTO_INCREMENT,
                event_turn VARCHAR(20) NOT NULL,
                guest_name VARCHAR(255) NOT NULL,
                birth_date DATE NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone BIGINT NOT NULL,
    			personal_no VARCHAR(255) NOT NULL,
                city VARCHAR(255) NOT NULL,
                street VARCHAR(255) NOT NULL,
                zip_code VARCHAR(20) NOT NULL,
                from_who VARCHAR(255) DEFAULT NULL,
    			more_info TEXT DEFAULT NULL,
                money INT DEFAULT NULL,
                status enum("waiting", "confirm", "resign", "old") NOT NULL DEFAULT "waiting",
                PRIMARY KEY(id)
            )ENGINE=InnoDB DEFAULT CHARSET=utf8';

        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        dbDelta($sql);
    }

    function createDbTableEvent(){

        $table_name = $this->getTableNameEvent();

        $sql = '
            CREATE TABLE IF NOT EXISTS '.$table_name.'(
                id INT NOT NULL AUTO_INCREMENT,
                event_code VARCHAR(20) NOT NULL,
                event_turn VARCHAR(20) NOT NULL,
                start_date DATE NOT NULL,
                end_date DATE NOT NULL,
                price INT NOT NULL,
                seat_no INT NOT NULL,
                status enum("yes", "no") NOT NULL DEFAULT "yes",
                PRIMARY KEY(id)
            )ENGINE=InnoDB DEFAULT CHARSET=utf8';

        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        dbDelta($sql);
    }

    //Zapisanie danych z formularza o rejsach do bazy danych
    function saveEventEntry(Gertis_EventEntry $EventEntry){

        $toSave = array(
            'event_code' => $EventEntry->getField('event_code'),
            'event_turn' => $EventEntry->getField('event_turn'),
            'start_date' => $EventEntry->getField('start_date'),
            'end_date' => $EventEntry->getField('end_date'),
            'price' => $EventEntry->getField('price'),
            'seat_no' => $EventEntry->getField('seat_no'),
            'status' => $EventEntry->getField('status'),
        );

        $maps = array('%s', '%s', '%s', '%s', '%d', '%d', '%s');

        $table_name = $this->getTableNameEvent();

        if($EventEntry->hasId()){

            if($this->wpdb->update($table_name, $toSave, array('id' => $EventEntry->getField('id')), $maps, '%d')){
                return $EventEntry->getField('id');
            }
            else{
                return FALSE;
            }
        }
        else{

            if($this->wpdb->insert($table_name, $toSave, $maps)){
                return $this->wpdb->insert_id;
            }
            else{
                return FALSE;
            }
        }
    }

    //Zapisanie danych z formularza o rejsach do bazy danych
    function saveGuestEntry(Gertis_GuestEntry $GuestEntry){

        $toSave = array(
            'event_turn' => $GuestEntry->getField('event_turn'),
            'guest_name' => $GuestEntry->getField('guest_name'),
            'birth_date' => $GuestEntry->getField('birth_date'),
            'email' => $GuestEntry->getField('email'),
            'phone' => $GuestEntry->getField('phone'),
            'personal_no' => $GuestEntry->getField('personal_no'),
            'city' => $GuestEntry->getField('city'),
            'street' => $GuestEntry->getField('street'),
            'zip_code' => $GuestEntry->getField('zip_code'),
            'from_who' => $GuestEntry->getField('from_who'),
            'more_info' => $GuestEntry->getField('more_info'),
            'money' => $GuestEntry->getField('money'),
            'status' => $GuestEntry->getField('status'),
        );

        $maps = array('%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s');

        $table_name = $this->getTableNameGuest();

        if($GuestEntry->hasId()){

            if($this->wpdb->update($table_name, $toSave, array('id' => $GuestEntry->getField('id')), $maps, '%d')){
                return $GuestEntry->getField('id');
            }
            else{
                return FALSE;
            }
        }
        else{

            if($this->wpdb->insert($table_name, $toSave, $maps)){
                return $this->wpdb->insert_id;
            }
            else{
                return FALSE;
            }
        }
    }

    //Pobiera oraz zwraca wydarzenie o konkretnym id
    function fetchEventRow($id){
        $table_name = $this->getTableNameEvent();
        $sql = "SELECT * FROM {$table_name} WHERE id = %d";
        $prep = $this->wpdb->prepare($sql, $id);
        return $this->wpdb->get_row($prep);
    }

    //Pobiera oraz zwraca uczestnika o konkretnym id
    function fetchGuestRow($id){
        $table_name = $this->getTableNameGuest();
        $sql = "SELECT * FROM {$table_name} WHERE id = %d";
        $prep = $this->wpdb->prepare($sql, $id);
        return $this->wpdb->get_row($prep);
    }


}
