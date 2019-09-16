PHP Cron Expression Parser ( Not Official Repository)
==========================

This is a fork from [dragonmantank/cron-expression](https://github.com/dragonmantank/cron-expression) with added not standard expression for Seconds. This is mainly used for [Fcron](https://github.com/montalvof/fcron) scheduling support for seconds.


Installing
==========

Add the dependency to your project:

```bash
composer require carlossosa88/cron-expression
```

Usage
=====
```php
<?php

require_once '/vendor/autoload.php';

// Works with predefined scheduling definitions
$cron = Cron\CronExpression::factory('@daily');
$cron->isDue();
echo $cron->getNextRunDate()->format('Y-m-d H:i:s');
echo $cron->getPreviousRunDate()->format('Y-m-d H:i:s');

// Works with complex expressions
$cron = Cron\CronExpression::factory('3-59/15 6-12 */15 1 2-5');
echo $cron->getNextRunDate()->format('Y-m-d H:i:s');

// Calculate a run date two iterations into the future
$cron = Cron\CronExpression::factory('@daily');
echo $cron->getNextRunDate(null, 2)->format('Y-m-d H:i:s');

// Calculate a run date relative to a specific time
$cron = Cron\CronExpression::factory('@monthly');
echo $cron->getNextRunDate('2010-01-12 00:00:00')->format('Y-m-d H:i:s');
```

Usage (Seconds)
=
```php
<?php

// Run a task every 5 seconds
$e = CronExpression::factory('* * * * * */5');
$this->assertTrue(
    $e->isDue(
        new DateTime('2014-04-07 00:00:05'), // Instance of datetime or 'now'
        null, // Time zone
        false // Drop seconds? Drop seconds parameter have to be set to FALSE, otherwise the default behavior is to reset to 0 current seconds 
    )
);

// Run a task on seconds 0,5,10,20
$e = CronExpression::factory('* * * * * 0,5,10,20');
$this->assertSame('2018-04-07 00:00:20',
    $e->getNextRunDate('2018-04-07 00:00:13', 0, false, null, false)
        ->format('Y-m-d H:i:s')
);
```

CRON Expressions
================

A CRON expression is a string representing the schedule for a particular command to execute.  The parts of a CRON schedule are as follows:

    *    *    *    *    *    *
    -    -    -    -    -    -
    |    |    |    |    |    |
    |    |    |    |    |    +- seconds (0 - 59)
    |    |    |    |    +------ day of week (0 - 7) (Sunday=0 or 7)
    |    |    |    +----------- month (1 - 12)
    |    |    +---------------- day of month (1 - 31)
    |    +--------------------- hour (0 - 23)
    +-------------------------- min (0 - 59)

This library also supports a few macros:

* `@yearly`, `@annually` - Run once a year, midnight, Jan. 1 - `0 0 1 1 *`
* `@monthly` - Run once a month, midnight, first of month - `0 0 1 * *`
* `@weekly` - Run once a week, midnight on Sun - `0 0 * * 0`
* `@daily` - Run once a day, midnight - `0 0 * * *`
* `@hourly` - Run once an hour, first minute - `0 * * * *`

Requirements
============

- PHP 7.1+
- PHPUnit is required to run the unit tests
- Composer is required to run the unit tests

Projects that Use cron-expression
=================================
* Part of the [Laravel Framework](https://github.com/laravel/framework/)
* Available as a [Symfony Bundle - setono/cron-expression-bundle](https://github.com/Setono/CronExpressionBundle)
