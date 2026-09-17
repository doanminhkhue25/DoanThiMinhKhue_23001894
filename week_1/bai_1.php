<?php
$students = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

$totalScore = 0;
$numberOfStudents = count($students);

echo "<h3>Students' information list:</h3>";
echo "<ul>";

foreach ($students as $student) {
    echo "<li>";
    echo "Name: " . $student['name'] . " | ";
    echo "Age: " . $student['age'] . " | ";
    echo "Score: " . $student['score'];
    echo "</li>";

    $totalScore += $student['score'];
}

echo "</ul>";

if ($numberOfStudents > 0) {
    $averageScore = $totalScore / $numberOfStudents;
    echo "<strong>Average score: " . $averageScore . "</strong>";
} else {
    echo "List of students is empty.";
}

?>