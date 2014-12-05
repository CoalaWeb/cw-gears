<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             Joomla
 * @subpackage          CoalaWeb Version Element
 * @author              Steven Palmer
 * @author url          http://coalaweb.com
 * @author email        support@coalaweb.com
 * @license             GNU/GPL, see /assets/en-GB.license.txt
 * @copyright           Copyright (c) 2014 Steven Palmer All rights reserved.
 *
 * CoalaWeb Contact is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
require_once (JPATH_SITE . '/plugins/system/cwgears/fields/base.php');

class CWElementVersion extends CWElement {

    public function fetchElement($name, $value, &$node, $control_name) {
        return NULL;
    }

    public function fetchTooltip($label, $description, &$node, $control_name, $name) {

        // Load version.php
        jimport('joomla.filesystem.file');
        $arr = explode("_", $label, 2);
        if ($arr[0] == 'com') {
            $version_php = JPATH_ADMINISTRATOR . '/' . 'components/' . $label . '/version.php';
        } else {
            $version_php = JPATH_SITE . '/' . 'modules/' . $label . '/version.php';
        }
        
        if (JFile::exists($version_php)) {
            require_once $version_php;
        }

        //Which extension is being displayed?
        switch ($label) {
            case "com_coalawebcontact":
                $version = (COM_CWCONTACT_VERSION);
                $date = (COM_CWCONTACT_DATE);
                $ispro = (COM_CWCONTACT_PRO);
                break;
            case "com_coalawebsociallinks":
                $version = (COM_CWSOCIALLINKS_VERSION);
                $date = (COM_CWSOCIALLINKS_DATE);
                $ispro = (COM_CWSOCIALLINKS_PRO);
                break;
            case "com_coalawebtraffic":
                $version = (COM_CWTRAFFIC_VERSION);
                $date = (COM_CWTRAFFIC_DATE);
                $ispro = (COM_CWTRAFFIC_PRO);
                break;
            case "mod_coalawebpanel":
                $version = (MOD_CWPANEL_VERSION);
                $date = (MOD_CWPANEL_DATE);
                $ispro = (MOD_CWPANEL_PRO);
                break;
            case "mod_coalawebnews":
                $version = (MOD_CWNEWS_VERSION);
                $date = (MOD_CWNEWS_DATE);
                $ispro = (MOD_CWNEWS_PRO);
                break;
            case "mod_coalawebflair":
                $version = (MOD_CWFLAIR_VERSION);
                $date = (MOD_CWFLAIR_DATE);
                $ispro = (MOD_CWFLAIR_PRO);
                break;
        }

        if ($ispro == 1) {
            $ispro = JText::_('PLG_CWGEARS_RELEASE_TYPE_PRO');
        } else {
            $ispro = JText::_('PLG_CWGEARS_RELEASE_TYPE_CORE');
        }

        return '<div class="cw-message-block">'
                . '<div class="cw-module">'
                . '<h3>' . JText::_('PLG_CWGEARS_RELEASE_TITLE') . '</h3>'
                . '<ul class="cw_module">'
                . '<li>' . JText::_('PLG_CWGEARS_FIELD_RELEASE_TYPE_LABEL') . ' <strong>' . $ispro . '</strong></li>'
                . '<li>' . JText::_('PLG_CWGEARS_FIELD_RELEASE_VERSION_LABEL') . ' <strong>' . $version . '</strong></li>'
                . '<li>' . JText::_('PLG_CWGEARS_FIELD_RELEASE_DATE_LABEL') . ' <strong>' . $date . '</strong></li>'
                . '</ul>'
                . '</div></div>';
    }

}

class JFormFieldVersion extends CWElementVersion {

    var $type = 'version';

}

class JElementVersion extends CWElementVersion {

    var $_name = 'version';

}
