<?php
use nBudget\Form;

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
	{
		$registerForm = new Form\Register();

		/** @var $request Zend_Controller_Request_Http */
		$request = $this->getRequest();
		$isPost = $request->isPost();
		if ($isPost) {
			$isValid = $registerForm->isValid($request->getPost());
			if ($isValid) {
				$userService = new \nBudget\Service\User;
				$result = $userService->create($registerForm->getValues());
				if ($result[0] === false) {
				}

			}
		}

		$this->view->registerForm = $registerForm;
	}

}

