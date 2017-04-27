<?php
$action_params = array('view' => 'event-form', 'action' => 'save');
if($Event->hasId()){
    $action_params['eventid'] = $Event->getField('id');
}

?>
<form action="<?php echo $this->getAdminPageUrl('', $action_params); ?>" method="post" id="gertis-event-form">

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
                <label for="gertis_event_turn">Turnus:</label>
            </th>
            <td>
                <input type="text" name="entry[event_turn]" id="gertis_event_turn" value="<?php echo $Event->getField('event_turn'); ?>" />

                <?php if($Event->hasError('event_turn')): ?>
                    <p class="description error"><?php echo $Event->getError('event_turn'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane. Format np. SPO1</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_start_date">Data początkowa:</label>
            </th>
            <td>
                <input type="date" name="entry[start_date]" id="gertis_start_date" placeholder="rrrr-mm-dd" value="<?php echo $Event->getField('start_date'); ?>" />

                <?php if($Event->hasError('start_date')): ?>
                    <p class="description error"><?php echo $Event->getError('start_date'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_end_date">Data końcowa:</label>
            </th>
            <td>
                <input type="date" name="entry[end_date]" id="gertis_end_date" placeholder="rrrr-mm-dd" value="<?php echo $Event->getField('end_date'); ?>" />

                <?php if($Event->hasError('end_date')): ?>
                <p class="description error"><?php echo $Event->getError('end_date'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_price">Cena kursu [zł]:</label>
            </th>
            <td>
                <input type="number" name="entry[price]" id="gertis_price" value="<?php echo $Event->getField('price'); ?>" />

                <?php if($Event->hasError('price')): ?>
                    <p class="description error"><?php echo $Event->getError('price'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_seats">Liczba mniejsc:</label>
            </th>
            <td>
                <input type="number" name="entry[seat_no]" id="gertis_seats" value="<?php echo $Event->getField('seat_no'); ?>" />

                <?php if($Event->hasError('seat_no')): ?>
                    <p class="description error"><?php echo $Event->getError('seat_no'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_status">Opublikowany:</label>
            </th>
            <td>
                <input type="checkbox" name="entry[status]" id="gertis_status" value="<?php echo $Event->getField('status'); ?>" <?php echo ($Event->checkStatus()) ? 'checked="checked"' : ''; ?> />
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