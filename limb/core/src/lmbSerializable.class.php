<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

/**
 * class lmbSerializable.
 *
 * @package core
 * @version $Id$
 */
class lmbSerializable
{
  protected $subject;
  protected $serialized;
  protected $class_paths = array();

  function __construct($subject)
  {
    $this->subject = $subject;
  }

  function getSubject()
  {
    if($this->serialized)
    {
      $this->_includeFiles();
      $this->subject = unserialize($this->serialized);
      $this->serialized = null;
    }
    return $this->subject;
  }

  function getClassPaths()
  {
    return $this->class_paths;
  }

  function __sleep()
  {
    // here we're assuming that if object was lazy loaded with getSubject
    // then serialized property is null and we need to serialize subject,
    // otherwise there's no need to serialize it again, this way we don't need
    // to implement __wakeup method
    if(is_null($this->serialized))
    {
      $this->serialized = serialize($this->subject);
      $this->_fillClassPathInfo($this->serialized);
    }
    return array('serialized', 'class_paths');
  }

  function _includeFiles()
  {
    if(function_exists('lmb_require'))
    {
      foreach($this->class_paths as $path)
        lmb_require($path);
    }
    else
    {
      foreach($this->class_paths as $path)
        require_once($path);
    }
  }

  function _fillClassPathInfo($serialized)
  {
    $classes = self :: extractSerializedClasses($serialized);
    $this->class_paths = array();

    foreach($classes as $class)
    {
      $reflect = new ReflectionClass($class);
      if($reflect->isInternal())
        throw new lmbException("Class '$class' can't be serialized since it's an iternal PHP class, consider omitting object of this class by providing custom __sleep, __wakeup handlers");
      $this->class_paths[] = $reflect->getFileName();
    }
  }

  static function extractSerializedClasses($str)
  {
    $extract_class_names_regexp = '~([\||;]O|^O):\d+:"([^"]+)":\d+:\{~';
    if(preg_match_all($extract_class_names_regexp, $str, $m))
      return array_unique($m[2]);
    else
      return array();
  }
  
  static function serialize($raw_data)
  {
    $container = new lmbSerializable($raw_data);
    return serialize($container);
  }
  
  static function unserialize($serialized_data)
  {
    $container = unserialize($serialized_data);
    return $container->getSubject();
  }
}


