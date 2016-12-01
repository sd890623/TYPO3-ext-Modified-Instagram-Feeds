<?php


/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Userfunc to render alternative label for media elements
 *
 */
class tx_pluginProcFunc
{

    
    /**
     * Modifies the selectbox of available actions
     *
     * @param array &$config
     * @return array config
     */
    public function fillFlexWithFeedSet(array &$config)
    {
        $optionList = array();
        // add first option
        $optionList[0] = array(0 => 'option1', 1 => 'value1');
        // add second option
        $optionList[1] = array(0 => 'option2', 1 => 'value2');
        $config['items'] = array_merge($config['items'],$optionList);
        return $config;
    }
}
