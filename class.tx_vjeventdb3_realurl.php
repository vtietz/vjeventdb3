<?

class tx_vjeventdb3_realurl {

  /**
  * Generates additional RealURL configuration and merges it with provided configuration
  *
  * @param       array           $params Default configuration
  * @param       tx_realurl_autoconfgen          $pObj   Parent object
  * @return      array           Updated configuration
  */
  function addRealUrlConfig($params, &$pObj) {
    return array_merge_recursive($params['config'], array(
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
    );

  }
}

?>
