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


<form action="<?php echo $this->getAdminPageUrl('-guests', array('view' => 'guests', 'action' => 'bulk')); ?>" method="post" id="gertis-guests-form-2" onsubmit="return confirm('Czy na pewno chcesz zastosować zmiany masowe?')">

    <?php wp_nonce_field($this->action_token.'bulk'); ?>

    <div class="tablenav">

        <div class="alignleft actions bulkactions">

            <select name="bulkaction">
                <option value="0">Masowe działania</option>
                <option value="delete">Usuń</option>
                <option value="waiting">Niepotwierdzony</option>
                <option value="resign">Zrezygnował</option>
                <option value="old">Nieaktualny</option>
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


    <table class="widefat">
        <thead>
        <tr>
            <th class="check-column"><input type="checkbox" /></th>
            <th>ID</th>
            <th>Imie i nazwisko</th>
            <th>Kod imprezy (turnus)</th>
            <th>Data urodzenia</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Pesel/ID</th>
            <th>Adres zamieszkania</th>
            <th>Wpłacono</th>
            <th>Skąd wiesz?</th>
            <th>Uwagi dodatkowe</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody id="the-list">

        <?php if($Pagination->hasItems()): ?>

            <?php foreach($Pagination->getItems() as $i=>$item): ?>

                <tr <?php echo ($i%2) ? 'class="alternate"' : ''; ?>>
                    <th class="check-column">
                        <input type="checkbox" value="<?php echo $item->id; ?> " name="bulkcheck[]" />
                    </th>
                    <td><?php echo $item->id; ?></td>
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
                            <span class="trash">
                                    <?php
                                    $token_name = $this->action_token.$item->id;
                                    $del_url = $this->getAdminPageUrl('-guests', array('action' => 'delete', 'guestid' => $item->id));
                                    ?>
                                <a class="delete" href="<?php echo wp_nonce_url($del_url, $token_name) ?>" onclick="return confirm('Czy na pewno chcesz usunąć tego uczestnika?')">Usuń</a>
                                </span>
                        </div>
                    </td>
                    <td><?php echo $item->event_turn; ?></td>
                    <td><?php echo $item->birth_date; ?></td>
                    <td><?php echo $item->email; ?></td>
                    <td><?php echo $item->phone; ?></td>
                    <td><?php echo $item->personal_no; ?></td>
                    <td>
                        <?php echo $item->city; ?> <br />
                        <?php echo $item->street; ?> <br />
                        <?php echo $item->zip_code; ?>
                    </td>
                    <td><?php echo $item->money; ?></td>
                    <td><?php echo $item->from_who; ?></td>
                    <td><?php echo $item->more_info; ?></td>
                    <td>
                        <?php
                            if($item->status == 'waiting') echo 'Oczekuje';
                            else if($item->status == 'confirm') echo 'Potwierdzony';
                            else if($item->status == 'resign') echo 'Zrezygnował';
                            else if($item->status == 'old') echo 'Nieaktualny';
                        ?>
                    </td>
                </tr>

            <?php endforeach; ?>


        <?php else: ?>
            <tr>
                <td colspan="12">Brak uczestników w bazie danych</td>
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