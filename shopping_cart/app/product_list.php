<?php

require_once "model/product.php";

$products = getAllProducts();

require_once "view/header.php";
?>

<h2>Danh sách sản phẩm</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Chức năng</th>
    </tr>

    <?php foreach ($products as $product): ?>

        <tr>

            <td>
                <?= $product['id'] ?>
            </td>

            <td>
                <?= htmlspecialchars($product['name']) ?>
            </td>

            <td>
                <?= $product['price'] ?>
            </td>

            <td>
                <?= $product['quantity'] ?>
            </td>

            <td>

                <a href="product_edit.php?id=<?= $product['id'] ?>">
                    Sửa
                </a>

                |

                <a href="product_delete.php?id=<?= $product['id'] ?>">
                    Xóa
                </a>

            </td>

        </tr>

    <?php endforeach; ?>

</table>

<?php

require_once "view/footer.php";
?>