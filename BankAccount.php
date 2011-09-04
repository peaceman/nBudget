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

    private $transactionCache = array();

    private $balanceCache = array();

    public function getActualBalance()
    {
        return $this->getBalanceForDate(new DateTime);
    }

    public function getBalanceForDate(DateTime $time)
    {
        if (!isset($this->balanceCache[$time])) {
            $this->generateBalanceCacheForDate($time);
        }

        return $this->balanceCache[$time];
    }

    private function generateBalanceCacheForDate(DateTime $calculateUntil)
    {
        $this->makeSureThatTransactionCacheExists();

        $tmpBalance = 0;

        foreach ($this->transactionCache as $executionTime => $transaction) {
            if ($executionTime > $calculateUntil)
                break;

            if (is_array($transaction)) {
                foreach ($transaction as $subTransaction) {
                    $tmpBalance += $subTransaction->getValue();
                }
            } else {
                $tmpBalance += $transaction->getValue();
            }
        }

        $this->balanceCache[$calculateUntil] = $tmpBalance;
    }

    private function makeSureThatTransactionCacheExists()
    {
        if ($this->transactionCache !== null)
            return;

        $this->generateTransactionCache();
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
}
