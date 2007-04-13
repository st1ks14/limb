<?php
/**
 * Limb Web Application Framework
 *
 * @link http://limb-project.com
 *
 * @copyright  Copyright &copy; 2004-2007 BIT
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 * @version    $Id: toolkit.inc.php 5651 2007-04-13 10:28:24Z pachanga $
 * @package    config
 */
lmb_require('limb/toolkit/src/lmbToolkit.class.php');
lmb_require('limb/fs/toolkit.inc.php');
lmb_require('limb/config/src/lmbConfTools.class.php');
lmbToolkit :: merge(new lmbConfTools());

?>