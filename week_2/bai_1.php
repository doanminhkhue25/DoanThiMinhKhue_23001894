<?php
class CartItem {
    private $name;
    private $price;
    private $quantity;

    public function __construct($name, $price, $quantity) {
        if ($price <= 0) {
            throw new Exception("Đơn giá phải lớn hơn 0.");
        }
        if ($quantity <= 0) {
            throw new Exception("Số lượng phải lớn hơn 0.");
        }
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName() {
        return $this->name;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getQuantity() {
        return $this->quantity;
    }

    public function getTotal() {
        return $this->price * $this->quantity;
    }
}

class ShoppingCart {
    private $items = [];

    public function addItem($item) {
        if ($item instanceof CartItem) {
            $this->items[] = $item;
            echo "<p>Đã thêm sản phẩm: " . $item->getName() . " vào giỏ hàng.</p>";
        } else {
            throw new Exception("Sản phẩm không tồn tại.");
        }
    }

    //Xóa sản phẩm khỏi giỏ hàng
    public function removeItem($itemName) {
        $found = false;
        foreach($this->items as $key => $item) {
            if ($item->getName() === $itemName) {
                unset($this->items[$key]);
                $this->items = array_values($this->items); // Reindex the array
                $found = true;
                echo "<p>Đã xóa sản phẩm: " . $itemName . " khỏi giỏ hàng.</p>";
                break;
            }
        }
        if (!$found) {
            echo "<p>Không tìm thấy sản phẩm " . $itemName . " trong giỏ hàng.</p>";
        }
    }

    public function calculateTotal() {
        $total = 0;
        if (empty($this->items)) {
            return $total;
        }
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }
    public function displayCart() {
        echo "\n--- DANH SÁCH GIỎ HÀNG ---\n";
        if (empty($this->items)) {
            echo "Giỏ hàng hiện đang trống.\n";
        } else {
            foreach ($this->items as $index => $item) {
                $stt = $index + 1;
                $name = $item->getName();
                $price = number_format($item->getPrice());
                $qty = $item->getQuantity();
                $total = number_format($item->getTotal());
                echo "<li>";
                echo "Tên: " . $name . " | ";
                echo "Đơn giá: " . $price . "đ | ";
                echo "Số lượng: " . $qty . " | ";
                echo "Thành tiền: " . $total . "đ";
                echo "</li>";
            }
        }
        
        // Hiển thị tổng tiền chung
        echo "=> TỔNG TIỀN GIỎ HÀNG: " . number_format($this->calculateTotal()) . "đ\n";
        echo "--------------------------\n\n";
    }
}

$cart = new ShoppingCart();
try {
    echo "<h3>Thêm sản phẩm vào giỏ hàng</h3>";
    $item1 = new CartItem("Laptop Dell", 15000000, 1);
    $item2 = new CartItem("Chuột không dây", 250000, 2);
    $item3 = new CartItem("Bàn phím cơ", 800000, 1);
    $item4 = new CartItem("Màn hình LG 24inch", 3000000, 2);
    $item5 = new CartItem("Tai nghe Bluetooth", 1200000, 1);
    $item6 = new CartItem("USB 16GB", 150000, 3);
    //$itemError = new CartItem("Ổ cứng SSD", -2000000, 1); // Giá âm, sẽ gây lỗi

    $cart->addItem($item1);
    $cart->addItem($item2);
    $cart->addItem($item3);
    $cart->addItem($item4);
    $cart->addItem($item5);
    $cart->addItem($item6);

    
} catch (Exception $e) {
    echo "<p>Lỗi: " . $e->getMessage() . "</p>";
}

//display cart
$cart->displayCart();

//remove item
$cart->removeItem("Chuột không dây");
$cart->displayCart();

//remove item that does not exist
$cart->removeItem("Bàn phím giả lập");
?>