<?php
$name = "Nguyễn Văn A";
$score = 8.5;

if ($score >= 8) {
    $rank = "Gioi";
} elseif ($score >= 6.5) {
    $rank = "Kha";
} elseif ($score >= 5) {
    $rank = "Trung binh";
} else {
    $rank = "Yeu";
}

echo "Tên học sinh: " . $name . "<br>";
echo "Điểm: " . $score . "<br>";
echo "Xếp loại: " . $rank;
?>
