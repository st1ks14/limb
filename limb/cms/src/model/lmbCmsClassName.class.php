<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
lmb_require('limb/active_record/src/lmbActiveRecord.class.php');
lmb_require('limb/dbal/src/criteria/lmbSQLFieldCriteria.class.php');

/**
 * class lmbCmsClassName.
 *
 * @package cms
 * @version $Id: lmbCmsClassName.class.php 6010 2007-06-21 09:46:14Z pachanga $
 */
class lmbCmsClassName extends lmbActiveRecord
{
  protected $_db_table_name = 'class_name';

  static function generateIdFor($object, $conn = null)
  {
    if(is_object($object))
      $title = get_class($object);
    else
      $title = $object;

    $criteria = new lmbSQLFieldCriteria('title', $title);
    if($obj = lmbActiveRecord :: findFirst('lmbCmsClassName', array('criteria' => $criteria), $conn))
    {
      return $obj->id;
    }
    else
    {
      $class_name = new lmbCmsClassName();
      $class_name->title = $title;
      $class_name->save();
      return $class_name->id;
    }

  }
}

?>
