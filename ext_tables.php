<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Events',
	'Events'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Event Database');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_event', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_event.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_event');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_event'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_event',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,subtitle,teasertext,description,images,teaser_images,submission_form_mode,location,dates,event_category,age_category,prices,performers,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Event.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_event.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_location', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_location.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_location');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_location'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_location',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,description,images,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Location.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_location.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_date', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_date.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_date');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_date'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_date',
		'label' => 'start_date',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',

		),
		'searchFields' => 'start_date,start_time,end_date,end_time,frequency,title,text,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Date.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_date.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_eventcategory', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_eventcategory.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_eventcategory');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_eventcategory'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventcategory',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/EventCategory.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_eventcategory.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_agecategory', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_agecategory.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_agecategory');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_agecategory'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_agecategory',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/AgeCategory.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_agecategory.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_price', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_price.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_price');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_price'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_price',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,price,price_category,price_unit,price_amount,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Price.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_price.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_pricecategory', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_pricecategory.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_pricecategory');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_pricecategory'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_pricecategory',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/PriceCategory.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_pricecategory.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_priceunit', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_priceunit.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_priceunit');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_priceunit'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_priceunit',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(

		),
		'searchFields' => 'name,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/PriceUnit.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_priceunit.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_priceamount', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_priceamount.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_priceamount');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_priceamount'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_priceamount',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',

		),
		'searchFields' => 'name,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/PriceAmount.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_priceamount.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_performer', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_performer.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_performer');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_performer'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_performer',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,description,images,performer_category,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Performer.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_performer.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_performercategory', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_performercategory.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_performercategory');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_performercategory'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_performercategory',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',

		),
		'searchFields' => 'name,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/PerformerCategory.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_performercategory.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vjeventdb3_domain_model_eventorder', 'EXT:vjeventdb3/Resources/Private/Language/locallang_csh_tx_vjeventdb3_domain_model_eventorder.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vjeventdb3_domain_model_eventorder');
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_eventorder'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang_db.xlf:tx_vjeventdb3_domain_model_eventorder',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,surname,address,telephone,email,message,appointment,mailtosender,mailtorecipient,event,age_category,date,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/EventOrder.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vjeventdb3_domain_model_eventorder.gif'
	),
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginName = strtolower('Events');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForm/flexform.xml');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'EventDetail',
		'EventDetail'
);


$pluginName = strtolower('EventDetail');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForm/flexform_eventDetail.xml');

// Gallery Plugin

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'EventGallery',
		'EventGallery'
);


$pluginName = strtolower('EventGallery');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForm/flexform.xml');

// Simple List Plugin

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'EventSimpleList',
		'EventSimpleList'
);


$pluginName = strtolower('EventSimpleList');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForm/flexform.xml');

// Teaser Plugin

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'EventTeaser',
		'EventTeaser'
);


$pluginName = strtolower('EventTeaser');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForm/flexform.xml');


// Performers Plugin

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'Performers',
		'Performers'
);

$pluginName = strtolower('Performers');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForm/flexform_performer.xml');

// Performer Detail Plugin

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'PerformerDetail',
		'PerformerDetail'
);

$pluginName = strtolower('PerformerDetail');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForm/flexform_performer.xml');

// Performer Detail Plugin

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'PerformerDetail',
		'PerformerDetail'
);

// EventOrderForm

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'EventOrderForm',
		'EventOrderForm'
);

$pluginName = strtolower('EventOrderForm');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForm/flexform_eventOrder.xml');

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_eventorder']['ctrl']['label'] = 'surname';
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_eventorder']['ctrl']['label_alt'] = 'surname, name';
$GLOBALS['TCA']['tx_vjeventdb3_domain_model_eventorder']['ctrl']['label_alt_force'] = 1;