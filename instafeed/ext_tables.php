<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Cerebrum.' . $_EXTKEY,
	'Frontfeeds',
	'List of Instagram Feeds'
);

if (TYPO3_MODE === 'BE') {
    $TBE_STYLES['inDocStyles_TBEstyle'] .= '@import "/typo3conf/ext/instafeed/Resources/Public/style.css";';
	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Cerebrum.' . $_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'instafeedback',	// Submodule key
		'',						// Position
		array(
			'RawPicture' => 'list, show, new, create, edit, updateAll, delete, select, jsonList','SelectedPicture' => 'list, show',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_instafeedback.xlf',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'InstaPicturesFeed');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_instafeed_domain_model_rawpicture', 'EXT:instafeed/Resources/Private/Language/locallang_csh_tx_instafeed_domain_model_rawpicture.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_instafeed_domain_model_rawpicture');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_instafeed_domain_model_selectedpicture', 'EXT:instafeed/Resources/Private/Language/locallang_csh_tx_instafeed_domain_model_selectedpicture.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_instafeed_domain_model_selectedpicture');
