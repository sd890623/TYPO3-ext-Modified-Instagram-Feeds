<?php
namespace Cerebrum\Instafeed\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 
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
 * Test case for class Cerebrum\Instafeed\Controller\RawPictureController.
 *
 */
class RawPictureControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Cerebrum\Instafeed\Controller\RawPictureController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Cerebrum\\Instafeed\\Controller\\RawPictureController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllRawPicturesFromRepositoryAndAssignsThemToView()
	{

		$allRawPictures = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$rawPictureRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\RawPictureRepository', array('findAll'), array(), '', FALSE);
		$rawPictureRepository->expects($this->once())->method('findAll')->will($this->returnValue($allRawPictures));
		$this->inject($this->subject, 'rawPictureRepository', $rawPictureRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('rawPictures', $allRawPictures);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenRawPictureToView()
	{
		$rawPicture = new \Cerebrum\Instafeed\Domain\Model\RawPicture();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('rawPicture', $rawPicture);

		$this->subject->showAction($rawPicture);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenRawPictureToRawPictureRepository()
	{
		$rawPicture = new \Cerebrum\Instafeed\Domain\Model\RawPicture();

		$rawPictureRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\RawPictureRepository', array('add'), array(), '', FALSE);
		$rawPictureRepository->expects($this->once())->method('add')->with($rawPicture);
		$this->inject($this->subject, 'rawPictureRepository', $rawPictureRepository);

		$this->subject->createAction($rawPicture);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenRawPictureToView()
	{
		$rawPicture = new \Cerebrum\Instafeed\Domain\Model\RawPicture();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('rawPicture', $rawPicture);

		$this->subject->editAction($rawPicture);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenRawPictureInRawPictureRepository()
	{
		$rawPicture = new \Cerebrum\Instafeed\Domain\Model\RawPicture();

		$rawPictureRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\RawPictureRepository', array('update'), array(), '', FALSE);
		$rawPictureRepository->expects($this->once())->method('update')->with($rawPicture);
		$this->inject($this->subject, 'rawPictureRepository', $rawPictureRepository);

		$this->subject->updateAction($rawPicture);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenRawPictureFromRawPictureRepository()
	{
		$rawPicture = new \Cerebrum\Instafeed\Domain\Model\RawPicture();

		$rawPictureRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\RawPictureRepository', array('remove'), array(), '', FALSE);
		$rawPictureRepository->expects($this->once())->method('remove')->with($rawPicture);
		$this->inject($this->subject, 'rawPictureRepository', $rawPictureRepository);

		$this->subject->deleteAction($rawPicture);
	}
}
