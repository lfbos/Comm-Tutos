<?php
/**
 * @version	$Id: Filter_Type_User.php 10887 2013-05-30 06:31:57Z btowles $
 * @author	 RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2016 RocketTheme, LLC
 * @license	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokSprocket_Provider_Seblod_Filter_Type_User extends RokCommon_Filter_Type
{
	/**
	 * @var string
	 */
	protected $type = 'user';
	protected static $js_loaded = false;

	public function getChunkRender()
	{
		return $this->getInput();
	}

	public function getChunkSelectionRender()
	{
		return rc__('ROKCOMMON_FILTER_PICKLIST_RENDER', $this->getTypeDescription($this->getChunkType()));
	}

	public function getChunkType()
	{
		return trim((string)$this->xmlnode['name']);
	}

	public function render($name, $type, $values)
	{
		$value = (isset($values[$type]) ? $values[$type] : '');
		return rc__('ROKCOMMON_FILTER_PICKLIST_RENDER', $this->getInput($name, $value));
	}

	protected function getInput($name = RokCommon_Filter_Type::JAVASCRIPT_NAME_VARIABLE, $value = '')
	{
		$id = $this->generateIdFromName($name);
		//if ($id == '|name|') return;

		// Initialize variables.
		$html	  = array();
		$groups	= $this->getGroups();
		$excluded = $this->getExcluded();
		$link	  = 'index.php?option=com_users&amp;view=users&amp;layout=modal&amp;tmpl=component&amp;field=Sprocket' . (isset($groups) ? ('&amp;groups=' . base64_encode(json_encode($groups))) : '') . (isset($excluded) ? ('&amp;excluded=' . base64_encode(json_encode($excluded))) : '');

		// Initialize some field attributes.
		$attr = $this->xmlnode['class'] ? ' class="' . (string)$this->xmlnode['class'] . '"' : '';
		$attr .= $this->xmlnode['size'] ? ' size="' . (int)$this->xmlnode['size'] . '"' : '';

		// Initialize JavaScript field attributes.
		$onchange = (string)$this->xmlnode['onchange'];

		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal');

		// Build the script.
		$script = str_replace('%ID%', $id, $this->getJSelectUser());

		// Add the script to the document head.
		if ($id != '|name|' && !self::$js_loaded){
			RokCommon_Header::addInlineScript($script);
			self::$js_loaded = true;
		}

		// Load the current username if available.
		$table = JTable::getInstance('user');
		if ($value) {
			$table->load($value);
		} else {
			$table->username = JText::_('JLIB_FORM_SELECT_USER');
		}

		if (empty($table->name)) $table->name = JText::_('JLIB_FORM_SELECT_USER');

		$html[] = ' <input type="text" data-other="true" disabled="disabled" value="' . htmlspecialchars($table->name, ENT_COMPAT, 'UTF-8') . '"' . ' ' . $attr . ' />';
		$html[] = '	  <a class="modal" title="' . JText::_('JLIB_FORM_CHANGE_USER') . '"' . ' href="' . $link . '"' . ' rel="{handler: \'iframe\', size: {x: 800, y: 500}}">';
		$html[] = '			<i class="icon tool user"></i>';
		$html[] = '	  </a>';

		// Create the real field, hidden, that stored the user id.
		$html[] = '<input type="hidden" name="'.$name.'" id="'.$id.'" data-name="'.$name.'" data-key="'.$this->getChunkType().'" value="' . (int)$value . '" />';

		return implode("\n", $html);
	}

	protected function generateIdFromName($name)
	{
		$id = $name;
		$id = str_replace('][','',$id);
		$id = str_replace('[','',$id);
		$id = str_replace(']','',$id);
		return $id;
	}

	/**
	 * Method to get the filtering groups (null means no filtering)
	 *
	 * @return  mixed  array of filtering groups or null.
	 *
	 * @since	11.1
	 */
	protected function getGroups()
	{
		return null;
	}

	/**
	 * Method to get the users to exclude from the list of users
	 *
	 * @return  mixed  Array of users to exclude or null to to not exclude them
	 *
	 * @since	11.1
	 */
	protected function getExcluded()
	{
		return null;
	}

	/**
	 * @return string
	 */
	protected function getJavascript($name = self::JAVASCRIPT_NAME_VARIABLE, $value = null)
	{
		$script = array();
		$script[] = "(function(){";
		$script[] = $this->getJSelectUser();
		$script[] = "%.modal%.addEvent('click', function(){ jSelectUserID = this; });";
		$script[] = "SqueezeBox.assign(%.modal%, {parse: 'rel'});";
		$script[] = "});";

		$this->javascript = implode("\n", $script);

		return $this->javascript;
	}

	protected function getJSelectUser(){
		$script = array();
		$script[] = "if (typeof jSelectUser_Sprocket == 'undefined'){";
		$script[] = '	window.jSelectUserID = null;';
		$script[] = '	window.jSelectUser_Sprocket = function(id, title) {';
		$script[] = "		var lnk = document.getElement(jSelectUserID),";
		$script[] = "			parent = lnk.getParent('.chunk'),";
		$script[] = "			item = parent.getElement('[data-key]'),";
		$script[] = "			other = parent.getElement('[data-other=true]'),";
		$script[] = "			value = item.get('value');";
		$crript[] = "";
		$script[] = '		if (value != id) {';
		$script[] = "			item.set('value', id);";
		$script[] = "			other.set('value', title);";
		$script[] = "			item.fireEvent((Browser.name == 'ie' && Browser.version <= 9) ? 'keypress' : 'input');";
		$script[] = '		}';
		$script[] = "";
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';
		$script[] = "";
		$script[] = "	window.addEvent('domready', function(){";
		$script[] = "		 document.getElements('.modal').addEvent('click', function(){ jSelectUserID = this; });";
		$script[] = "	});";
		$script[] = "};";

		return implode("\n", $script);
	}
}
