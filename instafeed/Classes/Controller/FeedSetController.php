<?php
namespace Cerebrum\Instafeed\Controller;

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
 * FeedSetController
 */
class FeedSetController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * feedSetRepository
     *
     * @var \Cerebrum\Instafeed\Domain\Repository\FeedSetRepository
     * @inject
     */
    protected $feedSetRepository = NULL;
    
    /**
     * rawPictureRepository
     *
     * @var \Cerebrum\Instafeed\Domain\Repository\RawPictureRepository
     * @inject
     */
    protected $rawPictureRepository = null;
    
    private $persistenceManager = null;
    
    /**
     * @param $val
     */
    public function convertStringToBoolean($val)
    {
        if ($val == 'true') {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * action backRoot
     *
     * @return void
     */
    public function backRootAction()
    {
        
    }
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $feedsSets = $this->feedSetRepository->findAll();
        $results = array();
        foreach ($feedsSets as $feedSet) {
            $feedSetArray = array();
            $name = $feedSet->getName();
            $feedSetArray['uid'] = $feedSet->getUid();
            $feedSetArray['name'] = $name;
            $feedSetArray['hashTags'] = $feedSet->getHashtags();

            $rawPictures = $feedSet->getRawPicture();
            $picturesArray = array();
            $simplePicsArray = $this->feedSetRepository->findMMByFeedSetUid($feedSet->getUid());
            //return var_dump($simplePicsArray);
            foreach ($rawPictures as $rawPicture) {
                $pictureArray = array();
                $pictureArray['uid'] = $rawPicture->getUid();
                $pictureArray['url'] = $rawPicture->getUrl();
                $pictureArray['hashTags'] = $rawPicture->getHashtag();
                $pictureArray['notes'] = $rawPicture->getNotes();
                //Fill in selected data
                foreach ($simplePicsArray as $simplePicArray) {
                    if ((int) $simplePicArray['uid_foreign'] == $rawPicture->getUid()) {
                        $pictureArray['selected'] = (int) $simplePicArray['selected'];
                    }
                }
                $pictureArray['id'] = $rawPicture->getId();
                $picturesArray[] = $pictureArray;
            }
            $feedSetArray['pictures'] = $picturesArray;
            $results[] = $feedSetArray;
        }
        return json_encode($results);
    }
    
    /**
     * action show
     *
     * @param \Cerebrum\Instafeed\Domain\Model\FeedSet $feedSet
     * @return void
     */
    public function showAction()
    {
        $feedSetUid = $this->settings['feedSets'];
        if ($feedSetUid == null || $this->feedSetRepository->findByUid($feedSetUid)==null ) {
            $this->view->assign('errorMsg', 'Woops, an error occured. Please choose a campaign in the backend of the page');
        } else {
            $feedSet = $this->feedSetRepository->findByUid($feedSetUid);
            $feedsUid = $this->feedSetRepository->findMMSelectedByUid($feedSet);
            $feeds = array();
            foreach ($feedsUid as $feedUid) {
                $feeds[] = $this->rawPictureRepository->findByUid($feedUid['uid_foreign']);
            }
            $this->view->assign('campaignName', $feedSet->getName());
            $this->view->assign('feeds', $feeds);
        }
    }
    
    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        
    }
    
    /**
     * action create
     *
     * @param \Cerebrum\Instafeed\Domain\Model\FeedSet $newFeedSet
     * @return void
     */
    public function createAction()
    {
        $name = $_POST['name'];
        $newFeedSet = new \Cerebrum\Instafeed\Domain\Model\FeedSet();
        $newFeedSet->setName($name);
        $this->feedSetRepository->add($newFeedSet);
        return 'feedSet added';
    }
    
    /**
     * action edit
     *
     * @param \Cerebrum\Instafeed\Domain\Model\FeedSet $feedSet
     * @ignorevalidation $feedSet
     * @return void
     */
    public function editAction()
    {
        $mode = $_POST['type'];
        if ($mode=='name') {
            $name = $_POST['name'];
            $feedSetUid = $_POST['feedSet-uid'];
            $feedSet = $this->feedSetRepository->findByUid($feedSetUid);
            if (!empty($feedSet)) {
                $feedSet->setName($name);
                $this->feedSetRepository->update($feedSet);
                return 'feedSet name updated';
            } else {
                return 'error';
            }            
        }
        else if ($mode=='hashtags') {
            return 'error';
        }

    }
    
    /**
     * action update
     *
     * @param \Cerebrum\Instafeed\Domain\Model\FeedSet $feedSet
     * @return string
     */
    public function updateAction()
    {
        $logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        $this->persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $post = $_POST;
        $mode = $post['type'];
        if ($mode == 'select') {
            $selected = $_POST['selected'];
            $feedSetId = $_POST['feedSet-uid'];
            $feedId = $_POST['feed-uid'];
            $this->feedSetRepository->updateFeedSelect($feedSetId, $feedId, $this->convertStringToBoolean($selected));
            return 'select Updated';
        } else {
            if ($mode == 'remove') {
                $feedSetId = $_POST['feedSet-uid'];
                $feedId = $_POST['feed-uid'];
                $feedSet = $this->feedSetRepository->findByUid($feedSetId);
                $feeds = $feedSet->getRawPicture();
                foreach ($feeds as $feed) {
                    if ($feed->getUid() == $feedId) {
                        $this->feedSetRepository->removeFeed($feedSetId, $feedId);
                        return 'removed';
                    }
                }
                return 'error';
            } else {
                if ($mode == 'change') {
                    $feedSetId = $_POST['feedSet-uid'];
                    $hashtags = $_POST['hashtags'];
                    if (empty($hashtags)) return 'feeds added';
                    $hashArray = explode('#', $hashtags);

                    //Insert your own access token, refer to https://www.instagram.com/developer/authentication/
                    $access_token = '';
                    $storagePageID = 49;
                    $feedSet = $this->feedSetRepository->findByUid($feedSetId);
                    //If hashtags changed, remove all records from mm table.
                    if ($hashtags!=$feedSet->getHashtags()) $this->feedSetRepository->removeAllFeed($feedSet->getUid());

                    $existHashArray=array();//explode ('#',$feedSet->getHashtags());
                    foreach ($hashArray as $eachHash) {

                        if ($eachHash!=""&&$eachHash!=" ") {
                            $url = 'https://api.instagram.com/v1/tags/' . $eachHash . '/media/recent?access_token=' . $access_token.'&count=150';
                            $logger->warning($url);
                            $this->getHttpSave($url,$existHashArray,$eachHash,$feedSet);

                        }
                    }
                    $feedSet->setHashtags(implode("#", $existHashArray));
                    $this->feedSetRepository->update($feedSet);
                    return 'feeds changed';
                }
            }
        }
        //Debug section
        /*
            $feedSetId=1;//$_POST['feedSet-uid'];
            //$hashtags=$_POST['hashtags'];
            $hashArray = ["zhangquandan"];//explode('#', $hashtags);
            $access_token='4036265431.061253b.13db852b5a6c4e83820dfaaf16edd776';
            $storagePageID=49;
        
            $feedSet=$this->feedSetRepository->findByUid($feedSetId);
        
            foreach ($hashArray as $eachHash) {
        
                $url = 'https://api.instagram.com/v1/tags/' . $eachHash . '/media/recent?access_token=' . $access_token;
                $json = file_get_contents($url);
                $data = json_decode($json, TRUE);
                foreach ($data['data'] as $var) {
                    $stdResImgUrl = $var['images']['standard_resolution']['url'];
                    $singleFeedInst = new \Cerebrum\Instafeed\Domain\Model\RawPicture();
                    $singleFeedInst->setUrl($stdResImgUrl);
                    $singleFeedInst->setHashtag($var['tags']);
                    $singleFeedInst->setSelected(FALSE);
                    $singleFeedInst->setId($var['id']);
                    $singleFeedInst->setPid((int)$storagePageID);
        
                    $exist=$this->rawPictureRepository->findById($singleFeedInst)->getFirst();
                    if (empty($exist)) {
                        $this->rawPictureRepository->add($singleFeedInst);
                        $this->feedSetRepository->addFeed($feedSet,$singleFeedInst);
                    }
                    else {
                        //return $this->feedSetRepository->findMMByUid($feedSet,$exist);
                        if (empty($this->feedSetRepository->findMMByUid($feedSet,$exist))) $this->feedSetRepository->addFeed($feedSet,$exist);
                    }
                }
        
            }
            return "feeds added";
        */
        
        //return ($this->feedSetRepository->updateFeedSelect(1,85,1));
        return 'error';
    }
    public function getHttpSave($url,&$existHashArray,$eachHash,$feedSet) {

        $json = file_get_contents($url);
        $data = json_decode($json, TRUE);
        //Deal with hashtags field
        $same=false;
        foreach($existHashArray as $existSingleHash) {
            if ($existSingleHash==$eachHash) $same=true;
        }
        if (!$same) $existHashArray[]=$eachHash;
        //if (empty($data['data'])) {return "empty result";}
        foreach ($data['data'] as $var) {
            $stdResImgUrl = $var['images']['standard_resolution']['url'];
            $origNotes=$var['caption']['text'];
            preg_match_all('/(?P<hashtags>\#\w+)/', $origNotes, $matches);

            $singleFeedInst = new \Cerebrum\Instafeed\Domain\Model\RawPicture();
            $singleFeedInst->setId($var['id']);
            $exist = $this->rawPictureRepository->findById($singleFeedInst)->getFirst();
            //Testing method.
            //$testFeedInst = new \Cerebrum\Instafeed\Domain\Model\RawPicture();
            //$testFeedInst->setId('1394752205466610478_4036265431');
            //$singleFeedInst=$this->rawPictureRepository->findById($testFeedInst)->getFirst();
            //return $singleFeedInst->getUrl();
            if (empty($exist)) {
                //return "empty exist";
                
                $singleFeedInst->setUrl($stdResImgUrl);
                $singleFeedInst->setHashtag($var['tags']);
                $singleFeedInst->setSelected(FALSE);
                $singleFeedInst->setNotes(str_replace($matches['hashtags'], '', $origNotes));
                $singleFeedInst->setPid((int) $storagePageID);

                $this->rawPictureRepository->add($singleFeedInst);
                $this->persistenceManager->persistAll();
                $this->feedSetRepository->addFeed($feedSet, $singleFeedInst);
            } else {
                $exist->setUrl($stdResImgUrl);
                $exist->setHashtag($var['tags']);
                $exist->setNotes(str_replace($matches['hashtags'], '', $origNotes));
                $this->rawPictureRepository->update($exist);
                $this->persistenceManager->persistAll();
                if (empty($this->feedSetRepository->findMMByUid($feedSet, $exist))) {
                    $this->feedSetRepository->addFeed($feedSet, $exist);
                }
            }
        }
        if ($data['pagination']['next_url']!=null) {
            $this->getHttpSave($data['pagination']['next_url'],$existHashArray,$eachHash,$feedSet);
        }
    }
    
    /**
     * action delete
     *
     * @param \Cerebrum\Instafeed\Domain\Model\FeedSet $feedSet
     * @return void
     */
    public function deleteAction()
    {
        $feedSetId = $_POST['feedSet-uid'];
        $this->feedSetRepository->removeAllFeed($feedSetId);
        $feedSet = $this->feedSetRepository->findByUid($feedSetId);
        $this->feedSetRepository->remove($feedSet);
        return 'feedSet removed';
    }

}