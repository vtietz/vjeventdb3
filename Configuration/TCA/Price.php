<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_vjeventdb3_domain_model_price'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_vjeventdb3_domain_model_price']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, price, price_category, price_unit, price_amount',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, price, price_category, price_unit, price_amount, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
				'foreign_table' => 'tx_vjeventdb3_domain_model_price',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_price.pid=###CURRENT_PID### AND tx_vjeventdb3_domain_model_price.sys_language_uid IN (-1,0)',
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

		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_price.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'price' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_price.price',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'price_category' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_price.price_category',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_vjeventdb3_domain_model_pricecategory',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_pricecategory.pid=###CURRENT_PID###',					
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'price_unit' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_price.price_unit',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_vjeventdb3_domain_model_priceunit',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_priceunit.pid=###CURRENT_PID###',					
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'price_amount' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_price.price_amount',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_vjeventdb3_domain_model_priceamount',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_priceamount.pid=###CURRENT_PID###',					
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		
	),
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$GLOBALS['TCA']['tx_vjeventdb3_domain_model_price']['types']['1'] = array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, price_category, price_amount, price_unit, price, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime');

$TCA['tx_vjeventdb3_domain_model_price']['ctrl']['label'] = 'name';
$TCA['tx_vjeventdb3_domain_model_price']['ctrl']['label_alt'] = 'price';
$TCA['tx_vjeventdb3_domain_model_price']['ctrl']['label_alt_force'] = 1;

$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_category']['config']['type'] = 'select';
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_category']['config']['items'] = array(
		array('-', ''),
);
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_category']['config']['size'] = 1;
//$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_category']['config']['wizards']['suggest'] = array('type' => 'suggest');
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_category']['config']['wizards']['edit'] = array(
				'type' => 'popup',
				'title' => 'Edit',
				'script' => 'wizard_edit.php',
				'icon' => 'edit2.gif',
				'popup_onlyOpenIfSelected' => 1,
				'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
		);
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_category']['config']['wizards']['add'] = array(
				'type' => 'script',
				'title' => 'Create new',
				'icon' => 'add.gif',
				'params' => array(
						'table' => 'tx_vjeventdb3_domain_model_pricecategory',
						'pid' => '###CURRENT_PID###',
						'setValue' => 'prepend'
				),
				'script' => 'wizard_add.php',
		);


$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_unit']['config']['type'] = 'select';
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_unit']['config']['items'] = array(
		array('-', ''),
);
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_unit']['config']['wizards']['edit'] = array(
		'type' => 'popup',
		'title' => 'Edit',
		'script' => 'wizard_edit.php',
		'icon' => 'edit2.gif',
		'popup_onlyOpenIfSelected' => 1,
		'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
);
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_unit']['config']['wizards']['add'] = array(
		'type' => 'script',
		'title' => 'Create new',
		'icon' => 'add.gif',
		'params' => array(
				'table' => 'tx_vjeventdb3_domain_model_priceunit',
				'pid' => '###CURRENT_PID###',
				'setValue' => 'prepend'
		),
		'script' => 'wizard_add.php',
);


$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_amount']['config']['type'] = 'select';
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_amount']['config']['items'] = array(
		array('-', ''),
);
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_amount']['config']['wizards']['edit'] = array(
		'type' => 'popup',
		'title' => 'Edit',
		'script' => 'wizard_edit.php',
		'icon' => 'edit2.gif',
		'popup_onlyOpenIfSelected' => 1,
		'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
);
$TCA['tx_vjeventdb3_domain_model_price']['columns']['price_amount']['config']['wizards']['add'] = array(
		'type' => 'script',
		'title' => 'Create new',
		'icon' => 'add.gif',
		'params' => array(
				'table' => 'tx_vjeventdb3_domain_model_priceamount',
				'pid' => '###CURRENT_PID###',
				'setValue' => 'prepend'
		),
		'script' => 'wizard_add.php',
);