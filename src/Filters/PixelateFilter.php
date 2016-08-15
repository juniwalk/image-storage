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

final class PixelateFilter implements \JuniWalk\ImageStorage\Filter
{
	/** @var int */
	private $blockSize;

	/** @var bool */
	private $smooth;


	/**
	 * @param int  $blockSize
	 */
	public function __construct(int $blockSize, bool $smooth = FALSE)
	{
		$this->blockSize = max(1, $blockSize);
		$this->smooth = $smooth;
	}


	/**
	 * @param Image  $image
	 */
	public function apply(Image $image)
	{
		$image->filter(IMG_FILTER_PIXELATE, $this->blockSize, $this->smooth);
	}
}
