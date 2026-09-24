<?php
class Movie {
    private $id;
    private $title;
    private $price;
    private $totalSeats;
    private $availableSeats;

    public function __construct($id, $title, $price, $totalSeats) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats; // Initialize available seats to total seats
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getTotalSeats() {
        return $this->totalSeats;
    }
    
    //book tickets for the movie
    public function bookTickets($quantity) {
        if ($quantity <= 0) {
            echo "<p>[!] LỖI ĐẶT VÉ ({$this->title}): Số lượng đặt phải lớn hơn 0 (Yêu cầu: $quantity).</p>";
            return false;
        }
        if ($quantity > $this->availableSeats) {
            echo "<p>[!] LỖI ĐẶT VÉ ({$this->title}): Không đủ ghế! Bạn đặt $quantity nhưng chỉ còn {$this->availableSeats} ghế.</p>";
            return false;
        }
        $this->availableSeats -= $quantity;
        echo "<p>[+] THÀNH CÔNG: Đã đặt $quantity vé cho phim '{$this->title}'.</p>";
        return true;
    }
    //cancel booked tickets for the movie
    public function cancelTickets($quantity) {
        if ($quantity <= 0) {
            echo "<p>[!] LỖI HỦY VÉ ({$this->title}): Số lượng hủy phải lớn hơn 0 (Yêu cầu: $quantity).</p>";
            return false;
        }
        $soldSeats = $this->getSoldSeats();
        if ($quantity > $soldSeats) {
            echo "<p>[!] LỖI HỦY VÉ ({$this->title}): Bạn đang cố gắng hủy $quantity vé nhưng chỉ có $soldSeats vé đã bán.</p>";
            return false;
        }
        $this->availableSeats += $quantity;
        echo "<p>[+] THÀNH CÔNG: Đã hủy $quantity vé cho phim '{$this->title}'.</p>";
        return true;
    }
    //get the number of sold seats for the movie
    public function getSoldSeats() {
        return $this->totalSeats - $this->availableSeats;
    }
    //get the revenue generated from sold tickets for the movie
    public function getRevenue() {
        return $this->getSoldSeats() * $this->price;
    }
    //display the information of the movie
    public function displayInfo() {
        echo "<li>";
        echo "ID: " . $this->id . " | ";
        echo "Tên phim: " . $this->title . " | ";
        echo "Giá vé: " . number_format($this->price) . "đ | ";
        echo "Tổng số ghế: " . $this->totalSeats . " | ";
        echo "Số ghế còn trống: " . $this->availableSeats . " | ";
        echo "Số ghế đã bán: " . $this->getSoldSeats() . " | ";
        echo "Doanh thu: " . number_format($this->getRevenue()) . "đ";
        echo "</li>";
    }
}

//Functions

//find a movie by its ID 
function findMovieById($movies, $id) {
    if (empty($movies)) {
        echo "<p>[!] LỖI: Danh sách phim trống.</p>";
        return null;
    }
    foreach ($movies as $movie) {
        if ($movie->getId() === $id) {
            return $movie;
        }
    }
    echo "<p>[!] LỖI: Không tìm thấy phim với ID: $id.</p>";
    return null; // Return null if movie not found
}

//get the total revenue from all movies
function getTotalRevenue($movies) {
    if (empty($movies)) {
        echo "<p>[!] LỖI: Danh sách phim trống. Tổng doanh thu: 0đ.</p>";
        return 0;
    }
    $totalRevenue = 0;
    foreach ($movies as $movie) {
        $totalRevenue += $movie->getRevenue();
    }
    return $totalRevenue;
}

//find the most popular movie based on the number of sold tickets
function getBestSellingMovie($movies) {
    if (empty($movies)) {
        echo "<p>[!] LỖI: Danh sách phim trống. Không thể xác định phim bán chạy nhất.</p>";
        return null;
    }
    $bestSellingMovie = null;
    $maxSoldSeats = -1;
    foreach ($movies as $movie) {
        if ($movie->getSoldSeats() > $maxSoldSeats) {
            $maxSoldSeats = $movie->getSoldSeats();
            $bestSellingMovie = $movie;
        }
    }
    return $bestSellingMovie;
}

//main
echo "<h1>QUẢN LÝ RẠP CHIẾU PHIM</h1>";
echo "<h3>=== KHỞI TẠO DANH SÁCH PHIM ===</h3>";
$movies = [
    new Movie(1, "The Shawshank Redemption", 100000, 100),
    new Movie(2, "The Godfather", 120000, 80),
    new Movie(3, "The Dark Knight", 90000, 150),
    new Movie(4, "Pulp Fiction", 110000, 90),
    new Movie(5, "Forrest Gump", 95000, 120)
];

echo "Rạp chiếu phim hiện có " . count($movies) . " bộ phim.\n\n";
foreach ($movies as $movie) {
    $movie->displayInfo();
}

echo "<h3>=== GIAO DỊCH ĐẶT/HỦY VÉ HỢP LỆ ===</h3>";
$shawshank = findMovieById($movies, 1);
$godfather = findMovieById($movies, 2);
$pulpfiction = findMovieById($movies, 4);
$darkknight = findMovieById($movies, 3);
$forrestgump = findMovieById($movies, 5);

if ($shawshank) $shawshank->bookTickets(30);

if ($godfather) $godfather->bookTickets(70); 

if ($pulpfiction) $pulpfiction->bookTickets(50);

if ($pulpfiction) $pulpfiction->cancelTickets(10);

echo "<h3>=== GIAO DỊCH ĐẶT/HỦY VÉ KHÔNG HỢP LỆ ===</h3>";

//check if quantity is smaller than or equal to 0
if ($shawshank) $shawshank->bookTickets(-2);

//check if quantity is greater than available seats
if ($godfather) $godfather->bookTickets(30);

//check if cancel quantity is smaller than or equal to 0
if ($pulpfiction) $pulpfiction->cancelTickets(0);

//check if cancel quantity is greater than sold seats
if ($darkknight) $darkknight->cancelTickets(10);

//check if movie ID does not exist
$nonExistentMovie = findMovieById($movies, 999);
if ($nonExistentMovie === null) {
    echo "<p>[-] Thông báo: Không tìm thấy phim có ID là 999.</p>";
}

//check: call functions with empty movie list
$emptyMovies = [];
echo "<h3>=== KIỂM TRA VỚI DANH SÁCH PHIM TRỐNG ===</h3>";
findMovieById($emptyMovies, 1);
getTotalRevenue($emptyMovies);
getBestSellingMovie($emptyMovies);

echo "<h3>=== BÁO CÁO THÔNG TIN CÁC PHIM ===</h3>";
//display information of all movies
foreach ($movies as $movie) {
    $movie->displayInfo();
}

//display total revenue from all movies
echo "<h3>\n=> TỔNG DOANH THU TOÀN RẠP: " . number_format(getTotalRevenue($movies)) . "đ</h3>";

//display the best-selling movie
$bestSellingMovie = getBestSellingMovie($movies);
if ($bestSellingMovie) {
    echo "<p>=> PHIM BÁN CHẠY NHẤT: " . $bestSellingMovie->getTitle() . " với " . $bestSellingMovie->getSoldSeats() . " vé đã bán.</p>";
} else {
    echo "<p>=> KHÔNG CÓ PHIM BÁN CHẠY NHẤT.</p>";
}

?>