<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.kickgdpr
 * @author      Niels Nübel <niels@niels-nuebel.de>
 * @copyright   2018 Niels Nübel
 * @license     GNU/GPLv3 <http://www.gnu.org/licenses/gpl-3.0.de.html>
 * @link        https://kicktemp.com
 */

// No direct access
defined('_JEXEC') or die;
use Joomla\Registry\Registry;

/**
 * Form Field class for Kubik-Rubik Joomla! Extensions.
 * Provides a donation code check.
 */
class JFormFieldPluginSave extends JFormField
{
	protected $type = 'pluginsave';

	protected function getInput()
	{
		$html = '<button onclick="Joomla.submitbutton(\'plugin.apply\');" class="btn button-apply btn-danger"><span class="icon-apply icon-white" aria-hidden="true"></span>' . JText::_('PLG_CWGEARS_APPLY') . '</button>';
		return $html;
	}

	protected function getLabel()
	{
		return '';
	}
}
