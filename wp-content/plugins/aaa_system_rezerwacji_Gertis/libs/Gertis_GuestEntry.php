<?php

class Gertis_GuestEntry{

    private $id = NULL;
    private $event_turn = NULL;
    private $guest_name = NULL;
    private $guest_surname = NULL;
    private $birth_date = NULL;
    private $email = NULL;
    private $phone = NULL;
    private $personal_no = NULL;
    private $city = NULL;
    private $street = NULL;
    private $zip_code = NULL;
    private $from_who = NULL;
    private $more_info = NULL;
    private $money = NULL;
    private $status = 'waiting';
    private $staff_info = NULL;
    private $register_date = NULL;

    private $errors = array();
    private $exists = FALSE;


    function __construct($id = NULL) {
        $this->id = $id;
        $this->load();
    }


    private function load(){
        if(isset($this->id)){
            $Model = new Gertis_BookingSystem_Model();
            $row = $Model->fetchGuestRow($this->id);

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

    // Return true if status == waiting
    function isWaiting(){
        return ($this->status == 'waiting');
    }

    // Return true if status == confirm
    function isConfirm(){
        return ($this->status == 'confirm');
    }

    // Return true if status == resign
    function isResign(){
        return ($this->status == 'resign');
    }

    // Return true if status == old
    function isOld(){
        return ($this->status == 'old');
    }

    // Return true if status == advance
    function isAdvance(){
        return ($this->status == 'advance');
    }

    // Return true if status == paid
    function isPaid(){
        return ($this->status == 'paid');
    }

    // Return true if status == send
    function isSend(){
        return ($this->status == 'send');
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


    //Funkcja walidująca poprawność pul w formularzu z uczestnikami. Zwraca true jeżeli nie ma błędów
    function validate(){

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
            $this->event_turn = sanitize_text_field($this->event_turn);
        }

        /*
         * guest_name:
         * - nie może być puste
         * - po oczyszczeniu kod nie może być dłuższy niż 255 znaków
         */
        if (empty($this->guest_name)) {
            $this->setError('guest_name', 'To pole nie może być puste');
        }
        else if (strlen($this->guest_name) > 255) {
            $this->setError('guest_name', 'To pole nie może być dłuższe niż 20 znaków.');
        }
        else{
            $this->guest_name = sanitize_text_field($this->guest_name);
        }

        /*
         * guest_surname:
         * - nie może być puste
         * - po oczyszczeniu kod nie może być dłuższy niż 255 znaków
         */
        if (empty($this->guest_surname)) {
            $this->setError('guest_surname', 'To pole nie może być puste');
        }
        else if (strlen($this->guest_surname) > 255) {
            $this->setError('guest_surname', 'To pole nie może być dłuższe niż 20 znaków.');
        }
        else{
            $this->guest_surname = sanitize_text_field($this->guest_surname);
        }


        /*
         * pole birth_date:
         * - nie może być puste
         * - musi być formatu data
         */
        if (empty($this->birth_date)) {
            $this->setError('birth_date', 'To pole nie może być puste');
        }

        else if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->birth_date)){
            $this->setError('birth_date', 'To pole musi być datą w formacie: rrrr-mm-dd np. 1993-05-30');

        }
//        else{
//            $date_start = date_parse($this->birth_date);
//            if (!$date_start["error_count"] == 0 || !checkdate($date_start["month"], $date_start["day"], $date_start["year"])) {
//                $this->setError('birth_date', 'To pole musi być poprawną datą w formacie: rrrr-mm-dd np. 1993-05-30');
//            }
//        }


        /*
         * pole email:
         * - nie może być puste
         * - musi być poprawnym email-em
         */
        if (empty($this->email)) {
            $this->setError('email', 'To pole nie może być puste');
        }
        else if((!filter_var($this->email, FILTER_VALIDATE_EMAIL))){
            $this->setError('email', 'To pole musi być poprawnym adresem email');
        }

        /*
         * pole phone:
         * - pole wymagane, nie moze być puste
         * - rzutowanie wartości do integera
         * - musi być to liczba większa od 0 i mniejsza od 999999999999999
         */
        if(empty($this->phone) && !is_numeric($this->phone)){
            $this->setError('phone', 'To pole nie może być puste.');
        }
        else{
            $this->phone = (int)$this->phone;
            if($this->phone < 0 || $this->phone > 999999999999999){
                $this->setError('phone', 'To pole musi być liczbą większą od 0 i mniejsza niż 999999999999999.');
            }
        }

        /*
         * personal_no:
         * - nie może być puste
         * - po oczyszczeniu kod nie może być dłuższy niż 255 znaków
         */
        if (empty($this->personal_no)) {
            $this->setError('personal_no', 'To pole nie może być puste');
        }
        else if (strlen($this->personal_no) > 255) {
            $this->setError('personal_no', 'To pole nie może być dłuższe niż 255 znaków.');
        }
        else{
            $this->personal_no = sanitize_text_field($this->personal_no);
        }

        /*
         * city:
         * - nie może być puste
         * - po oczyszczeniu kod nie może być dłuższy niż 255 znaków
         */
        if (empty($this->city)) {
            $this->setError('city', 'To pole nie może być puste');
        }
        else if (strlen($this->city) > 255) {
            $this->setError('city', 'To pole nie może być dłuższe niż 255 znaków.');
        }
        else{
            $this->city = sanitize_text_field($this->city);
        }

        /*
         * street:
         * - nie może być puste
         * - po oczyszczeniu kod nie może być dłuższy niż 255 znaków
         */
        if (empty($this->street)) {
            $this->setError('street', 'To pole nie może być puste');
        }
        else if (strlen($this->street) > 255) {
            $this->setError('street', 'To pole nie może być dłuższe niż 255 znaków.');
        }
        else{
            $this->street = sanitize_text_field($this->street);
        }

        /*
         * zip_code:
         * - nie może być puste
         * - po oczyszczeniu kod nie może być dłuższy niż 20 znaków
         */
        if (empty($this->zip_code)) {
            $this->setError('zip_code', 'To pole nie może być puste');
        }
        else if (strlen($this->zip_code) > 20) {
            $this->setError('zip_code', 'To pole nie może być dłuższe niż 20 znaków.');
        }
        else{
            $this->zip_code = sanitize_text_field($this->zip_code);
        }

        /*
         * from_who:
         * - może być puste
         * - jeżeli nie puste:
         *      - po wyczyszczeniu  nie może być dłuższy niż 255 znaków
         */
        if(!empty($this->from_who)){

            $this->from_who = sanitize_text_field($this->from_who);
            if(strlen($this->from_who) > 255){
                $this->setError('from_who', 'To pole nie może być dłuższe niż 255 znaków.');
            }
        }


        /*
         * more_info:
         * - może być puste
         * - jeżeli nie puste:
         *      - po wyczyszczeniu  nie może być dłuższy niż 50000 znaków
         */
        if(!empty($this->more_info)){

            $this->more_info = sanitize_text_field($this->more_info);
            if(strlen($this->more_info) > 50000){
                $this->setError('more_info', 'To pole nie może być dłuższe niż 50 000 znaków.');
            }
        }

        /*
         * staff_info:
         * - może być puste
         * - jeżeli nie puste:
         *      - po wyczyszczeniu  nie może być dłuższy niż 50000 znaków
         */
        if(!empty($this->staff_info)){

            $this->staff_info = sanitize_text_field($this->staff_info);
            if(strlen($this->staff_info) > 50000){
                $this->setError('staff_info', 'To pole nie może być dłuższe niż 50 000 znaków.');
            }
        }


        /*
         * pole money:
         * - może być puste
         * - rzutowanie wartości do integera
         * - musi być to liczba większa od 0 i mniejsza od 9999999
         */
        if(!empty($this->money)){

            $this->money = (int)$this->money;
            if($this->money < 0 || $this->money > 9999999){
                $this->setError('money', 'To pole musi być liczbą większą od 0 i mniejsza niż 9999999.');
            }
        }


        /*
         * pole status:
         * - musi zostać ustawione na 'waiting', 'confirm', 'resign', 'old', 'advance' itd...
         */
        if(isset($this->status) && $this->status == 'confirm'){
            $this->status = 'confirm';
        }
        else if(isset($this->status) && $this->status == 'resign'){
            $this->status = 'resign';
        }
        else if(isset($this->status) && $this->status == 'old'){
            $this->status = 'old';
        }
        else if(isset($this->status) && $this->status == 'advance'){
            $this->status = 'advance';
        }
        else if(isset($this->status) && $this->status == 'paid'){
            $this->status = 'paid';
        }
        else if(isset($this->status) && $this->status == 'send'){
            $this->status = 'send';
        }
        else{
            $this->status = 'waiting';
        }

        return (!$this->hasErrors());
    }



}