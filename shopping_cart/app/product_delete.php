<?php

require_once "model/product.php";

$id = $_GET["id"] ?? null;

if ($id === null || !filter_var($id, FILTER_VALIDATE_INT)) {
    die("ID sản phẩm không hợp lệ.");
}

$product = getProductById($id);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    deleteProduct($id);

    header("Location: product_list.php");
    exit;
}

require_once "view/header.php";
?>

<h2>Xóa sản phẩm</h2>

<p>
    Bạn có chắc chắn muốn xóa sản phẩm này không?
</p>

<p>
    <strong>
        <?= htmlspecialchars($product["name"]) ?>
    </strong>
</p>

<p>
    Giá: <?= $product["price"] ?>
</p>

<p>
    Số lượng: <?= $product["quantity"] ?>
</p>

<form method="POST">

    <button type="submit">
        Có, xóa sản phẩm
    </button>

    <a href="product_list.php">
        Hủy
    </a>

</form>

<?php require_once "view/footer.php"; ?>
