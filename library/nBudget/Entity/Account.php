<?php
/**
 * User: peaceman
 * Date: 05.12.11
 * Time: 22:51
 */
namespace nBudget\Entity;

/**
 * @Table(name="Account")
 * @Entity
 */
class Account
{
	/**
	 * @Id
	 * @GeneratedValue(strategy="IDENTITY")
	 * @Column(name="id", type="integer", nullable="false")
	 * @var integer $id
	 */
	private $id;

	/**
	 * @var User
	 * @ManyToOne(targetEntity="User")
	 */
	private $user;
}
