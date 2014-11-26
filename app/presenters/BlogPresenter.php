<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class BlogPresenter extends BasePresenter
{

	private $database;
	private $limitTable;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
		$this->limitTable = 1;
	}

	public function renderDefault()
	{
		$this->template->blog_contents = $this->database->table('blog_content')->order('create_post DESC')->limit($this->limitTable);
	}

}
