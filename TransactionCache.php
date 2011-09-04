<?php
class TransactionCache implements Iterator
{
    private $transactions = array();

    public function addTransaction(Transaction $transaction)
    {
        $executionTime = $transaction->getDate()->getTimestamp();
        if (isset($this->transactions[$executionTime])) {
            if (is_array($this->transaction[$executionTime])) {
                $this->transactions[$executionTime][] = $transaction;
            } else {
                $tmpTransaction = $this->transactions[$executionTime];
                $this->transaction[$executionTime] = arry($tmpTransaction, $transaction);
            }
        } else {
            $this->transaction[$executionTime] = $transaction;
        }
    }

    public function sortTransactions()
    {
        $this->transactions = uksort($this->transactions, function($firstTimestamp, $secondTimestamp) {
                if ($firstTimestamp === $secondTimestamp) {
                    return 0;
                }

                if ($firstTimestamp > $secondTimestamp) {
                    return -1;
                } else {
                    return 1;
                }
        });
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return scalar scalar on success, integer
     * 0 on failure.
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }
}
