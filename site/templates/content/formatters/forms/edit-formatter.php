<form action="<?= $page->fullURL; ?>" method="POST" class="screen-formatter-form" id="screen-formatter-form">
    <input type="hidden" name="action" value="save-formatter">
	<input type="hidden" name="user" value="<?= $user->loginid; ?>">
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><?= $page->title; ?> Formatter</h3> </div>
		<br>
		<div class="row">
			<div class="col-xs-12">
				<div class="formatter-container">
					<div>
						<ul class="nav nav-tabs" role="tablist">
							<?php foreach ($formatter->datasections as $datasection => $label) : ?>
								<?php $class = ($datasection == key($formatter->datasections)) ? 'active' : ''; ?>
								<li role="presentation" class="<?= $class; ?>"><a href="#<?= $datasection; ?>" aria-controls="<?= $datasection; ?>" role="tab" data-toggle="tab"><?= $label; ?></a></li>
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
				</div>
			</div>
		</div>
	</div>
	<button type="button" class="btn btn-info" onclick="preview_tableformatter()"><i class="fa fa-table" aria-hidden="true"></i> Preview Table</button>
</form>
<?php echo var_dump(json_decode(file_get_contents(TableScreenFormatter::$fieldfiledir."$formatter->type.json"), true)); ?>
