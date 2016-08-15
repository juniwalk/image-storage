Image Storage
=============

[![Travis](https://img.shields.io/travis/juniwalk/image-storage.svg?style=flat-square)](https://travis-ci.org/juniwalk/image-storage)
[![GitHub Release](https://img.shields.io/github/release/juniwalk/image-storage.svg?style=flat-square)](https://github.com/juniwalk/image-storage/releases)
[![Total Donwloads](https://img.shields.io/packagist/dt/juniwalk/image-storage.svg?style=flat-square)](https://packagist.org/packages/juniwalk/image-storage)
[![Code Quality](https://img.shields.io/scrutinizer/g/juniwalk/image-storage.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/image-storage/)
[![Tests Coverage](https://img.shields.io/scrutinizer/coverage/g/juniwalk/image-storage.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/image-storage/)
[![License](https://img.shields.io/packagist/l/juniwalk/image-storage.svg?style=flat-square)](https://mit-license.org)

Image storing utility that will help you save images into defined storages.

Installation
------------

```shell
$ composer require juniwalk/image-storage
```

Configuration
-------------

```yaml
extensions:
	imageStorage: JuniWalk\ImageStorage\DI\ImageStorageExtension

imageStorage:
	directory: /images		# Relative to $wwwDir
	allowOverwrite: TRUE
```

Adding new storages
-------------------

```yaml
services:
	imageStorage.storage.avatar:
		class: JuniWalk\ImageStorage\Storages\LocalStorage(avatar, jpg)
		setup:
			- addFilter(JuniWalk\ImageStorage\Filters\ResizeFilter(512, 512, 'EXACT'))
			- addFilter(JuniWalk\ImageStorage\Filters\WatermarkFilter(%wwwDir%/images/watermark.png))
```

Usage
-----

```php
/** @var JuniWalk\ImageStorage\Media */
$media = Media::fromImage(string $name, Nette\Utils\Image $image)
$media = Media::fromUpload(Nette\Http\FileUpload $fileUpload, string $name = NULL);
$media = Media::fromFile(string $filename);
$media = Media::fromString(string $name, string $content);

/** @var \JuniWalk\ImageStorage\ImageStorage */
$imageStorage = $this->getImageStorage();

/** @var string  Relative path to $wwwDir */
$path = $imageStorage->store(string $storage, Media $media);
```
