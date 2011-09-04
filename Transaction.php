<?php
class Transaction
{
	private $value;
	private $date;
	private	$sender;
	private $recipient;
	
	public function __construct(array $data = null)
	{
		if ($data !== null)
			$this->setData($data);
	}
	
	public function getValue()
	{
		return $this->value;
	}
	
	public function setValue($value)
	{
		if (!is_numeric($value)) {
			throw new InvalidArgumentException('Expected a number');
		}
		
		$this->value = $value;
	}
	
	public function getDate()
	{
		return $this->date;
	}
	
	public function setDate(DateTime $date)
	{
		$this->date = $date;
	}
	
	public function getSender()
	{
		return $this->sender;
	}
	
	public function setSender(BankAccount $account)
	{
		$this->sender = $account;
	}
	
	public function getRecipient()
	{
		return $this->recipient;
	}
	
	public function setRecipient(BankAccount $account)
	{
		$this->recipient = $account;
	}
	
	private function setData(array $data)
	{
		foreach ($data as $key => $value) {
			$methodName = 'set' . ucfirst(strtolower($key));
			if (method_exists($this, $methodName)) {
				$this->$methodName($value);
			} else {
				continue;
			}
		}
	}
}