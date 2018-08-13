<form action="<?= $page->fullURL; ?>" method="POST" class="print-formatter-form" id="print-formatter-form">
    <input type="hidden" name="action" value="save-formatter">
	<input type="hidden" name="user" value="<?= $user->loginid; ?>">
    <div>
        <h3>Editing <?= $page->title; ?> Formatter</h3>
        
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($formatter->datasections as $datasection => $label) : ?>
                <?php $class = ($datasection == key($formatter->datasections)) ? 'active' : ''; ?>
                <li role="presentation" class="nav-item"><a href="#<?= $datasection; ?>" class="nav-link <?= $class; ?>" aria-controls="<?= $datasection; ?>" role="tab" data-toggle="tab"><?= $label; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php foreach ($formatter->datasections as $datasection => $label) : ?>
                <?php $class = ($datasection == key($formatter->datasections)) ? 'active' : ''; ?>
                <div role="tabpanel" class="tab-pane <?= $class; ?>" id="<?= $datasection; ?>">
                    <?php include $config->paths->content."formatters/forms/section-table.php";  ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
	<button type="button" class="btn btn-info" onclick="preview_tableformatter('#print-formatter-form')"><i class="fa fa-table" aria-hidden="true"></i> Generate Preview</button>
    <a href="<?= $formatter->generate_previewurl(); ?>" target="_blank" class="btn btn-primary invisible" id="preview-formatter">View Preview</a>
    <button type="submit" class="btn btn-success">Save Formatter</button>
</form>
