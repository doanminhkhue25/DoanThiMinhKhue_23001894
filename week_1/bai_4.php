<?php

#define class Student
class Student {
    private $name;
    private $age;
    private $score;

    public function __construct($name, $age, $score) {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    public function getRank() {
        if ($this->score >= 8) {
            return "Giỏi";
        } elseif ($this->score >= 6.5) {
            return "Khá";
        } elseif ($this->score >= 5) {
            return "Trung bình";
        } else {
            return "Yếu";
        }
    }

    public function isPassed() {
        return $this->score >= 5;
    }

    public function display() {
        echo "<li>";
        echo "Họ tên: " . $this->name . " | ";
        echo "Tuổi: " . $this->age . " | ";
        echo "Điểm: " . $this->score . " | ";
        echo "<strong>Xếp loại: " . $this->getRank() . "</strong>";
        echo "</li>";
    }

    public function getName() {
        return $this->name;
    }

    public function getScore() {
        return $this->score;
    }

}

#functions
function displayAllStudents($students) {
    echo "<ul>";
    foreach ($students as $student) {
        $student->display();
    }
    echo "</ul>";
}

function getBestStudent($students) {
    if (empty($students)) return null;

    $best = $students[0];
    foreach ($students as $student) {
        if ($student->getScore() > $best->getScore()) {
            $best = $student;
        }
    }
    return $best;
}

function countPassedStudents($students) {
    $count = 0;
    foreach($students as $student) {
        if ($student->isPassed()) {
            $count += 1;
        }
    }
    return $count;
}

function calculateAverage($students) {
    if (empty($students)) return 0;

    $total = 0;
    foreach ($students as $student) {
        $total += $student->getScore(); 
    }

    return $total / count($students);
}

#print
$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);

$studentsList = [$student1, $student2, $student3, $student4];

echo "<h3>1. Danh sách sinh viên:</h3>";
displayAllStudents($studentsList);

echo "<h3>2. Kết quả thống kê:</h3>";
echo "<ul>";

$bestStudent = getBestStudent($studentsList);
if ($bestStudent) {
    echo "<li><strong>Sinh viên điểm cao nhất:</strong> " . $bestStudent->getName() . " (" . $bestStudent->getScore() . " điểm)</li>";
}

$passed = countPassedStudents($studentsList);
echo "<li><strong>Số lượng sinh viên đạt:</strong> " . $passed . " sinh viên</li>";

$average = calculateAverage($studentsList);
echo "<li><strong>Điểm trung bình của lớp:</strong> " . $average . "</li>";

echo "</ul>";

?>