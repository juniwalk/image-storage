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

final class WatermarkFilter implements \JuniWalk\ImageStorage\Filter
{
	/**
	 * Transparent color code.
	 * @var int
	 */
	const TRANSPARENT = 2130706432;


	/**
	 * Inner and outer margins in percents.
	 * @var float
	 */
	const MARGIN_INNER = 0.03;
	const MARGIN_OUTER = 0.97;


	/**
	 * Watermark size from source image.
	 * @var float
	 */
	const LARGE = 0.75;
	const SMALL = 0.25;

	/**
	 * Possible positions of the watermark.
	 * @var string
	 */
	const TOP_LEFT = 'top_left';
	const BOTTOM_LEFT = 'bottom_left';
	const TOP_RIGHT = 'top_right';
	const BOTTOM_RIGHT = 'bottom_right';
	const CENTER = 'center';


	/** @var Image */
	private $watermark;

	/** @var float */
	private $opacity;

	/** @var float */
	private $angle;

	/** @var string */
	private $align;


	/**
	 * @param string  $file
	 * @param string  $align
	 * @param float   $angle
	 * @param float   $opacity
	 */
	public function __construct(string $file, string $align = self::BOTTOM_RIGHT, float $angle = 0, float $opacity = 45)
	{
		$this->watermark = Image::fromFile($file);
		$this->opacity = $opacity;
		$this->align = $align;
		$this->angle = $angle;
	}


	/**
	 * @return Image
	 */
	public function getWatermark() : Image
	{
		return $this->watermark;
	}


	/**
	 * @return bool
	 */
	public function isAngled() : bool
	{
		return $this->angle <> 0;
	}


	/**
	 * @param  Image  $image
	 * @throws ImageException
	 */
	public function apply(Image $image)
	{
		$watermark = $this->getWatermark();

		if ($this->isAngled()) {
			$watermark->rotate($this->angle, static::TRANSPARENT);
		}

		$width = $this->getScale($image);
		$watermark->scale($width);

		switch ($this->align) {
			case static::TOP_LEFT;
				$x = $image->getWidth() * static::MARGIN_INNER;
				$y = $image->getHeight() * static::MARGIN_INNER;
				break;

			case static::BOTTOM_LEFT;
				$x = $image->getWidth() * static::MARGIN_INNER;
				$y = $image->getHeight() * static::MARGIN_OUTER - $watermark->getHeight();
				break;

			case static::TOP_RIGHT;
				$x = $image->getWidth() * static::MARGIN_OUTER - $watermark->getWidth();
				$y = $image->getHeight() * static::MARGIN_INNER;
				break;

			case static::BOTTOM_RIGHT;
				$x = $image->getWidth() * static::MARGIN_OUTER - $watermark->getWidth();
				$y = $image->getHeight() * static::MARGIN_OUTER - $watermark->getHeight();
				break;

			case static::CENTER;
				$y = ($image->getHeight() - $watermark->getHeight()) / 2;
				$x = ($image->getWidth() - $watermark->getWidth()) / 2;
				break;

			default:
				throw new ImageException;
		}

		$image->place($watermark, $x, $y, $this->opacity);
	}


	/**
	 * @param  Image  $image
	 * @return float
	 */
	private function getScale(Image $image) : float
	{
		$size = static::SMALL;

		if ($this->align === static::CENTER) {
			$size = static::LARGE;
		}

		return $image->getWidth() * $size;
	}
}
