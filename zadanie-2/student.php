<?php
require_once 'helpers.php';
define("STUDENTS_FILE", "studenti.json");

class Student
{
    public static function logStudent(string $studentName)
    {
        $students =  Helpers::getArrayFromJsonFile(STUDENTS_FILE);
        $foundKey = null;
        foreach ($students as $key => $student) {
            if ($student['name'] === $studentName) {
                $foundKey  = $key;
                break;
            }
        }

        if ($foundKey !== null) {
            $students[$foundKey]['arrivalCount']++;
        } else {
            $students[] = array('name' => $studentName, 'arrivalCount' => 1);
        }
        file_put_contents(STUDENTS_FILE, json_encode($students, JSON_PRETTY_PRINT));
    }

    public static function getStudents(): array
    {
        return Helpers::getArrayFromJsonFile(STUDENTS_FILE);
    }
}
