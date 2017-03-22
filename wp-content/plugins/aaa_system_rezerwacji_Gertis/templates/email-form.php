<?php
$action_params = array('view' => 'email-form', 'action' => 'save');
if($Email->hasId()){
    $action_params['eventid'] = $Email->getField('id');
}

?>
<form action="<?php echo $this->getAdminPageUrl('-emails', $action_params); ?>" method="post" id="gertis-event-form">

    <?php wp_nonce_field($this->action_token); ?>

    <table class="form-table">

        <tbody>

        <tr class="form-field">
            <th>
                <label for="gertis_event_code">Kod imprezy:</label>
            </th>
            <td>
                <input type="text" name="entry[event_code]" id="gertis_event_code" value="<?php echo $Event->getField('event_code'); ?>" />

                <?php if($Event->hasError('event_code')): ?>
                    <p class="description error"><?php echo $Event->getError('event_code'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane. Format np. SPO</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_register_mail">Email do uczestnika po rejestracji</label>
            </th>
            <td>
                <textarea name="entry[register_mail]" id="gertis_register_mail"></textarea>
<!--                <input type="text" name="entry[event_turn]" id="gertis_event_turn" value="--><?php //echo $Event->getField('event_turn'); ?><!--" />-->

                <?php if($Event->hasError('event_turn')): ?>
                    <p class="description error"><?php echo $Event->getError('event_turn'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane.</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_confirm_mail">Email po zaakceptowaniu</label>
            </th>
            <td>
                <textarea name="entry[confirm_mail]" id="gertis_confirm_mail"></textarea>
<!--                <input type="date" name="entry[confirm_mail]" id="gertis_start_date" placeholder="rrrr-mm-dd" value="--><?php //echo $Event->getField('start_date'); ?><!--" />-->

                <?php if($Event->hasError('start_date')): ?>
                    <p class="description error"><?php echo $Event->getError('start_date'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_advance_mail">Email po wpłacie zaliczki</label>
            </th>
            <td>
                <textarea name="entry[advance_mail]" id="gertis_advance_mail"></textarea>
<!--                <input type="date" name="entry[end_date]" id="gertis_end_date" placeholder="rrrr-mm-dd" value="--><?php //echo $Event->getField('end_date'); ?><!--" />-->

                <?php if($Event->hasError('end_date')): ?>
                <p class="description error"><?php echo $Event->getError('end_date'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_paid_mail">Email po wpłacie całości kwoty</label>
            </th>
            <td>
                <textarea name="entry[paid_mail]" id="gertis_paid_mail"></textarea>
<!--                <input type="number" name="entry[price]" id="gertis_price" value="--><?php //echo $Event->getField('price'); ?><!--" />-->

                <?php if($Event->hasError('price')): ?>
                    <p class="description error"><?php echo $Event->getError('price'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_cancel_mail">Email po anulowaniu rezerwacji</label>
            </th>
            <td>
                <textarea name="entry[cancel_mail]" id="gertis_cancel_mail"></textarea>
<!--                <input type="number" name="entry[cancel_mail]" id="gertis_seats" value="--><?php //echo $Event->getField('seat_no'); ?><!--" />-->

                <?php if($Event->hasError('seat_no')): ?>
                    <p class="description error"><?php echo $Event->getError('seat_no'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        </tbody>

    </table>

    <p class="submit">
        <a href="<?php echo $this->getAdminPageUrl() ?>" class="button-secondary">Wstecz</a>
        &nbsp;
        <input type="submit" class="button-primary" value="Zapisz zmiany" />
    </p>

</form>