# Hooks

## civicrm_trigger_condition_parse

This hook is invoked on the moment the condition is parsed to a sql condition on a dao.

### Parameters

1. *CRM_Triggers_BAO_TriggerRuleCondition* $condition
2. *CRM_Core_DAO* $dao 

### Example

Below an example of usage of hook which will set the is_active condition on the dao when the field_name is contact_id. This example is probably useless :-)

    function hook_civicrm_trigger_condition_parse(CRM_Triggers_BAO_TriggerRuleCondition $condition, CRM_Core_DAO $dao) {
        if ($condition->field_name == 'contact_id') {
            $dao->addWhere("is_active = '1'"); //only active contacts
        }
    }

## civicrm_trigger_action_parse_params

This hook is invoked on the moment the parameters for the action execution are parsed.

The definition of this hook looks like
    
    function hook_civicrm_trigger_action_parse_params(&$return, $params, CRM_Core_DAO $objRef, CRM_Triggers_BAO_TriggerRule $trigger_rule, CRM_Triggers_BAO_ActionRule $action);

You can set parameters in the variable `$return`.

### Parameters

1. `$return` This is an array you can set which is used the execution of the action
2. `$params` this is an array with the source parameters
3. `CRM_Core_DAO $objref` this is the entity which is processed
4. `CRM_Triggers_BAO_TriggerRule $trigger_rule` this is actual trigger
5. `CRM_Triggers_BAO_ActionRule $action` this is the actual action

### Example

    function hook_civicrm_trigger_action_parse_params(&$return, $params, CRM_Core_DAO $objRef, CRM_Triggers_BAO_TriggerRule $trigger_rule, CRM_Triggers_BAO_ActionRule $action) {
        if ($action->name == 'GroupMovement' and $action->entity == 'GroupContact') {
            $return['group_id'] = 21;//use group 21 for the action
        }
    }