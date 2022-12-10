
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
			<div class="naves">
				<span class='title' onclick="location.href='index.php'">متجر مستلزمات منزلية</span>
				<form id="search-form" action="index.php" method="GET">
					<input type="search" name="q" />
					<img onclick="this.pref" src="img/search.png" class="search-icon" onClick="this.previousElementSibling.style.display='flex'" />
				</form>
				<div class="admin"><img src="img/settings.jpg" alt="" / onclick="location.href='admin.php'"></div>
				<div class="admin"><img src="img/login.png" alt="" / onclick="location.href='login.php'"></div>
				<div class="basket" onclick="location.href = 'basket.php'">
					<img src="img/pay.png" />
					<span id="payCount">
						0
					</span>
				</div>
			</div>
		</header>



		<main class="main">
			<h3>
				<b> منتجاتنا : </b>
				<span><a href="index.php?type=ثلاجة">ثلاجات ،</a></span>
				<span><a href="index.php?type=غسالة">غسالات ،</a></span>
				<span><a href="index.php?type=مكيف">مكيفات ،</a></span>
				<span><a href="index.php?type=مروحة">مراوح ،</a></span>
				<span><a href="index.php?type=شاشة">شاشات ،</a></span>
				<span><a href="index.php?type=ميكرويف">مايكرو ويف ،</a></span>
				<span><a href="index.php?type=اثاث">اثاثات منزلية ،</a></span>
				<span><a href="index.php?type=مكواة">مكاوي ،</a></span>
				<span><a href="index.php?type=تلفاز">اجهزة التلفاز ،</a></span>
				<span><a href="index.php?type=ادوات منزلية">الادوات المنزلية ،</a></span>
				<span><a href="index.php?type=ادوات صحية">الادوات الصحية ،</a></span>
				<span><a href="index.php?type=مستلزمات">مستلزمات</a></span>
				<span><a href="index.php?type=اخري">اخري</a></span>
			</h3>

			<div class="products">

				<div class="products">
					<?php
					include_once 'connect.php';
					if (isset($_GET['q'])) {
						$q = $_GET['q'];

						$data = $db->query("SELECT * FROM `products` WHERE `name` LIKE '%$q%'")->fetchall();
					} elseif (isset($_GET['type'])) {
						$type = $_GET['type'];
						$data = $db->query("SELECT * FROM `products` WHERE `type` LIKE '%$type%'")->fetchall();
					} else {
						$data = $db->query("SELECT * FROM `products`")->fetchall();

					}

					if (count($data) == 0) {
						echo "<h2><a href='index.php' > الرجوع للقائمة الرئسية </a></h2>";
					}
					shuffle($data);

					foreach ($data as $item) {

					?>
						<div class="product ">
						<?php echo $item['id']; ?>
							<p class="ditils">
								<img src="img/x.png" onclick="this.parentElement.style.display='none'" />
								<br>
								<?php echo $item['disc']; ?>
							</p>
							<div class="ditils" id="comments">
								<img src="img/x.png" onclick="this.parentElement.style.display='none'" />
								<br>
								<ul>
									<?php
									$id = $item['id'];
									$d = $db->query("SELECT * FROM `comments` WHERE `info` = $id")->fetchall();

									foreach ($d as $comnt) { ?>

										<li>
											<div class="name"><?php echo $comnt['name']; ?></div>
											<div class="comment"><?php echo $comnt['comment']; ?></div>
										</li>
									<?php }  ?>

									<?php if (isset($_COOKIE["address"]) && isset($_COOKIE["phone"])) { ?>

										<!-- <div class="login"> -->
										<!-- <form action="index.php" method="POST" style="width: unset" enctype="multipart/form-data">
											<br>
											<br>
											<label style="width: 20%;">الاسم :</label>
											<input type="text" name="name" value="<?php echo $_COOKIE['name']; ?>" style="width: 70%;" />

											<label style="width: 20%;">التعليق:</label>
											<textarea name="comment" placeholder="اضف تعليقك هنا" style="width: 70%;"></textarea>

											<input type="hidden" name="info" value="<?php echo $item['id']; ?>" />
											<input type="hidden" name="add-comment" />
											<button style="padding: 10px; border: 1px solid #ccc;border-radius: 10px;">
												ارسال
											</button>
										</form> -->
										<!-- </div> -->
									<?php } ?>

								</ul>
							</div>
							<img src="img/<?php echo $item['image']; ?>"  class="<?php echo $item['id']; ?>" onclick="location.href = 'item.php?id='+this.className"/>
							<span><?php echo $item['name']; ?></span>
							<span onClick="this.parentElement.firstElementChild.style.display='block'">التفاصيل</span>

							<span>السعر: <?php echo $item['price']; ?></span>
							<span class="">
								<span style="border: none;" class="<?php echo $item['id']; ?>" onclick="clickCounter(<?php echo $item['id']; ?>, '<?php echo $item['name']; ?>', <?php echo $item['price']; ?>); this.innerHTML = `<span style='color:green;border:none'>تم اضافته للسلة</span>`">

									شــراء<img src="img/pay.png" />

								</span>
							</span>
							<span style="width: max-content;font-size: 22px;padding:2px 7px"> تقيمك :
								&nbsp;&nbsp;&nbsp;
								<span>
									<?php if (isset($_COOKIE['user'])) {
										if (strpos($item['info'],  $_COOKIE['user']) >-1) { 
											// if (str_contains($item['info'], $_COOKIE['user'])) { 
											$s = $item['info'];
											$u = $_COOKIE['user'];
											$r = substr($s, strpos($s,  $u), strpos(substr($s, strpos($s,  $u)), ";"));
											$rate =  explode("=", $r)[1];
											?>
											<span class='starsRate' onclick="rating(this, 'reset', <?php echo $item['id']; ?>)"><?php echo $rate; ?></span>
										<?php } else { ?>
											<span onclick="rating(this,1, <?php echo $item['id']; ?>)">☆</span>
											<span onclick="rating(this,2, <?php echo $item['id']; ?>)">☆</span>
											<span onclick="rating(this,3, <?php echo $item['id']; ?>)">☆</span>
											<span onclick="rating(this,4, <?php echo $item['id']; ?>)">☆</span>
											<span onclick="rating(this,5, <?php echo $item['id']; ?>)">☆</span>
									<?php }
									} else {?>
									<span style="font-size: 12px;">تجسيل دخول للتقيم</span>
									<?php } ?>
								</span>
							</span>
						</div>
					<?php } ?>


				</div>

		</main>
		<footer>
			<div class="pay-method">
				<h2>طرق الدفع : </h2>&nbsp;
				<span><img src="img/bankak.jpg" alt=""></span>
				<span><img src="img/fowry.png" alt=""></span>
				<span><img src="img/okash.jpg" alt=""></span>
				<span><img src="img/cash.png" alt="" style=" height: 120%;">الدفع النقدي</span>
				<span></span>
				<div class="contact"><a href="#">تواصل معنا </a></div>
			</div>

			<div class="copy-write">جميع الحقوق محفوظة @ متجر 2022</div>
		</footer>
	</div>

	<script src="js/index.js"></script>
	<script>
		if (localStorage.clickcount != undefined) {
			document.getElementById("payCount").innerHTML = localStorage.clickcount;
		}

		function rating(item, r, id) {
			if (r == 'reset') {
				item.parentElement.innerHTML =
					`<span onclick="rating(this,1, ${id})">☆</span>
				<span onclick="rating(this,2, ${id})">☆</span>
				<span onclick="rating(this,3, ${id})">☆</span>
				<span onclick="rating(this,4, ${id})">☆</span>
				<span onclick="rating(this,5, ${id})">☆</span>`;
			} else {
				let stars = `<span class='starsRate' onclick="rating(this, 'reset', ${id})">${'★★★★★☆☆☆☆☆'.slice(5 - r, 10 - r)}</span>`;
				let p = item.parentElement;
				item.parentElement.innerHTML = stars;

				let user = document.cookie.slice(document.cookie.indexOf("user")).split(";")[0].split("=")[1];
				// console.log(p);
				insertRating(p.children[0].textContent, id, user);
			}
		}

		function insertRating(stars, id, user){
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText);
			}
		};
		$v=user+"="+stars;
		xhttp.open("GET", `edit.php?ac=rate&id=${id}&stars=${$v}`);
		xhttp.send();
		}
	</script>
</body>

</html>