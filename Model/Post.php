<?php

App::uses('AppModel', 'Model');

class Post extends AppModel {
/**
 * Name
 *
 * @var string $name
 * @access public
 */
	public $name = 'Post';
/**
 * Validation parameters - initialized in constructor
 *
 * @var array
 * @access public
 */
	public $validate = array();

/**
 * belongsTo association
 *
 * @var array $belongsTo 
 * @access public
 */
	public $belongsTo = array(
		'Image' => array(
			'className' => 'FileStorage.ImageStorage',
			'foreignKey' => 'image_id',
		)
	);

/**
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 * @access public
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'name' => array(
				'notempty' => array('rule' => array('notempty'), 'required' => true, 'allowEmpty' => false, 'message' => __('Please enter a Name', true))),
		);
	}

	protected function _processImageUpload() {
		$data['Image']['foreign_key'] = $this->data[$this->alias][$this->primaryKey];
		$data['Image']['model'] = $this->name;
		$data['Image']['file'] = $this->data['Image']['file'];
		$this->Image->create();
		$result = $this->Image->save($data);
		if ($result) {
			return $this->Image->id;
		} else {
			return false;
		}
	}

/**
 * Adds a new record to the database
 *
 * @param array post data, should be Contoller->data
 * @return array
 * @access public
 */
	public function add($data = null) {
		if (!empty($data)) {
			$this->create();
			$result = $this->save($data);
			if ($result !== false) {
				$this->data = array_merge($data, $result);
				$this->data[$this->alias][$this->primaryKey] = $this->id;
				$imageId = $this->_processImageUpload();
				if (!empty($imageId)) {
					$this->saveField('image_id', $this->Image->id);
				}
				return true;
			} else {
				throw new OutOfBoundsException(__('Could not save the post, please check your inputs.', true));
			}
			return $return;
		}
	}

/**
 * Edits an existing Post.
 *
 * @param string $id, post id 
 * @param array $data, controller post data usually $this->data
 * @return mixed True on successfully save else post data as array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function edit($id = null, $data = null) {
		$post = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($post)) {
			throw new OutOfBoundsException(__('Invalid Post', true));
		}
		$this->set($post);

		if (!empty($data)) {
			$this->set($data);
			$result = $this->save(null, true);
			if ($result) {
				$this->data = $result;
				$imageId = $this->_processImageUpload();
				if (!empty($imageId)) {
					$this->saveField('image_id', $imageId);
					if (!empty($post[$this->name]['image_id'])) {
						$this->Image->delete($post[$this->name]['image_id']);
					}
				}
				return true;
			} else {
				return $data;
			}
		} else {
			return $post;
		}
	}

/**
 * Returns the record of a Post.
 *
 * @param string $id, post id.
 * @return array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function view($id = null) {
		$post = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id)));

		if (empty($post)) {
			throw new OutOfBoundsException(__('Invalid Post', true));
		}

		return $post;
	}

/**
 * Validates the deletion
 *
 * @param string $id, post id 
 * @param array $data, controller post data usually $this->data
 * @return boolean True on success
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function validateAndDelete($id = null, $data = array()) {
		$post = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($post)) {
			throw new OutOfBoundsException(__('Invalid Post', true));
		}

		$this->data['post'] = $post;
		if (!empty($data)) {
			$data['Post']['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]'));

			$this->set($data);
			if ($this->validates()) {
				if ($this->delete($data['Post']['id'])) {
					return true;
				}
			}
			$this->validate = $tmp;
			throw new Exception(__('You need to confirm to delete this Post', true));
		}
	}


}
