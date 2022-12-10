<?php

if (!(isset($_COOKIE['admin']) && isset($_COOKIE['pass']))) {
    header("Location: login.php?logout");
}

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
                <span><a href="login.php?logout">تسجيل الخروج</a></span>

        </header>


        <main class="main">
            <h2 style="text-align: center;font-size: 46px;">صفحة الادارة</h2>

            <div class="manege">


                <?php if (isset($_POST["add-product"])) {

                    $name = $_POST["name"];
                    $price = $_POST["price"];
                    $disc = $_POST["disc"];
                    $type = $_POST["type"];
                    $count = $_POST["count"];
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
                            //  print_r($errors);
                            var_dump($errors);
                        }
                    }
                    uplod_imge();
                    if ($image != "NO") {
                        include_once 'connect.php';
                        $db->exec("INSERT INTO `products` (`id`, `name`, `image`, `price`, `count`, `type`, `disc`, `info`, `date`) VALUES (NULL, '$name', '$image', $price, $count, '$type', '$disc', '', current_timestamp())");
                        echo "<div style='color:green;font-weight: bold;text-align: center;margin: 20px auto;font-size: 30px;'>تم اضافة المنتج</div>";
                    }

                    echo "<div onclick=\"location.href = 'admin.php?act=add' \" style=\"
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
                } elseif (!(isset($_GET["act"]))) { ?>
                    <div onClick="location.href = 'admin.php?act=add'">اضافة منتج</div>
                    <div onClick="location.href = 'admin.php?act=show'">عرض بيانات المنتجات</div>
                    <div onClick="location.href = 'admin.php?act=orders'">عرض قائمة الطلبات</div>
                    <div onClick="location.href = 'admin.php?act=users'">عرض قائمة المستخدمين</div>
                    <div onClick="location.href = 'admin.php?act=comment'">عرض التعليقات   </div>
                <?php } elseif (isset($_GET["act"])) {

                    if ($_GET["act"] == "add") { ?>

                        <form action="admin.php" method="post" enctype="multipart/form-data">

                            <h3> اضافة منتج </h3>
                            <label for="">اسم المنتج:</label>
                            <input type="text" name="name" />

                            <label for="">صورة المنتج:</label>
                            <input type="file" name="image" id="image" />

                            <label for="">سعر المنتج:</label>
                            <input type="number" name="price" value="0" />

                            <label for="">تفاصيل المنتج:</label>
                            <input type="text" name="disc" />

                            <label for="">نوع المنتج:</label>
                            <select name="type">
                                <option value="ثلاجة">ثلاجة</option>
                                <option value="غسالة">غسالة</option>
                                <option value="مروحة">مروحة</option>
                                <option value="مكيف">مكيف</option>
                                <option value="تلفاز">تلفاز</option>
                                <option value="شاشة">شاشة</option>
                                <option value="مكبر صوت">مكبر صوت</option>
                                <option value="ميكرويف">ميكرويف</option>
                                <option value="مكواة">مكواة</option>
                                <option value="ادوات صحية">ادوات صحية</option>
                                <option value="ادوات منزلية">ادوات منزلية</option>
                                <option value="مستلزمات">مستلزمات</option>
                                <option value="اثاث">اثاث</option>
                                <option value="اخري">اخري</option>
                            </select>

                            <label for="">كمية المنتج:</label>
                            <input type="number" name="count" value="" />

                            <input type="hidden" name="add-product" />

                            <br>
                            <button> اضافة</button>
                        </form>
                    <?php } elseif ($_GET["act"] == "show") { ?>
                        <h3 style="text-align: center">بيانات المنتجات</h3>

                        <form action="admin.php" method="get" style="text-align: center;box-sizing: border-box;padding: 20px 5px;">
                            <label for="">اسم المنتج للعرض:</label>
                            <input type="text" name="q">
                            <button>عرض</button>
                            <input type="hidden" name="act" value="show">
                        </form>

                        <table>
                            <thead>
                                <tr>
                                    <td>رقم المنج</td>

                                    <td>اسم المنتج</td>
                                    <td>صورة المنج</td>
                                    <td>سعر المنج</td>
                                    <td>تفاصيل المنج</td>
                                    <td> نوعد المنتج</td>
                                    <td> كمية المنتج</td>
                                    <td>  تقيمات الزبائن </td>
                                    <td>تعديل</td>
                                    <td>حذف</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include_once 'connect.php';


                                if (isset($_GET["q"])  && $_GET["q"] != '') {
                                    $q = $_GET["q"];
                                    $data = $db->query("SELECT * FROM `products` WHERE `name` LIKE '%$q%'")->fetchall();
                                } else {
                                    $data = $db->query("SELECT * FROM `products`")->fetchall();
                                }
                                foreach ($data as $item) {
                                ?>
                                    <tr class="<?php echo $item['id']; ?>">
                                        <td><?php echo $item['id']; ?></td>
                                        <td><textarea disabled> <?php echo $item['name']; ?> </textarea></td>
                                        <td><img src="img/<?php echo $item['image']; ?>" /> </td>
                                        <td><textarea disabled> <?php echo $item['price']; ?> </textarea></td>
                                        <td><textarea disabled> <?php echo $item['disc']; ?> </textarea></td>
                                        <td>
                                            <select name="type" class="hide-show" disabled>
                                                <option value="<?php echo $item['type']; ?>" selected><?php echo $item['type']; ?></option>
                                                <option value="ثلاجة">ثلاجة</option>
                                                <option value="غسالة">غسالة</option>
                                                <option value="مروحة">مروحة</option>
                                                <option value="مكيف">مكيف</option>
                                                <option value="تلفاز">تلفاز</option>
                                                <option value="شاشة">شاشة</option>
                                                <option value="مكبر صوت">مكبر صوت</option>
                                                <option value="ميكرويف">ميكرويف</option>
                                                <option value="مكواة">مكواة</option>
                                                <option value="ادوات صحية">ادوات صحية</option>
                                                <option value="ادوات منزلية">ادوات منزلية</option>
                                                <option value="مستلزمات">مستلزمات</option>
                                                <option value="اثاث">اثاث</option>
                                                <option value="اخري">اخري</option>
                                            </select>
                                        </td>
                                        <td><textarea disabled> <?php echo $item['count']; ?> </textarea></td>

                                        <td>
                                            <ul style="height: 100%;overflow-y: scroll"> 
                                            <?php  $rates = explode(";", $item['info']); 

                                                foreach ($rates as $rate) {
                                                    if( $rate != null){

                                                    $r = explode("=", $rate);
                                                    echo "<li style='margin: 2px 0'>".$r[0]." ==> ". $r[1]."</li>";

                                                    }
                                                }
                                            ?> 
                                            </ul>
                                        </td>

                                        <td style='text-decoration: underline;' onclick="if(confirm('تعديل؟؟')){this.parentElement.children[1].children[0].disabled == true? (this.textContent = 'حفظ',enableEdit(this.parentElement) ):(this.textContent = 'تعديل', editData(<?php echo $item['id']; ?> ,this));}"> تعديل </td>
                                        <td style='color:red' class="<?php echo $item['id']; ?>" onclick="removeData('products',this)">حذف </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } elseif ($_GET["act"] == "users") { ?>
                        <h3 style="text-align: center">بيانات المستخدمين</h3>
<!-- 
                        <form action="admin.php" method="get" style="text-align: center;box-sizing: border-box;padding: 20px 5px;">
                            <label for="">اسم المستخدم للعرض:</label>
                            <input type="text" name="q">
                            <button>عرض</button>
                            <input type="hidden" name="act" value="show">
                        </form> -->

                        <table>
                            <thead>
                                <tr>
                                    <td>رقم المستخدم</td>
                                    <td>اسم بالكامل</td>
                                    <td>رقم الهاتف</td>
                                    <td>عنوان المستخدم</td>
                                    <td>اسم المستخدم</td>
                                    <td>تاريخ التسجيل</td>
                                    <td>حذف</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include_once 'connect.php';


                                // if (isset($_GET["q"])  && $_GET["q"] != '') {
                                //     $q = $_GET["q"];
                                //     $data = $db->query("SELECT * FROM `users` WHERE `name` LIKE '%$q%' || `username` LIKE '%$q%'")->fetchall();
                                // } else {
                                    $data = $db->query("SELECT * FROM `users`")->fetchall();
                                // }
                                foreach ($data as $item) {
                                ?>
                                    <tr class="<?php echo $item['id']; ?>">
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo $item['name']; ?></td>
                                        <td><?php echo $item['phone']; ?></td>
                                        <td><?php echo $item['address']; ?></td>
                                        <td><?php echo $item['username']; ?></td>
                                        <td><?php echo $item['date']; ?></td>
                                        <td style='color:red' class="<?php echo $item['id']; ?>" onclick="removeData('users',this)">حذف </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    <?php } elseif ($_GET["act"] == "orders") { ?>

                        <h3 style="text-align: center">قائمة الطلبات</h3>

                        <table>
                            <thead>
                                <tr>
                                    <td>رقم الطلب</td>
                                    <td style="min-width: 200px;"> المنتجات المطلوبة</td>
                                    <td>اسم الزبون</td>
                                    <td>رقم الهاتف</td>
                                    <td>عنوان الزبون</td>
                                    <td>صورة الاشعار</td>
                                    <td style="min-width: 130px;">تاريخ الطلب</td>
                                    <td> حالة التنفيذ</td>
                                    <td>طباعة</td>
                                    <td>تعديل</td>
                                    <td>حذف</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include_once 'connect.php';


                                if (isset($_GET["q"])  && $_GET["q"] != '') {
                                    $q = $_GET["q"];
                                    $data = $db->query("SELECT * FROM `pyments` WHERE `name` LIKE '%$q%'")->fetchall();
                                } else {
                                    $data = $db->query("SELECT * FROM `pyments`")->fetchall();
                                }
                                foreach ($data as $item) {
                                ?>
                                    <tr >
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo str_replace("\n", "<br/>", $item['product']); ?></td>
                                        <td><?php echo $item['name']; ?></td>
                                        <td><?php echo $item['phone']; ?></td>
                                        <td><?php echo $item['address']; ?></td>
                                        <td><img src="img/<?php echo $item['receipt']; ?>" /> </td>
                                        <td><?php echo $item['date']; ?></td>
                                        <td>
                                            <select name="status" class="hide-show" disabled>
                                                <option value="<?php echo $item['status']; ?>" selected><?php echo $item['status']; ?></option>
                                                <option value="قيد الاجراء">قيد الاجراء</option>
                                                <option value="تم التسليم">تم التسليم</option>
                                            </select>
                                        </td>
                                        <td  onclick="document.querySelectorAll('.receipt').forEach(t => {t.style.display = 'none'; });document.getElementsByClassName('p<?php echo $item['id']; ?>')[0].style.display='table'">طباعة</td>
                                        <td style='text-decoration: underline;' onclick="if(confirm('تسليم البضاعة للزبون ؟؟')){this.parentElement.children[7].children[0].disabled == true? (this.textContent = 'حفظ',enableEdit(this.parentElement, 2) ):(this.textContent = 'تعديل', editOrder(<?php echo $item['id']; ?> ,this));}"> تعديل </td>
                                        <td style='color:red' class="<?php echo $item['id']; ?>" onclick="removeData('pyments', this)">حذف </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <br>

                <?php } elseif ($_GET["act"] == "comment") { ?>
                    <h2 style="text-align: center;">تعليقات الزبائن</h2>
                    <table>
                            <thead>
                                <tr>
                                    <td>رقم التعليق</td>
                                    <td>اسم الزبون</td>
                                    <td>نص التعليق</td>
                                    <td style="min-width: 130px;">التاريخ </td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include_once 'connect.php';

                                $data = $db->query("SELECT * FROM `comments`")->fetchall();
                                foreach ($data as $item) {
                                ?>
                                    <tr >
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo $item['name']; ?></td>
                                        <td><?php echo $item['comment']; ?></td>
                                        <td><?php echo $item['date']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <br>
                <?php }
                    
                    echo "<div onclick=\"location.href = 'admin.php' \" style=\"
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
                } ?>

            </div>


            <?php
            include_once 'connect.php';
            $data = $db->query("SELECT * FROM `pyments`")->fetchall();

            foreach ($data as $item) { ?>

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
                            <td style="border: none;" colspan="2"> <div colspan="2" class="print">طبعاعة</div></td>
                        </tr>
                    </tbody>
                </table>
                

            <?php } ?>
        </main>
    </div>

    <script src="js/index.js"></script>
</body>

</html>