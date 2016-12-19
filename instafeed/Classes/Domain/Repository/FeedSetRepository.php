<?php
namespace Cerebrum\Instafeed\Domain\Repository;

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
 * The repository for FeedSets
 */
class FeedSetRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @param null
     * @return stringified objects;
     */
    public function findAllWithSelected()
    {
        $query = $this->createQuery();
        //$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $results = $query->statement('SELECT * FROM tx_instafeed_domain_model_feedset AS FEEDSET');
        $results = $query->execute();
        return $results;
    }
    
    /**
     * @param feedSetUid
     * @return array objects;
     */
    public function findMMByFeedSetUid($uid)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_instafeed_feedset_rawpicture_mm AS MM WHERE uid_local = ' . $uid . '');
        $results = $query->execute(true);
        return $results;
    }
    
    /**
     * @param $feedSet
     * @param $feed
     * @return array objects;
     */
    public function findMMByUid($feedSet, $feed)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_instafeed_feedset_rawpicture_mm AS MM WHERE uid_local = ' . $feedSet->getUid() . ' AND uid_foreign = ' . $feed->getUid());
        //return ('SELECT * FROM tx_instafeed_feedset_rawpicture_mm AS MM WHERE uid_local = '.$feedSet->getUid().' AND uid_foreign = '.$feed->getUid() );
        $results = $query->execute(true);
        return $results;
    }
    
    /**
     * @param feedSet
     * @return array objects;
     */
    public function findMMSelectedByUid($feedSet)
    {
        $query = $this->createQuery();
        $query->statement('SELECT uid_foreign FROM tx_instafeed_feedset_rawpicture_mm AS MM WHERE uid_local = ' . $feedSet->getUid() . ' AND selected = 1 ');
        //return ('SELECT * FROM tx_instafeed_feedset_rawpicture_mm AS MM WHERE uid_local = '.$feedSet->getUid().' AND uid_foreign = '.$feed->getUid() );
        $results = $query->execute(true);
        return $results;
    }
    
    /**
     * @param $feedSetUid
     * @param $feedUid
     * @param $selected
     * @return sucess indicator?;
     */
    public function updateFeedSelect($feedSetUid, $feedUid, $selected)
    {
        //$query= $this -> createQuery();
        //$sql= 'UPDATE tx_instafeed_feedset_rawpicture_mm SET selected = 1 ';
        $results = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_instafeed_feedset_rawpicture_mm', 'uid_local = ' . $feedSetUid . ' AND uid_foreign = ' . $feedUid, array('selected' => $selected));
        //$query -> execute(true);
        return $results;
    }
    
    /**
     * @param $feedSet
     * @param $feed
     * @return sucess indicator?;
     */
    public function addFeed($feedSet, $feed)
    {
        //$query= $this -> createQuery();
        //$sql= 'UPDATE tx_instafeed_feedset_rawpicture_mm SET selected = 1 ';
        $fields = array('uid_local' => $feedSet->getUid(), 'uid_foreign' => $feed->getUid());
        $success = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_instafeed_feedset_rawpicture_mm', $fields);
        //$query -> execute(true);
        return $feedSet->getUid() . '  ' . $feed->getUid();
    }
    
    /**
     * @param $feedSetUid
     * @param $feedUid
     * @return sucess indicator?;
     */
    public function removeFeed($feedSetUid, $feedUid)
    {
        //$query= $this -> createQuery();
        //$sql= 'UPDATE tx_instafeed_feedset_rawpicture_mm SET selected = 1 ';
        $results = $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_instafeed_feedset_rawpicture_mm', 'uid_local = ' . $feedSetUid . ' AND uid_foreign = ' . $feedUid);
        //$query -> execute(true);
        return $results;
    }
    
    /**
     * @param feedSetUid, feedUid
     * @return sucess indicator?;
     */
    public function removeAllFeed($feedSetUid)
    {
        //$query= $this -> createQuery();
        //$sql= 'UPDATE tx_instafeed_feedset_rawpicture_mm SET selected = 1 ';
        $results = $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_instafeed_feedset_rawpicture_mm', 'uid_local = ' . $feedSetUid);
        //$query -> execute(true);
        return $results;
    }

}