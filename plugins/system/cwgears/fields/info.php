<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Gears
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL, see /assets/en-GB.license.txt
 * @copyright   Copyright (c) 2019 Steven Palmer All rights reserved.
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
 * Class CWElementInfo
 */
class CWElementInfo extends CWElement {

    /**
     * @param $name
     * @param $value
     * @param $node
     * @param $control_name
     * @return null
     */
    public function fetchElement($name, $value, &$node, $control_name) {

        return NULL;
    }

    /**
     * @param $label
     * @param $description
     * @param $node
     * @param $control_name
     * @param $name
     * @return string
     */
    public function fetchTooltip($label, $description, &$node, $control_name, $name) {
        return '<div class="cw-message-block">'
                . '<div class="cw-message">'
                . '<p class="info">' . JText::_($label) . '</p>'
                . '</div>'
                . '</div>';
    }

}

/**
 * Class JFormFieldInfo
 */
class JFormFieldInfo extends CWElementInfo {

    var $type = 'info';

}
