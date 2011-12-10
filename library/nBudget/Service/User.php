<?php
/**
 * User: peaceman
 * Date: 10.12.11
 * Time: 13:16
 */
namespace nBudget\Service;

use nBudget\Entity;
use Bisna\Application\Container;

class User
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $em;

	public function __construct()
	{
		$this->em = \Zend_Registry::get('doctrine')->getEntityManager();
	}

	public function create(array $data)
	{
		static $requiredData = array(
			'username',
			'password',
			'email',
		);
		$checkResult = $this->_checkRequirements($data, $requiredData);
		if ($checkResult !== true) {
			$exceptionMessage = sprintf('Missing data in %s::%s (%s)',
				get_class($this),
				__METHOD__,
				implode(', ', $checkResult));
			throw new \RuntimeException($exceptionMessage);
		}

		$errors = array();
		$isUniqueEmail = $this->_isUniqueEmail($data['email']);
		$isUniqueUsername = $this->_isUniqueUsername($data['username']);
		if (!$isUniqueEmail)
			$errors['email'] = 'Given email address is already in use!';

		if (!$isUniqueUsername)
			$errors['username'] = 'Given username is already in use!';

		if (!empty($errors))
			return array(false, $errors);

		$user = new Entity\User;
		$user->username = $data['username'];
		$user->email = $data['email'];
		$user->password = sha1($data['password']);

		$this->em->persist($user);
		$this->em->flush();
		return array(true, $user);
	}

	public function update($id, $data)
	{

	}

	public function read(array $data)
	{

	}

	public function delete($id)
	{

	}

	/**
	 * Prüft ob das Array $data alle aus
	 * dem Array $requirements hervorgehenden
	 * Daten enthält. Im Fehlerfall wird ein Array
	 * bestehend aus den Schlüssels der fehlenden
	 * Daten zurückgegeben, ansonsten true.
	 *
	 * @param array $data
	 * @param array $requirements
	 * @return array|bool
	 */
	protected function _checkRequirements(array $data, array $requirements)
	{
		$missing = array();
		foreach ($requirements as $requirement) {
			if (!array_key_exists($requirement, $data))
				$missing[] = $requirement;
		}

		if (count($missing) > 0)
			return $missing;
		return true;
	}

	protected function _isUniqueEmail($email)
	{
		$qry = $this->em->createQuery('SELECT u.id FROM nBudget\Entity\User u WHERE u.email = :email');
		$qry->setParameter('email', $email);
		$result = $qry->getResult();

		return count($result) === 0;
	}

	protected function _isUniqueUsername($username)
	{
		$qry = $this->em->createQuery('SELECT u.id FROM nBudget\Entity\User u WHERE u.username = :username');
		$qry->setParameter('username', $username);
		$result = $qry->getResult();

		return count($result) === 0;
	}
}
