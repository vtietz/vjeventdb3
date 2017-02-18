<?php
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']=array (
  '_DEFAULT' =>
  array (
    'init' =>
    array (
      'enableCHashCache' => true,
      'appendMissingSlash' => 'ifNotFile,redirect',
      'adminJumpToBackend' => true,
      'enableUrlDecodeCache' => true,
      'enableUrlEncodeCache' => true,
      'emptyUrlReturnValue' => '/',
    ),
    'pagePath' =>
    array (
      'type' => 'user',
      'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
      'spaceCharacter' => '-',
      'languageGetVar' => 'L',
      'rootpage_id' => '73',
    ),
    'fileName' =>
    array (
      'defaultToHTMLsuffixOnPrev' => 0,
      'acceptHTMLsuffix' => 1,
      'index' =>
      array (
        'print' =>
        array (
          'keyValues' =>
          array (
            'type' => 98,
          ),
        ),
      ),
    ),
    'preVars' =>
    array (
      0 =>
      array (
        'GETvar' => 'L',
        'valueMap' =>
        array (
          1 => '1',
        ),
        'noMatch' => 'bypass',
      ),
    ),
    'postVarSets' => array(
      '_DEFAULT' => array(
        'events' => array(
          array(
            'GETvar' => 'tx_vjeventdb3_eventdetail[controller]',
          ),
          array(
            'GETvar' => 'tx_vjeventdb3_eventdetail[action]',
          ),
          array(
            'GETvar' => 'tx_vjeventdb3_eventdetail[event]',
            'lookUpTable' => array(
              'table' => 'tx_vjeventdb3_domain_model_event',
              'id_field' => 'uid',
              'alias_field' => 'title',
              'addWhereClause' => ' AND NOT deleted',
              'useUniqueCache' => 1,
              'useUniqueCache_conf' => array(
                'strtolower' => 1,
                'spaceCharacter' => '-',
              ),
            ),
          ),
          array(
            'GETvar' => 'tx_vjeventdb3_eventdetail[date]',
          ),
          array(
            'GETvar' => 'tx_vjeventdb3_eventdetail[time]',
          ),
        ),
      ),
    ),
  ),
);


$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['encodeSpURL_postProc'] = array('user_encodeSpURL_postProc');
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['decodeSpURL_preProc'] = array('user_decodeSpURL_preProc');

function user_encodeSpURL_postProc(&$params, &$ref) {
    $params['URL'] = str_replace('kurs/events/EventDetail/show/', 'kurs/', $params['URL']);
}

function user_decodeSpURL_preProc(&$params, &$ref) {
    $params['URL'] = str_replace('kurs/', 'kurs/events/EventDetail/show/', $params['URL']);
}




?>
