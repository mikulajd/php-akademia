<?php
class Helpers
{
    public static function getArrayFromJsonFile(string $fileName): array
    {
        if (!file_exists($fileName)) {
            return array();
        }
        if (filesize($fileName) > 0) {
            $array = json_decode(file_get_contents($fileName), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return array();
            } else {
                return $array;
            }
        }
        return array();
    }

    public static function dateTimeToSeconds(DateTime $dateTime): int
    {
        $hours = intval($dateTime->format("G"));
        $minutes = intval($dateTime->format("i"));
        $seconds = intval($dateTime->format("s"));
        return $hours * 60 * 60 + $minutes * 60 + $seconds;
    }
}
