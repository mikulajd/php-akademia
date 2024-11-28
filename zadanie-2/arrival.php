<?php
require_once "helpers.php";
define("ARRIVALS_FILE", "arrivals.json");
class Arrivals
{
    function logArrival()
    {
        $arrivals = Helpers::getArrayFromJsonFile(ARRIVALS_FILE);
        $currentDateTime = new DateTime();
        $timeInSeconds = $this->dateTimeToSeconds($currentDateTime);
        if ($timeInSeconds >= 20 * 60 * 60 && $timeInSeconds <= 24 * 60 * 60) {
            return  "<p><strong> Prichody v casoch medzi 20:00 a 24:00 nie je mozne zapisat </strong></p>";
        }
        $arrivals[] = array('dateTime' => $currentDateTime->format("D d. F Y - H:i:s"));
        file_put_contents(ARRIVALS_FILE, json_encode($arrivals, JSON_PRETTY_PRINT));
        return "<p><strong> Prichod bol zaznamenany </strong></p>";
    }


    function markLateArrivals()
    {
        $arrivals = Helpers::getArrayFromJsonFile(ARRIVALS_FILE);
        $mappedArrivals = array_map(
            function ($arrival) {
                $timeString = $arrival["dateTime"];
                $time = DateTime::createFromFormat("D d. F Y - H:i:s", $timeString);
                if (!$time) return $arrival;
                $timeInSeconds = $this->dateTimeToSeconds($time);
                $arrival['note'] = $this->isLate($timeInSeconds) ? "Meškanie" : "";
                return  $arrival;
            },
            $arrivals
        );
        file_put_contents(ARRIVALS_FILE, json_encode($mappedArrivals, JSON_PRETTY_PRINT));
    }

    function getArrivals(): array
    {
        return Helpers::getArrayFromJsonFile(ARRIVALS_FILE);
    }


    private function isLate(int $timeInSeconds): bool
    {
        return $timeInSeconds > 8 * 60 * 60;
    }
    private  function dateTimeToSeconds(DateTime $dateTime): int
    {
        $hours = intval($dateTime->format("G"));
        $minutes = intval($dateTime->format("i"));
        $seconds = intval($dateTime->format("s"));
        return $hours * 60 * 60 + $minutes * 60 + $seconds;
    }
}
