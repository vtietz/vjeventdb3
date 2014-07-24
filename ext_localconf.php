<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'VJmedia.' . $_EXTKEY,
	'Events',
	array(
		'Event' => 'list, teaser, show',
		
	),
	// non-cacheable actions
	array(
		'Event' => 'list',
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder