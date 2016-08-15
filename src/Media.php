<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

namespace JuniWalk\ImageStorage;

use JuniWalk\ImageStorage\Exception\ImageInvalidException;
use Nette\Http\FileUpload;
use Nette\Utils\Image;
use Nette\Utils\Strings;

final class Media
{
	/** @var string */
	private $name;

	/** @var Image */
	private $image;


	/**
	 * @param string  $name
	 * @param Image   $image
	 */
	private function __construct(string $name, Image $image)
	{
		$this->setName($name);
		$this->image = $image;
	}


	/**
	 * @param  string  $name
	 * @param  Image   $image
	 * @return static
	 */
	public static function fromImage(string $name, Image $image) : self
	{
		return new static($name, $image);
	}


	/**
	 * @param  FileUpload   $fileUpload
	 * @param  string|NULL  $name
	 * @return static
	 * @throws ImageInvalidException
	 */
	public static function fromUpload(FileUpload $fileUpload, string $name = NULL) : self
	{
		if (!$fileUpload->isOk() || !$fileUpload->isImage()) {
			throw new ImageInvalidException;
		}

		return new static($name ?: $fileUpload->getName(), $fileUpload->toImage());
	}


	/**
	 * @param  string  $filename
	 * @return static
	 */
	public static function fromFile(string $filename) : self
	{
		return new static(basename($filename), Image::fromFile($filename));
	}


	/**
	 * @param  string  $name
	 * @param  string  $content
	 * @return static
	 */
	public static function fromString(string $name, string $content) : self
	{
		return new static($name, Image::fromString($content));
	}


	/**
	 * @param string  $name
	 */
	public function setName(string $name)
	{
		$this->name = Strings::webalize($name, '.');
	}


	/**
	 * @return string
	 */
	public function getName() : string
	{
		return $this->name;
	}


	/**
	 * @return int
	 */
	public function getWidth() : int
	{
		return $this->image->getWidth();
	}


	/**
	 * @return int
	 */
	public function getHeight() : int
	{
		return $this->image->getHeight();
	}


	/**
	 * @param Storage  $storage
	 */
	public function applyStorageFilters(Storage $storage)
	{
		$filters = $storage->getFilters();

		foreach ($filters as $filter) {
			$filter->apply($this->image);
		}
	}


	/**
	 * @param  string  $filename
	 * @return bool
	 */
	public function save(string $filename) : bool
	{
		return $this->image->save($filename);
	}
}
