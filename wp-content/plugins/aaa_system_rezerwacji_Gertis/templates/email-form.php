<?php
$action_params = array('view' => 'email-form', 'action' => 'save');
if($Email->hasId()){
    $action_params['emailid'] = $Email->getField('id');
}

?>
<form action="<?php echo $this->getAdminPageUrl('-emails', $action_params); ?>" method="post" id="gertis-email-form">

    <?php wp_nonce_field($this->action_token); ?>

    <table class="form-table">

        <tbody>

        <tr class="form-field">
            <th>
                <label for="gertis_event_code">Kod imprezy:</label>
            </th>
            <td>
                <input type="text" name="entry[event_code]" id="gertis_event_code" value="<?php echo $Email->getField('event_code'); ?>" />

                <?php if($Email->hasError('event_code')): ?>
                    <p class="description error"><?php echo $Email->getError('event_code'); ?></p>
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
                <textarea name="entry[register_mail]" id="gertis_register_mail" rows="7"><?php echo $Email->getField('register_mail'); ?></textarea>

                <?php if($Email->hasError('register_mail')): ?>
                    <p class="description error"><?php echo $Email->getError('register_mail'); ?></p>
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
                <textarea name="entry[confirm_mail]" id="gertis_confirm_mail" rows="7"><?php echo $Email->getField('confirm_mail'); ?></textarea>

                <?php if($Email->hasError('confirm_mail')): ?>
                    <p class="description error"><?php echo $Email->getError('confirm_mail'); ?></p>
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
                <textarea name="entry[advance_mail]" id="gertis_advance_mail" rows="7"><?php echo $Email->getField('advance_mail'); ?></textarea>

                <?php if($Email->hasError('advance_mail')): ?>
                <p class="description error"><?php echo $Email->getError('advance_mail'); ?></p>
                <?php else: ?>
                <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_paid_mail">Email po wpłacie całości kwoty</label>
            </th>
            <td>
                <textarea name="entry[paid_mail]" id="gertis_paid_mail" rows="7"><?php echo $Email->getField('paid_mail'); ?></textarea>

                <?php if($Email->hasError('paid_mail')): ?>
                    <p class="description error"><?php echo $Email->getError('paid_mail'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php endif; ?>
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_cancel_mail">Email po anulowaniu rezerwacji</label>
            </th>
            <td>
                <textarea name="entry[cancel_mail]" id="gertis_cancel_mail" rows="7"><?php echo $Email->getField('cancel_mail'); ?></textarea>

                <?php if($Email->hasError('cancel_mail')): ?>
                    <p class="description error"><?php echo $Email->getError('cancel_mail'); ?></p>
                <?php else: ?>
                    <p class="description">To pole jest wymagane</p>
                <?php endif; ?>

            </td>
        </tr>

        </tbody>

    </table>

    <p class="submit">
        <a href="<?php echo $this->getAdminPageUrl('-emails') ?>" class="button-secondary">Wstecz</a>
        &nbsp;
        <input type="submit" class="button-primary" value="Zapisz zmiany" />
    </p>

    <h3>Uwagi do szablonów</h3>
    <p>Aby mail ładnie się wyświetlał należy korzystać z tagów HTML</p>
    <p>Dopuszczalne tagi HTML: </p>
    <ul>
        <li>h1 -> główny nagłówek</li>
        <li>h2 -> poboczny nagłówek</li>
        <li>p -> akapit tekstu</li>
        <li>strong -> pogrubienie</li>
        <li>ul -> początek listy</li>
        <li>li -> lista</li>
        <li>br -> przejście do następnej lini (enter)</li>
        <li>a -> link</li>
        <li>img -> obrazek</li>
    </ul>

    <p>W treści szablonu można również kożystać ze specjalnych wartość:</p>
    <ul>
        <li><strong>%%IMIE%%</strong> -> zwraca imię i nazwisko uczestnika</li>
        <li><strong>%%TURNUS%%</strong> -> zwraca kod imprezy na który uczestnik się zapisał</li>
        <li><strong>%%DATA%%</strong> -> zwraca termin imprezy na który uczestnik się zapisał</li>
    </ul>

</form>