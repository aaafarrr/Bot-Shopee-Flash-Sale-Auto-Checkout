<?php
function tambah_keranjang($cookie = '', $shopid = 0, $itemid = 0, $modelid = 0, $add_on_deal_id = 0)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://shopee.co.id/api/v4/cart/add_to_cart');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

  $headers = array();
  $headers[] = $cookie;
  // $headers[] = 'Content-Length: 198';
  // $headers[] = 'Sec-Ch-Ua: "Chromium";v="105", "Not)A;Brand";v="8"';
  // $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
  $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.5195.102 Safari/537.36';
  // $headers[] = 'X-Api-Source: pc';
  // $headers[] = 'Accept: application/json';
  // $headers[] = 'X-Shopee-Language: id';
  // $headers[] = 'X-Requested-With: XMLHttpRequest';
  // $headers[] = 'If-None-Match-: 55b03-b600a6142d69bfdee6a1cef7d9a0f60f';
  $headers[] = 'Content-Type: application/json';
  // $headers[] = 'X-Csrftoken: nJ2103bjdLn8l0VywQzwz7h5y0vGC3YM';
  // $headers[] = 'Sec-Ch-Ua-Platform: "Windows"';
  // $headers[] = 'Origin: https://shopee.co.id';
  // $headers[] = 'Sec-Fetch-Site: same-origin';
  // $headers[] = 'Sec-Fetch-Mode: cors';
  // $headers[] = 'Sec-Fetch-Dest: empty';
  // $headers[] = 'Referer: https://shopee.co.id/';
  // $headers[] = 'Accept-Encoding: gzip, deflate';
  // $headers[] = 'Accept-Language: en-US,en;q=0.9';
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $dp = array();
  $dp['quantity'] = 1;
  $dp['checkout'] = true;
  $dp['update_checkout_only'] = true;
  $dp['donot_add_quantity'] = true;
  $dp['source'] = '{"refer_urls":[]}';
  // $dp['add_on_deal_id'] = 10837269;
  if ($add_on_deal_id != 0) {
    $dp['add_on_deal_id'] = $add_on_deal_id;
  }
  $dp['client_source'] = 1;
  $dp['shopid'] = intval($shopid);
  $dp['itemid'] = intval($itemid);
  $dp['modelid'] = intval($modelid);
  $data_post = json_encode($dp);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);

  $response = curl_exec($ch);
  return $response;
  curl_close($ch);
}

function harga_barang($shopid = 0, $itemid = 0, $modelid = 0)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://shopee.co.id/api/v4/product/get_purchase_quantities_for_selected_model?quantity=1&itemId=$itemid&modelId=$modelid&shopId=$shopid");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

  $response = curl_exec($ch);
  // echo $response."\n";
  // json decode
  $response = json_decode($response, true);
  // return isset($response['selected_price_and_stock']['display_price']) ? $response['selected_price_and_stock']['display_price'] : 999999999999999999999999;
  return isset($response['selected_price_and_stock']['display_price']) ? $response['selected_price_and_stock']['display_price'] : 999999999999999999999999;
  curl_close($ch);
}

function checkout($cookie = '', $addressid = 0, $ongkir = 0, $logisticid = 0, $harga_barang = 0, $modelid = 0, $itemgroupid = 0, $shopid = 0, $itemid = 0)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://shopee.co.id/api/v4/checkout/place_order');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

  $headers = array();
  $headers[] = 'Host: shopee.co.id';
  $headers[] = $cookie;
  // $headers[] = 'Content-Length: 4327';
  $headers[] = 'Sec-Ch-Ua: "Chromium";v="105", "Not)A;Brand";v="8"';
  // $headers[] = 'X-Cv-Id: 106';
  // $headers[] = 'X-Requested-With: XMLHttpRequest';
  // $headers[] = 'X-Sap-Access-F: 3.0.0.2.0|13|2.3.2-2_5.2.11_0_4327|186d8586faaf4496873ff1b6461d4b441e8985e29a8b40|10900|101';
  // $headers[] = 'X-Sz-Sdk-Version: 2.3.2-2';
  $headers[] = 'Content-Type: application/json';
  $headers[] = 'Accept: application/json';
  // $headers[] = 'X-Shopee-Language: id';
  $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
  // $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.5195.102 Safari/537.36';
  // user agent iphone app
  $headers[] = 'User-Agent: iPhone; iOS 14.4.2; Scale/3.00';
  // $headers[] = 'X-Sap-Access-T: 1663720932';
  $headers[] = 'X-Api-Source: pc';
  // $headers[] = 'X-Sap-Access-S: rr2gjXicy8gqzY7VxV6st_klswET2bh8PG7XNo0vzqs=';
  $headers[] = 'X-Csrftoken: mjKlqhcHfJUpMVLzy8MuFHdVVrKYUwrW';
  $headers[] = 'Sec-Ch-Ua-Platform: "iPhone"';
  $headers[] = 'Origin: https://shopee.co.id';
  $headers[] = 'Sec-Fetch-Site: same-origin';
  $headers[] = 'Sec-Fetch-Mode: cors';
  $headers[] = 'Sec-Fetch-Dest: empty';
  $headers[] = 'Referer: https://shopee.co.id/checkout/';
  $headers[] = 'Accept-Encoding: gzip, deflate';
  $headers[] = 'Accept-Language: en-US,en;q=0.9';

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $data_post = '{"client_id":0,"cart_type":0,"timestamp":1665895325,"checkout_price_data":{"merchandise_subtotal":9850000000,"shipping_subtotal_before_discount":1500000000,"shipping_discount_subtotal":0,"shipping_subtotal":1500000000,"tax_payable":0,"tax_exemption":0,"custom_tax_subtotal":0,"promocode_applied":null,"credit_card_promotion":null,"shopee_coins_redeemed":null,"group_buy_discount":0,"bundle_deals_discount":null,"price_adjustment":null,"buyer_txn_fee":0,"buyer_service_fee":100000000,"insurance_subtotal":0,"insurance_before_discount_subtotal":0,"insurance_discount_subtotal":0,"vat_subtotal":0,"total_payable":11350000000},"order_update_info":{},"dropshipping_info":{"enabled":false,"name":"","phone_number":""},"promotion_data":{"can_use_coins":true,"use_coins":false,"platform_vouchers":[],"free_shipping_voucher_info":{"free_shipping_voucher_id":0,"free_shipping_voucher_code":"","disabled_reason":null,"banner_info":{"msg":"","learn_more_msg":""},"required_be_channel_ids":[],"required_spm_channels":[]},"highlighted_platform_voucher_type":-1,"shop_voucher_entrances":[{"shopid":59414059,"status":true}],"applied_voucher_code":null,"voucher_code":null,"voucher_info":{"coin_earned":0,"voucher_code":null,"coin_percentage":0,"discount_percentage":0,"discount_value":0,"promotionid":0,"reward_type":0,"used_price":0},"invalid_message":"","price_discount":0,"coin_info":{"coin_offset":0,"coin_used":0,"coin_earn_by_voucher":0,"coin_earn":0},"card_promotion_id":null,"card_promotion_enabled":false,"promotion_msg":""},"selected_payment_channel_data":{"version":2,"option_info":"","channel_id":8005200,"channel_item_option_info":{"option_info":"89052007"},"additional_info":{"reason":"","channel_blackbox":"{}"},"text_info":{}},"shoporders":[{"shop":{"shopid":59414059,"shop_name":"Seller Name","cb_option":false,"is_official_shop":true,"remark_type":0,"support_ereceipt":false,"seller_user_id":37148060,"shop_tag":1},"items":[{"itemid":19440657315,"modelid":212066725378,"quantity":1,"item_group_id":null,"insurances":[],"shopid":59414059,"shippable":true,"non_shippable_err":"","none_shippable_reason":"","none_shippable_full_reason":"","price":9850000000,"name":"Product Name","model_name":"","add_on_deal_id":0,"is_add_on_sub_item":false,"is_pre_order":false,"is_streaming_price":false,"image":"IMGProduct","checkout":true,"categories":[{"catids":[0]}],"is_spl_zero_interest":false,"is_prescription":false,"channel_exclusive_info":{"source_id":0,"token":""},"offerid":0,"supports_free_returns":false}],"tax_info":{"use_new_custom_tax_msg":false,"custom_tax_msg":"","custom_tax_msg_short":"","remove_custom_tax_hint":false},"tax_payable":0,"shipping_id":1,"shipping_fee_discount":0,"shipping_fee":1500000000,"order_total_without_shipping":9850000000,"order_total":11350000000,"buyer_remark":"","ext_ad_info_mappings":[]}],"shipping_orders":[{"shipping_id":1,"shoporder_indexes":[0],"selected_logistic_channelid":8003,"selected_preferred_delivery_time_option_id":0,"buyer_remark":"","buyer_address_data":{"addressid":7171131,"address_type":0,"tax_address":""},"fulfillment_info":{"fulfillment_flag":64,"fulfillment_source":"","managed_by_sbs":false,"order_fulfillment_type":2,"warehouse_address_id":0,"is_from_overseas":false},"order_total":11350000000,"order_total_without_shipping":9850000000,"selected_logistic_channelid_with_warning":null,"shipping_fee":1500000000,"shipping_fee_discount":0,"shipping_group_description":"","shipping_group_icon":"","tax_payable":0,"is_fsv_applied":false,"prescription_info":{"images":null,"required":false,"max_allowed_images":5}}],"fsv_selection_infos":[],"buyer_info":{"share_to_friends_info":{"display_toggle":false,"enable_toggle":false,"allow_to_share":false},"kyc_info":null,"checkout_email":""},"client_event_info":{"is_platform_voucher_changed":false,"is_fsv_changed":false},"buyer_txn_fee_info":{"title":"Biaya Penanganan","description":"Besar biaya penanganan adalah Rp0 dari total transaksi.","learn_more_url":""},"disabled_checkout_info":{"description":"","auto_popup":false,"error_infos":[]},"can_checkout":true,"buyer_service_fee_info":{"learn_more_url": "https://shopee.co.id/m/biaya-layanan"},"__raw":{},"_cft":[188011],"captcha_version":1,"device_info":{"device_sz_fingerprint":"29KT42sFLmywobisZQnXeA==|viOYU14GtBS8/gIWMuFCc+8Hk0f3H+4Wc2LuxNVqe1oBCXQnc4Z7s9WmjF2US9kKknYv5ioR4ukrLzE8QO77t+wHluxYkyOrV1AlUQ==|oy3cSXiII7o5kRZA|06|3"}}';
  $dp = json_decode($data_post);

  // $ongkir = $dp->checkout_price_data->shipping_subtotal;
  // $biaya_tambahan = $dp->checkout_price_data->buyer_txn_fee;
  // $biaya_tambahan = $dp->checkout_price_data->buyer_service_fee;
  // $addressid = $dp->shipping_orders[0]->buyer_address_data->addressid;

  $pajak = $dp->checkout_price_data->buyer_txn_fee;
  $layanan = $dp->checkout_price_data->buyer_service_fee;

  // $biaya_tambahan = 100000000;

  $total = intval($harga_barang + $ongkir + $pajak + $layanan);

  $dp->timestamp = time();
  $dp->checkout_price_data->merchandise_subtotal = $harga_barang;
  $dp->checkout_price_data->shipping_subtotal_before_discount = $ongkir;
  $dp->checkout_price_data->shipping_subtotal = $ongkir;
  $dp->checkout_price_data->buyer_txn_fee = $pajak;
  $dp->checkout_price_data->total_payable = $total;

  $dp->shoporders[0]->items[0]->modelid = $modelid;
  $dp->shoporders[0]->items[0]->item_group_id = $itemgroupid;
  $dp->shoporders[0]->items[0]->price = $harga_barang;

  $dp->shipping_orders[0]->buyer_address_data->addressid = $addressid;
  $dp->shipping_orders[0]->order_total = intval($harga_barang + $ongkir);
  $dp->shipping_orders[0]->order_total_without_shipping = $harga_barang;
  $dp->shipping_orders[0]->shipping_fee = $ongkir;
  $dp->shipping_orders[0]->selected_logistic_channelid = $logisticid;

  $dp->shoporders[0]->shipping_fee = $ongkir;
  $dp->shoporders[0]->order_total_without_shipping = $harga_barang;
  $dp->shoporders[0]->order_total = intval($harga_barang + $ongkir);

  $dp->promotion_data->shop_voucher_entrances[0]->shopid = $shopid;
  $dp->shoporders[0]->shop->shopid = $shopid;
  $dp->shoporders[0]->items[0]->shopid = $shopid;

  $dp->shoporders[0]->items[0]->itemid = $itemid;

  $data_post = json_encode($dp);

  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
  $response = curl_exec($ch);

  return $response;
  curl_close($ch);
}
