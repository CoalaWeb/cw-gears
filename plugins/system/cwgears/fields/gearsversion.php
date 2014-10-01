<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             Joomla
 * @subpackage          CoalaWeb Gears Version Element
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

class CWElementGearsVersion extends CWElement {

    public function fetchElement($name, $value, &$node, $control_name) {
        return NULL;
    }

    public function fetchTooltip($label, $description, &$node, $control_name, $name) {

        // Load version.php
        jimport('joomla.filesystem.file');
        $version_php = JPATH_SITE . '/' . $label . '/version.php';
        if (JFile::exists($version_php)) {
            require_once $version_php;
        }

                //Which extension is being displayed?
        switch ($label) {
            case "plugins/system/cwgears":
                $version = (PLG_CWGEARS_VERSION);
                $date = (PLG_CWGEARS_DATE);
                $ispro = (PLG_CWGEARS_PRO);
                break;
            case "plugins/content/cwmarkdown":
                $version = (PLG_CWMARKDOWN_VERSION);
                $date = (PLG_CWMARKDOWN_DATE);
                $ispro = (PLG_CWMARKDOWN_PRO);
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

class JFormFieldGearsVersion extends CWElementGearsVersion {

    var $type = 'gearsversion';

}

class JElementGearsVersion extends CWElementGearsVersion {

    var $_name = 'gearsversion';

}
