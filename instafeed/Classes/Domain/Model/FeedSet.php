<?php
namespace Cerebrum\Instafeed\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * FeedSet
 */
class FeedSet extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * icon
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $icon = null;
    
    /**
     * description
     *
     * @var string
     */
    protected $description = '';
    
    /**
     * rawPicture
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cerebrum\Instafeed\Domain\Model\RawPicture>
     */
    protected $rawPicture = null;
    
    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->rawPicture = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the icon
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }
    
    /**
     * Sets the icon
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
     * @return void
     */
    public function setIcon(\TYPO3\CMS\Extbase\Domain\Model\FileReference $icon)
    {
        $this->icon = $icon;
    }
    
    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Adds a RawPicture
     *
     * @param \Cerebrum\Instafeed\Domain\Model\RawPicture $rawPicture
     * @return void
     */
    public function addRawPicture(\Cerebrum\Instafeed\Domain\Model\RawPicture $rawPicture)
    {
        $this->rawPicture->attach($rawPicture);
    }
    
    /**
     * Removes a RawPicture
     *
     * @param \Cerebrum\Instafeed\Domain\Model\RawPicture $rawPictureToRemove The RawPicture to be removed
     * @return void
     */
    public function removeRawPicture(\Cerebrum\Instafeed\Domain\Model\RawPicture $rawPictureToRemove)
    {
        $this->rawPicture->detach($rawPictureToRemove);
    }
    
    /**
     * Returns the rawPicture
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cerebrum\Instafeed\Domain\Model\RawPicture> $rawPicture
     */
    public function getRawPicture()
    {
        return $this->rawPicture;
    }
    
    /**
     * Sets the rawPicture
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cerebrum\Instafeed\Domain\Model\RawPicture> $rawPicture
     * @return void
     */
    public function setRawPicture(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $rawPicture)
    {
        $this->rawPicture = $rawPicture;
    }

}