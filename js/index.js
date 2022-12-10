

// تسجيل الخروج
function removeCookie() {
  document.cookie = "admin=; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/";
  document.cookie = "pass=; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/";
}




function editData(id, item) {
  var v1 = item.parentElement.children[1].firstElementChild;
  var v2 = item.parentElement.children[3].firstElementChild;
  var v3 = item.parentElement.children[4].firstElementChild;
  var v4 = item.parentElement.children[5].firstElementChild;
  var v5 = item.parentElement.children[6].firstElementChild;



  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState > 0 && this.readyState < 4) {
      item.innerHTML = "جاري";
    }
    if (this.readyState == 4 && this.status == 200) {
      v1.disabled = true;
      v2.disabled = true;
      v3.disabled = true;
      v4.disabled = true;
      v5.disabled = true;
      
      item.innerHTML = "تعديل";
      console.log(this.responseText);

      if (this.responseText == "OK") {
        alert("تم التحديث بنجاح");
      } else {
        alert("لم يتم التحديث");
      }

    }
  };
  xhttp.open(
    "GET",
    `./edit.php?ac=edit&id=${id}&v1=${v1.value}&v2=${v2.value}&v3=${v3.value}&v4=${v4.value}&v5=${v5.value}`,
    true
  );
  xhttp.send();
}


function editOrder(id, item) {
  var v = item.parentElement.children[7].firstElementChild;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState > 0 && this.readyState < 4) {
      item.innerHTML = "جاري";
    }
    if (this.readyState == 4 && this.status == 200) {
      v.disabled = true;
      item.innerHTML = "تعديل";
console.log(this.responseText);
      if (this.responseText == "OK") {
        alert("تم التحديث بنجاح");
      } else {
        alert("لم يتم التحديث");
      }
    }
  };
  xhttp.open("GET", `./edit.php?ac=order&id=${id}&v=${v.value}&`, true);
  xhttp.send();
}


function enableEdit(item, act=1) {
      if (act == 1) {
        item.children[1].firstElementChild.disabled = false;
        item.children[3].firstElementChild.disabled = false;
        item.children[4].firstElementChild.disabled = false;
        item.children[5].firstElementChild.disabled = false;
      }
      item.children[7].firstElementChild.disabled = false;
}
function removeData(t,item) {
  if (!confirm("مسح البيانات ؟؟")) {
    return;
  }
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState > 0 && this.readyState < 4) {
      item.innerHTML = "جاري المسح...";
    }
    if (this.readyState == 4 && this.status == 200) {
      console.log(item);
      console.log(this.responseText);
      
      item.parentElement.innerHTML = `<div style='color:red;text-align:center' >${this.responseText}</span>`;
    }
  };
  xhttp.open(
    "GET",
    `./edit.php?ac=delet&id=${item.className}&t=${t}&`,
    true
  );
  xhttp.send();
}

function pay(act, item, type, id = 1, rq='') {
  if (act=="set" && !confirm("شراء؟؟")) {
    location.href = "index.php";
    return;
  }

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState > 0 && this.readyState < 4) {

    }
    if (this.readyState == 4 && this.status == 200) {
        item.innerHTML = "تم اضافة الي السلة";
    }
  };
  xhttp.open("GET", `./${rg}&&idd=${id}`, true);
  xhttp.send();
}

// localStorage.clear();
// localStorage.clickcount = 0;

function clickCounter(id, i, p) {
  if (localStorage.clickcount) {
    localStorage.clickcount = Number(localStorage.clickcount) + 1;
    localStorage["item" + Number(localStorage.clickcount)] = [id, i, p];
  } else {
    localStorage.clickcount = 1;
  }
  document.getElementById("payCount").innerHTML = localStorage.clickcount;
}
// pay('set', this, '<?php echo  $item['type']; ?>', <?php echo $item['id']; ?>);
function getBasket() {
  let price = 0;
  let items = "";
  for (var key in localStorage) {
    if (key.indexOf("item") > -1) {
      let d = localStorage[key].split(",");
      price = Number(price) + Number(d[2]);
      items += `<li class="${d[0]}">${d[1]}  ${d[2]}ج <span style="color:red; float: left" onclick="localStorage.removeItem('${key}');location.reload()">مسح</span></li>`;

      // console.log(localStorage[key].split(","));
    }
  }
  return [items, price];
}
location.pathname.indexOf("basket.html") > -1 ?  basketItems.innerHTML = getBasket()[0]+"<br> جملة السعر: " + getBasket()[1]+ "ج" : '';