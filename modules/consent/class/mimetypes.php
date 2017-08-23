<?php
/**
 * Legal Consent is a module for obtain legal guardianship consent
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   	The XOOPS Project http://fonts2web.org.uk
 * @license     	General Public License version 3 (http://labs.coop/briefs/legal/general-public-licence/13,3.html)
 * @author      	Simon Roberts (wishcraft) <wishcraft@users.sourceforge.net>
 * @subpackage  	consent
 * @description 	Legal Consent is a module for obtain legal guardianship consent
 * @version		    1.0.1
 * @link			http://internetfounder.wordpress.com
 */

if (!defined('_MI_CONSENT_MODULE_DIRNAME')) {
	return false;
}

//*
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'objects.php');

/**
 * Class for Mimetypes in consent legal agreements
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_mimetypes` (
 *   `id` mediumint(38) unsigned NOT NULL AUTO_INCREMENT,
 *   `mimetype` varchar(255) DEFAULT '.',
 *   `extensions` tinytext,
 *   `files-embedded` int(12) unsigned DEFAULT '0',
 *   `files-attachment` int(12)  unsigned DEFAULT '0',
 *   `files-sent` int(12)  unsigned DEFAULT '0',
 *   `bytes-embedded` mediumint(32)  unsigned DEFAULT '0',
 *   `bytes-attachment` mediumint(32)  unsigned DEFAULT '0',
 *   `bytes-sent` mediumint(32)  unsigned DEFAULT '0',
 *   `created` int(12) DEFAULT '0',
 *   `deleted` int(12) DEFAULT '0',
 *   `accessed` int(12) DEFAULT '0',
 *   PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentMimetypes extends consentXoopsObject
{

	var $handler = '';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('id', XOBJ_DTYPE_INT, null, false);
        self::initVar('mimetype', XOBJ_DTYPE_TXTBOX, null, false, 255);
        self::initVar('mode', XOBJ_DTYPE_TXTBOX, 'unknown', false, 26);
        self::initVar('extensions', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('files-embedded', XOBJ_DTYPE_INT, null, false);
        self::initVar('files-attachment', XOBJ_DTYPE_INT, null, false);
        self::initVar('files-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('bytes-embedded', XOBJ_DTYPE_INT, null, false);
        self::initVar('bytes-attachment', XOBJ_DTYPE_INT, null, false);
        self::initVar('bytes-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('created', XOBJ_DTYPE_INT, time(), false);
        self::initVar('deleted', XOBJ_DTYPE_INT, null, false);
        self::initVar('accessed', XOBJ_DTYPE_INT, null, false);
        
        $this->handler = __CLASS__ . 'Handler';
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for Mimetypes in consent email systems
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentMimetypesHandler extends consentXoopsObjectHandler
{
	

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_mimetypes';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentMimetypes';
	
	/**
	 * Child Object Identity Key
	 *
	 * @var string
	 */
	var $identity = 'id';
	
	/**
	 * Child Object Default Envaluing Costs
	 *
	 * @var string
	 */
	var $envalued = 'mimetype';
	
    function __construct(&$db) 
    {
    	if (!object($db))
    		$db = $GLOBAL["xoopsDB"];
        parent::__construct($db, self::$tbl, self::$child, self::$identity, self::$envalued);
        
        $criteria = new Criteria("1", "1");
        if ($this->getCount($criteria)==0)
        {
        	xoops_load('XoopsLists');
        	foreach(XoopsLists::getFileListAsArray($path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'data') as $file)
        	{
        		if (substr($file,0,strlen('mimetypes-'))=='mimetypes-' && substr($file, strlen($file)-3) == 'diz')
        		{
        			foreach(file($path . DIRECTORY_SEPARATOR . $file) as $line => $value)
        			{
        				$parts = explode('||', trim(str_replace(array("\n", "\r", "\t"), "", $value)));
        				if (isset($parts[0]) && isset($parts[1]) && !empty($parts[0]) && !empty($parts[1]))
        				{
	        				$mime = $this->create();
	        				$mime->setVar('extensions', array($parts[0]=>$parts[0]));
	        				$mime->setVar('mimetype', $parts[1]);
	        				$mime->setVar('mode', strtolower(str_replace(array('mimetypes-', '.diz'), '', $file)));
	        				$mime->setVar('created', time());
	        				$this->insert($mime, true);
	        				unset($mime);
        				}
        			}
        		}
        	}
        	
        }
    }
    
    /**
     * Get File Extension from Mimetype
     * 
     * @param string $mimetype
     * @return string
     */
    function getFileExtension($mimetype = '')
    {
    	$criteria = new Criteria('mimetype', $mimetype, 'LIKE');
    	$criteria->setLimit(1);
    	if ($this->getCount($criteria)>0)
    	{
    		$objects = $this->getObjects($criteria);
    		$extensions = $objects[0]->getVar('extensions');
    		unset($objects);
    	} else
    		$extensions = array('.' . _MI_CONSENT_MODULE_DIRNAME . '.dat' => '.' . _MI_CONSENT_MODULE_DIRNAME . '.dat');
    	shuffle($extensions);
    	shuffle($extensions);
    	shuffle($extensions);
    	shuffle($extensions);
    	shuffle($extensions);
    	return $extensions[0];
    }
    
    /**
     * Inserts an object in the mimetypes table with no duplications
     * 
     * {@inheritDoc}
     * @see XoopsPersistableObjectHandler::insert()
     */
    function insert($object, $force = true)
    {
    	if ($object->isNew())
    	{
    		$criteria = new Criteria('mimetype', $object->getVar('mimetype'), 'LIKE');
    		$criteria->setLimit(1);
    		if ($this->getCount($criteria)>0)
    		{
    			foreach($this->getObjects($criteria) as $obj)
    			{
    				foreach($object->getVar('extensions') as $key => $value)
    				{
    					if (!in_array($value, $obj->getVar('extensions')))
    					{
    						$obj->setVar('extensions', array_merge(array($value=>$value), $obj->getVar('extensions')));
    					}
    				}
    				return parent::insert($obj, true);
    			}
    		}
    		$object->setVar('created', time());
    	}
    	return parent::insert($object, true);
    }
}
?>