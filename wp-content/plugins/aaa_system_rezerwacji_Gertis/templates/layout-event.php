<div class="wrap">

    <?php if($this->hasFlashMsg()): ?>
        <!--<div id="message" class="updated">-->
        <div id="message" class="<?php echo $this->getFlashMsgStatus(); ?>">
            <p><?php echo $this->getFlashMsg(); ?></p>
        </div>
    <?php endif; ?>

    <h2>
        <a href="<?php echo $this->getAdminEventUrl(); ?>">Gertis System Rezerwacji</a>
        <a class="add-new-h2" href="<?php echo $this->getAdminEventUrl(array('view' => 'form')); ?>">Dodaj nowy rejs/turnus</a>
    </h2>

    <br /><br /><br />

<?php require_once $view; ?>


<br style="clear: both;">

</div>