<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'VJmedia.' . $_EXTKEY,
	'Events',
	array(
		//'Event' => 'list, simplelist, teaser, gallery, show',
		//'Performer' => 'list',
		'Event' => 'list'
	),
	// non-cacheable actions
	array(
		'Event' => 'list',
	)
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'VJmedia.' . $_EXTKEY,
		'EventDetail',
		array(
			'EventDetail' => 'show',
		),
		// non-cacheable actions
		array()
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'VJmedia.' . $_EXTKEY,
		'EventGallery',
		array(
			'EventGallery' => 'list',
		),
		// non-cacheable actions
		array()
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'VJmedia.' . $_EXTKEY,
		'EventSimpleList',
		array(
			'EventSimpleList' => 'list',
		),
		// non-cacheable actions
		array()
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'VJmedia.' . $_EXTKEY,
		'EventTeaser',
		array(
			'EventTeaser' => 'list',
		),
		// non-cacheable actions
		array()
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'VJmedia.' . $_EXTKEY,
		'Performers',
		array(
			'Performer' => 'list',
		),
		// non-cacheable actions
		array()
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'VJmedia.' . $_EXTKEY,
		'PerformerDetail',
		array(
			'PerformerDetail' => 'show',
		),
		// non-cacheable actions
		array()
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'VJmedia.' . $_EXTKEY,
		'EventOrderForm',
		array(
				'EventOrderForm' => 'show,submit',
		),
		// non-cacheable actions
		array()
);