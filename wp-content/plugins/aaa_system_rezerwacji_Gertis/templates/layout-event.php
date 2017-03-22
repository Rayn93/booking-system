<div class="wrap">
    <br />

    <?php if($this->hasFlashMsg()): ?>
        <div id="message" class="<?php echo $this->getFlashMsgStatus(); ?>">
            <p><?php echo $this->getFlashMsg(); ?></p>
        </div>
    <?php endif; ?>

    <h2>
        <a href="<?php echo $this->getAdminPageUrl(); ?>">Gertis System Rezerwacji</a>
        <a class="add-new-h2" href="<?php echo $this->getAdminPageUrl('', array('view' => 'event-form')); ?>">Dodaj nową usługę.</a>
    </h2>

    <br /><br />

<?php require_once $view; ?>


<br style="clear: both;">

</div>