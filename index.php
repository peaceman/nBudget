<?php
require_once 'Transaction.php';
require_once 'RecurringTransaction.php';

$transaction = new Transaction(array(
					'value' => 1600,
				));
$recurringTransaction = new RecurringTransaction(array(	
							'interval' => new DateInterval('P5D'),
							'startDate' => new DateTime('2011-08-01'),
							'endDate' => new DateTime('2012-07-31'),
							'transaction' => $transaction,
						));
foreach ($recurringTransaction->getAllTransactions() as $transaction) {
	echo $transaction->getDate() . PHP_EOL;
}