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

if (!defined('_MD_CONSENT_MODULE_DIRNAME')) {
	return false;
}

//*
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'objects.php');

/**
 * Database Table for Callbacks in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_callbacks` (
 *   `when` int(12) NOT NULL,
 *   `uri` varchar(250) NOT NULL DEFAULT '',
 *   `timeout` int(4) NOT NULL DEFAULT '0',
 *   `connection` int(4) NOT NULL DEFAULT '0',
 *   `data` longtext,
 *   `queries` longtext,
 *   `fails` int(3) NOT NULL DEFAULT '0',
 *   PRIMARY KEY (`when`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentCallbacks extends consentXoopsObject
{

	var $handler = 'consentCallbacksHandler';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('when', XOBJ_DTYPE_INT, null, false);
        self::initVar('uri', XOBJ_DTYPE_TXTBOX, null, false, 250);
        self::initVar('timeout', XOBJ_DTYPE_INT, null, false);
        self::initVar('connection', XOBJ_DTYPE_INT, null, false);
        self::initVar('data', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('queries', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('fails', XOBJ_DTYPE_INT, null, false);
        
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for Callbacks
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentCallbacksHandler extends consentXoopsObjectHandler
{
	

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_callbacks';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentCallbacks';
	
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
	var $envalued = 'value';
	
    function __construct(&$db) 
    {
    	if (!is_object($db))
    		$db = $GLOBAL["xoopsDB"];
        parent::__construct($db, $this->tbl, $this->child, $this->identity, $this->envalued);
    }
}
?>