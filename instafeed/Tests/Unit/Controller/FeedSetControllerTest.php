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
 * Test case for class Cerebrum\Instafeed\Controller\FeedSetController.
 *
 */
class FeedSetControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Cerebrum\Instafeed\Controller\FeedSetController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Cerebrum\\Instafeed\\Controller\\FeedSetController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllFeedSetsFromRepositoryAndAssignsThemToView()
	{

		$allFeedSets = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$feedSetRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\FeedSetRepository', array('findAll'), array(), '', FALSE);
		$feedSetRepository->expects($this->once())->method('findAll')->will($this->returnValue($allFeedSets));
		$this->inject($this->subject, 'feedSetRepository', $feedSetRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('feedSets', $allFeedSets);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenFeedSetToView()
	{
		$feedSet = new \Cerebrum\Instafeed\Domain\Model\FeedSet();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('feedSet', $feedSet);

		$this->subject->showAction($feedSet);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenFeedSetToFeedSetRepository()
	{
		$feedSet = new \Cerebrum\Instafeed\Domain\Model\FeedSet();

		$feedSetRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\FeedSetRepository', array('add'), array(), '', FALSE);
		$feedSetRepository->expects($this->once())->method('add')->with($feedSet);
		$this->inject($this->subject, 'feedSetRepository', $feedSetRepository);

		$this->subject->createAction($feedSet);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenFeedSetToView()
	{
		$feedSet = new \Cerebrum\Instafeed\Domain\Model\FeedSet();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('feedSet', $feedSet);

		$this->subject->editAction($feedSet);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenFeedSetInFeedSetRepository()
	{
		$feedSet = new \Cerebrum\Instafeed\Domain\Model\FeedSet();

		$feedSetRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\FeedSetRepository', array('update'), array(), '', FALSE);
		$feedSetRepository->expects($this->once())->method('update')->with($feedSet);
		$this->inject($this->subject, 'feedSetRepository', $feedSetRepository);

		$this->subject->updateAction($feedSet);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenFeedSetFromFeedSetRepository()
	{
		$feedSet = new \Cerebrum\Instafeed\Domain\Model\FeedSet();

		$feedSetRepository = $this->getMock('Cerebrum\\Instafeed\\Domain\\Repository\\FeedSetRepository', array('remove'), array(), '', FALSE);
		$feedSetRepository->expects($this->once())->method('remove')->with($feedSet);
		$this->inject($this->subject, 'feedSetRepository', $feedSetRepository);

		$this->subject->deleteAction($feedSet);
	}
}
