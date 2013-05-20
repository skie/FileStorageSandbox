<h2><?php echo sprintf(__('Delete Post "%s"?'), $post['Post']['title']); ?></h2>
<p>	
	<?php echo __('Be aware that your Post and all associated data will be deleted if you confirm!'); ?>
</p>
<?php
	echo $this->Form->create('Post', array(
		'url' => array(
			'action' => 'delete',
			$post['Post']['id'])));
	echo $this->Form->input('confirm', array(
		'label' => __('Confirm'),
		'type' => 'checkbox',
		'error' => __('You have to confirm.')));
	echo $this->Form->submit(__('Continue'));
	echo $this->Form->end();
?>