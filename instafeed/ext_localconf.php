<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Cerebrum.' . $_EXTKEY,
	'Frontfeeds',
	array(
		'RawPicture' => 'frontList,jsonList,update,create,delete,edit',
		'FeedSet' => 'list, show, new, create, edit, update, delete',
		
	),
	// non-cacheable actions
	array(
		'RawPicture' => 'frontList,jsonList',
		'FeedSet' => 'create, update, delete',
		
	)
);
