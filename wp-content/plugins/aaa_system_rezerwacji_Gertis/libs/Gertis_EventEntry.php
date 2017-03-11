<?php

/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 09.03.2017
 * Time: 19:41
 */
class Gertis_EventEntry{

    private $id = NULL;
    private $event_code = NULL;
    private $event_turn = NULL;
    private $start_date = NULL;
    private $end_date = NULL;
    private $price = NULL;
    private $seat_no = NULL;
    private $status = 'yes';

    private $errors = array();
    private $exists = FALSE;


    function __construct($id = NULL) {
        $this->id = $id;
        $this->load();
    }


    private function load(){
        if(isset($this->id)){
            $Model = new Gertis_BookingSystem_Model();
            $row = $Model->fetchEventRow($this->id);

            if(isset($row)){
                $this->setFields($row);
                $this->exists = TRUE;
            }
        }
    }

    function exist(){
        return $this->exists;
    }


    function getField($field){
        if(isset($this->{$field})){
            return $this->{$field};
        }

        return NULL;
    }

    function setFields($fields){
        foreach($fields as $key => $val){
            $this->{$key} = $val;
        }
    }

    function hasId(){
        return isset($this->id);
    }

    // Return true if status == yes
    function checkStatus(){
        return ($this->status == 'yes');
    }


    function setError($field, $error){
        $this->errors[$field] = $error;
    }

    function getError($field){
        if(isset($this->errors[$field])){
            return $this->errors[$field];
        }

        return NULL;
    }

    function hasError($field){
        return isset($this->errors[$field]);
    }

    // Return true if errors > 0
    function hasErrors(){
        return (count($this->errors) > 0);
    }


    //Funkcja walidująca poprawność pul w formularzu z impreza. Zwraca true jeżeli nie ma błędów
    function validate(){

        /*
         * event_code:
         * - nie może być puste
         * - po oczyszczeniu kod nie może być dłuższy niż 20 znaków
         */



        if (empty($this->event_code)) {
            $this->setError('event_code', 'To pole nie może być puste');
        }
        else if (strlen($this->event_code) > 20) {
            $this->setError('event_code', 'To pole nie może być dłuższe niż 20 znaków.');
        }
        else{
            $this->event_code = wp_kses_data($this->event_code);
        }

        /*
         * event_turn:
         * - nie może być puste
         * - po oczyszczeniu kod nie może być dłuższy niż 20 znaków
         */
        if (empty($this->event_turn)) {
            $this->setError('event_turn', 'To pole nie może być puste');
        }
        else if (strlen($this->event_turn) > 20) {
            $this->setError('event_turn', 'To pole nie może być dłuższe niż 20 znaków.');
        }
        else{
            $this->event_turn = wp_kses_data($this->event_turn);
        }


        /*
         * pole start_date:
         * - nie może być puste
         * - musi być formatu data
         */


        if (empty($this->start_date)) {
            $this->setError('start_date', 'To pole nie może być puste');
        }
        else if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->start_date)){
            $this->setError('start_date', 'To pole musi być datą w formacie: rrrr-mm-dd np. 1993-05-30');

        }
//        else{
//            $date_start = date_parse($this->start_date);
//            if (!$date_start["error_count"] == 0 || !checkdate($date_start["month"], $date_start["day"], $date_start["year"])) {
//                $this->setError('start_date', 'To pole musi być datą');
//            }
//        }


        /*
         * pole end_date:
         * - nie może być puste
         * - musi być formatu data
         */


        if (empty($this->end_date)) {
            $this->setError('end_date', 'To pole nie może być puste');
        }
        else if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->end_date)){
            $this->setError('end_date', 'To pole musi być datą w formacie: rrrr-mm-dd np. 1993-05-30');

        }
//        else{
//            $date_end = date_parse($this->end_date);
//            if (!$date_end["error_count"] == 0 || !checkdate($date_end["month"], $date_end["day"], $date_end["year"])) {
//                $this->setError('end_date', 'To pole musi być datą');
//            }
//        }

        /*
         * pole price:
         * - pole wymagane, nie moze być puste
         * - rzutowanie wartości do integera
         * - musi być to liczba większa od 0
         */
        if(empty($this->price) && !is_numeric($this->price)){
            $this->setError('price', 'To pole nie może być puste.');
        }
        else{
            $this->price = (int)$this->price;
            if($this->price < 0){
                $this->setError('price', 'To pole musi być liczbą większą bądź równą 0.');
            }
        }


        /*
         * pole seat_no:
         * - pole wymagane, nie moze być puste
         * - rzutowanie wartości do integera
         * - musi być to liczba większa od 0
         */
        if(empty($this->seat_no) && !is_numeric($this->seat_no)){
            $this->setError('seat_no', 'To pole nie może być puste.');
        }
        else{
            $this->seat_no = (int)$this->seat_no;
            if($this->seat_no < 0){
                $this->setError('seat_no', 'To pole musi być liczbą większą bądź równą 0.');
            }
        }

        /*
         * pole status:
         * - musi zostać ustawione na 'yes' lub 'no'
         */
        if(isset($this->status) && $this->status == 'yes'){
            $this->status = 'yes';
        }else{
            $this->status = 'no';
        }


        return (!$this->hasErrors());
    }



}