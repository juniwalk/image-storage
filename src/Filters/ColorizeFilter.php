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

final class ColorizeFilter implements \JuniWalk\ImageStorage\Filter
{
	/** @var int[] */
	private $color;


	/**
	 * @param int  $level
	 */
	public function __construct(int $red, int $green, int $blue, int $alpha = 0)
	{
		$this->color = Image::rgb($red, $green, $blue, $alpha);
	}


	/**
	 * @param Image  $image
	 */
	public function apply(Image $image)
	{
		$image->filter(IMG_FILTER_COLORIZE,
			$this->color['red'],
			$this->color['green'],
			$this->color['blue'],
			$this->color['alpha']
		);
	}
}
