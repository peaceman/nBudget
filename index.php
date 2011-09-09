<?php
require_once 'Transaction.php';
require_once 'RecurringTransaction.php';
require_once 'BankAccount.php';
require_once 'TransactionCache.php';

$transaction = new Transaction(array(
					'value' => 1600,
				));
$recurringTransaction = new RecurringTransaction(array(	
							'interval' => new DateInterval('P1M'),
							'startDate' => new DateTime('2011-08-31'),
							'endDate' => new DateTime('2012-07-31'),
							'transaction' => $transaction,
						));
$recurringTransactions = array(
    new RecurringTransaction(array(
        'interval' => new DateInterval('P1M'),
        'startDate' => new DateTime('2011-08-29'),
        'endDate' => new DateTime('2012-07-31'),
        'transaction' => new Transaction(array('value' => -300)),
    )),
    new RecurringTransaction(array(
        'interval' => new DateInterval('P1M'),
        'startDate' => new DateTime('2011-08-29'),
        'endDate' => new DateTime('2012-07-31'),
        'transaction' => new Transaction(array('value' => -80)),
    )),
    $recurringTransaction,
);

$account = new BankAccount(array(
    'recurringTransactions' => $recurringTransactions
));

echo $account->getActualBalance() . PHP_EOL;
echo $account->getBalanceForDate(new DateTime('2012-01-01')) . PHP_EOL;
