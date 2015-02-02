<?php

class BaseController extends Controller {

	/**
	 * Data handler for data
	 *
	 * @var array
	 */
	public $data = array();

	function __construct()
	{
		$this->setData();
		$this->setFormerLanguage();
	}

	/**
	 * Set Former Template language
	 *
	 * @return void
	 */
	protected function setFormerLanguage()
	{
		Former::framework('TwitterBootstrap3');
	}

	/**
	 * Set meta data
	 *
	 * @return void
	 */
	protected function setData()
	{
		// Meta Data
		$this->setMeta();

		$this->data['enable_breadcrumb'] = false;

	}

	/**
	 * Set meta object from data
	 *
	 * @return void
	 */
	protected function setMeta()
	{
		$meta = new stdClass();

		$meta->title         = "";
		$meta->title_prefix  = "";
		$meta->title_suffix  = "";
		$meta->description   = "";
		$meta->keywords      = "";

		$this->data['meta']  = $meta;
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
