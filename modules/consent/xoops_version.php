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

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

if (!defined(_MD_CONSENT_MODULE_DIRNAME))
	define('_MD_CONSENT_MODULE_DIRNAME', basename(__DIR__));

global $consentModule, $consentConfigsList, $consentConfigs, $consentConfigsOptions;

if (empty($consentModule))
{
	if (is_a($consentModule = xoops_gethandler('module')->getByDirname(_MD_CONSENT_MODULE_DIRNAME), "XoopsModule"))
	{
		if (empty($consentConfigsList))
		{
			$consentConfigsList = xoops_gethandler('config')->getConfigList($consentModule->getVar('mid'));
		}
		if (empty($consentConfigs))
		{
			$consentConfigs = xoops_gethandler('config')->getConfigs(new Criteria('conf_modid', $consentModule->getVar('mid')));
		}
		if (empty($consentConfigsOptions) && !empty($consentConfigs))
		{
			foreach($consentConfigs as $key => $config)
				$consentConfigsOptions[$config->getVar('conf_name')] = $config->getConfOptions();
		}
	}
}

$modversion['dirname'] 					= _MD_CONSENT_MODULE_DIRNAME;
$modversion['name'] 					= _MD_CONSENT_MODULE_NAME;
$modversion['version']     				= _MD_CONSENT_MODULE_VERSION;
$modversion['releasedate'] 				= _MD_CONSENT_MODULE_RELEASEDATE;
$modversion['status']      				= _MD_CONSENT_MODULE_STATUS;
$modversion['description'] 				= _MD_CONSENT_MODULE_DESCRIPTION;
$modversion['credits']     				= _MD_CONSENT_MODULE_CREDITS;
$modversion['author']      				= _MD_CONSENT_MODULE_AUTHORALIAS;
$modversion['help']        				= _MD_CONSENT_MODULE_HELP;
$modversion['license']     				= _MD_CONSENT_MODULE_LICENCE;
$modversion['official']    				= _MD_CONSENT_MODULE_OFFICAL;
$modversion['image']       				= _MD_CONSENT_MODULE_ICON;
$modversion['module_status'] 			= _MD_CONSENT_MODULE_STATUS;
$modversion['website'] 					= _MD_CONSENT_MODULE_WEBSITE;
$modversion['dirmoduleadmin'] 			= _MD_CONSENT_MODULE_ADMINMODDIR;
$modversion['icons16'] 					= _MD_CONSENT_MODULE_ADMINICON16;
$modversion['icons32'] 					= _MD_CONSENT_MODULE_ADMINICON32;
$modversion['release_info'] 			= _MD_CONSENT_MODULE_RELEASEINFO;
$modversion['release_file'] 			= _MD_CONSENT_MODULE_RELEASEFILE;
$modversion['release_date'] 			= _MD_CONSENT_MODULE_RELEASEDATE;
$modversion['author_realname'] 			= _MD_CONSENT_MODULE_AUTHORREALNAME;
$modversion['author_website_url'] 		= _MD_CONSENT_MODULE_AUTHORWEBSITE;
$modversion['author_website_name'] 		= _MD_CONSENT_MODULE_AUTHORSITENAME;
$modversion['author_email'] 			= _MD_CONSENT_MODULE_AUTHOREMAIL;
$modversion['author_word'] 				= _MD_CONSENT_MODULE_AUTHORWORD;
$modversion['status_version'] 			= _MD_CONSENT_MODULE_VERSION;
$modversion['warning'] 					= _MD_CONSENT_MODULE_WARNINGS;
$modversion['demo_site_url'] 			= _MD_CONSENT_MODULE_DEMO_SITEURL;
$modversion['demo_site_name'] 			= _MD_CONSENT_MODULE_DEMO_SITENAME;
$modversion['support_site_url'] 		= _MD_CONSENT_MODULE_SUPPORT_SITEURL;
$modversion['support_site_name'] 		= _MD_CONSENT_MODULE_SUPPORT_SITENAME;
$modversion['submit_feature'] 			= _MD_CONSENT_MODULE_SUPPORT_FEATUREREQUEST;
$modversion['submit_bug'] 				= _MD_CONSENT_MODULE_SUPPORT_BUGREPORTING;
$modversion['people']['developers'] 	= explode("|", _MD_CONSENT_MODULE_DEVELOPERS);
$modversion['people']['testers']		= explode("|", _MD_CONSENT_MODULE_TESTERS);
$modversion['people']['translaters']	= explode("|", _MD_CONSENT_MODULE_TRANSLATERS);
$modversion['people']['documenters']	= explode("|", _MD_CONSENT_MODULE_DOCUMENTERS);

// Requirements
$modversion['min_php']        			= '7.0';
$modversion['min_xoops']      			= '2.5.8';
$modversion['min_db']         			= array('mysql' => '5.0.7', 'mysqli' => '5.0.7');
$modversion['min_admin']      			= '1.1';

// Database SQL File and Tables
$modversion['sqlfile']['mysql'] 		= "sql/mysqli.sql";
$modversion['tables']	 				= explode("\n", file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'tables.diz'));

//Search
$modversion['hasSearch'] 				= _MD_CONSENT_MODULE_HASSEARCH;
//$modversion['search']['file'] 		= "include/search.inc.php";
//$modversion['search']['func'] 		= "publisher_search";

// Main
$modversion['hasMain'] 					= _MD_CONSENT_MODULE_HASMAIN;

// Admin
$modversion['hasAdmin'] 				= _MD_CONSENT_MODULE_HASADMIN;
$modversion['adminindex']  				= "admin/index.php";
$modversion['adminmenu']   				= "admin/menu.php";
$modversion['system_menu'] 				= 1;

// Comments
$modversion['hasComments'] 				= _MD_CONSENT_MODULE_HASCOMMENTS;
//$modversion['comments']['itemName'] = 'itemid';
//$modversion['comments']['pageName'] = 'item.php';
//$modversion['comments']['callbackFile']        = 'include/comment_functions.php';
//$modversion['comments']['callback']['approve'] = 'publisher_com_approve';
//$modversion['comments']['callback']['update']  = 'publisher_com_update';

// Add extra menu items
//$modversion['sub'][3]['name'] = _MD_CONSENT_SUB_ARCHIVE;
//$modversion['sub'][3]['url']  = "archive.php";


// Create Block Constant Defines
$i = 0;
++$i;
//$modversion['blocks'][$i]['file']        = "items_new.php";
//$modversion['blocks'][$i]['name']        = _MD_CONSENT_ITEMSNEW;
//$modversion['blocks'][$i]['description'] = _MD_CONSENT_ITEMSNEW_DSC;
//$modversion['blocks'][$i]['show_func']   = "publisher_items_new_show";
//$modversion['blocks'][$i]['edit_func']   = "publisher_items_new_edit";
//$modversion['blocks'][$i]['options']     = "0|datesub|0|5|65|none";
//$modversion['blocks'][$i]['template']    = "publisher_items_new.tpl";


// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = 'convert_index.html';
$modversion['templates'][$i]['description'] = 'Font Converter Root Index';
$i++;
$modversion['templates'][$i]['file'] = 'convert_history.html';
$modversion['templates'][$i]['description'] = 'Font Converter History Index';
$i++;
$modversion['templates'][$i]['file'] = 'convert_fonts.html';
$modversion['templates'][$i]['description'] = 'Font Converter Font display Index';


// Config categories
$modversion['configcat']['seo']['name']        = _MD_CONSENT_CONFCAT_SEO;
$modversion['configcat']['seo']['description'] = _MD_CONSENT_CONFCAT_SEO_DESC;

$modversion['configcat']['mod']['name']        = _MD_CONSENT_CONFCAT_MODULE;
$modversion['configcat']['mod']['description'] = _MD_CONSENT_CONFCAT_MODULE_DESC;

$modversion['configcat']['twitter']['name']        = _MD_CONSENT_CONFCAT_TWITTER;
$modversion['configcat']['twitter']['description'] = _MD_CONSENT_CONFCAT_TWITTER_DESC;
// Config categories
$i=0;

++$i;
$modversion['config'][$i]['name']        = 'htaccess';
$modversion['config'][$i]['title']       = '_MD_CONSENT_HTACCESS';
$modversion['config'][$i]['description'] = '_MD_CONSENT_HTACCESS_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = false;
$modversion['config'][$i]['options']     = array();
$modversion['config'][$i]['category']    = 'seo';
++$i;
$modversion['config'][$i]['name']        = 'base';
$modversion['config'][$i]['title']       = '_MD_CONSENT_BASE';
$modversion['config'][$i]['description'] = '_MD_CONSENT_BASE_DESC';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'convert';
$modversion['config'][$i]['options']     = array();
$modversion['config'][$i]['category']    = 'seo';
++$i;
$modversion['config'][$i]['name']        = 'html';
$modversion['config'][$i]['title']       = '_MD_CONSENT_HTML';
$modversion['config'][$i]['description'] = '_MD_CONSENT_HTML_DESC';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'html';
$modversion['config'][$i]['options']     = array();
$modversion['config'][$i]['category']    = 'seo';
++$i;
$modversion['config'][$i]['name']        = 'agreement-referee';
$modversion['config'][$i]['title']       = '_MD_CONSENT_AGREEMENT_REFEREE';
$modversion['config'][$i]['description'] = '_MD_CONSENT_AGREEMENT_REFEREE_DESC';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'AAA000AAA';
$modversion['config'][$i]['options']     = array();
$modversion['config'][$i]['category']    = 'mod';
++$i;
$modversion['config'][$i]['name']        = 'batch-referee';
$modversion['config'][$i]['title']       = '_MD_CONSENT_BATCH_REFEREE';
$modversion['config'][$i]['description'] = '_MD_CONSENT_BATCH_REFEREE_DESC';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'A00ZAAZZA';
$modversion['config'][$i]['options']     = array();
$modversion['config'][$i]['category']    = 'mod';

$modversion['hasNotification']             = false;
//$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
//$modversion['notification']['lookup_func'] = 'publisher_notify_iteminfo';

//$modversion['notification']['category'][1]['name']           = 'global_item';
//$modversion['notification']['category'][1]['title']          = _MD_CONSENT_GLOBAL_ITEM_NOTIFY;
//$modversion['notification']['category'][1]['description']    = _MD_CONSENT_GLOBAL_ITEM_NOTIFY_DSC;
//$modversion['notification']['category'][1]['subscribe_from'] = array('index.php', 'category.php', 'item.php');

//$modversion['notification']['event'][1]['name']          = 'category_created';
//$modversion['notification']['event'][1]['category']      = 'global_item';
//$modversion['notification']['event'][1]['title']         = _MD_CONSENT_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY;
//$modversion['notification']['event'][1]['caption']       = _MD_CONSENT_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP;
//$modversion['notification']['event'][1]['description']   = _MD_CONSENT_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC;
//$modversion['notification']['event'][1]['mail_template'] = 'global_item_category_created';
//$modversion['notification']['event'][1]['mail_subject']  = _MD_CONSENT_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ;

?>
