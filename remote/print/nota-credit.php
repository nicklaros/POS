<?php

use ORM\CreditQuery;
use ORM\CreditPaymentQuery;
use ORM\OptionQuery;
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
    <title>Print Nota Piutang <?php echo $id; ?></title>
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
    
    $credit = CreditQuery::create()
        ->filterByStatus('Active')
        ->filterById($id)
        ->useSalesQuery()
            ->leftJoin('SecondParty')
            ->withColumn('SecondParty.Id', 'second_party_id')
            ->withColumn('SecondParty.Name', 'second_party_name')
            ->withColumn('Sales.Date', 'date')
        ->endUse()
        ->select(array(
            'id',
            'sales_id',
            'total',
            'second_party_id',
            'second_party_name',
            'date'
        ))
        ->findOne($con);

    if(!$credit) throw die('Data tidak ditemukan.');

    $credit = (object) $credit;

    $payment = CreditPaymentQuery::create()
        ->filterByStatus('Active')
        ->filterByCreditId($credit->id)
        ->withColumn('SUM(Paid)', 'total_paid')
        ->select(array(
            'total_paid'
        ))
        ->findOne($con);

    $credit->paid = $payment;
    $credit->balance = $credit->total - $credit->paid;
    $credit->status = ($credit->balance <= 0 ? 'Lunas' : $credit->balance);
    $credit->cash_back = ($credit->balance < 0 ? abs($credit->balance) : '-');
    
    $creditPayments = CreditPaymentQuery::create()
        ->filterByStatus('Active')
        ->filterByCreditId($id)
        ->leftJoin('Cashier')
        ->withColumn('Cashier.Id', 'cashier_id')
        ->withColumn('Cashier.Name', 'cashier_name')
        ->select(array(
            'id',
            'date',
            'paid',
            'cashier_name'
        ))
        ->orderBy('date', 'ASC')
        ->find($con);
?>

<div style="font-weight: bold; font-size: 15px; text-align: center;">
    <?php echo $info->client_name;?>
</div>
<div style="text-align: center;"><?php echo $info->client_address;?>. Telp <?php echo $info->client_phone;?></div>

<p>
    <table>
        <tr>
            <td width="100">Kode Piutang</td>
            <td>:</td>
            <td><?php echo $credit->id;?></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>:</td>
            <td><?php echo $credit->second_party_name;?></td>
        </tr>
        <tr>
            <td>Piutang</td>
            <td>:</td>
            <td><?php echo number_format($credit->total, 0, ',', '.');?></td>
        </tr>
        <tr>
            <td>Dibayar</td>
            <td>:</td>
            <td><?php echo number_format($credit->paid, 0, ',', '.');?></td>
        </tr>
        <tr>
            <td>Sisa Piutang</td>
            <td>:</td>
            <td><?php echo $credit->status;?></td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td>:</td>
            <td><?php echo $credit->cash_back;?></td>
        </tr>
    </table>
</p>
<p>
    <strong>Data Pembayaran</strong>
    <table cellspacing="0" cellpadding="2">
        <thead>
            <tr>
                <td width="100" class="left">Tanggal</td>
                <td width="100" class="right">Sebesar</td>
                <td width="200" class="right">Kasir</td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($creditPayments as $creditPayment) {
            $creditPayment = (object) $creditPayment;
            ?>
            <tr>
                <td class="left"><?php echo $creditPayment->date;?></td>
                <td class="right"><?php echo number_format($creditPayment->paid, 0, ',', '.');?></td>
                <td class="right"><?php echo $creditPayment->cashier_id . '. ' . $creditPayment->cashier_name;?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</p>
<div style="margin-top: 25px; text-align: center; font-size: 13px; font-weight: bold;">
    Terima Kasih Atas Kunjungan Anda
</div>
</body>
</html>