<?php

declare(strict_types=1);

namespace Cron;

use InvalidArgumentException;

/**
 * CRON field factory implementing a flyweight factory.
 *
 * @see http://en.wikipedia.org/wiki/Cron
 */
class FieldFactory
{
    /**
     * @var array Cache of instantiated fields
     */
    private $fields = [];

    /**
     * Get an instance of a field object for a cron expression position.
     *
     * @param int $position CRON expression position value to retrieve
     *
     * @throws InvalidArgumentException if a position is not valid
     *
     * @return FieldInterface
     */
    public function getField(int $position): FieldInterface
    {
        if (!isset($this->fields[$position])) {
            switch ($position) {
                case 0:
                    $this->fields[$position] = new MinutesField();

                    break;
                case 1:
                    $this->fields[$position] = new HoursField();

                    break;
                case 2:
                    $this->fields[$position] = new DayOfMonthField();

                    break;
                case 3:
                    $this->fields[$position] = new MonthField();

                    break;
                case 4:
                    $this->fields[$position] = new DayOfWeekField();

                    break;
                case 5:
                    $this->fields[$position] = new SecondField();

                    break;
                default:
                    throw new InvalidArgumentException(
                        ($position + 1) . ' is not a valid position'
                    );
            }
        }

        return $this->fields[$position];
    }
}
