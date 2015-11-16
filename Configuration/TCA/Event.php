<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_vjeventdb3_domain_model_event'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_vjeventdb3_domain_model_event']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, teasertext, description, images, teaser_images, submission_form_mode, location, dates, event_category, age_category, prices, performers',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, subtitle, teasertext, description;;;richtext:rte_transform[mode=ts_links], images, teaser_images, submission_form_mode, location, dates, event_category, age_category, prices, performers, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_vjeventdb3_domain_model_event',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_event.pid=###CURRENT_PID### AND tx_vjeventdb3_domain_model_event.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'subtitle' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.subtitle',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'teasertext' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.teasertext',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
		),
		'images' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.images',
			'config' => 
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'images',
				array('maxitems' => 10),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),

		),
		'teaser_images' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.teaser_images',
			'config' => 
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'teaserImages',
				array('maxitems' => 10),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),

		),
		'submission_form_mode' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.submission_form_mode',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'location' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.location',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_vjeventdb3_domain_model_location',
				'MM' => 'tx_vjeventdb3_event_location_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_vjeventdb3_domain_model_location',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'dates' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.dates',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_vjeventdb3_domain_model_date',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_date.pid=###CURRENT_PID###',
				'foreign_field' => 'event',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'useSortable' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'event_category' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.event_category',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_vjeventdb3_domain_model_eventcategory',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_eventcategory.pid=###CURRENT_PID###',					
				'MM' => 'tx_vjeventdb3_event_eventcategory_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_vjeventdb3_domain_model_eventcategory',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'age_category' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.age_category',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_vjeventdb3_domain_model_agecategory',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_agecategory.pid=###CURRENT_PID###',
				'MM' => 'tx_vjeventdb3_event_agecategory_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_vjeventdb3_domain_model_agecategory',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'prices' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.prices',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_vjeventdb3_domain_model_price',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_price.pid=###CURRENT_PID###',
				'MM' => 'tx_vjeventdb3_event_price_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_vjeventdb3_domain_model_price',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'performers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event.performers',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_vjeventdb3_domain_model_performer',
				'MM' => 'tx_vjeventdb3_event_performer_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_vjeventdb3_domain_model_performer',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		
	),
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$TCA['tx_vjeventdb3_domain_model_event']['types']['1'] = array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, subtitle, teasertext, description;;;richtext:rte_transform[mode=ts_links],  --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.images, teaser_images, images, --div--;Dates, location, prices, dates, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended, performers, event_category, age_category, submission_form_mode, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime');

$TCA['tx_vjeventdb3_domain_model_event']['columns']['images']['config']['size'] = 5;
$TCA['tx_vjeventdb3_domain_model_event']['columns']['teaser_images']['config']['size'] = 5;
$TCA['tx_vjeventdb3_domain_model_event']['columns']['event_category']['config']['size'] = 5;
$TCA['tx_vjeventdb3_domain_model_event']['columns']['age_category']['config']['size'] = 5;
$TCA['tx_vjeventdb3_domain_model_event']['columns']['performers']['config']['size'] = 5;
$TCA['tx_vjeventdb3_domain_model_event']['columns']['prices']['config']['size'] = 5;

$TCA['tx_vjeventdb3_domain_model_event']['columns']['location']['config']['type'] = 'select';
$TCA['tx_vjeventdb3_domain_model_event']['columns']['location']['config']['size'] = 1;
$TCA['tx_vjeventdb3_domain_model_event']['columns']['location']['config']['maxitems'] = 1;

$TCA['tx_vjeventdb3_domain_model_event']['columns']['dates']['config']['appearance']['collapseAll'] = 1;

$TCA['tx_vjeventdb3_domain_model_event']['columns']['event_category']['config']['wizards']['suggest'] = array('type' => 'suggest');
$TCA['tx_vjeventdb3_domain_model_event']['columns']['age_category']['config']['wizards']['suggest'] = array('type' => 'suggest');
$TCA['tx_vjeventdb3_domain_model_event']['columns']['performers']['config']['wizards']['suggest'] = array('type' => 'suggest');
$TCA['tx_vjeventdb3_domain_model_event']['columns']['prices']['config']['wizards']['suggest'] = array('type' => 'suggest');

$TCA['tx_vjeventdb3_domain_model_event']['columns']['teasertext']['config']['rows'] = 5;

$TCA['tx_vjeventdb3_domain_model_event']['columns']['submission_form_mode']['config']['items'] = array(
		array('LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_mdb.xlf:tx_vjeventdb3_events.submission_mode.I.0', '0'),
		array('LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_mdb.xlf:tx_vjeventdb3_events.submission_mode.I.1', '1'),
		array('LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_mdb.xlf:tx_vjeventdb3_events.submission_mode.I.2', '2'),
		array('LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_mdb.xlf:tx_vjeventdb3_events.submission_mode.I.3', '3'),
);
