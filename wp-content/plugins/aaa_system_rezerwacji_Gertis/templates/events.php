<form method="get" action="" id="gertis-events-form-1">

<!--    <input type="hidden" name="page" value="--><?php //echo static::$plugin_id; ?><!--" />-->
<!--    <input type="hidden" name="paged" value="--><?php //echo $Pagination->getCurrPage(); ?><!--" />-->

    Sortuj według
    <select name="orderby">
<!--        --><?php //foreach(LTEHomeSlider_Model::getOrderByOpts() as $key=>$val): ?>
<!--            <option-->
<!--                --><?php //echo($val == $Pagination->getOrderBy()) ? 'selected="selected"' : ''; ?>
<!--                value="--><?php //echo $val; ?><!--">-->
<!--                --><?php //echo $key; ?>
<!--            </option>-->
<!--        --><?php //endforeach; ?>
        <option value="id">ID</option>
        <option value="id">Kod wydarzenia</option>
        <option value="id">Status</option>
        <option value="id">Liczba miejsc</option>
    </select>

    <select name="orderdir">
<!--        --><?php //if($Pagination->getOrderDir() == 'asc') :?>
            <option selected="selected" value="asc">Rosnąco</option>
            <option value="desc">Majeląco</option>
<!--        --><?php //else: ?>
<!--            <option value="asc">Rosnąco</option>-->
<!--            <option selected="selected" value="desc">Majeląco</option>-->
<!--        --><?php //endif; ?>
    </select>

    <input type="submit" class="button-secondary" value="Sortuj" />

</form>


<form action="#" method="post" id="gertis-events-form-2" onsubmit="return confirm('Czy na pewno chcesz zastosować zmiany masowe?')">

<!--    --><?php //wp_nonce_field($this->action_token.'bulk'); ?>

    <div class="tablenav">

        <div class="alignleft actions bulkactions">

            <select name="bulkaction">
                <option value="0">Masowe działania</option>
                <option value="delete">Usuń</option>
                <option value="public">Aktualny</option>
                <option value="private">Nieaktualny</option>
            </select>

            <input type="submit" class="button-secondary" value="Zastosuj" />

        </div>

        <div class="alignleft actions">

            <select name="filter">
                <option value="0">Wszystkie imprezy</option>
                <option value="pos">POS</option>
                <option value="dem">DEM</option>
                <option value="bjk">BJK</option>
            </select>

            <input type="submit" class="button-secondary" value="Filtruj" />

        </div>

        <div class="tablenav-pages">
            <span class="displaying-num"><?php // echo $Pagination->getTotalCount(); ?> 23 imprezy</span>

<!--            --><?php
//            $curr_page = $Pagination->getCurrPage();
//            $last_page = $Pagination->getLastPage();
//
//            $first_disabled = '';
//            $last_disabled = '';
//
//            $url_params = array(
//                'orderby' => $Pagination->getOrderBy(),
//                'orderdir' => $Pagination->getOrderDir()
//            );
//
//
//            $url_params['paged'] = 1;
//            $first_page_url = $this->getAdminPageUrl($url_params);
//
//            $url_params['paged'] = $curr_page-1;
//            $prev_page_url = $this->getAdminPageUrl($url_params);
//
//            $url_params['paged'] = $last_page;
//            $last_page_url = $this->getAdminPageUrl($url_params);
//
//            $url_params['paged'] = $curr_page+1;
//            $next_page_url = $this->getAdminPageUrl($url_params);
//
//
//            if($curr_page == 1){
//                $first_page_url = '#';
//                $prev_page_url = '#';
//
//                $first_disabled = 'disabled';
//            }else
//                if($curr_page == $last_page){
//                    $last_page_url = '#';
//                    $next_page_url = '#';
//
//                    $last_disabled = 'disabled';
//                }
//            ?>

            <span class="pagination-links">
                <a href="<?php// echo $first_page_url; ?>" title="Idź do pierwszej strony" class="first-page <?php// echo $first_disabled; ?>">«</a>&nbsp;&nbsp;
                <a href="<?php// echo $prev_page_url; ?>" title="Idź do poprzedniej strony" class="prev-page <?php// echo $first_disabled; ?>">‹</a>&nbsp;&nbsp;
                
                <span class="paging-input"><?php// echo $curr_page ?> 1 z <span class="total-pages"><?php// echo $last_page ?> 4</span></span>
                
                &nbsp;&nbsp;<a href="<?php// echo $next_page_url; ?>" title="Idź do następnej strony" class="next-page <?php// echo $last_disabled; ?>">›</a>
                &nbsp;&nbsp;<a href="<?php// echo $last_page_url; ?>" title="Idź do ostatniej strony" class="last-page <?php// echo $last_disabled; ?>">»</a>
                
            </span>
        </div>

        <div class="clear"></div>

    </div>


    <table class="widefat">
        <thead>
        <tr>
            <th class="check-column"><input type="checkbox" /></th>
            <th>ID</th>
            <th>Kod wydarzenia</th>
            <th>Turnus</th>
            <th>Początek</th>
            <th>Koniec</th>
            <th>Cena</th>
            <th>Liczba miejsc</th>
            <th>Zapisanych</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody id="the-list">

        <?php //if($Pagination->hasItems()): ?>

            <?php //foreach($Pagination->getItems() as $i=>$item): ?>

                <tr <?php //echo ($i%2) ? 'class="alternate"' : ''; ?>>
                    <th class="check-column">
                        <input type="checkbox" value="<?php// echo $item->id; ?> 1" name="bulkcheck[]" />
                    </th>
                    <td><?php //echo $item->id; ?> 1</td>
                    <td>OPT
                        <div class="row-actions">
                                <span class="edit">
                                    <a class="edit" href="<?php// echo $this->getAdminPageUrl(array('view' => 'form', 'slideid' => $item->id)); ?>">Edytuj</a>
                                </span> |
                            <span class="trash">
<!--                                    --><?php
//                                    $token_name = $this->action_token.$item->id;
//                                    $del_url = $this->getAdminPageUrl(array('action' => 'delete', 'slideid' => $item->id));
//                                    ?>
                                <a class="delete" href="<?php// echo wp_nonce_url($del_url, $token_name) ?>" onclick="return confirm('Czy na pewno chcesz usunąć ten wpis?')">Usuń</a>
                                </span>
                        </div>
                    </td>
                    <td>OPT8</td>
                    <td>21.06</td>
                    <td>02.07</td>
                    <td>1999</td>
                    <td>21</td>
                    <td>2</td>
                    <td>aktualny</td>
                </tr>

            <?php// endforeach; ?>


        <?php// else: ?>
            <tr>
                <td colspan="8">Brak rejsów w bazie danych</td>
            </tr>
        <?php //endif; ?>
        </tbody>

    </table>


    <div class="tablenav">
        <div class="tablenav-pages">
            
            <span class="pagination-links">
                Przejdź do strony
                    <strong>1</strong>
                    &nbsp;<a href="#">2</a>
                    &nbsp;<a href="#">3</a>
                    &nbsp;<a href="#">4</a>
<!--                --><?php
//
//                $url_params = array(
//                    'orderby' => $Pagination->getOrderBy(),
//                    'orderdir' => $Pagination->getOrderDir()
//                );
//
//                for($i=1; $i<=$Pagination->getLastPage(); $i++){
//
//                    $url_params['paged'] = $i;
//                    $url = $this->getAdminPageUrl($url_params);
//
//                    if($i == $Pagination->getCurrPage()){
//                        echo "&nbsp;<strong>{$i}</strong>";
//                    }else{
//                        echo '&nbsp;<a href="'.$url.'">'.$i.'</a>';
//                    }
//
//                }
//                ?>
            </span>

        </div>

        <div class="clear"></div>
    </div>

</form>