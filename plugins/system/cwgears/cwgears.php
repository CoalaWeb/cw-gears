<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             Joomla
 * @subpackage          CoalaWeb Gears
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

class plgSystemCwgears extends JPlugin {

    function __construct(&$subject, $config) {
        parent::__construct($subject, $config);

        // load the CoalaWeb Gears language file
        $lang = JFactory::getLanguage();
        if ($lang->getTag() != 'en-GB') {
            // Loads English language file as fallback (for undefined stuff in other language files)
            $lang->load('plg_system_cwgears', JPATH_ADMINISTRATOR, 'en-GB');
        }
        $lang->load('plg_system_cwgears', JPATH_ADMINISTRATOR, null, 1);
    }

    public function onAfterInitialise() {

        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        $option = JRequest::getCmd('option');
        $ext = JRequest::getCmd('extension');
        $baseUrl = '../media/coalaweb/';

        if (JFactory::getApplication()->isAdmin()) {

            if ($option == 'com_categories' && ($ext == 'com_coalawebquotes' || $ext == 'com_coalawebmarket')) {
                 if (version_compare(JVERSION, '3.0', '>')) {
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-base-j3.css");
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-categories.css");
                } else {
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-base.css");
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-categories.css");
                }
            }
            

            if (in_array($option, array('com_coalawebcontact', 'com_coalawebsociallinks', 'com_coalawebtraffic', 'com_coalawebmarket'))) {

                if (version_compare(JVERSION, '3.0', '>')) {
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-base-j3.css");
                } else {
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-base.css");
                }
            }
        }
    }

    public function onBeforeCompileHead() {

        //Should we load jQuery at all?
        $loadJquery = $this->params->get('jquery_on', 0);
        if (!$loadJquery) {
            return;
        }

        // Do we want jQuery in the Admin area?
        $loadBackend = $this->params->get("jquery_backend", 0);
        if (!$loadBackend) {
            $app = JFactory::getApplication();
            if ($app->isAdmin()) {
                return;
            }
        }

        // Let create a link to our local directory.
        $doc = JFactory::getDocument();
        $localURL = JURI::root() . "media/coalaweb/plugins/system/gears/js";

        // Lets choose the location we want to use.
        switch ($this->params->get("jquery_server")) {

            case 1: // code.jquery.com
                $url = "//code.jquery.com/jquery-" . $this->params->get("jquery_library") . ".min.js";
                break;

            case 2: // ajax.googleapis.com
                $url = "//ajax.googleapis.com/ajax/libs/jquery/" . $this->params->get("jquery_library") . "/jquery.min.js";
                break;

            case 3: // ajax.aspnetcdn.com
                $url = "//ajax.aspnetcdn.com/ajax/jQuery/jquery-" . $this->params->get("jquery_library") . ".min.js";
                break;

            case 4: // cdnjs.cloudflare.com
                $url = "//cdnjs.cloudflare.com/ajax/libs/jquery/" . $this->params->get("jquery_library") . "/jquery.min.js";
                break;

            default: // Localhost
                $url = $localURL . "/jquery-" . $this->params->get("jquery_library") . ".min.js";
                break;
        }

        // Should we include no conflict?
        if ($this->params->get("jquery_noconflict")) {
            JHtml::_('behavior.framework');
        }

        $doc->addScript($url);

        if ($this->params->get("jquery_noconflict")) {
            $doc->addScript($localURL . "/jquery-noconflict.js");
        }

        // Should we include migrate?
        if ($this->params->get("jquery_migrate")) {
            $doc->addScript($localURL . "/jquery-migrate-1.2.1.min.js");
        }

        // Order scripts
        $headData = $doc->getHeadData();

        // These are allowed jQuery librarie, no conflict script and migrate script.
        // Only they can be rearranged.
        $allowedJQuery = array("jquery.min.js", "jquery-" . $this->params->get("jquery_library") . ".min.js", "jquery-noconflict.js", "jquery-migrate-1.2.1.min.js");

        $first = array();
        $jquery = array();
        foreach ($headData["scripts"] as $key => $value) {

            if ((false !== strpos($key, "mootools-core-uncompressed.js")) OR (false !== strpos($key, "mootools-core.js"))) {
                $first[$key] = $value;
                unset($headData["scripts"][$key]);
            }

            if ((false !== strpos($key, "mootools-more-uncompressed.js")) OR (false !== strpos($key, "mootools-more.js"))) {
                $first[$key] = $value;
                unset($headData["scripts"][$key]);
            }

            if (false !== strpos($key, "jquery")) {
                $baseName = basename($key);

                // Order only jQuery library and no conflict script
                if (in_array($baseName, $allowedJQuery)) {
                    $jquery[$key] = $value;
                }
            }
        }

        $jquery = $this->orderLibrarires($jquery);
        $first = array_merge($first, $jquery);

        $second = $headData["scripts"];
        $headData["scripts"] = array_merge($first, $second);

        $doc->setHeadData($headData);

        unset($first);
        unset($second);
        unset($scripts);
        unset($headData);
    }

    /**
     * Order jQuery libraries in valid order
     * @param array $libs
     */
    private function orderLibrarires($libs) {

        $strings = array("code.jquery.com", "ajax.googleapis.com", "ajax.aspnetcdn.com", "cdnjs.cloudflare.com", "cwjquery");

        $first = array();
        foreach ($libs as $key => $value) {
            foreach ($strings as $string) {

                if (false !== strpos($key, $string)) {
                    $first[$key] = $value;
                    unset($libs[$key]);
                }
            }
        }

        $first = array_merge($first, $libs);
        return $first;
    }

}
