<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

require_once('limb/wact/src/compiler/tag_node/WactRuntimeComponentTag.class.php');

/**
 * class WactRuntimeDatasourceComponentTag.
 *
 * @package wact
 * @version $Id: WactRuntimeDatasourceComponentTag.class.php 7486 2009-01-26 19:13:20Z pachanga $
 */
class WactRuntimeDatasourceComponentTag extends WactRuntimeComponentTag
{
  protected $runtimeComponentName = 'WactDatasourceRuntimeComponent';

  function generateBeforeContent($code_writer)
  {
    if($this->hasAttribute('from'))
    {
      $code_writer->writePHP($this->getComponentRefCode() . '->registerDataSource(');
      $this->attributeNodes['from']->generateExpression($code_writer);
      $code_writer->writePHP(');');
    }

    $id = $this->getServerId();
    $code_writer->writePHP('$' . $id . ' = ' . $this->getComponentRefCode() . "->getDataSource();\n");
  }

  function getDataSource()
  {
    return $this;
  }

  function isDataSource()
  {
    return TRUE;
  }
}

