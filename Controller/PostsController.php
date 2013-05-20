<?php

App::uses('AppController', 'Controller');

class PostsController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	public $name = 'Posts';

/**
 * Helpers
 *
 * @var array
 * @access public
 */
	public $helpers = array('Html', 'Form');

/**
 * Index for post.
 * 
 * @access public
 */
	public function index() {
		$this->Post->recursive = 0;
		$this->set('posts', $this->Paginator->paginate()); 
	}

/**
 * View for post.
 *
 * @param string $id, post id 
 * @access public
 */
	public function view($id = null) {
		try {
			$post = $this->Post->view($id);
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('post')); 
	}

/**
 * Add for post.
 * 
 * @access public
 */
	public function add() {
		try {
			//debug($this->request->data);
			$result = $this->Post->add($this->request->data);
			if ($result === true) {
				$this->Session->setFlash(__('The post has been saved', true));
				$this->redirect(array('action' => 'index'));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			// $this->redirect(array('action' => 'index'));
		}
		$images = $this->Post->Image->find('list');
		$this->set(compact('images'));
 
	}

/**
 * Edit for post.
 *
 * @param string $id, post id 
 * @access public
 */
	public function edit($id = null) {
		try {
			$result = $this->Post->edit($id, $this->request->data);
			if ($result === true) {
				$this->Session->setFlash(__('Post saved', true));
				$this->redirect(array('action' => 'view', $this->Post->data['Post']['id']));
				
			} else {
				$this->request->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		$images = $this->Post->Image->find('list');
		$this->set(compact('images'));
 
	}

/**
 * Delete for post.
 *
 * @param string $id, post id 
 * @access public
 */
	public function delete($id = null) {
		try {
			$result = $this->Post->validateAndDelete($id, $this->request->data);
			if ($result === true) {
				$this->Session->setFlash(__('Post deleted', true));
				$this->redirect(array('action' => 'index'));
			}
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->Post->data['post'])) {
			$this->set('post', $this->Post->data['post']);
		}
	}

}
