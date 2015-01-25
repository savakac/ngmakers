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
		$this->limitTable = 7;
	}

	// Zobrazenie prispevku na stranke blogu
	public function renderDefault()
	{
		$this->template->blog_contents = $this->database->table('blog_content')->order('create_post DESC')->limit($this->limitTable);
	}

	// Zobrazenie prispevku na stranke blogu s id
	public function renderShow($id)
	{
		$contents = $this->database->table('blog_content')->get($id);
		if (!$contents) {
			$this->error("Stranka nebola najdena.");
		}
		$this->template->contents = $contents;
	}

	// Vytvorenie formularu pre vkladanie dalsich clankou
	protected function createComponentPostForm()
	{
		if (!$this->user->isLoggedIn()) {
			// $this->error('Pre pridavanie alebo editovanie prispevku musite byt prihlaseny.');
			$this->redirect('Sign:in');
		} else {
			$form = new Nette\Application\UI\Form;

			$form->addText('title', 'Titulok: ', 101)->setRequired();
			$form->addTextArea('content', 'Obsah: ', 100, 10)->setRequired();

			$form->addSubmit('send', 'Ulozit a publikovat');
			$form->onSuccess[] = $this->postFormSucceeded;

			return $form;
		}
	}

	// Ukladanie noveho prispevku z forumulara
	public function postFormSucceeded($form)
	{
		$values = $form->getValues();
		$id = $this->getParameter("id");

		if (!$this->user->isLoggedIn()) {
			$this->error('Pre pridavanie alebo editovanie prispevku musite byt prihlaseny.');
		}

		if ($id) {
			$contents = $this->database->table('blog_content')->get($id);
			$contents->update($values);
		} else {
			$contents = $this->database->table('blog_content')->insert($values);
		}

		$this->flashMessage("Prispevok bol uspesne publikovany.", 'success');
		$this->redirect('show', $contents->id);
	}

	// Editacia prispevku
	public function actionEdit($id)
	{
		if (!$this->user->isloggedIn()) {
			// $this->error('Pre pridavanie alebo editaovanie prispevku musite byt prihlaseny.');
			$this->redirect('Sign:in');
		} else {
			$contents = $this->database->table('blog_content')->get($id);
			if (!$contents) {
				$this->error('Prispevok nebol najdeny');
			}
			$this['postForm']->setDefaults($contents->toArray());
		}
	}

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste odhlaseny.');
		$this->redirect('Homepage:defualt');
	}

}
