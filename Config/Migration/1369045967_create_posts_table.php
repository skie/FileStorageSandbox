<?php
class CreatePostsTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'posts' => array(
					'id' => array('type'    =>'integer', 'null'    => false, 'default' => NULL, 'length'  => 11, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null'    => false, 'default' => NULL, 'length'  => 200),
					'image_id' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
					'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
				),
			)
		),
		'down' => array(
			'drop_table' => array('posts')
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
