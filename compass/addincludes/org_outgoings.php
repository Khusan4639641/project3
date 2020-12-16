<?php include_once("../DB/functions.php"); ?>
<?php 

  // if ($session_role !== 'Admin' OR $session_role !== 'Direktor') {
  //   $_SESSION['xabar'] = 'xato';
  //  header("Location: index.php");
  // }

?>
<?php
  if (isset($_GET['orgid']) ) {
    $storage = 2;
    $org_id = $_GET['orgid'];
    $org_id = mysqli_real_escape_string($connection, $org_id);
    $org_search = "SELECT * FROM buyers WHERE buyers_id = '$org_id'";
    $org_tanlov = mysqli_query($connection, $org_search);
    if ($org_id == 10) {
     die("Iltimos kiritilayotgan ma'lumotni aniqlab, qayta urinib koring!"); 
    }
    $storage_search = "SELECT * FROM storages WHERE storage_id = '$storage'";
    $storage_tanlov = mysqli_query($connection, $storage_search);
    if ($storage_tanlov) {
      $storage_result = mysqli_fetch_array($storage_tanlov);
      $storage_name = $storage_result['storage_name'];
    }
    
    if (!$org_tanlov OR !$storage_tanlov) {
      die("Tashkilotni va omborni qidirishda xatolik");
    }
    else {
      $count = mysqli_num_rows($org_tanlov);
      $count_storage = mysqli_num_rows($storage_tanlov);
    }

    if ($count == 1 AND $count_storage == 1) {
      while ($row = mysqli_fetch_assoc($org_tanlov)) {
        $tashkilot_id = $row["buyers_id"];
        $tashkilot_ismi = $row['buyers_name'];
        $tashkilot_byudjeti = $row['buyers_budget'];
        $tashkilot_safety = $row['buyers_safety'];
      }
      if ($tashkilot_safety == 2) {
        $safety = 'success';
      }
      elseif ($tashkilot_safety == 1) {
        $safety = 'warning';
      }
      else {
        $safety = 'error';
      }
    }
    else {
      die("Kiritilayotgan ma'lumotni qayta tekshirib amalga oshiring!");
    }
  }
  else {
    $_SESSION['xabar'] = 'xato';
    header("Location: index.php");
  }
 ?>
<form role="form" method="post"  onkeypress="return event.keyCode != 13;" action="analyzer.php" class="form-horizontal form-groups-bordered order">
  <ol class="breadcrumb hidden-print">
    <li><a href="organizations.php">Tashkilotlar boshqaruvi</a></li>
    <li><a href="#"><?php echo $tashkilot_ismi; ?></a></li>
    <li><a href="#">Chiqim</a></li>
  </ol>
  <br>
  <div class="row hidden-print">
    <h2 class="text-center"><?php echo $tashkilot_ismi; ?></h2>
      <?php
      $func = new database_func();
      ?>
      <?
      $sorov="select max(saved_times),buyer_id from saved INNER JOIN buyers ON buyers.buyers_id=saved.buyer_id WHERE buyer_id=".$_GET['orgid'];
      $func->queryMysql($sorov);
      $row=$func->result->fetch_array(MYSQL_ASSOC);
      ?>
      <?
      if($row['max(saved_times)']>0){
        ?>
        <h3 class="text-center tabel">Tabel №: <? echo $row['buyer_id']."-".($row['max(saved_times)']); ?></h3>
      <?}else{?>
        <h3 class="text-center tabel">Tabel №: <? echo $_GET['orgid']; ?></h3>
      <?}?>
      <br>
    <div class="col-sm-6">
      <input id="user_name" class="form-control" type="text" name="user_name" placeholder="Ismi.."/>
    </div>
    <div class="col-sm-6">
      <input class="form-control" type="text" name="tell_num" placeholder="Telefon nomer.."/>
    </div>
    <div class="clearfix"></div><br>
    <div class="col-md-12">
      <textarea rows="3" class="form-control" id="field-ta" type="text" name="desc" placeholder="Qabul qilingan maxsulotlar.."></textarea>
    </div>
  </div><br>
  <!-- Start Services Rows -->
  <?php if ($session_role == 'Direktor') {
  		$hidden = "hidden";
  		} else {
  			$hidden = "";
  		}
   ?>
  <fieldset for="services" id="services" class="servicefield" <?=$hidden?>>
    <legend class="hidden-print servicelegend" onclick="Xcode(1)">Xizmatlar</legend>
    <div class="table-responsive">
      <input placeholder="Scan barcode here..." type="text" onkeypress="autoCode1(value)" value="" id="code1" class="code form-control">
      <table class="table sr-table item-table table-bordered table-striped">
        <thead>
          <tr>
            <th class="col-sm-1">#</th>
            <th class="col-sm-4">Ismi</th>
            <th class="col-sm-2">Narxi</th>
            <th class="col-sm-2">Soni</th>
            <th class="col-sm-2">Qiymati</th>
            <th class="col-sm-1 hidden-print">-</th>
          </tr>
        </thead>
      <tbody></tbody>
      <tfoot>
      <tr class="hidden-print">
        <td colspan="3">
          <div class="input-group pull-left">
            <a href="#" onclick="return false;" id="sr_add" class="btn btn-success btn-lg btn-icon icon-left">
              Xizmat qo'shish
            <i class="entypo-plus-squared"></i></a>
          </div>
        </td>
        <td colspan="3">
          <div class="input-group pull-right">
            <input id="sr_subtotal" type="number" class="form-control input-lg bold subtotal" name="service[subtotal]" disabled>
            <div class="input-group-addon servicecolor">Xizmatlar qiymati:</div>
          </div>
        </td>
      </tr>
      </tfoot>
    </table>
  </div>
  </fieldset>
  <!-- End Services Row -->

  <!-- Start Products Rows -->
  <fieldset for="products" class="productsfield" id="products">
    <legend class="hidden-print productlegend" onclick="Xcode(2)">Mahsulotlar</legend>
    <div class="table-responsive">
<!--      autofocus-->
      <input placeholder="Scan barcode here..." type="text" onkeypress="autoCode(value)" value="" id="code" class="code form-control">
      <table class="table pr-table item-table table-bordered table-striped">
        <thead>
        <tr>
          <th class="col-sm-1">#</th>
          <th class="col-sm-4">Ismi</th>
          <th class="col-sm-2">Narxi</th>
          <th class="col-sm-2">Soni</th>
          <th class="col-sm-2">Qiymati</th>
          <th class="col-sm-1 hidden-print">-</th>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
        <tr class="hidden-print">
          <td colspan="3">
            <div class="input-group pull-left">
              <a href="#" onclick="return false;" id="pr_add" class="btn btn-info btn-lg btn-icon icon-left">
                Mahsulot qo'shish
                <i class="entypo-plus-squared"></i></a>
            </div>
          </td>
          <td colspan="3">
            <div class="input-group pull-right">
              <input id="pr_subtotal" type="number" class="form-control input-lg bold subtotal" name="product[subtotal]" disabled>
              <div class="input-group-addon productcolor">Mahsulotlar qiymati:</div>
            </div>
          </td>
        </tr>
        </tfoot>
      </table>
    </div>
  </fieldset>
  <!-- End Products Row -->
  
  <div class="row">
    <div class="col-md-6">
      <div class="input-group pull-left hidden-print">
        <input type="number"  class="form-control bold input-lg input-md" disabled placeholder="<?php echo number_format($tashkilot_byudjeti); ?>">
          <input type="hidden" id="org_summa" value="<?php echo $tashkilot_byudjeti; ?>">
          <input type="hidden" name="session_name" value="<?php echo $session_name ?>">
        <div class="input-group-addon dollar">Tashkilot byudjeti:</div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="input-group pull-left">
        <input id="total" type="number" class="form-control bold input-lg number" name="total" readonly>
        <div class="input-group-addon dollar">Umumiy qiymat:</div>
      </div>
    </div>
  </div><br>

  <div class="row">
    <div class="col-md-6">
      <div class="input-group pull-left hidden-print">
        <input type="date" class="form-control input-lg" data-validate="required" name="date">
        <div class="input-group-addon">
          <a href="#"><i class="entypo-calendar"></i></a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="input-group pull-left">
        <? if($tashkilot_byudjeti<=0){ ?>
        <input id="price1" readonly onkeyup="createKech(value)" type="number" class="form-control bold input-lg number" required name="prices3">
        <?}else{?>
          <input id="price1" onkeyup="createKech(value)" type="number" class="form-control bold input-lg number" required name="prices3">
          <?}?>
        <div class="input-group-addon payment">Pul ko`chirish:</div>
      </div>
    </div>
    <div class="col-md-12" style="display: none;" id="Div_price">
      <br/>
      <table class="table prices">
        <thead>
        <th>
          <img class="payment_img" src="https://image.flaticon.com/icons/svg/401/401180.svg" alt=""><br>
          Terminal
        </th>
        <th>
          <img class="payment_img" src="https://image.flaticon.com/icons/svg/401/401137.svg" alt=""><br>
          Naqd
        </th>
        <th>
          <img class="payment_img" src="https://image.flaticon.com/icons/svg/401/401134.svg" alt=""><br>
          Click
        </th>
        <th>
          <img class="payment_img" src="https://image.flaticon.com/icons/svg/579/579449.svg" alt=""><br>
          Qarz
        </th>
        </thead>
        <tbody>
        <td><input id="price2" value="0" onkeyup="checkPrice(value,1)" type="number" class="form-control bold input-lg number" name="prices2"></td>
        <td><input id="price3" value="0" onkeyup="checkPrice(value,2)" type="number" class="form-control bold input-lg number" name="prices1"></td>
        <td><input id="price5" value="0" onkeyup="checkPrice(value,3)" type="number" class="form-control bold input-lg number" name="prices5"></td>
        <td><input id="price4"  type="number" class="form-control bold input-lg number" name="prices4" readonly></td>
        </tbody>
      </table>
    </div>
    <input type="hidden" name="tashkilot" value="<?php echo $tashkilot_id; ?>">
    <input type="hidden" name="tashkilot_budget" value="<?php echo $tashkilot_byudjeti; ?>">
    <input type="hidden" name="storage" value="<?php echo $storage; ?>">
    <input type="hidden" name="user_id" value="<?php echo $session_id; ?>">
    <div class="clearfix hidden-print"></div><br><br>
    <div class="col-md-12 buttonlar hidden-print">
      <button onClick="deleteqilish(this);return false;" type="submit" id="savdo" name="admin_org_outgoing" class="btn btn-lg btn-success hidden-print">Savdo</button> 
      <a href="organizations.php" class="btn btn-lg btn-danger hidden-print">Orqaga qaytish
      </a> 
      <button id="saqlash" class="btn btn-lg btn-blue hidden-print" name="save" value="saved">Saqlash</button>
    </div>
  </div>
</form>

<!-- Products Templates -->
<div id="pr_template" style="display: none;">
  <table id="prod_div">
    <tr class="pr-row row-item">
      <td class="pr-row-num"></td>
        <input type="hidden" value="" id="ID" class="code form-control"/>
        <input type="hidden" id="org_type" class="code form-control" value="org"/>
      <td>
        <select id="pr_name" name="product[__i__][name]" class="form-control input-md pr-name item-select">
          <option value="">- TANLANG! -</option>
          <?php if ($session_role == 'Direktor'): ?>
          	<?php 
          		$query = "SELECT * FROM products WHERE product_id = 383";
          		$proquery = mysqli_query($connection, $query);
          		while ($row = mysqli_fetch_assoc($proquery)) {
          			$barcode = $row['product_barcode'];
          			$maxsulot_id = $row['product_id'];
          			$maxsulot_ismi = $row['product_name'];
          			$maxsulot_skladdagi_soni = $row['product_count'];
          			$maxsulot_sotish_narxi = $row['product_prise_out'];
          			$maxsulot_sotish_narxi = $maxsulot_sotish_narxi * $sum;
          		?>
				<option value="<?php echo $maxsulot_id; ?>" data-barcode1="<?php echo $barcode; ?>" data-price="<?php echo $maxsulot_sotish_narxi; ?>" data-left="<?php echo $maxsulot_skladdagi_soni; ?>"><?php echo "$maxsulot_ismi"; ?></option>
          		<?php } ?>
            <?php else: ?>
          <?php
          $query = "SELECT * FROM products WHERE product_count > 0";
          $proquery = mysqli_query($connection, $query);
          if (!$proquery) {
            die ("Mahsulot ismini zaprosida xatolik");
          }
          while ($row = mysqli_fetch_assoc($proquery)) {
            $barcode = $row['product_barcode'];
            $maxsulot_id = $row['product_id'];
            $maxsulot_ismi = $row['product_name'];
            $maxsulot_skladdagi_soni = $row['product_count'];
            $maxsulot_sotish_narxi = $row['product_prise_out'];
            $maxsulot_sotish_narxi = ($maxsulot_sotish_narxi * $sum) / 0.85;
            $maxsulot_sotish_narxi = round($maxsulot_sotish_narxi, -2);
            ?>
            <option value="<?php echo $maxsulot_id; ?>" data-barcode1="<?php echo $barcode; ?>" data-price="<?php echo $maxsulot_sotish_narxi; ?>" data-left="<?php echo $maxsulot_skladdagi_soni; ?>"><?php echo "$maxsulot_ismi"; ?></option>
          <?php } ?>
          <?php endif ?>
        </select>
      </td>
      <td>
        <div class="input-group pr-price">
          <input id="pr_price" type="number" min="0" step="any" name="product[__i__][price]" class="bold input-lg form-control pr-price item-price" value="0">
        </div>
      </td>
      <td>
        <div class="input-group pr-quantity">
          <input id="pr_quantity" type="number" onkeyup="items()" min="1" name="product[__i__][quantity]" class="bold input-lg form-control pr-quantity item-quantity" value="1">
        </div>
        <div class="hidden-print"><span class="badge storageinfo1 badge-roundless">Omborda:</span><span id="pr_left" class="badge badge-info badge-roundless storageinfo2 item-left"></span></div>
      </td>
      <td>
        <div class="input-group pr-total">
          <input id="pr_total" type="number" name="product[__i__][total]" class="form-control bold input-lg pr-total sub-total item-total" value="0" disabled>
        </div>
      </td>
      <td class="pr-remove hidden-print"><a href="#" onclick="return false;" id="btn_pr_remove" name="btn_pr_remove" class="btn btn-default btn-lg"><i class="entypo-trash"></i></a></td>
    </tr>
  </table>
</div>

<!-- Services Templates -->
<div id="sr_template" style="display: none;">
  <table>
    <tr class="sr-row row-item">
      <td class="sr-row-num"></td>
      <input type="hidden" value="" id="ID_" class="code form-control">
      <td>
        <select id="sr_name" name="service[__i__][name]" class="form-control input-md sr-name item-select">
          <option value="">- TANLANG! -</option>
                <?php 
                  $query = "SELECT * FROM services WHERE service_pro_id in (SELECT product_id FROM products WHERE product_count > 0)
              UNION
              SELECT * FROM services WHERE service_pro_id = 0";
                  $serquery = mysqli_query($connection, $query);

                  if (!$serquery) {
                    die ("Xizmat ismini zaprosida xatolik");
                  }
                  
                  while ($row = mysqli_fetch_assoc($serquery)) {
                    $xizmat_id = $row['service_id'];
                    $xizmat_ismi = $row['service_name'];
                    $barcode1 = $row['service_barcode'];
                    $xizmat_narxi = $row['service_price'];
                    $xizmatga_ketadigan_mahsulot = $row['service_pro_id'];
                    
                    if ($xizmatga_ketadigan_mahsulot == 0) {
                      $xizmatga_ketadigan_mahsulotni_skladdagi_soni = 'Not need';
                    }
                    else {
                      $querymax = "SELECT * FROM products WHERE product_id = '$xizmatga_ketadigan_mahsulot'";
                      $resultquerymax = mysqli_query($connection, $querymax);

                      while ($row = mysqli_fetch_assoc($resultquerymax)) {
                        $xizmatga_ketadigan_mahsulotni_skladdagi_soni = $row['product_count'];
                      }
                    }
                 ?>
                      <option value="<?php echo $xizmat_id; ?>" data-barcode="<?php echo $barcode1; ?>" data-price="<?php echo $xizmat_narxi; ?>" data-left="<?php echo $xizmatga_ketadigan_mahsulotni_skladdagi_soni; ?>"><?php echo $xizmat_ismi; ?></option>
                  <?php } ?>
        </select>
      </td>
      <td>
        <div class="input-group sr-price">
          <input id="sr_price" type="number" min="0" step="any" name="service[__i__][price]" class="form-control input-lg bold sr-price item-price" value="0">
        </div>
      </td>
      <td>
        <div class="input-group sr-quantity">
          <input id="sr_quantity" type="number" onkeyup="items()" min="1" name="service[__i__][quantity]" class="form-control bold input-lg sr-quantity item-quantity" value="1">
        </div>
        <div class="hidden-print"><span class="badge storageinfo1 badge-roundless">Omborda:</span><span id="sr_left" class="badge badge-success storageinfo2 badge-roundless item-left"></span></div>
      </td>
      <td>
        <div class="input-group sr-total">
          <input id="sr_total" type="text" class="form-control bold input-lg item-total" name="service[__i__][total]" value="0" disabled>
        </div>
      </td>
      <td class="sr-remove hidden-print"><a href="#" onclick="return false;" id="btn_sr_remove" name="btn_sr_remove" class="btn btn-lg btn-default"><i class="entypo-trash"></i></a></td>
    </tr>
  </table>
</div>

<!-- Scripts -->
<script>
      $("#saqlash").click(function(){
          $("#user_name").attr('required', '');
          })
      $("#savdo").click(function(){
          $("#user_name").removeAttr("required");
          })
</script>

<script type="text/javascript">
  jQuery(document).ready(function($)
  {
        var opts = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-left",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };

      toastr.info("<?php echo $storage_name; ?>", "Ombor", opts);
      toastr.<?php echo $safety; ?>("<?php echo $tashkilot_ismi; ?>", "Savdodagi tashkilot", opts);
    });
  ;
</script>

<script src="assets/js/toastr.js"></script>
<!-- <script src="assets/js/pay.js"></script> -->