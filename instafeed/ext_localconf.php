<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Cerebrum.' . $_EXTKEY,
	'Frontfeeds',
	array(
		'RawPicture' => 'frontList,jsonList',
		'SelectedPicture' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'RawPicture' => 'frontList,jsonList',
		'SelectedPicture' => 'frontList',
		
	)
);
