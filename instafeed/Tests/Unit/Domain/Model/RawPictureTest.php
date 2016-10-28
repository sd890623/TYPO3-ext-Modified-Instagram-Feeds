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
 * Test case for class \Cerebrum\Instafeed\Domain\Model\RawPicture.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class RawPictureTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Cerebrum\Instafeed\Domain\Model\RawPicture
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Cerebrum\Instafeed\Domain\Model\RawPicture();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getUrlReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getUrl()
		);
	}

	/**
	 * @test
	 */
	public function setUrlForStringSetsUrl()
	{
		$this->subject->setUrl('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'url',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getHashtagReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getHashtag()
		);
	}

	/**
	 * @test
	 */
	public function setHashtagForStringSetsHashtag()
	{
		$this->subject->setHashtag('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'hashtag',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getNotesReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getNotes()
		);
	}

	/**
	 * @test
	 */
	public function setNotesForStringSetsNotes()
	{
		$this->subject->setNotes('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'notes',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getSelectedReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getSelected()
		);
	}

	/**
	 * @test
	 */
	public function setSelectedForBoolSetsSelected()
	{
		$this->subject->setSelected(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'selected',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIdReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getId()
		);
	}

	/**
	 * @test
	 */
	public function setIdForStringSetsId()
	{
		$this->subject->setId('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'id',
			$this->subject
		);
	}
}
