<?php
require_once 'helpers.php';
require_once 'student.php';
require_once 'arrival.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Príchody študentov</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>


<body>
    <div class="container w-50 ">
        <form method="post" action="">
            <label for="name" class="form-label">Meno študenta</label>
            <div class="input-group mb-3">
                <input type="text" name="name" class="form-control w-75" id="name" aria-describedby="emailHelp">
                <input type="submit" value="Pridať príchod" name="addStudent" class="btn btn-primary">
            </div>
        </form>

        <?php
        $arrivals = new Arrivals();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['name']) && isset($_POST['addStudent'])) {
                echo $arrivals->logArrival();
                Student::logStudent($_POST['name']);
            }
            if (empty($_POST['name']) && isset($_POST['addStudent'])) {
                echo '<div class="alert alert-danger" role="alert">Vyplňte pole pre meno študenta</div>';
            }
            if (isset($_POST["markLateArrivals"])) {
                $arrivals->markLateArrivals();
            }
            if (isset($_POST["usePrintR"])) {
                echo "<pre>";
                print_r(Student::getStudents());
                echo "</pre>";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['name'])) {
            $studentName = $_GET['name'];
            if (!empty($studentName)) {
                echo $arrivals->logArrival();
                Student::logStudent($studentName);
            }
        }

        ?>
        <div class="row">
            <div class="col-sm-2">
                <form method="post" action="">
                    <input type="submit" value="Označiť meškania" name="markLateArrivals" class="btn btn-secondary">
                </form>
            </div>
            <div class="col-sm-2">
                <form method="post" action="">
                    <input type="submit" value="Print študentov cez print_r" name="usePrintR" class="btn btn-secondary">
                </form>
            </div>

        </div>
        <hr />
        <div class="row">
            <div class="table-responsive col-md-7">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Čas príchodu</th>
                            <th scope="col">Poznámka</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $arrivalsArr = $arrivals->getArrivals();
                        foreach ($arrivalsArr as $key => $arrival) { ?>
                            <tr>
                                <td><?= $arrival['dateTime']; ?></td>
                                <td> <?php if (!empty($arrival['note'])) { ?>
                                        <?= $arrival['note']; ?>
                                    <?php }  ?>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1"></div>
            <div class="table-responsive col-md-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Meno</th>
                            <th scope="col">Počet príchodov</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $students = Student::getStudents();
                        foreach ($students as $key => $student) { ?>
                            <tr>
                                <td><?= $student['name']; ?></td>
                                <td><?= $student['arrivalCount']; ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <hr>


</body>

</html>