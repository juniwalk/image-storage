<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

namespace JuniWalk\ImageStorage\DI;

use JuniWalk\ImageStorage\Storage;

final class ImageStorageExtension extends \Nette\DI\CompilerExtension
{
	/** @var array */
	private $defaults = [
		'directory' => '/images',
		'allowOverwrite' => FALSE,
	];


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);
		$config['wwwDir'] = $builder->expand('%wwwDir%');

		$imageStorage = $builder->addDefinition($this->prefix('imageStorage'))
			->setClass('JuniWalk\ImageStorage\ImageStorage', $config);
	}


	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		if (!$storages = $builder->findByType(Storage::class)) {
			return NULL;
		}

		$imageStorage = $builder->getDefinition($this->prefix('imageStorage'));

		foreach ($storages as $storage) {
			$imageStorage->addSetup('addStorage', [$storage]);
		}
	}
}
