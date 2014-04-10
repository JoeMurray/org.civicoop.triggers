<?php

class CRM_Triggers_BAO_RuleScheduleTrigger extends CRM_Triggers_DAO_RuleScheduleTrigger {
  
  public static function findByRuleScheduleId($rule_schedule_id, $fetchFirst=FALSE) {
    $dao = new CRM_Triggers_BAO_RuleScheduleTrigger();
    $dao->rule_schedule_id = $rule_schedule_id;
    $dao->find($fetchFirst);
    return $dao;
  }
  
  public function getTriggerRule() {
    $trigger = CRM_Triggers_BAO_TriggerRule::getDaoByTriggerRuleId($this->trigger_rule_id);
    return $trigger;
  }
  
  /**
   * Returns a new QueryBuilder object for this trigger
   * 
   * @return CRM_Triggers_QueryBuilder
   */
  public function createQueryBuilder() {
    $trigger = $this->getTriggerRule();
    $dao = $trigger->getEntityDAO();
    $builder = new CRM_Triggers_QueryBuilder("`" . $dao->tableName() . "`");
    $builder->addSelect("`" . $dao->tableName() . "`.*");
    return $builder;
  }
  
  /**
   * Adds the trigger conditions to the query builder
   * 
   * @param CRM_Triggers_QueryBuilder $builder
   */
  public function addTriggerConditionsToQueryBuilder(CRM_Triggers_QueryBuilder $builder) {
    //build condition for this dao
    $trigger = $this->getTriggerRule();
    $dao = $trigger->getEntityDAO();
    $where = new CRM_Triggers_QueryBuilder_Subcondition();
    $having = new CRM_Triggers_QueryBuilder_Subcondition();
    if (strlen($this->logic_operator)) {
      $where->linkToPrevious = $this->logic_operator;
      $having->linkToPrevious = $this->logic_operator;
    }
    $conditions = CRM_Triggers_BAO_TriggerRuleCondition::findByTriggerRuleId($trigger->id);
    while($conditions->fetch()) {
      $conditions->parseCondition($where, $having, $builder, $trigger);
    }
    
    //add a join on civicrm_processed_trigger
    $alreadyProcessedCond = new CRM_Triggers_QueryBuilder_Condition("`".$dao->tableName() ."`.`id` NOT IN ("
        . "SELECT `entity_id` FROM `civicrm_processed_trigger` "
        . "WHERE `entity` = '".$dao->escape($trigger->entity)."' "
        . "AND `trigger_action_id` = '".$dao->escape($this->id)."')");
    
    $where->addCond($alreadyProcessedCond);
    
    //add the conditions to the query builder
    $qb->addWhere($where);
    $qb->addHaving($having);
  }
  
}

