<?php

#declare list of students
$students = [
    ["name" => "Nguyen Van An", "age" => 20, "score" => 8.5],
    ["name" => "Tran Thi Binh", "age" => 21, "score" => 6.5],
    ["name" => "Le Van Cuong", "age" => 19, "score" => 4.5],
    ["name" => "Pham Thi Dung", "age" => 20, "score" => 7.5]
];

#functions
function findBestStudent($students) { 
    if (empty($students)) return null;

    $bestStudent = $students[0]; 
    
    foreach ($students as $student) {
        if ($student['score'] > $bestStudent['score']) {
            $bestStudent = $student;
        }
    }
    return $bestStudent;
}

function findWorstStudent($students) {
    if (empty($students)) return null;

    $worstStudent = $students[0];
    
    foreach ($students as $student) {
        if ($student['score'] < $worstStudent['score']) {
            $worstStudent = $student;
    
        }
    }
    return $worstStudent;
}

function countPassedStudents($students) {
    $count = 0;
    foreach ($students as $student) {
        if ($student['score'] >=5 ) {
            $count += 1;
        }
    }

    return $count;
}

function findStudentByName($students, $name) {
    foreach ($students as $student) {
        if (strtolower($student['name']) == strtolower($name)) {
            return $student;
        }
    }
    return null;
}


#print
echo "<h3>Xử lý danh sách sinh viên:</h3>";
echo "<ul>";

$best = findBestStudent($students);
if ($best) {
    echo "<li><strong>Sinh viên điểm cao nhất:</strong> " . $best['name'] . " (" . $best['score'] . " điểm)</li>";
}

$worst = findWorstStudent($students);
if ($worst) {
    echo "<li><strong>Sinh viên điểm thấp nhất:</strong> " . $worst['name'] . " (" . $worst['score'] . " điểm)</li>";
}

$passedCount = countPassedStudents($students);
echo "<li><strong>Số lượng sinh viên đạt (>= 5 điểm):</strong> " . $passedCount . " sinh viên</li>";

$searchName = "Tran Thi Binh";
$foundStudent = findStudentByName($students, $searchName);

if ($foundStudent) {
    echo "<li><strong>Tìm thấy sinh viên:</strong> " . $foundStudent['name'] . " | Tuổi: " . $foundStudent['age'] . " | Điểm: " . $foundStudent['score'] . "</li>";
} else {
    echo "<li><strong>Không tìm thấy</strong> sinh viên có tên '$searchName'</li>";
}

echo "</ul>";

?>