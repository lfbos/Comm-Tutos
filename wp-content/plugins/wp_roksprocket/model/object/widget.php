<?php
/**
 * @version   $Id: widget.php 11788 2013-06-26 23:02:33Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2016 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokSprocket_Model_Object_Widget extends RokSprocket_Model_Object_Abstract
{

	/**
	 * @var string
	 */
	protected $_tbl = 'roksprocket';
	/**
	 * @var string
	 */
	protected $_tbl_key = 'id';

	/**
	 * @var int
	 */
	protected $id = 0;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var RokCommon_Date
	 */
	protected $modified;

	/**
	 * @var RokCommon_Registry
	 */
	protected $params;

	/**
	 * @var string
	 */
	protected $_uuid;

	public function __construct()
	{
		parent::__construct(); // TODO: Change the autogenerated stub
		$this->params = new RokCommon_Registry();
	}


	/**
	 * @param RokSprocket_Model_Object_Widget
	 *
	 * @return \RokSprocket_Model_Object_Widget
	 */
	public static function genereateFromArray($array)
	{
		$instance = new self();
		$instance->bind($array);
		return $instance;
	}

	/**
	 * @param array  $array
	 *
	 * @param string $ignore
	 *
	 * @return bool
	 */
	public function bind($array, $ignore = '')
	{
		if (isset($array['modified']) && is_object($array['modified']) && $array['modified'] instanceof RokCommon_Date) {
			$array['modified'] = (string)$array['modified'];
		}
		if (isset($array['params']) && is_array($array['params'])) {
			if (get_magic_quotes_gpc()) {
				$array['params'] = self::_stripSlashesRecursive($array['params']);
			}
			$registry = new RokCommon_Registry;
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}
		return parent::bind($array, $ignore);
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param \RokCommon_Date $modified
	 */
	public function setModified($modified)
	{
		$this->modified = $modified;
	}

	/**
	 * @return \RokCommon_Date
	 */
	public function getModified()
	{
		return $this->modified;
	}

	/**
	 * @param \RokCommon_Registry $params
	 */
	public function setParams($params)
	{
		$this->params = $params;
	}

	/**
	 * @param $json
	 */
	public function setParamsFromJSON($json)
	{
		$this->params = new RokCommon_Registry($json);
	}

	/**
	 * @return \RokCommon_Registry
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $uuid
	 */
	public function setUuid($uuid)
	{
		$this->_uuid = $uuid;
	}

	/**
	 * @return string
	 */
	public function getUuid()
	{
		return $this->_uuid;
	}

}