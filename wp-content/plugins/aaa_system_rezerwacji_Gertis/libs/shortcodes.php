<?php


//Shortcode z formularzem frontend

function gertisMainForm() {

    ob_start();

    ?>

    <div id="booking_system_form" class="container">
        <div class="row">

            <form class="form-horizontal" data-toggle="validator" role="form">

                <div class="form-group">
                    <label for="event_code" class="col-sm-3 control-label">Kod imprezy *</label>
                    <div class="col-sm-4">
                        <select id="event_code" class="form-control">
                            <option>asd123</option>
                            <option>qwe123</option>
                            <option>dfg456</option>
                            <option>yui678</option>
                            <option>234fgh</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_date" class="col-sm-3 control-label">Termin imprezy *</label>
                    <div class="col-sm-4">
                        <select id="event_date" class="form-control">
                            <option>12 VI - 28 VI 2017</option>
                            <option>12 VI - 28 VI 2017</option>
                            <option>12 VI - 28 VI 2017</option>
                            <option>12 VI - 28 VI 2017</option>
                            <option>12 VI - 28 VI 2017</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Imię i nazwisko *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="Imię i nazwisko uczestnika" data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="data" class="col-sm-3 control-label">Data urodzenia *</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="data" data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email *</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" placeholder="Adres Email"  data-error="Podaj prawidłowy adres E-mail" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-3 control-label">Nr telefonu * </label>
                    <div class="col-sm-9">
                        <input type="tel" class="form-control" id="phone" placeholder="Numer telefonu" data-error="Podaj aktualny nr telefonu" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pesel" class="col-sm-3 control-label">Pesel lub nr ID *</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="pesel" placeholder="Pesel lub nr dowodu osobistego" data-minlength="6" data-error="Podaj min 6 cyfr" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="city" class="col-sm-3 control-label">Miasto *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="city" placeholder="Miejscowość zamieszkania np. Poznań" data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="street" class="col-sm-3 control-label">Ulica i nr budynku *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="street"  placeholder="Ulica i numer budynku zamieszkania np. Piłsudzkiego 3A" data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zipcode" class="col-sm-3 control-label">Kod pocztowy *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="zipcode" pattern="^\d{2}(?:[-]\d{3})?$" placeholder="Kod pocztowy miejsca zamieszkania" data-error="Wprowadzona wartość musi mieć format xx-xxx np. 41-400" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="from-who" class="col-sm-3 control-label">Skąd o nas wiesz?</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" id="from-who" placeholder="Np. znajomi, internet, gazeta itp."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="addition" class="col-sm-3 control-label">Uwagi dodatkowe</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" id="addition" placeholder="Twoje pytania, faktura VAT, dojazd itp."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required> Znak i akceptuję <a href ="#">warunki uczestnictwa w imprezie</a>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input type="text" name="recaptcha" value="" id="recaptchaValidator" pattern="1" data-error="Sorry, no robots!" style="visibility: hidden; height: 1px" required>
                        <div class="g-recaptcha" data-sitekey="6LcesSATAAAAAKLNFstcDb6fhWKvXNvshHJSnXNC" data-callback="captcha_onclick"></div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-default">Zapisz mnie</button>
                    </div>
                </div>

            </form>

    <?php

    $form = ob_get_contents();
    ob_end_clean();

    return $form;

}

add_shortcode( 'gertis_main_form', 'gertisMainForm' );