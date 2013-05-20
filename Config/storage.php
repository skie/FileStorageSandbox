<?php
/**
 * FileStorage configuration
 */
App::uses('FileStorageUtils', 'FileStorage.Lib/Utility');
App::uses('StorageManager', 'FileStorage.Lib');
App::uses('LocalImageProcessingListener', 'FileStorage.Event');
//App::uses('LocalFileStorageListener', 'FileStorage.Event');
App::uses('CakeEventManager', 'Event');

spl_autoload_register(__NAMESPACE__ .'\FileStorageUtils::gaufretteLoader');

$listener = new LocalImageProcessingListener();
CakeEventManager::instance()->attach($listener);

/**
 * Local file system adapter
 */
StorageManager::config('Local', array(
	'adapterOptions' => array(APP . 'FileStorage' . DS, true),
	'adapterClass' => '\Gaufrette\Adapter\Local',
	'class' => '\Gaufrette\Filesystem'));

/**
 * AWS SDK setup
 */
require_once(APP . 'Vendor' . DS . 'AwsSdk' . DS . 'sdk.class.php');
CFCredentials::set(array(
	'production' => array(
		'certificate_authority' => true,
		'key' => 'key',
		'secret' => 'secret')
	)
);
$s3 = new AmazonS3();

/**
 * S3 adapter
 */
StorageManager::config('S3', array(
	'adapterOptions' => array(
		$s3,
		'bt.residential.1'),
	'adapterClass' => '\Gaufrette\Adapter\AmazonS3',
	'class' => '\Gaufrette\Filesystem'));

/**
 * Image resizing configuration
 */
Configure::write('Media', array(
	'basePath' => APP . 'FileStorage' . DS,
	'imageSizes' => array(
		'Post' => array(
			'c940' => array(
				'crop' => array(
					'width' => 940, 'height' => 200)),
			't50' => array(
				'thumbnail' => array(
					'width' => 150, 'height' => 150)),
			't150' => array(
				'thumbnail' => array(
					'width' => 150, 'height' => 150))),
		),
	)
);

App::uses('ClassRegistry', 'Utility');
ClassRegistry::init('FileStorage.ImageStorage')->generateHashes();
