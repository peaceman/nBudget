<?php
/**
 * User: peaceman
 * Date: 05.12.11
 * Time: 22:07
 */
namespace nBudget\Entity;

/**
 * @Table(name="user")
 * @Entity
 */
class User
{
	/**
	 * @Id
	 * @GeneratedValue(strategy="IDENTITY")
	 * @Column(name="id", type="integer", nullable="false")
	 * @var integer $id
	 */
	private $id;

	/**
	 * @Column(name="username", type="string", length="64", nullable="false")
	 * @var string $username
	 */
	private $username;

	/**
	 * @Column(name="password", type="string", length="40", nullable="false")
	 * @var string $password
	 */
	private $password;

	/**
	 * @Column(name="email", type="string", length="128", nullable="false")
	 * @var string $email;
	 */
	private $email;

	/**
	 * @var \Doctrine\Common\Collections\Collection $accounts
	 * @OneToMany(targetEntity="Account", mappedBy="user", cascade={"persist", "remove"})
	 */
	private $accounts;

	public function __get($property)
	{
		if (property_exists($this, $property))
			return $this->$property;

		return null;
	}

	public function __set($property, $value)
	{
		$this->$property = $value;
	}
}
