<?php

namespace Cerebrum\Instafeed\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \Cerebrum\Instafeed\Domain\Model\FeedSet.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FeedSetTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Cerebrum\Instafeed\Domain\Model\FeedSet
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Cerebrum\Instafeed\Domain\Model\FeedSet();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName()
	{
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIconReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getIcon()
		);
	}

	/**
	 * @test
	 */
	public function setIconForFileReferenceSetsIcon()
	{
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setIcon($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'icon',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription()
	{
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRawPictureReturnsInitialValueForRawPicture()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getRawPicture()
		);
	}

	/**
	 * @test
	 */
	public function setRawPictureForObjectStorageContainingRawPictureSetsRawPicture()
	{
		$rawPicture = new \Cerebrum\Instafeed\Domain\Model\RawPicture();
		$objectStorageHoldingExactlyOneRawPicture = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneRawPicture->attach($rawPicture);
		$this->subject->setRawPicture($objectStorageHoldingExactlyOneRawPicture);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneRawPicture,
			'rawPicture',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addRawPictureToObjectStorageHoldingRawPicture()
	{
		$rawPicture = new \Cerebrum\Instafeed\Domain\Model\RawPicture();
		$rawPictureObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$rawPictureObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($rawPicture));
		$this->inject($this->subject, 'rawPicture', $rawPictureObjectStorageMock);

		$this->subject->addRawPicture($rawPicture);
	}

	/**
	 * @test
	 */
	public function removeRawPictureFromObjectStorageHoldingRawPicture()
	{
		$rawPicture = new \Cerebrum\Instafeed\Domain\Model\RawPicture();
		$rawPictureObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$rawPictureObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($rawPicture));
		$this->inject($this->subject, 'rawPicture', $rawPictureObjectStorageMock);

		$this->subject->removeRawPicture($rawPicture);

	}
}
