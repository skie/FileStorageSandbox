<div class="posts form">
<?php echo $this->Form->create('Post', array('type' => 'file', 'url' => array('action' => 'add')));?>
	<fieldset>
 		<legend><?php echo __('Add Post');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('Image.file', array('type' => 'file'));
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Posts'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List File Storages'), array('controller' => 'file_storages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'file_storages', 'action' => 'add')); ?> </li>
	</ul>
</div>