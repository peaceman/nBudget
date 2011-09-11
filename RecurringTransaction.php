<?php	
class RecurringTransaction 
{
    /**
     * @var Transaction
     */
	private $transaction;

    /**
     * @var DateTime
     */
	private $startDate;

    /**
     * @var DateTime
     */
	private $endDate;

    /**
     * @var DateInterval
     */
	private $interval;
	
	public function __construct(array $data = null)
	{
		if ($data !== null)
			$this->setData($data);
	}

	private function setData(array $data)
	{
		foreach ($data as $key => $value) {
			$methodName = 'set' . ucfirst($key);
			if (method_exists($this, $methodName)) {
				$this->$methodName($value);
			}
		}
	}
	
	public function setTransaction(Transaction $transaction)
	{
		$this->transaction = $transaction;
	}
	
	public function setStartDate(DateTime $date)
	{
		$this->startDate = $date;
	}
	
	public function setEndDate(DateTime $date)
	{
		$this->endDate = $date;
	}
	
	public function setInterval(DateInterval $interval)
	{
		$this->interval = $interval;
	}
	
	public function getTransaction()
	{
		return $this->transaction;
	}
	
	public function getStartDate()
	{
		return $this->startDate;
	}
	
	public function getEndDate()
	{
		return $this->endDate;
	}
	
	public function getInterval()
	{
		return $this->interval;
	}
	
	public function getTransactionsForDateRange(DateTime $rangeStart, DateTime $rangeEnd)
	{
		if ($this->interval === null)
			throw new RuntimeException('Couldn´t calculate transactions for a specific date range if no interval is set');
			
		$period = new DatePeriod($rangeStart, $this->interval, $rangeEnd);
		$toReturn = array();
		
		foreach ($period as $dateTime) {
			$tmpTransaction = clone $this->transaction;
			$tmpTransaction->setDate($dateTime);
			$toReturn[] = $tmpTransaction;
		}
		
		return $toReturn;
	}
	
	public function getAllTransactions()
	{
		if ($this->startDate === null || $this->endDate === null)
			throw new RuntimeException('Couldn´t calculate all transactions, when there is no start and end date defined');
			
		return $this->getTransactionsForDateRange($this->startDate, $this->endDate);
	}
}
