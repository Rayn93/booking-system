<?php
//$action_params = array('view' => 'form', 'action' => 'save');
//if($Slide->hasId()){
//    $action_params['slideid'] = $Slide->getField('id');
//}
//
//?>
<form action="<?php //echo $this->getAdminPageUrl($action_params); ?>" method="post" id="gertis-event-form">

    <?php //wp_nonce_field($this->action_token); ?>

    <table class="form-table">

        <tbody>

        <tr class="form-field">
            <th>
                <label for="gertis_event_code">Kod imprezy:</label>
            </th>
            <td>
                <input type="text" name="entry[event_code]" id="gertis_event_code" value="<?php //echo $Slide->getField('slide_url'); ?>" />

                <?php //if($Slide->hasError('slide_url')): ?>
                    <p class="description error"><?php //echo $Slide->getError('slide_url'); ?></p>
                <?php //else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_event_turn">Turnus:</label>
            </th>
            <td>
                <input type="text" name="entry[event_turn]" id="gertis_event_turn" value="<?php //echo $Slide->getField('title'); ?>" />

                <?php //if($Slide->hasError('title')): ?>
                    <p class="description error"><?php //echo $Slide->getError('title'); ?></p>
                <?php //else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_start_date">Data początkowa:</label>
            </th>
            <td>
                <input type="date" name="entry[start_date]" id="gertis_start_date" value="<?php //echo $Slide->getField('caption'); ?>" />

                <?php //if($Slide->hasError('caption')): ?>
                    <p class="description error"><?php //echo $Slide->getError('caption'); ?></p>
                <?php //else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_end_date">Data końcowa:</label>
            </th>
            <td>
                <input type="date" name="entry[end_date]" id="gertis_end_date" value="<?php //echo $Slide->getField('caption'); ?>" />

                <?php //if($Slide->hasError('caption')): ?>
                <p class="description error"><?php //echo $Slide->getError('caption'); ?></p>
                <?php //else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_price">Cena kursu [zł]:</label>
            </th>
            <td>
                <input type="number" name="entry[price]" id="gertis_price" value="<?php //echo $Slide->getField('read_more_url'); ?>" />

                <?php //if($Slide->hasError('read_more_url')): ?>
                    <p class="description error"><?php //echo $Slide->getError('read_more_url'); ?></p>
                <?php //else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php //endif; ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_seats">Liczba mniejs:</label>
            </th>
            <td>
                <input type="text" name="entry[seat_no]" id="gertis_seats" value="<?php //echo $Slide->getField('position'); ?>" />

                <?php //if($Slide->hasError('position')): ?>
                    <p id="pos-info" class="description error"><?php //echo $Slide->getError('position'); ?></p>
                <?php //else: ?>
                    <p id="pos-info" class="description">To pole jest wymagane</p>
                <?php //endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_status">Opublikowany:</label>
            </th>
            <td>
                <input type="checkbox" name="entry[status]" id="gertis_status" value="yes" <?php //echo ($Slide->isPublished()) ? 'checked="checked"' : ''; ?> />
            </td>
        </tr>

        </tbody>

    </table>

    <p class="submit">
        <a href="#" class="button-secondary">Wstecz</a>
        &nbsp;
        <input type="submit" class="button-primary" value="Zapisz zmiany" />
    </p>

</form>