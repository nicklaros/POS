<?php

use ORM\OptionQuery;
use ORM\SalesQuery;
use ORM\SalesDetailQuery;
use Propel\Runtime\Propel;

require '../../vendor/autoload.php';
require '../propel-config.php';
require '../session.php';

if (!$session->get('pos/state') === 1) die('Akses ditolak. Anda belum masuk.');

$con = Propel::getConnection('pos');
$con->beginTransaction();

$id = (isset($_GET['id']) ? $_GET['id'] : die('Missing Parameter.'));

// Get application info from database
$info = [];
$options = OptionQuery::create()
    ->filterByName([
        'app_name',
        'app_photo',
        'dev_name',
        'dev_email',
        'dev_phone',
        'dev_website',
        'dev_address',
        'client_name',
        'client_email',
        'client_phone',
        'client_website',
        'client_address',
        'homepath'
    ])
    ->find($con);

foreach($options as $row){
    $info[$row->getName()] = $row->getValue();
}

$info = (object) $info;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Print Nota <?php echo $id; ?></title>
    <link rel="stylesheet" type="text/css" href="print.css">
</head>
<script>
    setTimeout(function(){
        window.print();
        window.close();
    }, 10)
</script>
<body>
<?php
    $sales = SalesQuery::create()
        ->leftJoin('SecondParty')
        ->leftJoin('Cashier')
        ->filterByStatus('Active')
        ->filterById($id)
        ->select(array(
            'id',
            'date',
            'total_price',
            'paid',
            'note'
        ))
        ->withColumn('SecondParty.Name', 'second_party_name')
        ->withColumn('Cashier.Id', 'cashier_id')
        ->withColumn('Cashier.Name', 'cashier_name')
        ->findOne($con);

    if(!$sales) throw die('Data tidak ditemukan.');
    
    $sales = (object) $sales;

    $salesDetails = SalesDetailQuery::create()
        ->filterBySalesId($sales->id)
        ->filterByStatus('Active')
        ->select(array(
            'amount',
            'unit_price',
            'discount',
            'total_price'
        ))
        ->useStockQuery()
            ->leftJoin('Product')
            ->leftJoin('Unit')
            ->withColumn('Product.Name', 'product_name')
            ->withColumn('Unit.Name', 'unit_name')
        ->endUse()
        ->find($con);
?>

<div style="font-weight: bold; font-size: 15px; text-align: center;">
    <?php echo $info->client_name;?>
</div>
<div style="text-align: center;"><?php echo $info->client_address;?>. Telp <?php echo $info->client_phone;?></div>

<p>
    <table>
        <tr>
            <td width="100">Kode Nota</td>
            <td>:</td>
            <td><?php echo $sales->id;?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?php echo $sales->date;?></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>:</td>
            <td><?php echo $sales->second_party_name;?></td>
        </tr>
    </table>
</p>
<p>
    <table cellspacing="0" cellpadding="2">
        <thead>
        <tr>
            <td width="200">Produk</td>
            <td width="120" class="left"></td>
            <td width="30" class="right"></td>
            <td width="50" class="right">Harga</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($salesDetails as $salesDetail) {
            $salesDetail = (object) $salesDetail;
            ?>
            <tr>
                <td><?php echo $salesDetail->product_name;?></td>
                <td class="left"><small><?php echo $salesDetail->amount . ' ' . $salesDetail->unit_name . ' x ' . number_format($salesDetail->unit_price, 0, ',', '.');?></small></td>
                <td class="right" style="font-size: 8px;"><?php echo $salesDetail->discount;?>%</td>
                <td class="right"><?php echo number_format($salesDetail->total_price, 0, ',', '.');?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" class="right">Total</td>
            <td style="text-align: right; border-top: 1px solid black;"><?php echo number_format($sales->total_price, 0, ',', '.');?></td>
        </tr>
        <tr>
            <td colspan="3" class="right">Dibayar</td>
            <td style="text-align: right"><?php echo number_format($sales->paid, 0, ',', '.');?></td>
        </tr>
        <tr>
            <td colspan="3" class="right">Kembali</td>
            <td style="text-align: right; border-top: 1px solid black;"><?php echo number_format(($sales->paid - $sales->total_price), 0, ',', '.');?></td>
        </tr>
        </tbody>
    </table>
</p>
<div style="margin-top: 25px; text-align: center; font-size: 13px; font-weight: bold;">
    Terima Kasih Atas Kunjungan Anda
</div>
<div style="text-align: center;"><small>Kasir: <?php echo $sales->cashier_id . '. ' . $sales->cashier_name; ?></small></div>
</body>
</html>