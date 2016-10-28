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
 * RawPictures
 */
class RawPicture extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * url
     *
     * @var string
     */
    protected $url = '';
    
    /**
     * hashtag
     *
     * @var string
     */
    protected $hashtag = '';
    
    /**
     * notes
     *
     * @var string
     */
    protected $notes = '';
    
    /**
     * selected
     *
     * @var bool
     */
    protected $selected = false;
    
    /**
     * id
     *
     * @var string
     */
    protected $id = '';
    
    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * Returns the hashtag
     *
     * @return string $hashtag
     */
    public function getHashtag()
    {
        return $this->hashtag;
    }
    
    /**
     * Sets the hashtag
     *
     * @param string $hashtag
     * @return void
     */
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;
    }
    
    /**
     * Returns the notes
     *
     * @return string $notes
     */
    public function getNotes()
    {
        return $this->notes;
    }
    
    /**
     * Sets the notes
     *
     * @param string $notes
     * @return void
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
    
    /**
     * Returns the selected
     *
     * @return bool $selected
     */
    public function getSelected()
    {
        return $this->selected;
    }
    
    /**
     * Sets the selected
     *
     * @param bool $selected
     * @return void
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
    }
    
    /**
     * Returns the boolean state of selected
     *
     * @return bool
     */
    public function isSelected()
    {
        return $this->selected;
    }
    
    /**
     * Returns the id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the id
     *
     * @param string $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}