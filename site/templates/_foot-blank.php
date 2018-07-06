        <?php foreach($config->scripts->unique() as $script) : ?>
            <script src="<?= $script; ?>"></script>
        <?php endforeach; ?>
        <div id="loading-bkgd" class="modal-backdrop fade in"></div>
        <?php// include $config->paths->content."common/modals/ajax-modal.php"; ?>
    </body>
</html>
