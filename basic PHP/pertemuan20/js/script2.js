// ambil elemen yang dibutuhkan
//  JS tolong carikan document yang elementnya yang idnya =keyword,tombol-cari,container;
var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

// untuk menjalankan ajax kita butuh trigger
// trigger = sebuah aksi untuk menjalankan ajax

// tombolCari.addEventListener('mouseover', function(){

//     alert('berhasil');
// } );


// menjadi trigger atau pelatuk;
// tambahkan event ketika keyword ditulis;
// keyup = ketika kita melepaskan tangan dan dari keyboad akan memuncul nilai inputnya;
keyword.addEventListener('keyup', function () {

    // keyword.value = ambil inputnya keyword , apapun value yang akan diketikan oleh user;
    // console.log(keyword.value);


    // buat object ajax
    // XMLHttpRequesr() hanya bisa dibrowser baru saja, di internet explorer;
    var ajax = new XMLHttpRequest();


    // pengecekan kesiapan ajax
    ajax.onreadystatechange = function () {

        // 4 = ready , 200 = status normal, 404 = not found atau kosong
        if (ajax.readyState == 4 && ajax.status == 200) {

            // responseText = berisi apapun yang berisi yang ada disumber
            // console.log(ajax.responseText);

            container.innerHTML = ajax.responseText;

        }
    }

    // eksekusi ajax;
    // 3 ada parameter = method, sumbernya , mengaktifkan ajax atau true;
    // ajax.open('GET', 'ajax/coba.txt', true);

    ajax.open('GET', 'ajax/mahasiswa.php?keyword=' + keyword.value, true);



    // untuk menjalankan ajaxnya;
    ajax.send();
});