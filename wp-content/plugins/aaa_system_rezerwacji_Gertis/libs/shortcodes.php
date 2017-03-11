<?php

//Shortcode z formularzem frontend

add_shortcode('gertis_main_form', 'gertisMainForm');
function gertisMainForm(){

    ob_start();

    $action_token = 'gertis-bs-action';

    //$main_object = new Gertis_booking_system();

    ?>

    <div id="booking_system_form" class="container">
        <div class="row">

            <div class="my_errors"><?php echo isset($_SESSION['form_error']) ? $_SESSION['form_error'] : ''; unset($_SESSION['form_error']); ?></div>

            <form class="form-horizontal" action="../Gertis_booking_system.php" data-toggle="validator" role="form" method="post">

                <?php wp_nonce_field($action_token); ?>

                <div class="form-group">
                    <label for="event_turn" class="col-sm-3 control-label">Kod imprezy *</label>
                    <div class="col-sm-4">
                        <select id="event_turn" class="form-control" name="front_entry[event_turn]">
                            <option value="OPT1">OPT1</option>
                            <option value="OPT2">OPT2</option>
                            <option value="OPT3">OPT3</option>
                            <option value="OPT4">OPT4</option>
                            <option value="OPT5">OPT5</option>
                        </select>
                    </div>
                </div>

                <!--                <div class="form-group">-->
                <!--                    <label for="event_date" class="col-sm-3 control-label">Termin imprezy *</label>-->
                <!--                    <div class="col-sm-4">-->
                <!--                        <select id="event_date" class="form-control">-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                        </select>-->
                <!--                    </div>-->
                <!--                </div>-->

                <div class="form-group">
                    <label for="guest_name" class="col-sm-3 control-label">Imię i nazwisko *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[guest_name]" id="guest_name" placeholder="Imię i nazwisko uczestnika"
                               data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="birth_date" class="col-sm-3 control-label">Data urodzenia *</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="front_entry[birth_date]" id="birth_date" placeholder="rrrr-mm-dd" pattern="^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$"
                               data-error="Data musi zostać podana i musi mieć format: rrrr-mm-dd np. 1993-05-30" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email *</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="front_entry[email]" id="email" placeholder="Adres Email"
                               data-error="Podaj prawidłowy adres E-mail" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-3 control-label">Nr telefonu * </label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="front_entry[phone]" id="phone" placeholder="Numer telefonu"
                               data-error="Podaj aktualny nr telefonu (musi się składać z samych liczb)" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="personal_no" class="col-sm-3 control-label">Pesel lub nr ID *</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="front_entry[personal_no]" id="personal_no" placeholder="Pesel lub nr dowodu osobistego" data-minlength="6"
                               data-error="Podaj min 6 cyfr" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="city" class="col-sm-3 control-label">Miasto *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[city]" id="city" placeholder="Miejscowość zamieszkania np. Poznań"
                               data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="street" class="col-sm-3 control-label">Ulica i nr budynku *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[street]" id="street" placeholder="Ulica i numer budynku zamieszkania np. Piłsudzkiego 3A"
                               data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zip_code" class="col-sm-3 control-label">Kod pocztowy *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[zip_code]" id="zip_code" pattern="^\d{2}(?:[-]\d{3})?$"
                               placeholder="Kod pocztowy miejsca zamieszkania"
                               data-error="Wprowadzona wartość musi mieć format xx-xxx np. 41-400" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="from_who" class="col-sm-3 control-label">Skąd o nas wiesz?</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="front_entry[from_who]" id="from_who" placeholder="Np. znajomi, internet, gazeta itp."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="more_info" class="col-sm-3 control-label">Uwagi dodatkowe</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="front_entry[more_info]" id="more_info" placeholder="Twoje pytania, faktura VAT, dojazd itp."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input type="text" name="recaptcha" value="" id="recaptchaValidator" pattern="1"
                               data-error="Jesteś botem!" style="visibility: hidden; height: 1px" required>
                        <div class="g-recaptcha" data-sitekey="6LcesSATAAAAAKLNFstcDb6fhWKvXNvshHJSnXNC"
                             data-callback="captcha_onclick"></div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <script>
                    function captcha_onclick(e) {
                        $('#recaptchaValidator').val(1);
                        $('#booking_system_form').validator('validate');
                    }
                </script>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required> Znam i akceptuję <a class="credential" href="#">warunki uczestnictwa w imprezie</a>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-default">Zapisz mnie</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php

    $form = ob_get_contents();
    ob_end_clean();

    return $form;

}

add_action('init', 'my_init');
function my_init() {
    if (!session_id()) {
        session_start();
    }
}
