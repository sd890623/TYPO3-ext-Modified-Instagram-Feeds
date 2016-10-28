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
 * Test case for class Cerebrum\Instafeed\Controller\RawPicturesController.
 *
 */
class RawPicturesControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Cerebrum\Instafeed\Controller\RawPicturesController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Cerebrum\\Instafeed\\Controller\\RawPicturesController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllRawPicturessFromRepositoryAndAssignsThemToView()
	{

		$allRawPicturess = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$rawPicturesRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\RawPicturesRepository', array('findAll'), array(), '', FALSE);
		$rawPicturesRepository->expects($this->once())->method('findAll')->will($this->returnValue($allRawPicturess));
		$this->inject($this->subject, 'rawPicturesRepository', $rawPicturesRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('rawPicturess', $allRawPicturess);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenRawPicturesToView()
	{
		$rawPictures = new \Cerebrum\Instafeed\Domain\Model\RawPictures();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('rawPictures', $rawPictures);

		$this->subject->showAction($rawPictures);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenRawPicturesToRawPicturesRepository()
	{
		$rawPictures = new \Cerebrum\Instafeed\Domain\Model\RawPictures();

		$rawPicturesRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\RawPicturesRepository', array('add'), array(), '', FALSE);
		$rawPicturesRepository->expects($this->once())->method('add')->with($rawPictures);
		$this->inject($this->subject, 'rawPicturesRepository', $rawPicturesRepository);

		$this->subject->createAction($rawPictures);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenRawPicturesToView()
	{
		$rawPictures = new \Cerebrum\Instafeed\Domain\Model\RawPictures();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('rawPictures', $rawPictures);

		$this->subject->editAction($rawPictures);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenRawPicturesInRawPicturesRepository()
	{
		$rawPictures = new \Cerebrum\Instafeed\Domain\Model\RawPictures();

		$rawPicturesRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\RawPicturesRepository', array('update'), array(), '', FALSE);
		$rawPicturesRepository->expects($this->once())->method('update')->with($rawPictures);
		$this->inject($this->subject, 'rawPicturesRepository', $rawPicturesRepository);

		$this->subject->updateAction($rawPictures);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenRawPicturesFromRawPicturesRepository()
	{
		$rawPictures = new \Cerebrum\Instafeed\Domain\Model\RawPictures();

		$rawPicturesRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\RawPicturesRepository', array('remove'), array(), '', FALSE);
		$rawPicturesRepository->expects($this->once())->method('remove')->with($rawPictures);
		$this->inject($this->subject, 'rawPicturesRepository', $rawPicturesRepository);

		$this->subject->deleteAction($rawPictures);
	}
}
