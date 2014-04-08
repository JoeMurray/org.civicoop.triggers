<?php

/* 
 * This is the BAO file for the trigger action table
 */

class CRM_Triggers_BAO_TriggerRule extends CRM_Triggers_DAO_TriggerRule {
  
  /**
   * Returns the BAO/DAO for a given entity
   * 
   * @param String $entity
   * @return BAO/DAO
   */
  public static function getEntityDAO($entity) {
    $dao = CRM_Core_DAO_AllCoreTables::getFullName($entity);
    if ($dao == NULL) {
      throw new CRM_Triggers_Exception_DAO_Not_Found("Entity ".$entity." has no DAO");
    }
    return new $dao();
  }
    /**
     * Function to get conditions
     * 
     * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
     * @date 8 Apr 2014
     * @param array $params name/value pairs with field names/values
     * @return array $result found rows with data
     * @access public
     * @static
     */
    public static function getValues($params) {
        $result = array();
        $triggerRule = new CRM_Triggers_BAO_TriggerRule();
        if (!empty($params)) {
            $fields = self::fields();
            foreach ($params as $paramKey => $paramValue) {
                if (isset($fields[$paramKey])) {
                    $triggerRule->$paramKey = $paramValue;
                }
            }
        }
        $triggerRule->find();
        while ($triggerRule->fetch()) {
            self::storeValues($triggerRule, $row);
            $result[$row['id']] = $row;
        }
        return $result;
    }
  
}

