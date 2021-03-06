<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_vjeventdb3_domain_model_exceptionaldate'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_vjeventdb3_domain_model_exceptionaldate']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, start_date, start_time, title, text',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, start_date, start_time, title, text;;;richtext:rte_transform[mode=ts_links], '),
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
				'foreign_table' => 'tx_vjeventdb3_domain_model_exceptionaldate',
				'foreign_table_where' => 'AND tx_vjeventdb3_domain_model_exceptionaldate.pid=###CURRENT_PID### AND tx_vjeventdb3_domain_model_exceptionaldate.sys_language_uid IN (-1,0)',
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

		'start_date' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_exceptionaldate.start_date',
			'config' => array(
				'dbType' => 'date',
				'type' => 'input',
				'size' => 7,
				'eval' => 'date,required',
				'checkbox' => 0,
				'default' => '0000-00-00'
			),
		),
		'start_time' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_exceptionaldate.start_time',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'time',
				'checkbox' => 1,
				'default' => time()
			)
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_exceptionaldate.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'text' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_exceptionaldate.text',
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
		
		'event' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$TCA['tx_vjeventdb3_domain_model_exceptionaldate']['types']['1'] =  array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, start_date, start_time, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,title, text;;;richtext:rte_transform[mode=ts_links], ');

// $TCA['tx_vjeventdb3_domain_model_date']['ctrl']['hideTable'] = 1;
$TCA['tx_vjeventdb3_domain_model_exceptionaldate']['ctrl']['label'] = 'start_date';
$TCA['tx_vjeventdb3_domain_model_exceptionaldate']['ctrl']['label_alt'] = 'start_time,title';
$TCA['tx_vjeventdb3_domain_model_exceptionaldate']['ctrl']['label_alt_force'] = 1;
