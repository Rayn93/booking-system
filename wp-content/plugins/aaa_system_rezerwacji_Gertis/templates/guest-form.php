<?php
    $action_params = array('view' => 'guest-form', 'action' => 'save');
    if($Guest->hasId()){
        $action_params['guestid'] = $Guest->getField('id');
    }
?>
<form action="<?php echo $this->getAdminPageUrl('-guests', $action_params); ?>" method="post" id="gertis-guest-form">

    <?php wp_nonce_field($this->action_token); ?>

    <table class="form-table">

        <tbody>

        <tr class="form-field">
            <th>
                <label for="gertis_event_turn">Kod imprezy [turnus]:</label>
            </th>
            <td>
                <input type="text" name="entry[event_turn]" id="gertis_event_turn" value="<?php echo $Guest->getField('event_turn'); ?>"/>

                <?php if($Guest->hasError('event_turn')): ?>
                <p class="description error"><?php echo $Guest->getError('event_turn'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane. Format np. SPO1</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_guest_name">Imie i nazwisko uczestnika</label>
            </th>
            <td>
                <input type="text" name="entry[guest_name]" id="gertis_guest_name" value="<?php echo $Guest->getField('guest_name'); ?>"/>

                <?php if($Guest->hasError('guest_name')): ?>
                <p class="description error"><?php echo $Guest->getError('guest_name'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane.</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_birth_date">Data urodzenia</label>
            </th>
            <td>
                <input type="date" name="entry[birth_date]" id="gertis_birth_date" placeholder="rrrr-mm-dd" value="<?php echo $Guest->getField('birth_date'); ?>"/>

                <?php if($Guest->hasError('birth_date')): ?>
                <p class="description error"><?php echo $Guest->getError('birth_date'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_email">Email</label>
            </th>
            <td>
                <input type="email" name="entry[email]" id="gertis_email" value="<?php echo $Guest->getField('email'); ?>"/>

                <?php if($Guest->hasError('email')): ?>
                <p class="description error"><?php echo $Guest->getError('email'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_phone">Telefon:</label>
            </th>
            <td>
                <input type="number" name="entry[phone]" id="gertis_phone" value="<?php echo $Guest->getField('phone'); ?>"/>

                <?php if($Guest->hasError('phone')): ?>
                <p class="description error"><?php echo $Guest->getError('phone'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_personal_no">Pesel / nr ID</label>
            </th>
            <td>
                <input type="text" name="entry[personal_no]" id="gertis_personal_no" value="<?php echo $Guest->getField('personal_no'); ?>"/>

                <?php if($Guest->hasError('personal_no')): ?>
                <p class="description error"><?php echo $Guest->getError('personal_no'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_money">Zapłacona kwota [zł]:</label>
            </th>
            <td>
                <input type="number" name="entry[money]" id="gertis_money" value="<?php echo $Guest->getField('money'); ?>"/>

                <?php if($Guest->hasError('money')): ?>
                    <p class="description error"><?php echo $Guest->getError('money'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest opcjonalne</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_city">Miasto</label>
            </th>
            <td>
                <input type="text" name="entry[city]" id="gertis_city" value="<?php echo $Guest->getField('city'); ?>"/>

                <?php if($Guest->hasError('city')): ?>
                <p class="description error"><?php echo $Guest->getError('city'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_street">Ulica i nr budynku</label>
            </th>
            <td>
                <input type="text" name="entry[street]" id="gertis_street" value="<?php echo $Guest->getField('street'); ?>"/>

                <?php if($Guest->hasError('street')): ?>
                <p class="description error"><?php echo $Guest->getError('street'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_zip_code">Kod pocztowy</label>
            </th>
            <td>
                <input type="text" name="entry[zip_code]" id="gertis_zip_code" value="<?php echo $Guest->getField('zip_code'); ?>"/>

                <?php if($Guest->hasError('zip_code')): ?>
                <p class="description error"><?php echo $Guest->getError('zip_code'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_from_who">Skąd się dowiedziałeś o nas?</label>
            </th>
            <td>
                <input type="text" name="entry[from_who]" id="gertis_from_who" value="<?php echo $Guest->getField('from_who'); ?>"/>

                <?php if($Guest->hasError('from_who')): ?>
                <p class="description error"><?php echo $Guest->getError('from_who'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest opcjonalne</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_more_info">Uwagi dodatkowe</label>
            </th>
            <td>
                <input type="text" name="entry[more_info]" id="gertis_more_info" value="<?php echo $Guest->getField('more_info'); ?>" />

                <?php if($Guest->hasError('more_info')): ?>
                <p class="description error"><?php echo $Guest->getError('more_info'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest opcjonalne</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr>
            <th>
                <label for="gertis_status">Status uczestnictwa:</label>
            </th>
            <td>
                <fieldset>
                    <label>
                        <input type='radio' name='entry[status]' value='waiting' <?php echo ($Guest->isWaiting()) ? 'checked="checked"' : ''; ?>/>
                        <span>niepotwierdzony</span>
                    </label><br/>
                    <label>
                        <input type='radio' name='entry[status]' value='confirm' <?php echo ($Guest->isConfirm()) ? 'checked="checked"' : ''; ?>/>
                        <span>potwierdzony</span>
                    </label><br/>
                    <label>
                        <input type='radio' name='entry[status]' value='resign' <?php echo ($Guest->isResign()) ? 'checked="checked"' : ''; ?>/>
                        <span>rezygnacja</span>
                    </label><br/>
                    <label>
                        <input type='radio' name='entry[status]' value='old' <?php echo ($Guest->isOld()) ? 'checked="checked"' : ''; ?>/>
                        <span>nieaktualny</span>
                    </label><br/>
                </fieldset>

                <?php if($Guest->hasError('status')): ?>
                <p class="description error"><?php echo $Guest->getError('status'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest obowiązkowe</p>
                <?php endif; ?>
            </td>
        </tr>

        </tbody>

    </table>

    <p class="submit">
        <a href="<?php echo $this->getAdminPageUrl('-guests') ?>" class="button-secondary">Wstecz</a>
        &nbsp;
        <input type="submit" class="button-primary" value="Zapisz zmiany"/>
    </p>

</form>