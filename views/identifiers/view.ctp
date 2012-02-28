<div class="identifiers view">
<h2><?php  __('Identifier');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $identifier['Identifier']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $identifier['Identifier']['number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Part Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $identifier['Identifier']['part_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $identifier['Identifier']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $identifier['Identifier']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Identifier', true), array('action' => 'edit', $identifier['Identifier']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Identifier', true), array('action' => 'delete', $identifier['Identifier']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $identifier['Identifier']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Identifiers', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Identifier', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
