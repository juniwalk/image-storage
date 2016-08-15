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

final class CropFilter implements \JuniWalk\ImageStorage\Filter
{
	/** @var mixed */
	private $left;

	/** @var mixed */
	private $top;

	/** @var mixed */
	private $width;

	/** @var mixed */
	private $height;


	/**
	 * @param mixed  $left
	 * @param mixed  $top
	 * @param mixed  $width
	 * @param mixed  $height
	 */
	public function __construct($left, $top, $width, $height)
	{
		$this->left = $left;
		$this->top = $top;
		$this->width = $width;
		$this->height = $height;
	}


	/**
	 * @param Image  $image
	 */
	public function apply(Image $image)
	{
		$image->crop($this->left, $this->top, $this->width, $this->height);
	}
}
