<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

namespace JuniWalk\ImageStorage\Filters;

use Nette\Utils\Image;
use Nette\Utils\Strings;

final class ResizeFilter implements \JuniWalk\ImageStorage\Filter
{
	/** @var mixed */
	private $width;

	/** @var mixed */
	private $height;

	/** @var int */
	private $flags;


	/**
	 * @param  mixed   $width
	 * @param  mixed   $height
	 * @param  string  $flag
	 * @param  bool    $shrinkOnly
	 * @throws InvalidFlagException
	 */
	public function __construct($width, $height, string $flag = 'FIT', bool $shrinkOnly = FALSE)
	{
		$constant = Image::class.'::'.Strings::upper($flag);

		if (!defined($constant)) {
			throw new InvalidFlagException($flag);
		}

		$flags = constant($constant);

		if ($shrinkOnly) {
			$flags = $flags | Image::SHRINK_ONLY;
		}

		$this->width = $width;
		$this->height = $height;
		$this->flags = $flags;
	}


	/**
	 * @param Image  $image
	 */
	public function apply(Image $image)
	{
		$image->resize($this->width, $this->height, $this->flags);
	}
}
