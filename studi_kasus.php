<?php
session_start();

// Inisialisasi array transaksi jika belum ada
if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

// Fungsi untuk menghitung total penjualan
function calculateTotalSales($transactions) {
    $total_sales = 0;
    foreach ($transactions as $trans) {
        $total_sales += $trans['total'];
    }
    return $total_sales;
}

// Tampilkan form dan laporan penjualan
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan Toko</title>
</head>
<body>
    <h1>Form Data Penjualan</h1>
    <form action="" method="POST">
        <label for="product_name">Nama Produk:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="price">Harga:</label>
        <input type="number" id="price" name="price" required><br><br>

        <label for="quantity">Jumlah Terjual:</label>
        <input type="number" id="quantity" name="quantity" required><br><br>

        <input type="submit" value="Simpan Data">
    </form>

    <?php
    // Ambil data dari form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        // Simpan transaksi dalam array asosiatif
        $transaction = [
            'product_name' => $product_name,
            'price' => $price,
            'quantity' => $quantity,
            'total' => $price * $quantity
        ];

        // Tambahkan transaksi ke dalam session
        $_SESSION['transactions'][] = $transaction;
    }

    // Tampilkan laporan penjualan
    if (isset($_SESSION['transactions']) && count($_SESSION['transactions']) > 0) {
        ?>
        <h1>Laporan Penjualan</h1>
        <table border="1">
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah Terjual</th>
                <th>Total</th>
            </tr>
            <?php foreach ($_SESSION['transactions'] as $trans): ?>
            <tr>
                <td><?php echo htmlspecialchars($trans['product_name']); ?></td>
                <td><?php echo htmlspecialchars($trans['price']); ?></td>
                <td><?php echo htmlspecialchars($trans['quantity']); ?></td>
                <td><?php echo htmlspecialchars($trans['total']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h2>Total Penjualan: <?php echo calculateTotalSales($_SESSION['transactions']); ?></h2>
        <?php
    }
    ?>
</body>
</html>