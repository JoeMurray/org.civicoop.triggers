<?php
$CRM_Core_EntityReference_exists = false;
try { $CRM_Core_EntityReference_exists = class_exists('CRM_Core_EntityReference'); } catch (Exception $e) { ; }

if (!$CRM_Core_EntityReference_exists) {
/**
 * Description of a one-way link between two entities
 *
 * This could be a foreign key or a generic (entity_id, entity_table) pointer
 */
class CRM_Core_EntityReference {
  protected $refTable;
  protected $refKey;
  protected $refTypeColumn;
  protected $targetTable;
  protected $targetKey;

  function __construct($refTable, $refKey, $targetTable = NULL, $targetKey = 'id', $refTypeColumn = NULL) {
    $this->refTable = $refTable;
    $this->refKey = $refKey;
    $this->targetTable = $targetTable;
    $this->targetKey = $targetKey;
    $this->refTypeColumn = $refTypeColumn;
  }

  function getReferenceTable() {
    return $this->refTable;
  }

  function getReferenceKey() {
    return $this->refKey;
  }

  function getTypeColumn() {
    return $this->refTypeColumn;
  }

  function getTargetTable() {
    return $this->targetTable;
  }

  function getTargetKey() {
    return $this->targetKey;
  }

  /**
   * @return true if the reference can point to more than one type
   */
  function isGeneric() {
    return ($this->refTypeColumn !== NULL);
  }
}

}