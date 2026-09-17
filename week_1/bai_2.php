<?php
function calculateAverageScore($students) {
    $numberOfStudents = count($students);

    if ($numberOfStudents == 0) {
        return 0;
    }

    $totalScore = 0;
    foreach ($students as $student) {
        $totalScore += $student['score'];
    }
    return $totalScore / $numberOfStudents;
}

function getRank($score) {
    if ($score >= 8) {
        return "Giỏi";
    } elseif ($score >= 6.5) {
        return "Khá";
    } elseif ($score >= 5) {
        return "Trung bình";
    } else {
        return "Yếu";
    }
}

function displayStudent($student) {
    $rank = getRank($student['score']);

    echo "<li>";
    echo "Họ tên: " . $student['name'] . ' | ';
    echo "Tuổi: " . $student['age'] . " | ";
    echo "Điểm: " . $student['score'] . " | ";
    echo "<strong>Xếp loại: " . $rank . "</strong>";
    echo "</li>";
}

$students = [
    ["name" => "Nguyen Van An", "age" => 20, "score" => 8.5],
    ["name" => "Tran Thi Binh", "age" => 21, "score" => 6.5],
    ["name" => "Le Van Cuong", "age" => 19, "score" => 4.5],
    ["name" => "Pham Thi Dung", "age" => 20, "score" => 7.5]
];


echo "<h3>Danh sách thông tin sinh viên kèm Xếp loại:</h3>";
echo "<ul>";

foreach ($students as $student) {
    displayStudent($student);
}

echo "</ul>";

$average = calculateAverageScore($students);
echo "<strong>Điểm trung bình của cả lớp là: " . $average . "</strong>";

?>