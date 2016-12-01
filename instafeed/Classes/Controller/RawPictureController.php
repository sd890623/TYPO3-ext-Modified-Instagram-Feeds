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
 * RawPictureController
 */
class RawPictureController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * rawPictureRepository
     *
     * @var \Cerebrum\Instafeed\Domain\Repository\RawPictureRepository
     * @inject
     */
    protected $rawPictureRepository = NULL;
    
    /**
     * @param $val
     */
    public function convertZeroToBoolean($val)
    {
        if ($val == "true") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * action frontList
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @return void
     */

    public function frontListAction() {
        $rawPictures = $this->rawPictureRepository->findSelected();
        $this->view->assign('rawPictures', $rawPictures);
        $this->view->assign('flag',"hello");
    }
    /**
     * action list
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @return void
     */
    public function listAction()
    {
        //$rawPictures = $this->rawPictureRepository->findAll();
        //$this->view->assign('rawPictures', $rawPictures);
        //$emptyArray = array('name' => 'sun');
        //$this->view->assign('formValues', $emptyArray);
    }
    
    /**
     * action jsonList
     *
     * @param null
     * @return array of objects in JSON
     */
    public function jsonListAction() {
        $rawPictures = $this->rawPictureRepository->findAll();
        $results=array();
        foreach($rawPictures as $rawPicture) {
            $arr=array();
            $arr['uid']=$rawPicture->getUid();
            $arr['url']=$rawPicture->getUrl();
            $arr['hashtag']=$rawPicture->getHashtag();
            $arr['notes']=$rawPicture->getNotes();
            $arr['selected']=$rawPicture->getSelected();
            $arr['id']=$rawPicture->getId();
            $results[]=$arr;
        }
        return json_encode($results);
    }
    /**
     * action show
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @return void
     */
    public function showAction(\Cerebrum\Instafeed\Domain\Model\RawPicture $rawPicture)
    {
        $this->view->assign('rawPicture', $rawPicture);
    }
    
    /**
     * action updateAll
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @return void
     */
    public function updateAllAction()
    {
        //print_r($_POST[tx_instafeed_web_instafeedinstafeedback][tx_instfeed]);
        //echo("\n");
        $hashtag = $_POST[tx_instafeed_web_instafeedinstafeedback][tx_instfeed][hashtag];
        $hashArray = explode('#', $hashtag);
        $access_token = $_POST[tx_instafeed_web_instafeedinstafeedback][tx_instfeed][access_token];
        if ($access_token==null || $access_token=="") {
            $access_token='4036265431.061253b.13db852b5a6c4e83820dfaaf16edd776';
        }
        $storagePageID=$_POST[tx_instafeed_web_instafeedinstafeedback][tx_instfeed][storage];
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
                //$this->rawPictureRepository->removeAll();
                //echo '<img src="' . $stdResImgUrl . '">';
                //print_r($results);
                if (empty($this->rawPictureRepository->findById($singleFeedInst))) {
                    $this->rawPictureRepository->add($singleFeedInst);
                }
            }
        }
        //print_r($data['data']);
        $this->redirect('list');
    }
    
    /**
     * action select
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @return string
     */
    public function updateAction()
    {

        $post = $_POST;
        $mode=$post["type"];
        if ($mode=="select") {
            $selected = $_POST["selected"];
            $itemID = $_POST["uid"];
            $singleFeedInst = $this->rawPictureRepository->findByUid($itemID);
            $singleFeedInst->setSelected($this->convertZeroToBoolean($selected));
            $this->rawPictureRepository->update($singleFeedInst);
            return 'select Updated';
        }
        else if ($mode=="remove") {
            $itemID = $_POST["uid"];
            $singleFeedInst = $this->rawPictureRepository->findByUid($itemID);
            $this->rawPictureRepository->remove($singleFeedInst);
            return 'removed';
        }
        return "error";


    }
    
    /**
     * action new
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @return void
     */
    public function newAction()
    {
        
    }
    
    /**
     * action create
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @return void
     */
    public function createAction(\Cerebrum\Instafeed\Domain\Model\RawPicture $newRawPicture)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->rawPictureRepository->add($newRawPicture);
        $this->redirect('list');
    }
    
    /**
     * action edit
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @ignorevalidation $rawPicture
     * @return void
     */
    public function editAction(\Cerebrum\Instafeed\Domain\Model\RawPicture $rawPicture)
    {
        $this->view->assign('rawPicture', $rawPicture);
    }
    
    /**
     * action delete
     *
     * @param Cerebrum\Instafeed\Domain\Model\RawPicture
     * @return void
     */
    public function deleteAction(\Cerebrum\Instafeed\Domain\Model\RawPicture $rawPicture)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->rawPictureRepository->remove($rawPicture);
        $this->redirect('list');
    }

}