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

use JuniWalk\ImageStorage\ImageStorage;
use Tester\Assert;

require __DIR__.'/../bootstrap.php';

final class ImageStorageTest extends \Tester\TestCase
{
	public function testEmpty()
	{
		Assert::true(TRUE);
	}
}

(new ImageStorageTest)->run();
