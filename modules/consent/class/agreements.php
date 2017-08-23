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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'xcp' . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'xcp.class.php');

/**
 * Database Table for Agreements in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_agreements` (
 *   `id` int(32) NOT NULL AUTO_INCREMENT,
 *   `mailbox-id` int(14) NOT NULL DEFAULT '0',
 *   `uid` int(13) NOT NULL DEFAULT '0',
 *   `approval` enum('Waiting','Approved','Unapproved') NOT NULL DEFAULT 'Waiting',
 *   `batch-id` int(20) NOT NULL DEFAULT '0',
 *   `guardian-id` int(20) NOT NULL DEFAULT '0',
 *   `clientel-id` int(20) NOT NULL DEFAULT '0',
 *   `hashkey` varchar(12) NOT NULL DEFAULT '',
 *   `referee` varchar(18) NOT NULL DEFAULT '',
 *   `callback-url` varchar(255) NOT NULL DEFAULT '',
 *   `svn-paths` longtext,
 *   `guardian-filename-pdf` varchar(128) NOT NULL DEFAULT '',
 *   `clientel-filename-pdf` varchar(128) NOT NULL DEFAULT '',
 *   `guardian-response-file` varchar(128) NOT NULL DEFAULT '',
 *   `clientel-response-file` varchar(128) NOT NULL DEFAULT '',
 *   `response-waiting` enum('Guardian','Clientel','Both','None') NOT NULL DEFAULT 'Both',
 *   `response-sourced` enum('Guardian','Clientel','Both') NOT NULL DEFAULT 'Both',
 *   `response-comment` longtext,
 *   `response-network` longtext,
 *   `response-notified` int(11) NOT NULL DEFAULT '0',
 *   `response-weight` int(11) NOT NULL DEFAULT '0',
 *   `response-guardian-weight` int(11) NOT NULL DEFAULT '0',
 *   `response-clientel-weight` int(11) NOT NULL DEFAULT '0',
 *   `email-ids` longtext,
 *   `email-agreement-type` enum('None','Guardian','Clientel','Both') NOT NULL DEFAULT 'Both',
 *   `email-recovery-type` enum('None','Guardian','Clientel','Batch') NOT NULL DEFAULT 'None',
 *   `email-recovery-guardian-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-recovery-clientel-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-from` varchar(64) NOT NULL DEFAULT '',
 *   `email-email-from` varchar(196) NOT NULL DEFAULT '',
 *   `email-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-views` int(11) NOT NULL DEFAULT '0',
 *   `email-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-guardian-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-guardian-views` int(11) NOT NULL DEFAULT '0',
 *   `email-guardian-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-clientel-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-clientel-views` int(11) NOT NULL DEFAULT '0',
 *   `email-clientel-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-remiders-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-remiders-views` int(11) NOT NULL DEFAULT '0',
 *   `email-remiders-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-progress-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-progress-views` int(11) NOT NULL DEFAULT '0',
 *   `email-progress-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-recovery-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-recovery-views` int(11) NOT NULL DEFAULT '0',
 *   `email-recovery-viewed` int(11) NOT NULL DEFAULT '0',
 *   `created` int(11) NOT NULL DEFAULT '0',
 *   `emailed` int(11) NOT NULL DEFAULT '0',
 *   `response` int(11) NOT NULL DEFAULT '0',
 *   `recovery` int(11) NOT NULL DEFAULT '0',
 *   `reminded` int(11) NOT NULL DEFAULT '0',
 *   `timeout` int(11) NOT NULL DEFAULT '0',
 *   PRIMARY KEY (`id`),
 *   KEY `SEARCH` (`approval`,`batch-id`,`guardian-id`,`clientel-id`,`hashkey`,`email-agreement-type`,`created`,`emailed`,`response`,`reminde`,`timeout`) USING BTREE KEY_BLOCK_SIZE=32
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentAgreements extends consentXoopsObject
{

	var $handler = 'consentAgreementsHandler';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('id', XOBJ_DTYPE_INT, null, false);
        self::initVar('mailbox-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('uid', XOBJ_DTYPE_INT, null, false);
        self::initVar('approval', XOBJ_DTYPE_ENUM, 'Waiting', false, false, false, consentEnumeratorValues(basename(__FILE__), 'approval'));
        self::initVar('batch-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('guardian-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('hashkey', XOBJ_DTYPE_TXTBOX, null, false, 12);
        self::initVar('referee', XOBJ_DTYPE_TXTBOX, null, false, 18);
        self::initVar('callback-url', XOBJ_DTYPE_TXTBOX, null, false, 255);
        self::initVar('svn-paths', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('guardian-filename-pdf', XOBJ_DTYPE_TXTBOX, null, false, 128);
        self::initVar('clientel-filename-pdf', XOBJ_DTYPE_TXTBOX, null, false, 128);
        self::initVar('guardian-response-file', XOBJ_DTYPE_TXTBOX, null, false, 128);
        self::initVar('clientel-response-file', XOBJ_DTYPE_TXTBOX, null, false, 128);
        self::initVar('response-waiting', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'response-waiting'));
        self::initVar('response-sourced', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'response-sourced'));
        self::initVar('response-comment', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('response-network', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('response-notified', XOBJ_DTYPE_INT, null, false);
        self::initVar('response-weight', XOBJ_DTYPE_INT, null, false);
        self::initVar('response-guardian-weight', XOBJ_DTYPE_INT, null, false);
        self::initVar('response-clientel-weight', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-ids', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('email-agreement-type', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'email-agreement-type'));
        self::initVar('email-recovery-type', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'email-recovery-type'));
        self::initVar('email-recovery-guardian-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-recovery-clientel-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-from', XOBJ_DTYPE_TXTBOX, null, false, 64);
        self::initVar('email-email-from', XOBJ_DTYPE_INT, null, false, 196);
        self::initVar('email-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-guardian-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-guardian-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-guardian-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-clientel-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-clientel-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-clientel-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-remiders-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-remiders-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-remiders-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-progress-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-progress-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-progress-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-recovery-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-recovery-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-recovery-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('created', XOBJ_DTYPE_INT, null, false);
        self::initVar('emailed', XOBJ_DTYPE_INT, null, false);
        self::initVar('reponse', XOBJ_DTYPE_INT, null, false);
        self::initVar('recovery', XOBJ_DTYPE_INT, null, false);
        self::initVar('reminded', XOBJ_DTYPE_INT, null, false);
        self::initVar('timeout', XOBJ_DTYPE_INT, null, false);
        
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for Agreements
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentAgreementsHandler extends consentXoopsObjectHandler
{
    
    /**
     *
     * @var integer
     */
    var $created = 0;
    
    /**
     *
     * @var integer
     */
    var $existing = 0;
    

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_agreements';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentAgreements';
	
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
    
    /**
     * Checks the form from a submission of the subscription form after being submited
     * 
     * @param array $result
     * @param string $errors_array
     */
    static public function checkSubscriptionForm($result = array(), $errors_array = false)
    {
        static $errors = array();
        if (empty($errors))
        {
            if (empty($result['guardian-name']) || strlen(trim($result['guardian-name'])) == 0)
                $errors['guardian-name'] = _ERR_CONSENT_FORM_GUARDIAN_NAME_MISSING;
            if (empty($result['guardian-phone']) || strlen(trim($result['guardian-phone'])) == 0)
                $errors['guardian-phone'] = _ERR_CONSENT_FORM_GUARDIAN_PHONE_MISSING;
            if (empty($result['guardian-email']) || strlen(trim($result['guardian-email'])) == 0)
                $errors['guardian-email'] = _ERR_CONSENT_FORM_GUARDIAN_EMAIL_MISSING;
            if (!empty($result['guardian-phone']) && strlen(consentToNumeric($result['guardian-phone'])) < 10)
                $errors['guardian-phone'] = _ERR_CONSENT_FORM_GUARDIAN_PHONE_WRONGLENGTH;
            if (!empty($result['guardian-name']) && count(explode(' ', $result['guardian-name'])) < 2)
                $errors['guardian-name'] = _ERR_CONSENT_FORM_GUARDIAN_NAME_MALFORMED;
            if (!empty($result['guardian-email']) && !checkEmail($result['guardian-email']))
                $errors['guardian-email'] = _ERR_CONSENT_FORM_GUARDIAN_EMAIL_MALFORMED;
            if (empty($result['clientel-name']) || strlen(trim($result['clientel-name'])) == 0)
                $errors['clientel-name'] = _ERR_CONSENT_FORM_CLIENTEL_NAME_MISSING;
            if (empty($result['clientel-phone']) || strlen(trim($result['clientel-phone'])) == 0)
                $errors['clientel-phone'] = _ERR_CONSENT_FORM_CLIENTEL_PHONE_MISSING;
            if (empty($result['clientel-email']) || strlen(trim($result['clientel-email'])) == 0)
                $errors['clientel-email'] = _ERR_CONSENT_FORM_CLIENTEL_EMAIL_MISSING;
            if (!empty($result['clientel-name']) && count(explode(' ', $result['clientel-name'])) < 2)
                $errors['clientel-name'] = _ERR_CONSENT_FORM_CLIENTEL_NAME_MALFORMED;
            if (!empty($result['clientel-phone']) && strlen(consentToNumeric($result['clientel-phone'])) < 10)
                $errors['clientel-phone'] = _ERR_CONSENT_FORM_CLIENTEL_PHONE_WRONGLENGTH;
            if (!empty($result['clientel-email']) && !checkEmail($result['clientel-email']))
                $errors['clientel-email'] = _ERR_CONSENT_FORM_CLIENTEL_EMAIL_MALFORMED;
                
            $agreementsHandler = $this;
            $guardiansHandler = xoops_getModuleHandler('guardians', _MD_CONSENT_MODULE_DIRNAME);
            $clientelsHandler = xoops_getModuleHandler('clientels', _MD_CONSENT_MODULE_DIRNAME);
            $guardianscriteria = new Criteria('email', $result['guardian-email']);
            $clientelscriteria = new Criteria('email', $result['clientel-email']);
            $guardianids = $guardiansHandler->getIds($guardianscriteria);
            $clientelids = $clientelsHandler->getIds($clientelscriteria);
            if (count($guardianids) > 0 && count($clientelids) > 0)
            {
                $criteria = new CriteriaCompo(new Criteria('guardian-id', "(" . implode(", ", $guardianids) . ')', "IN"));
                $criteria->add(new Criteria('clientel-id', "(" . implode(", ", $clientelids) . ')', 'IN'));
                $criteria->add(new Criteria('approval', 'Waiting'));
                $criteria->add(new Criteria('response-waiting', "('Guardian','Clientel','Both')", "IN"));
                $criteria->add(new Criteria('timeout', time(), ">="));
                if ($agreementsHandler->getCount($criteria) > 0)
                    $errors['agreements'] = _ERR_CONSENT_FORM_AGREEMENT_EXISTINGINQUEUE;
            }
        }
        if ($errors_array == false && empty($errors))
            return true;
        elseif ($errors_array == false && !empty($errors))
            return false;
        else 
            return $errors;
    }
    
    
    /**
     * Get's the error array for a form checked on submission of the subscription form
     * 
     * @param array $result
     */
    static public function errorsSubscriptionForm($result = array())
    {
        return self::checkSubscriptionForm($result, true);
    }
    
    
    /**
     * Get the subscription to consent form for submission
     * 
     * @param array $result
     */
    static public function getSubscriptionForm($result = array())
    {
        if (!isset($result['guardian-name']) || empty($result['guardian-name']) && (!empty($_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['name']) || !empty($_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-name'])))
        {
            if (!empty($_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['name']))
                $result['guardian-name'] = $_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['name'];
            elseif (!empty($_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-name']))
                $result['guardian-name'] = $_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-name'];
        }
        if (!isset($result['guardian-phone']) || empty($result['guardian-phone']) && (!empty($_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['phone']) || !empty($_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-phone'])))
        {
            if (!empty($_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['phone']))
                $result['guardian-phone'] = $_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['phone'];
            elseif (!empty($_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-phone']))
                $result['guardian-phone'] = $_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-phone'];
        }
        if (!isset($result['guardian-email']) || empty($result['guardian-email']) && (!empty($_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['email']) || !empty($_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-email'])))
        {
            if (!empty($_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['email']))
                $result['guardian-email'] = $_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['email'];
            elseif (!empty($_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-email']))
                $result['guardian-email'] = $_COOKIE[_MD_CONSENT_MODULE_DIRNAME . '-guardian-email'];
        }
        
        if (!empty($result['timeout']) && is_string($result['timeout']) && !is_numeric($result['timeout']))
            $result['timeout'] = strtotime($result['timeout'], time());
        
        xoops_load('XoopsThemeForm');
        
        $form = new XoopsThemeForm(_MN_CONSENT_FORM_SUBCRIPTION, _MD_CONSENT_MODULE_DIRNAME . '-subsription', $_SERVER['REQUEST_URI'], 'post');
        $form->setExtra('enctype="multipart/form-data"');                
        $formobj = array();
        $eletray = array();
        $sformobj = array();
        
        $formobj['guardian-name'] = new XoopsFormText(_MN_CONSENT_FORM_GUARDIAN_NAME, 'guardian-name', 35, 64, $result['guardian-name']);
        $formobj['guardian-name']->setDescription(_MN_CONSENT_FORM_GUARDIAN_NAME_DESC);
        $formobj['guardian-email'] = new XoopsFormText(_MN_CONSENT_FORM_GUARDIAN_EMAIL, 'guardian-email', 35, 196, $result['guardian-email']);
        $formobj['guardian-email']->setDescription(_MN_CONSENT_FORM_GUARDIAN_EMAIL_DESC);
        $formobj['guardian-phone'] = new XoopsFormText(_MN_CONSENT_FORM_GUARDIAN_PHONE, 'guardian-phone', 15, 20, $result['guardian-phone']);
        $formobj['guardian-phone']->setDescription(_MN_CONSENT_FORM_GUARDIAN_PHONE_DESC);
        $formobj['clientel-name'] = new XoopsFormText(_MN_CONSENT_FORM_CLIENTEL_NAME, 'clientel-name', 35, 64, $result['clientel-name']);
        $formobj['clientel-name']->setDescription(_MN_CONSENT_FORM_CLIENTEL_NAME_DESC);
        $formobj['clientel-email'] = new XoopsFormText(_MN_CONSENT_FORM_CLIENTEL_EMAIL, 'clientel-email', 35, 196, $result['clientel-email']);
        $formobj['clientel-email']->setDescription(_MN_CONSENT_FORM_CLIENTEL_EMAIL_DESC);
        $formobj['clientel-phone'] = new XoopsFormText(_MN_CONSENT_FORM_CLIENTEL_PHONE, 'clientel-phone', 15, 20, $result['clientel-phone']);
        $formobj['clientel-phone']->setDescription(_MN_CONSENT_FORM_CLIENTEL_PHONE_DESC);
        $formobj['timeout'] = new XoopsFormTextDateSelect(_MN_CONSENT_FORM_TIMEOUT, 'timeout', 15, (empty($result['timeout'])? time() + (60*60*24*14): $result['timeout']));
        $formobj['timeout']->setDescription(_MN_CONSENT_FORM_TIMEOUT_DESC);
        $formobj['callback-url'] = new XoopsFormText(_MN_CONSENT_FORM_CALLBACK_URL, 'callback-url', 35, 196, $result['callback-url']);
        $formobj['callback-url']->setDescription(sprintf(_MN_CONSENT_FORM_CALLBACK_URL_DESC, XOOPS_URL . '/modules/' . _MD_CONSENT_MODULE_DIRNAME . '/callback-example.php'));
        $eletray['buttons'] = new XoopsFormElementTray('', '&nbsp;');
        $sformobj['buttons']['save'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
        $eletray['buttons']->addElement($sformobj['buttons']['save']);
        $formobj['buttons'] = $eletray['buttons'];
                
        $required = array('timeout', 'guardian-name', 'guardian-email', 'guardian-phone', 'clientel-name', 'clientel-email', 'clientel-phone');
        foreach($formobj as $id => $obj)
            if (in_array($id, $required))
                $sform->addElement($formobj[$id], true);
            else
                $sform->addElement($formobj[$id], false);
                            
        $form->addElement(new XoopsFormHidden('op', 'make-agreement'));
        return $form->render();
    }
    
    
    /**
     * Inserts a New Agreement
     *
     * @param consentAgreements $object
     * @param string $force
     * @return unknown
     */
    public static function insert(consentAgreements $object, $force = true)
    {
        if ($object->isNew())
        {
            $criteria = new CriteriaCompo(new Criteria('guardian-id', $object->getVar('guardian-id')));
            $criteria->add(new Criteria('clientel-id', $object->getVar('clientel-id')));
            $criteria->add(new Criteria('approval', 'Waiting'));
            $criteria->add(new Criteria('response-waiting', "('Guardian','Clientel','Both')", "IN"));
            $criteria->add(new Criteria('timeout', time(), ">="));
            if ($this->getCount($criteria)>0)
            {
                $objs = $this->getObjects($criteria);
                if (is_object($objs[0]) && isset($objs[0]))
                {
                    $this->existing++;
                    return $objs[0]->getVar($this->identity);
                }
            }
            $this->created++;
            $object->setVar('created', time());
            $object->setVar('approval', 'Waiting');
            $crc = new xcp($data = $this->created.$object->getVar('uid').$object->getVar('created').$object->getVar('guardian-id').$object->getVar('clientel-id').$object->getVar('batch-id'), mt_rand(0,255), mt_rand(4,10));
            $object->setVar('hashkey', $crc->crc);
            $criteria = new CriteriaCompo(new Criteria('1', '1'));
            $object->setVar('referee', consentStripeReferee($referee = ($consentConfigsList['agreement-referee'] + $this->getCount($criteria)), 3, strlen($referee)));
            if ($object->getVar('timeout') < time())
                $object->setVar('timeout', time() + (3600*24*21));
            $daysdiff = $object->getVar('timeout') - $object->getVar('created') / (3600*24);
            $remind = floor($daysdiff / mt_rand(3,7));
            $object->setVar('reminded', time() + (3600*24*$remind));
        }
        return parent::insert($object, $force);
    }
}
?>