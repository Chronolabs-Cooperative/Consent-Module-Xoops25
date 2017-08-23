<?php
/**
 * Font Converter for fonts2web.org.uk
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
* @subpackage  	convert
* @description 	Converts fonts to web distributional format in a zip pack stamped
* @version		1.0.1
* @link        	http://fonts2web.org.uk
* @link        	http://fonts.labs.coop
* @link			http://internetfounder.wordpress.com
*/


// Errors for Single Subscription to Consent
define('_ERR_CONSENT_FORM_GUARDIAN_NAME_MISSING','Guardian\'s Name is empty and missing');
define('_ERR_CONSENT_FORM_GUARDIAN_PHONE_MISSING','Guardian\'s Phone is empty and missing');
define('_ERR_CONSENT_FORM_GUARDIAN_EMAIL_MISSING','Guardian\'s eMail is empty and missing');
define('_ERR_CONSENT_FORM_GUARDIAN_PHONE_WRONGLENGTH','Guardian\'s Phone must contain at least 10 numbers ~ include country code+area code!');
define('_ERR_CONSENT_FORM_GUARDIAN_NAME_MALFORMED','Guardian\'s Name must consist of at least two words seperated by a space');
define('_ERR_CONSENT_FORM_GUARDIAN_EMAIL_MALFORMED','Guardian\'s eMail is malformed and not an email address');
define('_ERR_CONSENT_FORM_CLIENTEL_NAME_MISSING','Clientel\'s Name is empty and missing');
define('_ERR_CONSENT_FORM_CLIENTEL_PHONE_MISSING','Clientel\'s Phone is empty and missing');
define('_ERR_CONSENT_FORM_CLIENTEL_EMAIL_MISSING','Clientel\'s eMail is empty and missing');
define('_ERR_CONSENT_FORM_CLIENTEL_PHONE_WRONGLENGTH','Clientel\'s Phone must contain at least 10 numbers ~ include country code+area code!');
define('_ERR_CONSENT_FORM_CLIENTEL_NAME_MALFORMED','Clientel\'s Name must consist of at least two words seperated by a space');
define('_ERR_CONSENT_FORM_CLIENTEL_EMAIL_MALFORMED','Clientel\'s eMail is malformed and not an email address');
define('_ERR_CONSENT_FORM_AGREEMENT_EXISTINGINQUEUE','Guardian+Clientel is already exists in a current consent request agreements!');

?>