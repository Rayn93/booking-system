<?php
//$action_params = array('view' => 'event-form', 'action' => 'save');
//if($Event->hasId()){
//    $action_params['eventid'] = $Event->getField('id');
//}
//
//?>
<form action="<?php //echo $this->getAdminPageUrl('', $action_params); ?>" method="post" id="gertis-guest-form">

    <?php //wp_nonce_field($this->action_token); ?>

    <table class="form-table">

        <tbody>

        <tr class="form-field">
            <th>
                <label for="gertis_event_turn">Kod imprezy [turnus]:</label>
            </th>
            <td>
                <input type="text" name="entry[event_turn]" id="gertis_event_turn"
                       value="<?php //echo $Event->getField('event_code'); ?>"/>

                <?php //if($Event->hasError('event_code')): ?>
                <p class="description error"><?php //echo $Event->getError('event_code'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane. Format np. SPO1</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_guest_name">Imie i nazwisko uczestnika</label>
            </th>
            <td>
                <input type="text" name="entry[guest_name]" id="gertis_guest_name"
                       value="<?php //echo $Event->getField('event_turn'); ?>"/>

                <?php //if($Event->hasError('event_turn')): ?>
                <p class="description error"><?php //echo $Event->getError('event_turn'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane.</p>
                <?php //endif; ?>
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_birth_date">Data urodzenia</label>
            </th>
            <td>
                <input type="date" name="entry[birth_date]" id="gertis_birth_date"
                       value="<?php //echo $Event->getField('start_date'); ?>"/>

                <?php //if($Event->hasError('start_date')): ?>
                <p class="description error"><?php //echo $Event->getError('start_date'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_email">Email</label>
            </th>
            <td>
                <input type="email" name="entry[email]" id="gertis_email"
                       value="<?php //echo $Event->getField('end_date'); ?>"/>

                <?php //if($Event->hasError('end_date')): ?>
                <p class="description error"><?php //echo $Event->getError('end_date'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_phone">Telefon:</label>
            </th>
            <td>
                <input type="number" name="entry[phone]" id="gertis_phone"
                       value="<?php //echo $Event->getField('price'); ?>"/>

                <?php //if($Event->hasError('price')): ?>
                <p class="description error"><?php //echo $Event->getError('price'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_personal_no">Pesel / nr ID</label>
            </th>
            <td>
                <input type="text" name="entry[personal_no]" id="gertis_personal_no"
                       value="<?php //echo $Event->getField('seat_no'); ?>"/>

                <?php //if($Event->hasError('seat_no')): ?>
                <p class="description error"><?php //echo $Event->getError('seat_no'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_city">Miasto</label>
            </th>
            <td>
                <input type="text" name="entry[city]" id="gertis_city"
                       value="<?php //echo $Event->getField('end_date'); ?>"/>

                <?php //if($Event->hasError('end_date')): ?>
                <p class="description error"><?php //echo $Event->getError('end_date'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_street">Ulica i nr budynku</label>
            </th>
            <td>
                <input type="text" name="entry[street]" id="gertis_street"
                       value="<?php //echo $Event->getField('end_date'); ?>"/>

                <?php //if($Event->hasError('end_date')): ?>
                <p class="description error"><?php //echo $Event->getError('end_date'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_zip_code">Kod pocztowy</label>
            </th>
            <td>
                <input type="text" name="entry[zip_code]" id="gertis_zip_code"
                       value="<?php //echo $Event->getField('end_date'); ?>"/>

                <?php //if($Event->hasError('end_date')): ?>
                <p class="description error"><?php //echo $Event->getError('end_date'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_from_who">Skąd się dowiedziałeś o nas?</label>
            </th>
            <td>
                <input type="text" name="entry[from_who]" id="gertis_from_who"
                       value="<?php //echo $Event->getField('end_date'); ?>"/>

                <?php //if($Event->hasError('end_date')): ?>
                <p class="description error"><?php //echo $Event->getError('end_date'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest opcjonalne</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_more_info">Uwagi dodatkowe</label>
            </th>
            <td>
                <textarea name="entry[more_info]" id="gertis_more_info" value="<?php //echo $Event->getField('end_date'); ?>"></textarea>

                <?php //if($Event->hasError('end_date')): ?>
                <p class="description error"><?php //echo $Event->getError('end_date'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest opcjonalne</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_status">Status uczestnictwa:</label>
            </th>
            <td>
                <fieldset>
                    <label>
                        <input type='radio' name='entry[status]' value='niepotwierdzony' checked='checked'/>
                        <span>niepotwierdzony</span>
                    </label><br/>
                    <label>
                        <input type='radio' name='entry[status]' value='potwierdzony' />
                        <span>potwierdzony</span>
                    </label><br/>
                    <label>
                        <input type='radio' name='entry[status]' value='rezygnacja' />
                        <span>rezygnacja</span>
                    </label><br/>
                    <label>
                        <input type='radio' name='entry[status]' value='nieaktualny' />
                        <span>nieaktualny</span>
                    </label><br/>
                </fieldset>

                <?php //if($Event->hasError('end_date')): ?>
                <p class="description error"><?php //echo $Event->getError('end_date'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest obowiązkowe</p>
                <?php //endif; ?>
            </td>
        </tr>

        </tbody>

    </table>

    <p class="submit">
        <a href="#" class="button-secondary">Wstecz</a>
        &nbsp;
        <input type="submit" class="button-primary" value="Zapisz zmiany"/>
    </p>

</form>