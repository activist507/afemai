<?php 
  if(session_status() === PHP_SESSION_NONE){
    session_start();
  }
  include('../config/app.php');
  $result = array();
  function truncate(string $text, int $length = 30): string {
    if(strlen($text) <= $length){
      return $text;
    }
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    $text .= "...";
    return $text;
  }

  if(isset($_POST['type']) && $_POST['type'] == 'getItem'){
    $item_id = $_POST['item_id'];
    $res = $conq->query("SELECT * FROM items WHERE id = '$item_id'");
    $row = $res->fetch_object();
    $result['id'] = $row->id;
    $result['item_name'] = strtoupper(truncate($row->item_name));
    $result['left'] = ($row->qty);
    $result['price'] = ($row->selling_price);
    $result['category'] = ($row->category);
    $result['cost_price'] = ($row->cost_price);

    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type'] == 'submitSale'){
    $itemss = $_POST['itemss'];
    $payType = $_POST['payType'];
    $cname = $_POST['cname'];
    $seller = $_POST['seller'];
    $sellerCate = $_POST['sellerCate'];

    // <!--generating trx id NDC-00001 -->
      $res = $conq->query("SELECT trx_id FROM sales ORDER BY id DESC LIMIT 1");
      if($res->num_rows > 0){
        $row = $res->fetch_object();
        $exist = $row->trx_id;
        $arrExist = explode("-",$exist);
        $last = trim($arrExist[1]);
        $newDigi = (int)$last + 1;
        $trx_id = 'NDC-'.str_pad($newDigi, 5,'0',STR_PAD_LEFT);
      } else {
        $trx_id = 'NDC-00001';
      }
    // <!--END generating trx id -->

    $noOfItem = count($itemss);
    $date = date('Y-m-d');
    $recTotal = 0;

    //get the prev values
      $available = $conq->query("SELECT id,items,qty,sales_amount FROM sales_personnel WHERE userID = '$seller' AND salesdate = '$date'")->fetch_object();
      $_item_cnt = $available->items;
      $_qty = $available->qty;
      $_sales_amount = $available->sales_amount;
      $upID = $available->id;
    //get the prev values

    for($i = 0; $i < $noOfItem; $i++){
      $item = $itemss[$i]['value'];
      $itemarray = explode('/', $item);
      $itemID = $itemarray[0];
      $itemtotCost = $itemarray[1];
      $itemName = $itemarray[2];
      $itemRate = $itemarray[3];
      $itemQty = $itemarray[4];
      $icostPrice = $itemarray[5];
      $iCategory = $itemarray[6];
      $total_cost = ($icostPrice*$itemQty);
      $profit = $itemtotCost - $total_cost;
      $sql = $conq->query("INSERT INTO sales (trx_id,item_sold,qty,rate,total_cost,total_sale,profit,customer_name,date,processed_by,category,method_of_payment) 
      VALUES ('$trx_id','$itemName','$itemQty','$itemRate','$total_cost','$itemtotCost','$profit','$cname','$date','$seller','$iCategory','$payType')");
      if($sql){
        $res = $conq->query("SELECT * FROM items WHERE id = '$itemID'");
        $itemDb = $res->fetch_object();
        $oldqty = $itemDb->qty;
        $newQty = $oldqty - $itemQty;
        $_query = "UPDATE items SET qty='$newQty' WHERE id='$itemID'"; 
        $res_qry = $conq->query($_query);
        // <!--insert into summary -->
          if($res_qry){
            $summary = $conq->query("SELECT * FROM summary WHERE salesdate='$date' AND itemid='$itemID'")->fetch_object();
            if(isset($summary->id)){
              $sumID = $summary->id;
              $olddQty = $summary->soldqty;
              $olddAmt = $summary->amount;

              $newwQty =(float)$olddQty + (float)$itemQty;
              $newwAmt =(float)$olddAmt + (float)$itemtotCost;

              $sqlUpdate = $conq->query("UPDATE summary SET soldqty='$newwQty',amount='$newwAmt' WHERE id='$sumID'");

            } else {
              $sqlInsert = $conq->query("INSERT INTO summary SET salesdate='$date',itemid='$itemID',items='$itemName', soldqty='$itemQty',soldprice='$itemRate',amount='$itemtotCost',sellerid='$seller',department='$sellerCate'");
            }
          }
        // <!--END insert into summary -->
      } else {
        $result['msg'] = "Could not complete purchase";
        $result['status'] = "failed";
      }
      $recTotal += $itemtotCost;
      $_sales_amount += $itemtotCost;
      $_qty += $itemQty;
      $_item_cnt++;
    }

    // <!--insert into salesbyreceipt -->
      $qy = "INSERT INTO salesbyreceipts SET recno = '$trx_id',salesdate='$date',total='$recTotal',paid='$recTotal',personnel='$seller',paymentmethod='$payType',category='$sellerCate'";
      $resRefund = $conq->query($qy);
    // <!--END insert into salesbyreceipt -->

    // <!--update  sales_personnel -->
      $userUpd = $conq->query("UPDATE sales_personnel SET items ='$_item_cnt',qty='$_qty',sales_amount='$_sales_amount',salesconfirmed=0,salesclosed=0 WHERE id='$upID'");
    // <!--END update  sales_personnel -->

    $result['msg'] = "Purchase completed";
    $result['status'] = "succeeded";
    $result['trx_id'] = $trx_id;

    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type'] == 'submitUnprinted'){
    $trx_id = $_POST['trx_id'];
    $cname = $_POST['cname'];
    $seller = $_POST['seller'];
    $date = date('Y-m-d');
    $sql = $conq->query("INSERT INTO unprinted_receipt (trx_id,cname,processed_by,date) VALUES ('$trx_id','$cname','$seller','$date')");
    $result['msg'] = "success";
    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type'] == 'getSales'){
    $html = '';
    $sales = $conq->query("SELECT * FROM sales ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
    if(count($sales)>0){
      foreach($sales as $sale){
        $html .= '<tr>
          <td>'.$sale['item_sold'].'</td>
          <td>'.number_format($sale['qty']).'</td>
          <td>'.number_format($sale['rate']).'</td>
          <td>'.number_format($sale['total_sale']).'</td>
          <td>'.$sale['processed_by'].'</td>
        </tr>';
      }
      $result['html'] = $html;
      echo json_encode($result);
    }

  }


  if(isset($_POST['type']) && $_POST['type'] == 'paginateSales'){
    $html = '';
    $page = $_POST['page']; //page if clicked
    $limit = $_POST['limit']; //records per page
    $search = $_POST['search']; //if search was included
    $offset = ($page - 1) * $limit;

    $resultSales = $conq->query("SELECT COUNT(*) AS total FROM sales WHERE item_sold LIKE '%$search%' OR processed_by LIKE '%$search%'")->fetch_assoc();
    $totalRecords = $resultSales['total'];
    $totalPages = ceil($totalRecords / $limit);

    $sales = $conq->query("SELECT * FROM sales WHERE item_sold LIKE '%$search%' OR processed_by LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    if(count($sales)>0){
      foreach($sales as $sale){
        $html .= '<tr>
          <td>'.$sale['item_sold'].'</td>
          <td>'.number_format($sale['qty']).'</td>
          <td>'.number_format($sale['rate']).'</td>
          <td>'.number_format($sale['total_sale']).'</td>
          <td>'.$sale['processed_by'].'</td>
        </tr>';
      }
    } else {
      $html = '<tr><td colspan="5" class="no-data">No records found.</td></tr>';
    }
    $result['html'] = $html;
    $result['totalPages'] = $totalPages;
    $result['currentPage'] = $page;
    echo json_encode($result);
  }

  if(isset($_POST['type']) && $_POST['type'] == 'showFilter'){
    $filter = $_POST['filter'];
    $who = $_POST['who'];
    $role = $_POST['role'];
    if($filter == 'This Year'){
      $date = date('Y');
    } elseif($filter == 'This Month'){
      $date = date('Y-m');
    } else {
      $date = date('Y-m-d');
    }
    $filterType = $_POST['filterType'];
    if($filterType == 'sales'){
      if($role == 'Superadmin'|| $role == 'admin'){
        $sales = $conq->query("SELECT COUNT(*) AS saleCount FROM sales WHERE date LIKE '%$date%'")->fetch_assoc();
      } else {
        $sales = $conq->query("SELECT COUNT(*) AS saleCount FROM sales WHERE date LIKE '%$date%' AND processed_by ='$who' ")->fetch_assoc();
      }
      $result['total'] = number_format($sales['saleCount']);
    } else {
      if($role == 'Superadmin'|| $role == 'admin'){
        $sales = $conq->query("SELECT SUM(total_sale) AS total FROM sales WHERE date LIKE '%$date%'")->fetch_assoc();
      } else {
        $sales = $conq->query("SELECT SUM(total_sale) AS total FROM sales WHERE processed_by ='$who' AND date LIKE '%$date%'")->fetch_assoc();
      }
      $result['total'] = number_format($sales['total']);
    }

    echo json_encode($result);
  }


  if(isset($_POST['type']) && $_POST['type'] == 'paginateReceipt'){
    $html = '';
    $who = $_POST['who'];
    $role = $_POST['role'];
    $page = $_POST['page2']; //page if clicked
    $limit = $_POST['limit2']; //records per page
    $search = $_POST['search2']; //if search was included
    $offset = ($page - 1) * $limit;

    if($role == 'Superadmin'|| $role == 'admin'){
      $resultUnprinted = $conq->query("SELECT COUNT(*) AS total FROM unprinted_receipt WHERE (trx_id LIKE '%$search%' OR processed_by LIKE '%$search%') AND printed='0'")->fetch_assoc();
      $totalRecords = $resultUnprinted['total'];
      $totalPages = ceil($totalRecords / $limit);
  
      $unprinted_receipt = $conq->query("SELECT * FROM unprinted_receipt WHERE (trx_id LIKE '%$search%' OR processed_by LIKE '%$search%') AND printed = '0' LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    } else {
      $resultUnprinted = $conq->query("SELECT COUNT(*) AS total FROM unprinted_receipt WHERE trx_id LIKE '%$search%' AND printed='0' AND processed_by='$who'")->fetch_assoc();
      $totalRecords = $resultUnprinted['total'];
      $totalPages = ceil($totalRecords / $limit);
  
      $unprinted_receipt = $conq->query("SELECT * FROM unprinted_receipt WHERE trx_id LIKE '%$search%' AND printed = '0' AND processed_by='$who' LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);
    }

    if(count($unprinted_receipt)>0){
      $no = 1;
      foreach($unprinted_receipt as $unprint){
        $html .= '<tr>
          <th scope="row">'.$no.'</th>
          <td>'.strtoupper($unprint['cname']).'</td>
          <td>'.$unprint['trx_id'].'</td>
          <td>'.$unprint['date'].'</td>
          <td>
            <button class="btn btn-primary openPrint" 
              data-trx_id="'.$unprint['trx_id'].'" 
              data-cname="'.$unprint['cname'].'">
              <i class="bi bi-printer"></i>
            </button>
          </td>
        </tr>';
        $no++;
      }
    } else {
      $html = '<tr><td colspan="5" class="no-data">No records found.</td></tr>';
    }
    $result['html'] = $html;
    $result['totalPages'] = $totalPages;
    $result['currentPage'] = $page;
    // $result['cnt'] = count($unprinted_receipt);
    echo json_encode($result);
  }


  if(isset($_POST['type']) && $_POST['type'] == 'plotChart'){
    
    $pages=array(); $data=array();
		// $sdate=clean($_POST['sDate']);
		$sdate=$_POST['sDate'];
		$chartSel=clean($_POST['chart']);
		if(!empty($sdate)){
		  $sdate1=explode(';', $sdate);
			$date=explode('~', $sdate1[0]);
			$sdateTitle=$sdate1[1];
			
			if(count($date) == 1){
		    $chart=$conq->query("SELECT DISTINCT(date) AS date FROM sales WHERE date='".$date[0]."'  ORDER BY date ASC");
			}
			else{
		    $chart=$conq->query("SELECT DISTINCT(date) AS date FROM sales WHERE (date >= '".$date[0]."' AND date <= '".$date[1]."')  ORDER BY date ASC");
			}
		}
		else{
      $chart=$conq->query("SELECT DISTINCT(date) AS date FROM sales WHERE DATE_FORMAT(date, '%Y-%m')='".date('Y-m')."'  ORDER BY date ASC");
      $sdateTitle='This Month';
		}

    if(!$chart){
      $result['error']=$conq->error;
      $result['success']='false';
    }
    else{
      $j=1; $pages[0]='0'; $data[0]=0;
      if($chartSel == 'Line'){
        $pages[0]='0'; $data[0]=0;
      } else {
        $pages[0]='1'; $data[0]=1;
      }
      
      while($rowc=$chart->fetch_assoc()){
        $sqx=$conq->query("SELECT SUM(total_sale) AS tot FROM sales WHERE date='".$rowc['date']."' ");
        $rox=$sqx->fetch_assoc();
        $pages[$j] = sentence($rowc['date']);
        $data[$j] = $rox['tot'];
        $j++;
      }
      $result['sales']=$pages;
      $result['data']=$data;
      $result['title']=$sdateTitle;
      $result['success']='true';
    }
    echo json_encode($result); 
  }

  if(isset($_POST['type']) && $_POST['type'] == 'updatePermit'){
    $role = $_POST['role'];
    $user_permit = $conq->query("SELECT * FROM user_permit WHERE role='$role'")->fetch_object();
    
    $result['items_in_store'] = $user_permit->items_in_store;
    $result['refund'] = $user_permit->refund;
    $result['report'] = $user_permit->report;
    $result['create_user'] = $user_permit->create_user;
    $result['user_permission'] = $user_permit->user_permission;
    $result['userOnline'] = $user_permit->userOnline;

    echo json_encode($result);
  }

?>