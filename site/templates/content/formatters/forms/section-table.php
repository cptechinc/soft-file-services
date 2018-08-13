<table class="table table-striped table-bordered table-condensed table-sm">
	<thead>
		<tr> <th>Field</th> <th>Field Definition</th> <th>Line</th> <th>Column</th> <th>Column Length</th> <th>Column Label</th> </tr>
	</thead>
	<?php foreach (array_keys($formatter->formatter[$datasection]['columns']) as $column) : ?>
		<?php $name = str_replace(' ', '', $column); ?>
		<tr>
			<td class="field"><?= $column; ?></td>
			<td>
				<?php if ($formatter->fields[$datasection][$column]['type'] == 'D') : ?>
					<select class="form-control form-control-sm" name="<?= $name."-date-format";?>">
						<?php foreach ($formatter->datetypes as $key => $value) : ?>
							<?php if ($key == $formatter->formatter[$datasection]['columns'][$column]['date-format']) : ?>
								<option value="<?= $key; ?>" selected><?= $value . ' - '. date($key); ?></option>
							<?php else : ?>
								<option value="<?= $key; ?>"><?= $value . ' - '. date($key); ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				<?php elseif ($formatter->fields[$datasection][$column]['type'] == 'I') : ?>
					Integer
				<?php elseif ($formatter->fields[$datasection][$column]['type'] == 'C') : ?>
					Text
				<?php elseif ($formatter->fields[$datasection][$column]['type'] == 'N') : ?>
					<div class="form-row">
						<div class="col">
							Before Decimal &nbsp;
							<input type="text" class="form-control form-control-sm text-right before-decimal" name="<?= $name."-before-decimal";?>" value="<?= $formatter->formatter[$datasection]['columns'][$column]['before-decimal']; ?>"> &nbsp; &nbsp;
						</div>
						<div class="col">
							After Decimal &nbsp;  
							<input type="text" class="form-control form-control-sm text-right after-decimal" name="<?= $name."-after-decimal";?>" value="<?= $formatter->formatter[$datasection]['columns'][$column]['after-decimal']; ?>">
							<span class="display"></span>
						</div>
					</div>
				<?php endif; ?>
			</td>
			<?php $columndefinition = array_key_exists($column, $formatter->formatter[$datasection]['columns']) ? $formatter->formatter[$datasection]['columns'][$column] : $formatter->get_defaultformattercolumn(); ?>
			<td><input type="text" class="form-control form-control-sm text-right qty-sm <?= $datasection; ?>-line" name="<?= $name."-line";?>" value="<?= $columndefinition['line']; ?>"></td>
			<td><input type="text" class="form-control form-control-sm text-right column" name="<?= $name."-column";?>" value="<?= $columndefinition['column']; ?>"></td>
			<td><input type="text" class="form-control form-control-sm text-right column-length" name="<?= $name."-length";?>" value="<?= $columndefinition['col-length']; ?>"></td>
			<td><input type="text" class="form-control form-control-sm col-label" name="<?= $name."-label";?>" value="<?= $columndefinition['label']; ?>"></td>
		</tr>
	<?php endforeach; ?>
</table>
