<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_vjeventdb3_domain_model_eventorder'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_vjeventdb3_domain_model_eventorder']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, surname, address, telephone, email, message, event, age_category, date',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, surname, address, telephone, email, message, event, age_category, date, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
				'foreign_table' => 'tx_vjeventdb3_domain_model_eventorder',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_eventorder.pid=###CURRENT_PID### AND tx_vjeventdb3_domain_model_eventorder.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'surname' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.surname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'address' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'telephone' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.telephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'message' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.message',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'event' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.event',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_vjeventdb3_domain_model_event',
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
		'age_category' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.age_category',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_vjeventdb3_domain_model_agecategory',
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
		'date' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder.date',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_vjeventdb3_domain_model_date',
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

$GLOBALS['TCA']['tx_vjeventdb3_domain_model_eventorder']['columns']['event']['config']['type'] = 'select';