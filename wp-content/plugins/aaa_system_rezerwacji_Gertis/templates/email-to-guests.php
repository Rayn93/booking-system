<?php
$action_params = array('view' => 'email-to-guests', 'action' => 'send', 'event_turn' => $_GET['event_turn']);

?>

<form action="<?php echo $this->getAdminPageUrl('-emails', $action_params); ?>" method="post" id="gertis-group-email-form">

<!--    --><?php //wp_nonce_field($this->action_token); ?>

    <table class="form-table">

        <tbody>

        <tr class="form-field">
            <th>
                <label for="gertis_guest_emails">E-mail uczestników z turnusu: <?php echo $_GET['event_turn']; ?> </label>
            </th>
            <td>
                <textarea name="guests_emails" id="gertis_guest_emails" rows="3"><?php foreach ($Emails as $email ){ echo $email['email'].', '; }  ?></textarea>
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_email_subject">Temat wiadomości</label>
            </th>
            <td>
                <input type="text" name="email_subject" id="gertis_email_subject" value="" />
            </td>
        </tr>

        <tr class="form-field">
            <th>
                <label for="gertis_email_massage">Treść wiadomości</label>
            </th>
            <td>
                <textarea name="email_massage" id="gertis_email_massage" rows="10"></textarea>
            </td>
        </tr>

        </tbody>

    </table>

    <p class="submit">&nbsp;
        <input type="submit" class="button-primary" value="Wyślij" />
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

<!--    <p>W treści szablonu można również kożystać ze specjalnych wartość:</p>-->
<!--    <ul>-->
<!--        <li><strong>%%IMIE%%</strong> -> zwraca imię i nazwisko uczestnika</li>-->
<!--        <li><strong>%%TURNUS%%</strong> -> zwraca kod imprezy na który uczestnik się zapisał</li>-->
<!--        <li><strong>%%DATA%%</strong> -> zwraca termin imprezy na który uczestnik się zapisał</li>-->
<!--    </ul>-->

</form>