<?php
class BankAccount
{
    /**
     * @var Transaction[]
     */
    private $transactions = array();

    /**
     * @var RecurringTransaction[]
     */
    private $recurringTransactions = array();

    private $transactionCache;

    private $balanceCache = array();

    public function __construct(array $data = null)
    {
        if ($data !== null)
            $this->setData($data);
    }

    private function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            if (method_exists($this, $methodName))
                $this->$methodName($value);
        }
    }

    public function getActualBalance()
    {
        return $this->getBalanceForDate(new DateTime);
    }

    public function getBalanceForDate(DateTime $time)
    {
        if (!isset($this->balanceCache[$time->getTimestamp()])) {
            $this->generateBalanceCacheForDate($time);
        }

        return $this->balanceCache[$time->getTimestamp()];
    }

    private function generateBalanceCacheForDate(DateTime $calculateUntil)
    {
        $this->makeSureThatTransactionCacheExists();

        $tmpBalance = 0;
        foreach ($this->transactionCache as $executionTime => $transaction) {
            if ($executionTime > $calculateUntil->getTimestamp())
                break;

            if (is_array($transaction)) {
                foreach ($transaction as $subTransaction) {
                    $tmpBalance += $subTransaction->getValue();
                }
            } else {
                $tmpBalance += $transaction->getValue();
            }
        }

        $this->balanceCache[$calculateUntil->getTimestamp()] = $tmpBalance;
    }

    private function makeSureThatTransactionCacheExists()
    {
        if ($this->transactionCache !== null)
            return;

        $this->generateTransactionCache();
        $this->transactionCache->sortTransactions();
    }

    private function generateTransactionCache()
    {
        $this->transactionCache = new TransactionCache;

        foreach ($this->transactions as $transaction) {
            $this->transactionCache->addTransaction($transaction);
        }

        foreach ($this->recurringTransactions as $recurringTransaction) {
            foreach ($recurringTransaction->getAllTransactions() as $transaction) {
                $this->transactionCache->addTransaction($transaction);
            }
        }
    }

    public function setRecurringTransactions(array $transactions)
    {
        $this->recurringTransactions = $transactions;
    }
}
