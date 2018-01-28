<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Gears
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL, see /assets/en-GB.license.txt
 * @copyright   Copyright (c) 2018 Steven Palmer All rights reserved.
 *
 * CoalaWeb Gears is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/gpl.html>.
 */

defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE . '/plugins/system/cwgears/fields/base.php');

/**
 * Class CWElementCss
 */
class CWElementCss extends CWElement {

    /**
     * @param $name
     * @param $value
     * @param $node
     * @param $control_name
     */
    public function fetchElement($name, $value, &$node, $control_name) {

        $doc = JFactory::getDocument();

        $doc->addStyleSheet(JURI::root(true) . '/media/coalaweb/modules/generic/css/cw-config-j3.css');
        $doc->addStyleSheet(JURI::root(true) . '/media/coalaweb/modules/generic/css/cw-config-v2.css');

    }

    /**
     * @param $label
     * @param $description
     * @param $node
     * @param $control_name
     * @param $name
     * @return null
     */
    public function fetchTooltip($label, $description, &$node, $control_name, $name) {
        return NULL;
    }

}

/**
 * Class JFormFieldCss
 */
class JFormFieldCss extends CWElementCss {

    var $type = 'css';

}
