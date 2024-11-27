<?php
define("LOG_FILE", "datetime_log.txt");
function logDate(DateTime $arrivalDateTime, bool $isLate)
{
    $formattedDate =  $arrivalDateTime->format("D d. F Y - H:i:s") . ($isLate ? " - meskanie" : "");
    echo "Aktualny prichod: " . $formattedDate . "<br><br><br>";
    file_put_contents(LOG_FILE, $formattedDate . PHP_EOL, FILE_APPEND);
}

function getLogs()
{
    $file =  fopen(LOG_FILE, "r");
    if (!$file) {
        die("Nie su zaevidovane ziadne prichody");
    };
    echo "Vsetky prichody: <br>";
    while (($line = fgets($file, 4096)) !== false) {
        echo  $line . "<br>";
    }
    fclose($file);
}

function dateTimeToSeconds(DateTime $dateTime): int
{
    $hours = intval($dateTime->format("G"));
    $minutes = intval($dateTime->format("i"));
    $seconds = intval($dateTime->format("s"));
    return $hours * 60 * 60 + $minutes * 60 + $seconds;
}

function studentArrival()
{

    $currentDate = new DateTime();
    $timeInSeconds = dateTimeToSeconds($currentDate);
    if ($timeInSeconds >= 20 * 60 * 60 && $timeInSeconds <= 24 * 60 * 60) {
        die("Prichody v casoch medzi 20:00 a 24:00 nie je mozne zapisat");
    }
    $isLate = $timeInSeconds > 8 * 60 * 60;
    logDate($currentDate, $isLate);
}
?>

<!DOCTYPE html>
<html>

<body>
    <?php
    studentArrival();
    getLogs(); ?>
</body>

</html>