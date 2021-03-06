<?php

/*
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

/** @var $credentials array */
/** @var $memoryQuota string */
global $credentials, $memoryQuota;

echo writeText('INFO', '46').'Getting Information from the Cluster via API....'.PHP_EOL;

$serverInfo = communicateCouchbase('pools/default', $credentials)['body'];

$memoryQuota = $serverInfo->memoryQuota;

communicateCouchbase('pools/default', $credentials, ['indexMemoryQuota' => ($memoryQuota / 8)]);

echo writeText('INFO', '46')."Your Cluster RAM size is: {$memoryQuota}MB.".PHP_EOL;
