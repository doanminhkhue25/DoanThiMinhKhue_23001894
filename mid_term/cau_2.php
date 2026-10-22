
<?php
// 1. Khai bao mang gia san pham
$prices = [50, 100, 250, 150, 500, 300];

// 2. Ham tinh tong gia san pham
function calculateTotal($prices) {
    $total = 0;

    foreach ($prices as $price) {
        $total += $price;
    }

    return $total;
}

// 3. Ham tim gia san pham cao nhat
function findMaxPrice($prices) {
    $max = $prices[0];

    foreach ($prices as $price) {
        if ($price > $max) {
            $max = $price;
        }
    }

    return $max;
}

// 4. Goi hai ham
$total = calculateTotal($prices);
$maxPrice = findMaxPrice($prices);

// 5. Hien thi ket qua
echo "Tong gia san pham: " . $total . "<br>";
echo "Gia san pham cao nhat: " . $maxPrice;
?>
