<?php

// if (!(isset($_COOKIE['user']) && isset($_COOKIE['name']) && isset($_COOKIE['phone']))) {
//   header("Location: login.php?logout");
// }

if (isset($_POST["add-payment"])) {



  $product = $_POST["product"];
  $name = $_POST["name"];
  $phone = $_POST["phone"];
  $address = $_POST["address"];
  $image = '';

  function uplod_imge()
  {

    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $arg = explode('.', $_FILES['image']['name']);
    $file_ext = strtolower(end($arg));

    $extensions = array("jpeg", "jpg", "png", "jfif");

    if (in_array($file_ext, $extensions) === false) {
      $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
      $errors[] = 'File size must be excately 2 MB';
    }

    if (empty($errors) == true) {

      $file_name = explode(" ", microtime())[1] . "." . $file_ext;
      move_uploaded_file($file_tmp, "img/" . $file_name);

      $GLOBALS['image'] = $file_name;
    } else {
      $GLOBALS['image'] = "NO";
      var_dump($errors);
    }
  }
  uplod_imge();
  if ($image != "NO") {
    include_once 'connect.php';

    $db->exec("INSERT INTO `pyments` (`id`, `product`, `name`, `phone`, `address`, `receipt`, `status`, `date`) VALUES 
      (NULL, '$product', '$name', $phone, '$address', '$image', 'قيد الاجراء', current_timestamp())");
?>
    <div style='color:green;font-weight: bold;text-align: center;margin: 20px auto;font-size: 30px;'>تم الشراء سيصللك الطلبية بعد مراجعة الاشعار </div>
    <br>
    <div style='color:red;font-weight: bold;text-align: center;margin: 20px auto;font-size: 20px;'>الرجاء حفظ الاشعار </div>
    <br>
    <?php
    include_once 'connect.php';
    $data = $db->query("SELECT * FROM `pyments`")->fetchall();

    $item = array_pop($data);
    ?>

    <style>
      .receipt {
        padding: 20px;
        margin: 10px auto 10px;
        border: 2px solid #ccccff;
        max-width: 350px;
        text-align: center;
        width: 100%;
        box-sizing: border-box;
        border-radius: 10px;
      }

      .receipt thead {
        border-radius: 10px 10px 0px 0px;
      }

      .receipt h2 {
        margin-block-end: 0px;
        text-align: center;
      }

      .receipt h4 {
        margin-block-start: 10px;
        text-align: center;
      }

      .receipt tr {
        padding: 5px 10px;
        margin: 5px;
      }

      .receipt td {
        padding: 5px 10px;
        text-align: right;
        border: 2px solid #ccccff;

      }

      div.print {
        padding: 4px 20px;
        margin: 0px auto;
        width: max-content;
        border: 2px solid #ccccff;
        font-weight: bold;
        border-radius: 5px;
      }
    </style>
    <table class="receipt p<?php echo $item['id']; ?>">
      <thead>
        <td colspan="2">
          <h2>
            موقع متجر
          </h2>
          <h4>
            ايصال الدفع الالكتروني
          </h4>
        </td>
      </thead>
      <tbody>

        <tr>
          <td>رقم المعاملة </td>
          <td><?php echo $item['id']; ?></td>
        </tr>

        <tr>
          <td>تاريخ المعاملة </td>
          <td><?php echo $item['date']; ?></td>
        </tr>

        <tr>
          <td>المنتجات</td>
          <td><?php echo str_replace("\n", "<br/>", substr($item['product'], 0, strpos($item['product'], "P="))); ?></td>
        </tr>

        <tr>
          <td>الاسم</td>
          <td><?php echo $item['name']; ?></td>
        </tr>

        <tr>
          <td>رقم الهاتف</td>
          <td><?php echo $item['phone']; ?></td>
        </tr>

        <tr>
          <td>العنوان</td>
          <td><?php echo $item['address']; ?></td>
        </tr>

        <tr>
          <td>جملة المبلغ</td>
          <td><?php echo substr($item['product'], strpos($item['product'], "P=") + 2); ?>ج</td>
        </tr>

        <tr>
          <td style="border: none;" colspan="2">
            <div  colspan="2" class="print" onclick="window.print()">طبعاعة</div>
          </td>
        </tr>
      </tbody>
    </table>
  <?php  }


  echo "  <script>
            localStorage.clear();
            localStorage.clickcount = 0;
          </script>

          <div onclick=\"location.href = 'basket.php' \" style=\"
              font-size: 22px;
              width: fit-content;
              font-weight: bold;
              letter-spacing: 3px;
              margin: 5px auto;
              cursor: pointer;
              border: unset;
              background: unset;
              color: black;
          \">الرجوع</div>";
} elseif(isset($_POST["add-comment"])){

  $name = $_POST["name"];
  $comment = $_POST["comment"];
  
  include_once 'connect.php';

  $db->exec("INSERT INTO `comments` (`id`, `name`, `comment`, `info`, `date`) VALUES (NULL, '$name', '$comment', '0', current_timestamp())");
  echo "<div style='color:green;font-weight: bold;text-align: center;margin: 20px auto;font-size: 30px;'> تم اضافة تعليقك <br> شكراا لك رايك يهمنا </div>";

  echo "  <script>
  localStorage.clear();
  localStorage.clickcount = 0;
</script>

<div onclick=\"location.href = 'basket.php' \" style=\"
    font-size: 22px;
    width: fit-content;
    font-weight: bold;
    letter-spacing: 3px;
    margin: 5px auto;
    cursor: pointer;
    border: unset;
    background: unset;
    color: black;
\">الرجوع</div>";

} else {

  ?>




  <!DOCTYPE html>
  <html>

  <head>
    <title>متجر</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/style.css">

  </head>

  <body>
    <div class="app">
      <header>
        <div class="naves" style="justify-content: space-evenly">
          <span class="title">متجر مستلزمات منزلية</span>
          <span><a href="index.php">الصفحة الرئسية </a></span>
        </div>
      </header>


      <main class="main">
        <h3 style="text-align: center">سلة المشتريات</h3>

        <?php

        $display = "";
        if (isset($_GET['payment'])) {
          $display = "none";
          $display1 = "block";
        } else {
          $display = "block";
          $display1 = "none";
        } ?>
        <ul id="basketItems" style="display: <?php echo $display; ?>;"> </ul>

        <div class="act" onclick="location.href = 'basket.php?payment'" style="color: #55a50c;display: <?php echo $display; ?>">
          دفع </div>

        <ul style="text-align: center;list-style: none;display: <?php echo $display1; ?>" class="payment">
          <li>رقم حساب بنكك : <b style="color: red;">7777 777</b></li>
          <li>اسم الحساب : <b style="color: green;">موقع تجاري</b></li>
          <li></li>
          <h2 id="price"></h2>
          <li></li>
          <li>بعد الدفع الرجاء رفع صورة الاشعار هنا &#128071;</li>
          <div class="login">
            <form action="basket.php" method="POST" style="width: unset" enctype="multipart/form-data">
              <li>
                <input type="file" name="image" id="image" style="width: 100%;" onchange="loadImage(event);productValue.value=getPaiedItems()[0] + ' P='+ getPaiedItems()[1];console.log(productValue.value)" />
                <img id="img" src="" width="250px" />

                <br>
                <br>
                <label>الاسم :</label>
                <input type="text" name="name" value="<?php if(isset($_COOKIE['name'])){echo $_COOKIE['name'];} ?>"/>

                <label>الهاتف:</label>
                <input type="number" name="phone" value="<?php if(isset($_COOKIE['phone'])){echo $_COOKIE['phone'];} ?>" />

                <label>العنوان:</label>
                <input type="text" name="address" value="<?php if(isset($_COOKIE['address'])){echo $_COOKIE['address'];} ?>"/>
                <input type="hidden" name="product" id="productValue" />
                <input type="hidden" name="add-payment" />
              </li>


              <li></li>

              <li>
                <button style="padding: 10px; border: 1px solid #ccc;border-radius: 10px;">
                  <div class="act" style="color: #55a50c;height: 30px;line-height: .5;font-size: 22px;">
                    ارسال
                  </div>
                </button>
              </li>

            </form>
          </div>
          <div class="act" style="color: red;" onclick="location.href = 'basket.php'">الغاء</div>
        </ul>

        <div class="login">
            <form action="basket.php" method="POST" style="width: unset" enctype="multipart/form-data">
                <br>
                <br>
                <label style="width: 20%;">الاسم :</label>
                <input type="text" name="name" value="<?php if(isset($_COOKIE['name'])){echo $_COOKIE['name'];} ?>" style="width: 70%;"/>

                <label style="width: 20%;">التعليق:</label>
                <textarea name="comment" placeholder="اضف تعليقك هنا" style="width: 70%;"></textarea>

                <input type="hidden" name="add-comment" />
                <button style="padding: 10px; border: 1px solid #ccc;border-radius: 10px;">
                    ارسال
                </button>
            </form>
        </div>
      </main>
      <footer></footer>
    </div>





    <script>
      function getBasket() {
        let price = 0;
        let items = "";
        for (var key in localStorage) {
          if (key.indexOf("item") > -1) {
            let d = localStorage[key].split(",");
            price = Number(price) + Number(d[2]);
            items += `<li class="${d[0]}">${d[1]}  ${d[2]}ج <span style="color:red; float: left" onclick="localStorage.removeItem('${key}');localStorage.clickcount = Number(localStorage.clickcount) - 1;location.reload()">مسح</span></li>`;

            // console.log(localStorage[key].split(","));
          }
        }
        return [items, price];
      }

      function getPaiedItems() {

        let items = "";
        let price = 0;
        let i = 0;
        for (var key in localStorage) {

          if (key.indexOf("item") > -1) {
            let d = localStorage[key].split(",");
            price = Number(price) + Number(d[2]);
            items += `${i}-- ${d[1]}  --> ${d[2]} \n`;
          }
          i++
        }
        return [items, price];
      }


      basketItems.innerHTML +=
        getBasket()[0] + "<h2> جملة السعر: " + getBasket()[1] + "ج </h2>";
      price.innerHTML = "جملة السعر: " + getBasket()[1] + "ج";




      var loadImage = function(event) {
        var image = document.getElementById('img');
        image.src = URL.createObjectURL(event.target.files[0]);
      };
    </script>
  </body>

  </html>
<?php } ?>