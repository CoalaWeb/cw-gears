<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             Joomla
 * @subpackage          CoalaWeb Header Field
 * @author              Steven Palmer
 * @author url          http://coalaweb.com
 * @author email        support@coalaweb.com
 * @license             GNU/GPL, see /assets/en-GB.license.txt
 * @copyright           Copyright (c) 2013 Steven Palmer All rights reserved.
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

class CWElementUpgrade extends CWElement {

    public function fetchElement($name, $value, &$node, $control_name) {

        return '<div class="cw-message-block">'
                . '<div class="cw-message">'
                . '<p class="upgrade">' . JText::_($value) . '</p>'
                . '</div></div>';
    }

    public function fetchTooltip($label, $description, &$node, $control_name, $name) {
        return NULL;
    }

}

class JFormFieldUpgrade extends CWElementUpgrade {

    var $type = 'upgrade';

}

class JElementUpgrade extends CWElementUpgrade {

    var $_name = 'upgrade';

}
