<!--If sprawdzający czy widok jest dla wszystkich uczestników czy tylko dla uczestników w danym obozie-->

<h2>Tabela exportu dla obozu: <?php echo  $_GET['event_turn']?></h2>

<form action="<?php echo $this->getAdminPageUrl('-guests', array('view' => 'guests', 'action' => 'bulk')); ?>" method="post" id="gertis-guests-form-2" onsubmit="return confirm('Czy na pewno chcesz zastosować zmiany masowe?')">

    <table id="table2excel" class="widefat">
        <thead>
        <tr>
            <th>ID</th>
            <th>Data rejestracji</th>
            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Kod imprezy (turnus)</th>
            <th>Data urodzenia</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Pesel/ID</th>
            <th>Adres</th>
            <th>Wpłacono</th>
            <th>Skąd wiesz?</th>
            <th>Uwagi dodatkowe</th>
            <th>Nasze uwagi</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody id="the-list">

        <?php if($Pagination->hasItems()): ?>

            <?php foreach($Pagination->getItems() as $i=>$item): ?>

                <tr <?php echo ($i%2) ? 'class="alternate"' : ''; ?>>

                    <td><?php echo $item->id; ?></td>
                    <td><?php echo $item->register_date; ?></td>
                    <td><?php echo $item->guest_name; ?></td>
                    <td><?php echo $item->guest_surname; ?></td>
                    <td><?php echo $item->event_turn; ?></td>
                    <td><?php echo $item->birth_date; ?></td>
                    <td><?php echo $item->email; ?></td>
                    <td><?php echo $item->phone; ?></td>
                    <td><?php echo $item->personal_no; ?></td>
                    <td>
                        <?php echo $item->street; ?>,
                        <?php echo $item->city; ?>,
                        <?php echo $item->zip_code; ?>
                    </td>
                    <td><?php echo $item->money; ?></td>
                    <td><?php echo $item->from_who; ?></td>
                    <td><?php echo $item->more_info; ?></td>
                    <td><?php echo $item->staff_info; ?></td>
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
                </tr>

            <?php endforeach; ?>


        <?php else: ?>
            <tr>
                <td colspan="12">Brak uczestników</td>
            </tr>
        <?php endif; ?>
        </tbody>

    </table>

</form>
<br />
<br />

<button id="btnExport" class="button button-primary button-large"> Export uczestników do Excel-a</button>

