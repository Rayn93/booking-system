<!--If sprawdzający czy widok jest dla wszystkich uczestników czy tylko dla uczestników w danym obozie-->
<?php if($_GET['action'] == 'members'): ?>
<h2>Lista uczestników dla obozu: <?php echo  $_GET['event_turn']?></h2>
<?php else: ?>

<form method="get" action="<?php echo $this->getAdminPageUrl('-guests'); ?>" id="gertis-guests-form-1">

    <input type="hidden" name="page" value="<?php echo static::$plugin_id.'-guests'; ?>" />
    <input type="hidden" name="paged" value="<?php echo $Pagination->getCurrPage(); ?>" />

    Sortuj według
    <select name="orderby">
        <?php foreach(Gertis_BookingSystem_Model::getGuestOrderByOpts() as $key=>$val): ?>
            <option
                <?php echo($val == $Pagination->getOrderBy()) ? 'selected="selected"' : ''; ?>
                value="<?php echo $val; ?>">
                <?php echo $key; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="orderdir">
        <?php if($Pagination->getOrderDir() == 'asc') :?>
            <option selected="selected" value="asc">Rosnąco</option>
            <option value="desc">Majeląco</option>
        <?php else: ?>
            <option value="asc">Rosnąco</option>
            <option selected="selected" value="desc">Majeląco</option>
        <?php endif; ?>
    </select>

    <input type="submit" class="button-secondary" value="Sortuj" />

<!--    <div class="alignleft actions">-->
<!---->
<!--        <select name="event_turn">-->
<!--            <option value="0">Wszystkie imprezy</option>-->
<!--            --><?php //foreach(Gertis_BookingSystem_Model::getEventForFilter() as $key=>$val): ?>
<!--                <option-->
<!--                    --><?php //echo($val == $Pagination->getFilter()) ? 'selected="selected"' : ''; ?>
<!--                    value="--><?php //echo $val; ?><!--">-->
<!--                    --><?php //echo $key; ?>
<!--                </option>-->
<!--            --><?php //endforeach; ?>
<!---->
<!---->
<!--            <option value="OPT1">OPT1</option>-->
<!--            <option value="OPT2">OPT2</option>-->
<!--            <option value="OPT3">OPT3</option>-->
<!--            <option value="OPT4">OPT4</option>-->
<!--        </select>-->
<!---->
<!--        <input type="submit" class="button-secondary" value="Filtruj" />-->
<!---->
<!--    </div>-->

</form>

<?php endif; ?>

<form action="<?php echo $this->getAdminPageUrl('-guests', array('view' => 'guests', 'action' => 'bulk')); ?>" method="post" id="gertis-guests-form-2" onsubmit="return confirm('Czy na pewno chcesz zastosować zmiany masowe?')">

    <?php wp_nonce_field($this->action_token.'bulk'); ?>

    <?php if(!isset($_GET['action']) && $_GET['action'] != 'members'): ?>
    <div class="tablenav">

        <div class="alignleft actions bulkactions">

            <select name="bulkaction">
                <option value="0">Masowe działania</option>
                <option value="delete">Usuń</option>
                <option value="waiting">Niepotwierdzony</option>
                <option value="resign">Zrezygnował</option>
                <option value="old">Zakończony</option>
            </select>

            <input type="submit" class="button-secondary" value="Zastosuj" />

        </div>

        <div class="tablenav-pages">
            <span class="displaying-num"><?php  echo $Pagination->getTotalCount(); ?> Uczestników</span>

            <?php
            $curr_page = $Pagination->getCurrPage();
            $last_page = $Pagination->getLastPage();

            $first_disabled = '';
            $last_disabled = '';

            $url_params = array(
                'orderby' => $Pagination->getOrderBy(),
                'orderdir' => $Pagination->getOrderDir()
            );


            $url_params['paged'] = 1;
            $first_page_url = $this->getAdminPageUrl('-guests', $url_params);

            $url_params['paged'] = $curr_page-1;
            $prev_page_url = $this->getAdminPageUrl('-guests', $url_params);

            $url_params['paged'] = $last_page;
            $last_page_url = $this->getAdminPageUrl('-guests', $url_params);

            $url_params['paged'] = $curr_page+1;
            $next_page_url = $this->getAdminPageUrl('-guests', $url_params);


            if($curr_page == 1){
                $first_page_url = '#';
                $prev_page_url = '#';

                $first_disabled = 'disabled';
            }
            if($curr_page == $last_page){
                $last_page_url = '#';
                $next_page_url = '#';

                $last_disabled = 'disabled';
            }
            ?>

            <span class="pagination-links">
                <a href="<?php echo $first_page_url; ?>" title="Idź do pierwszej strony" class="first-page <?php echo $first_disabled; ?>">«</a>&nbsp;&nbsp;
                <a href="<?php echo $prev_page_url; ?>" title="Idź do poprzedniej strony" class="prev-page <?php echo $first_disabled; ?>">‹</a>&nbsp;&nbsp;

                <span class="paging-input"><?php echo $curr_page ?> z <span class="total-pages"><?php echo $last_page ?></span></span>

                &nbsp;&nbsp;<a href="<?php echo $next_page_url; ?>" title="Idź do następnej strony" class="next-page <?php echo $last_disabled; ?>">›</a>
                &nbsp;&nbsp;<a href="<?php echo $last_page_url; ?>" title="Idź do ostatniej strony" class="last-page <?php echo $last_disabled; ?>">»</a>

            </span>
        </div>

        <div class="clear"></div>

    </div>

    <?php endif; ?>


    <table id="table2excel" class="widefat">
        <thead>
        <tr>
            <?php if(!isset($_GET['action']) && $_GET['action'] != 'members'): ?>
            <th class="check-column"><input type="checkbox" /></th>
            <?php endif; ?>
<!--            <th>ID</th>-->

            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Kod imprezy (turnus)</th>
            <th>Status</th>
            <th>Telefon</th>
            <th>Data urodzenia</th>
            <th>Email</th>
            <th>Pesel/ID</th>
            <th>Adres</th>
            <th>Wpłacono</th>
<!--            <th>Skąd wiesz?</th>-->
            <th>Uwagi dodatkowe</th>
            <th>Nasze uwagi</th>
            <th>Data rejestracji</th>

        </tr>
        </thead>
        <tbody id="the-list">

        <?php if($Pagination->hasItems()): ?>

            <?php foreach($Pagination->getItems() as $i=>$item): ?>

                <tr <?php echo ($i%2) ? 'class="alternate"' : ''; ?>>

                    <?php if(!isset($_GET['action']) && $_GET['action'] != 'members'): ?>
                        <th class="check-column">
                            <input type="checkbox" value="<?php echo $item->id; ?> " name="bulkcheck[]" />
                        </th>
                    <?php endif; ?>

<!--                    <td>--><?php //echo $item->id; ?><!--</td>-->
                    <td><?php echo $item->guest_name; ?>
                        <div class="row-actions">
                                <span class="edit">
                                    <a class="edit" href="<?php echo $this->getAdminPageUrl('-guests', array('view' => 'guest-form', 'guestid' => $item->id)); ?>">Edytuj</a>
                                </span> |
                                <?php if($item->status == 'waiting'): ?>
                                    <span class="edit">
                                        <?php
                                        $token_name = $this->action_token.$item->id;
                                        $confirm_url = $this->getAdminPageUrl('-guests', array('action' => 'confirm', 'guestid' => $item->id));
                                        ?>
                                        <a class="edit" href="<?php echo wp_nonce_url($confirm_url, $token_name) ?>" onclick="return confirm('Czy na pewno chcesz potwierdzić zgłoszenie tego uczestnika?')">Potwierdź</a>
                                    </span> |
                                <?php endif ?>
                        </div>
                    </td>
                    <td><?php echo $item->guest_surname; ?>
                        <div class="row-actions">
                            <span class="trash">
                                    <?php
                                    $token_name = $this->action_token.$item->id;
                                    $del_url = $this->getAdminPageUrl('-guests', array('action' => 'delete', 'guestid' => $item->id));
                                    ?>
                                <a class="delete" href="<?php echo wp_nonce_url($del_url, $token_name) ?>" onclick="return confirm('Czy na pewno chcesz usunąć tego uczestnika?')">Usuń</a>
                                    </span> |
                            <?php if($item->status == 'waiting' || $item->status == 'confirm' || $item->status == 'advance' || $item->status == 'paid'): ?>
                                <span class="trash">
                                            <?php
                                            $token_name = $this->action_token.$item->id;
                                            $cancel_url = $this->getAdminPageUrl('-guests', array('action' => 'cancel', 'guestid' => $item->id));
                                            ?>
                                    <a class="edit" href="<?php echo wp_nonce_url($cancel_url, $token_name) ?>" onclick="return confirm('Czy na pewno chcesz anulować zgłoszenie tego uczestnika?')">Anuluj</a>
                                        </span>
                            <?php endif ?>
                        </div>
                    </td>
                    <td><?php echo $item->event_turn; ?></td>
                    <td>
                        <?php
                        if($item->status == 'waiting') echo 'Oczekuje';
                        else if($item->status == 'confirm') echo 'Potwierdzony';
                        else if($item->status == 'advance') echo 'Zapłacona zaliczka';
                        else if($item->status == 'paid') echo 'Zapłacona całość';
                        else if($item->status == 'send') echo 'Przesłany dalej';
                        else if($item->status == 'resign') echo 'Zrezygnował';
                        else if($item->status == 'old') echo 'Zakończony';
                        ?>
                    </td>
                    <td><?php echo $item->phone; ?></td>
                    <td><?php echo $item->birth_date; ?></td>
                    <td><?php echo $item->email; ?></td>
                    <td><?php echo $item->personal_no; ?></td>
                    <td class="nocenter">
                        <?php echo $item->street; ?>
                        <?php echo $item->zip_code; ?>
                        <?php echo $item->city; ?>
                    </td>
                    <td><?php echo $item->money; ?>
                        <div class="row-actions">
                            <?php if($item->status == 'confirm'): ?>
                                <span class="edit">
                                            <?php
                                            $token_name = $this->action_token.$item->id;
                                            $advance_url = $this->getAdminPageUrl('-guests', array('action' => 'advance', 'guestid' => $item->id));
                                            ?>
                                    <a class="edit" href="<?php echo wp_nonce_url($advance_url, $token_name) ?>" onclick="return confirm('Czy na pewno chcesz zmienić status na: Zapłacono zaliczkę, tego uczestnika?')">Zap. zalicz.</a>
                                        </span><br />
                            <?php endif ?>
                            <?php if($item->status == 'advance' || $item->status == 'confirm'): ?>
                                <span class="edit">
                                            <?php
                                            $token_name = $this->action_token.$item->id;
                                            $paid_url = $this->getAdminPageUrl('-guests', array('action' => 'paid', 'guestid' => $item->id));
                                            ?>
                                    <a class="edit" href="<?php echo wp_nonce_url($paid_url, $token_name) ?>" onclick="return confirm('Czy na pewno chcesz zmienić status na: Zapłacono całość, tego uczestnika?')">Zap. całość</a>
                                        </span>
                            <?php endif ?>
                        </div>
                    </td>
<!--                    <td>--><?php //echo $item->from_who; ?><!--</td>-->
                    <td><?php echo $item->more_info; ?></td>
                    <td><?php echo $item->staff_info; ?></td>
                    <td><?php echo $item->register_date; ?></td>

                </tr>

            <?php endforeach; ?>


        <?php else: ?>
            <tr>
                <td colspan="12">Brak uczestników</td>
            </tr>
        <?php endif; ?>
        </tbody>

    </table>


    <div class="tablenav">
        <div class="tablenav-pages">

            <span class="pagination-links">
                Przejdź do strony
                <?php

                $url_params = array(
                    'orderby' => $Pagination->getOrderBy(),
                    'orderdir' => $Pagination->getOrderDir()
                );

                for($i=1; $i<=$Pagination->getLastPage(); $i++){

                    $url_params['paged'] = $i;
                    $url = $this->getAdminPageUrl('-guests', $url_params);

                    if($i == $Pagination->getCurrPage()){
                        echo "&nbsp;<strong>{$i}</strong>";
                    }else{
                        echo '&nbsp;<a href="'.$url.'">'.$i.'</a>';
                    }

                }
                ?>
            </span>

        </div>

        <div class="clear"></div>
    </div>

</form>


<?php if($_GET['action'] == 'members'): ?>
    <?php $email_params = array('view' => 'email-to-guests', 'event_turn' => $_GET['event_turn']); ?>

    <?php $Model = new Gertis_BookingSystem_Model(); ?>

    <a class="button button-primary button-large" href="<?php echo $this->getAdminPageUrl('-guests', array('view' => 'guests-export', 'event_turn' => $_GET['event_turn'], 'event_date' => $Model->getEventDate($_GET['event_turn']))); ?>">Export uczestników</a>
    <a class="button button-primary button-large" href="<?php echo $this->getAdminPageUrl('-emails', $email_params); ?>" />Email do uczestników</a>

<?php endif; ?>
