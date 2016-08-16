<?php

/**
 * TEST: Form Architect factory.
 * @testCase
 *
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

use JuniWalk\ImageStorage\Exception\ImageExistsException;
use JuniWalk\ImageStorage\Exception\InvalidPathException;
use JuniWalk\ImageStorage\Exception\StorageNotFoundException;
use JuniWalk\ImageStorage\Filters;
use JuniWalk\ImageStorage\ImageStorage;
use JuniWalk\ImageStorage\Media;
use JuniWalk\ImageStorage\Storages\LocalStorage;
use Nette\Utils\Image;
use Tester\Assert;

require __DIR__.'/../bootstrap.php';

final class ImageStorageTest extends \Tester\TestCase
{
	/**
	 * Path to a test image in data directory.
	 * @var string
	 */
	const TEST_IMAGE = __DIR__.'/../Data/broccoli-659x544.gif';


	/** @var ImageStorage */
	private $imageStorage;

	/** @var string */
	private $path;


	public function __construct()
	{
		$path = TMPDIR.'/images';

		if (!is_dir($path)) {
			mkdir($path, 0777, TRUE);
		}

		$imageStorage = new ImageStorage(basename($path), dirname($path), FALSE);
		$imageStorage->addStorage(new LocalStorage('Test 1'));

		$this->imageStorage = $imageStorage;
		$this->path = $path;
	}


	/**
	 * @return ImageStorage
	 */
	public function getImageStorage() : ImageStorage
	{
		return $this->imageStorage;
	}


	public function testConstructor()
	{
		$imageStorage = $this->getImageStorage();

		Assert::same($this->path, $imageStorage->getPath());
		Assert::false($imageStorage->isOverwriteAllowed());

		Assert::exception(function () {
			new ImageStorage('/unknown', TMPDIR);

		}, InvalidPathException::class);
	}


	public function testStorage()
	{
		$imageStorage = $this->getImageStorage();
		$media = Media::fromString('empty.gif', Image::EMPTY_GIF);

		$image = $imageStorage->store('test-1', $media);
		$image = dirname($this->path).'/'.$image;

		Assert::same(Image::EMPTY_GIF, file_get_contents($image));
		Assert::exception(function () use ($imageStorage, $media) {
			$imageStorage->store('unknown', $media);

		}, StorageNotFoundException::class);

		Assert::exception(function () use ($imageStorage, $media) {
			$imageStorage->store('test-1', $media);

		}, ImageExistsException::class);
	}


	public function testFilters()
	{
		$storage = new LocalStorage('Test 2', 'jpg');
		$storage->addFilter(new Filters\ResizeFilter(800, 480, 'EXACT'));
		$storage->addFilter(new Filters\CropFilter(0, 0, 800, 480));
		$storage->addFilter(new Filters\BlurFilter(5));
		$storage->addFilter(new Filters\PixelateFilter(5));
		$storage->addFilter(new Filters\SketchFilter());
		$storage->addFilter(new Filters\BrightnessFilter(-127));
		$storage->addFilter(new Filters\ContrastFilter(-25));
		$storage->addFilter(new Filters\SharpenFilter());
		$storage->addFilter(new Filters\GrayscaleFilter());
		$storage->addFilter(new Filters\NegateFilter());
		$storage->addFilter(new Filters\ColorizeFilter(0x19, 0x2D, 0x5B));
		$storage->addFilter(new Filters\WatermarkFilter(static::TEST_IMAGE, 'bottom_right', 0, 100));

		$imageStorage = $this->getImageStorage();
		$imageStorage->addStorage($storage);

		$imageStorage->store('test-2', Media::fromFile(static::TEST_IMAGE));

		Assert::true(TRUE);
	}
}

(new ImageStorageTest)->run();
