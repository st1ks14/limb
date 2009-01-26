<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
lmb_require('limb/web_app/src/command/lmbActionCommand.class.php');

/**
 * class lmbCmsUnpublishObjectCommand.
 *
 * @package cms
 * @version $Id: lmbCmsUnpublishObjectCommand.class.php 7486 2009-01-26 19:13:20Z pachanga $
 */
class lmbCmsUnpublishObjectCommand extends lmbActionCommand
{
  protected $class_name;

  function __construct($class_name)
  {
    $this->class_name = $class_name;
    parent :: __construct();
  }

  function perform()
  {
    $ids = $this->request->get('ids');

    if(!is_array($ids) || !count($ids))
      $this->closePopup();

    foreach($ids as $id)
    {
      $item = new $this->class_name((int)$id);
      $item->setIsPublished(false);
      $item->save();
    }

    $this->closePopup();
  }
}


