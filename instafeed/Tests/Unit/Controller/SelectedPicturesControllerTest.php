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
 * Test case for class Cerebrum\Instafeed\Controller\SelectedPicturesController.
 *
 */
class SelectedPicturesControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Cerebrum\Instafeed\Controller\SelectedPicturesController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Cerebrum\\Instafeed\\Controller\\SelectedPicturesController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllSelectedPicturessFromRepositoryAndAssignsThemToView()
	{

		$allSelectedPicturess = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$selectedPicturesRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\SelectedPicturesRepository', array('findAll'), array(), '', FALSE);
		$selectedPicturesRepository->expects($this->once())->method('findAll')->will($this->returnValue($allSelectedPicturess));
		$this->inject($this->subject, 'selectedPicturesRepository', $selectedPicturesRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('selectedPicturess', $allSelectedPicturess);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenSelectedPicturesToView()
	{
		$selectedPictures = new \Cerebrum\Instafeed\Domain\Model\SelectedPictures();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('selectedPictures', $selectedPictures);

		$this->subject->showAction($selectedPictures);
	}
}
