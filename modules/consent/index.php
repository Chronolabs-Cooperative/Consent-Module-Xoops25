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

	
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'header.php';
	
	xoops_load('XoopsSecurity');

	$op = ((!isset($_REQUEST['op']) || empty($_REQUEST['op'])) ? 'default' : (string)$_REQUEST['op']);
	
	switch($op)
	{
	    case 'make-agreement':
	        if (xoops_getModuleHandler('agreements', _MD_CONSENT_MODULE_DIRNAME)->checkSubscriptionForm($_REQUEST, false))
	        {
	            $agreementsHandler = xoops_getModuleHandler('agreements', _MD_CONSENT_MODULE_DIRNAME);
	            $guardiansHandler = xoops_getModuleHandler('guardians', _MD_CONSENT_MODULE_DIRNAME);
	            $clientelsHandler = xoops_getModuleHandler('clientels', _MD_CONSENT_MODULE_DIRNAME);
	            
	            $obj = $guardiansHandler->create();
	            if (is_object($GLOBALS['xoopsUser']))
	                $obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
	            $obj->setVar('name', $_REQUEST['guardian-name']);
	            $obj->setVar('email', $_REQUEST['guardian-email']);
	            $obj->setVar('phone', $_REQUEST['guardian-phone']);
	            $guardian = $guardiansHandler->get($guardianid = $guardiansHandler->insert($obj));
	
	            setcookie(_MD_CONSENT_MODULE_DIRNAME . '-guardian-name', $_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['name'] = $_REQUEST['guardian-name'], 60*60*24*14*14*9, '/', XOOPS_COOKIE_DOMAIN, true);
	            setcookie(_MD_CONSENT_MODULE_DIRNAME . '-guardian-email', $_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['email'] = $_REQUEST['guardian-email'], 60*60*24*14*14*9, '/', XOOPS_COOKIE_DOMAIN, true);
	            setcookie(_MD_CONSENT_MODULE_DIRNAME . '-guardian-phone', $_SESSION[_MD_CONSENT_MODULE_DIRNAME]['guardian']['phone'] = $_REQUEST['guardian-phone'], 60*60*24*14*14*9, '/', XOOPS_COOKIE_DOMAIN, true);
	            
	            $obj = $clientelsHandler->create();
	            if (is_object($GLOBALS['xoopsUser']))
	                $obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
	            $obj->setVar('name', $_REQUEST['clientel-name']);
	            $obj->setVar('email', $_REQUEST['clientel-email']);
	            $obj->setVar('phone', $_REQUEST['clientel-phone']);
	            $clientel = $clientelsHandler->get($clientelid = $clientelsHandler->insert($obj));
	            
	            $obj = $agreementsHandler->create();
	            if (is_object($GLOBALS['xoopsUser']))
	                $obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
	            $obj->setVar('guardian-id', $guardianid);
	            $obj->setVar('clientel-id', $clientelid);
	            $obj->setVar('timeout', strtotime($_REQUEST['timeout']));
	            $obj->setVar('callback-url', $_REQUEST['callback-url']);
	            $agreement = $agreementsHandler->get($agreementid = $agreementsHandler->insert($obj, true));
	            
	            require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'header.php';
	            if (is_object($GLOBALS['xoTheme']))
	                $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . _MD_CONSENT_MODULE_DIRNAME . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css');
	            $GLOBALS['xoopsTpl']->assign('guardian', $guardian->getValues(array('name','email','phone','hashkey','id','created')));
	            $GLOBALS['xoopsTpl']->assign('clientel', $clientel->getValues(array('name','email','phone','hashkey','id','created')));
	            $GLOBALS['xoopsTpl']->assign('agreement', $agreement->getValues(array('hashkey','referee','created','timeout','id')));
	            $GLOBALS['xoopsTpl']->display(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'index-agreement-created.html');
                require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'footer.php';
                
	            break;
	        }
	    default:
	        require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'header.php';
	        if (is_object($GLOBALS['xoTheme']))
	            $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/' . _MD_CONSENT_MODULE_DIRNAME . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css');
	        $GLOBALS['xoopsTpl']->assign('form', xoops_getModuleHandler('agreements', _MD_CONSENT_MODULE_DIRNAME)->getSubscriptionForm($_REQUEST));
	        $GLOBALS['xoopsTpl']->assign('errors', xoops_getModuleHandler('agreements', _MD_CONSENT_MODULE_DIRNAME)->errorsSubscriptionForm($_REQUEST));
	        $GLOBALS['xoopsTpl']->display(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'index-subscribe-consent.html');
	        require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'footer.php';
	        break;
	}
	