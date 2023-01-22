<?php

date_default_timezone_set('Asia/Jakarta');
include 'base.php';

// ===============================
// BOT SHOPEE AUTO CHECKOUT
// === ON DEVELOPMENT ===
// BY : Farh (github.com/aaafarrr)
// ===============================
echo "Masukan Cookie: ";
$cookie = trim(fgets(STDIN));
echo "Masukan AddressID: ";
$addressid = trim(fgets(STDIN));
echo "Masukan ShopID: ";
$shopid = trim(fgets(STDIN));
echo "Masukan ItemID: ";
$itemid = trim(fgets(STDIN));

echo "Masukan ModelID: ";
$modelid = trim(fgets(STDIN));
$modelid = explode(",", $modelid);

echo "Masukan ItemGroupID: ";
$itemgroupid = trim(fgets(STDIN));
$itemgroupid = explode(",", $itemgroupid);

echo "Masukan AddOnDealID: ";
$add_on_deal_id = trim(fgets(STDIN));
$add_on_deal_id = explode(",", $add_on_deal_id);

echo "Masukan PaymentID: ";
$paymentid = trim(fgets(STDIN));
echo "Masukan DeliveryID: ";
$deliveryid = trim(fgets(STDIN));
echo "Masukan Harga Ongkir: ";
$ongkir = intval(trim(fgets(STDIN))) * 100000;

echo "Mode Test? (0 = OFF, 1 = ON): ";
$test = trim(fgets(STDIN));

echo "Max Execute: ";
$max_execute = trim(fgets(STDIN));

echo "Skip Cart? (0 = OFF, 1 = ON): ";
$skip_cart = trim(fgets(STDIN));

echo  "Jasa Kirim? (1 = REGULER, 2 = HEMAT, 3 = KARGO): ";
$jasa_kirim = trim(fgets(STDIN));

echo "Timer? (0 = OFF, 1 = ON): ";
$timer = trim(fgets(STDIN));
echo "Masukkan Jam Mulai: ";
$jam = trim(fgets(STDIN));
echo "Masukkan Menit Mulai: ";
$menit = trim(fgets(STDIN));
echo "Masukkan Detik Mulai: ";
$detik = trim(fgets(STDIN));

if ($test == 1) {
  $batas_harga = 100000 * 100000 * 10000000000000;
} else {
  $batas_harga = 10000 * 100000;
}

if ($jasa_kirim == 1) {
  $logisticid = 8003;
} else if ($jasa_kirim == 2) {
  $logisticid = 8005;
} else if ($jasa_kirim == 3) {
  $logisticid = 8006;
} else {
  $logisticid = 0;
}

// TIMER
$waktu = $jam . ':' . $menit . ':' . $detik;
$waktu = strtotime($waktu);
$selisih = $waktu - time();
$selisih = $selisih - 1;
$jam = floor($selisih / (60 * 60));
$sisa = $selisih % (60 * 60);
$menit = floor($sisa / 60);
$sisa = $sisa % 60;
$detik = floor($sisa);

// mulai hitung mundur
if ($selisih > 0) {
  while (true) {
    if ($timer == 0) {
      break;
    }
    sleep(1);
    $detik--;
    if ($detik < 0) {
      $detik = 59;
      $menit--;
    }
    if ($menit < 0) {
      $menit = 59;
      $jam--;
    }
    if ($jam < 0) {
      break;
    }
    echo "Waktu Hitung Mundur: $jam:$menit:$detik \r";
  }
}

$n = 1;
while (true) {
  for ($i = 0; $i <= (count($modelid) - 1); $i++) {
    $modelid_loop = $modelid[$i];
    // echo $modelid_loop;
    $itemgroupid_loop = $itemgroupid[$i];
    $harga_barang = harga_barang($shopid, $itemid, $modelid_loop);

    if ($harga_barang <= $batas_harga) {
      $now = date('Y-m-d H:i:s');
      echo "\n>> Harga Barang : Rp. $harga_barang (" . $now . ")\n";
      $n = 1;
      while (true) {
        if ($skip_cart == 0) {
          $res_tambah_keranjang = tambah_keranjang($cookie, $shopid, $itemid, $modelid_loop);
          // json decode
          $res_tambah_keranjang = json_decode($res_tambah_keranjang, true);
        }
        if ((isset($res_tambah_keranjang['error']) && $res_tambah_keranjang['error'] == 0) || $skip_cart == 1) {
          echo "\n>> Sukses Tambah Keranjang!, Percobaan (" . $n++ . ") \n";
          $n = 1;
          while (true) {
            if ($n == $max_execute) {
              exit();
            }
            $res_checkout = checkout($cookie, $addressid, $ongkir, $logisticid, $harga_barang, $modelid_loop, $itemgroupid_loop, $shopid, $itemid);
            echo "\n";
            print_r($res_checkout);
            echo "\n\n";

            $res_checkout = json_decode($res_checkout, true);

            if (isset($res_checkout['checkoutid']) && $res_checkout['checkoutid'] != '') {
              echo "\n>> Success Checkout, Percobaan (" . $n++ . ") \n";
              exit();
            } else {
              echo "xx Failed Checkout, Coba Lagi (" . $n++ . ") \r";
              // print_r($res_checkout);
            }
          }
        } else {
          echo "xx Gagal Tambah Keranjang!, Coba Lagi (" . $n++ . ") \r";
          // print_r($res_tambah_keranjang);
        }
      }
    } else {
      echo "xx Harga Barang : Rp. $harga_barang, Coba Lagi (" . $n++ . ") \r";
    }
  }
}

exit();


// === DEV ===
// MAKE OOP
// ADD CHECK INFO ACCOUNT
// ADD CHECK INFO ITEM
// SAVE ALL INPUT TO FILE
