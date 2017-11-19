<?php

namespace App\Command;

use Tarsana\Command\Command;

class DirectionCommand extends Command
{
    protected function execute()
    {
        // Данные считываются из специального файла в корне.
        $rows   = explode("\n", file_get_contents(ROOT . '/input'));
        $number = 0;

        do {
            $xDist = [];
            $yDist = [];

            // Первая цифра должна означать кол-во опрешенных в кейсе.
            $numberOfPeople = $rows[$number];
            if ($numberOfPeople == 0) {
                break;
            }

            $this->console->line("<info>Input:</info>\n" . $numberOfPeople);

            $number++;

            for ($i = 0; $i < $numberOfPeople; $i++) {
                $line = $rows[$number + $i];

                $this->console->line($line);

                $line = explode(' ', $line);

                $x     = $line[0];
                $y     = $line[1];
                $angle = $line[3];

                $numberLine = 4;

                do {
                    $command = $line[$numberLine];
                    $numberLine++;

                    if ($command == 'turn') {
                        $angle += $line[$numberLine];
                    } else {
                        $walk = $line[$numberLine];

                        $x += $walk * cos($angle * pi() / 180);
                        $y += $walk * sin($angle * pi() / 180);
                    }

                    $numberLine++;
                } while($numberLine < count($line));

                $xDist[] = $x;
                $yDist[] = $y;
            }

            // Подсчитываем средние координаты.
            $xAvg = array_sum($xDist) / $numberOfPeople;
            $yAvg = array_sum($yDist) / $numberOfPeople;

            // Находим наибольшее расстояние от средних координат.
            $maxDist = 0;
            for ($i = 0; $i < $numberOfPeople; $i++) {
                $dist = sqrt(pow($xAvg - $xDist[$i], 2) + pow($yAvg - $yDist[$i], 2));

                if ($maxDist < $dist) {
                    $maxDist = $dist;
                }
            }

            $this->console->out(
                sprintf("<success>Result:</success>\n%.2f %.2f %.2f\n", $xAvg, $yAvg, $maxDist)
            );

            $number += $numberOfPeople;
        } while($number < count($rows));
    }
}
