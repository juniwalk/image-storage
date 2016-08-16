<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

namespace JuniWalk\ImageStorage;

use JuniWalk\ImageStorage\Exception\ImageException;
use JuniWalk\ImageStorage\Exception\ImageExistsException;
use JuniWalk\ImageStorage\Exception\InvalidPathException;
use JuniWalk\ImageStorage\Exception\StorageNotFoundException;

final class ImageStorage
{
	/** @var string */
	private $wwwDir;

	/** @var string */
	private $path;

	/** @var bool */
	private $isOverwriteAllowed;

	/** @var Storage[] */
	private $storages = [];


	/**
	 * @param  string  $directory
	 * @param  string  $wwwDir
	 * @param  bool    $allowOverwrite
	 * @throws InvalidPathException
	 */
	public function __construct(string $directory, string $wwwDir, bool $allowOverwrite = FALSE)
	{
		$this->wwwDir = rtrim($wwwDir, '/');
		$this->path = $this->wwwDir.'/'.trim($directory, '/');
		$this->isOverwriteAllowed = $allowOverwrite;

		if (!is_dir($this->path)) {
			throw new InvalidPathException;
		}
	}


	/**
	 * @return string
	 */
	public function getPath() : string
	{
		return $this->path;
	}


	/**
	 * @return bool
	 */
	public function isOverwriteAllowed() : bool
	{
		return $this->isOverwriteAllowed;
	}


	/**
	 * @param Storage  $storage
	 */
	public function addStorage(Storage $storage)
	{
		$this->storages[$storage->getName()] = $storage;
	}


	/**
	 * @param  string  $storageName
	 * @return Storage|NULL
	 */
	public function getStorage(string $storageName)
	{
		if (!isset($this->storages[$storageName])) {
			return NULL;
		}

		return $this->storages[$storageName];
	}


	/**
	 * @param  string  $storageName
	 * @param  Media   $media
	 * @return string
	 * @throws ImageException
	 * @throws StorageNotFoundException
	 */
	public function store(string $storageName, Media $media) : string
	{
		if (!$storage = $this->getStorage($storageName)) {
			throw new StorageNotFoundException($storageName);
		}

		$path = $this->createPath($storage, $media);
		$media->applyStorageFilters($storage);

		if (!$media->save($path)) {
			throw new ImageException;
		}

		// Remove www directory to make the path relative
		return str_replace($this->wwwDir, NULL, $path);
	}


	/**
	 * @param  Media    $media
	 * @param  Storage  $storage
	 * @return string
	 * @throws ImageExistsException
	 */
	private function createPath(Storage $storage, Media $media) : string
	{
		$info = pathinfo($media->getName());
		$type = $storage->getType();

		if ($type && $type !== $info['extension']) {
			$media->setName($info['filename'].'.'.$type);
		}

		$path = $this->getPath().'/'.$storage->getName().'/'.$media->getName();

		if (!$this->isOverwriteAllowed() && is_file($path)) {
			throw new ImageExistsException;
		}

		// Make sure that given directory exists
		@mkdir(dirname($path), 0755, TRUE);

		return $path;
	}
}
