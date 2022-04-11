
// REMINDER!!!!
// Script JS harus selalu ada bawah TAG HTML dikarenakan yang diload duluan itu HTMLnya dulu , 
// baru JS supaya kita mengenal element dan diload element tersebut

// Jika menggunakn JQUERY atau kita bisa menaruh JS nya dihead tapi harus dibungkus dulu dengan JQUERY baru JS bisa jalankan


// cara menghilangkan tombol cari diJQUERY;

    $('#tombol-cari').hide();



// tanda $ = memanggil jquerynya, bisa menggunkan JQUERY
// apappun yang ada didalam kurungnya document

// Bungkus Dulu dengan menggunakan JQUERY;
$(document).ready(function(){



// ajax
// event ketika keyword ditulis, sebelumnya kita menggunakan addEventListener();

// JQUERY tolong carikan saya element Keyword ketika dikeyup jalankan fungsi berikut ini;
    $('#keyword').on('keyup', function(){

        // munculkan loader ketika diketik;
        $('.loader').show();



        // JQUERY tolong carikan saya element container , lalu load isi atau ubah  data yang dari sumber menggunakan GET
        // apapun yang diketik oleh usernya;

        // cara simple
        // memanggil ajax dengan 1 baris saja
        // tapi fungsi load() ini cuma bisa menggunkan get saja untuk load menggunkan post menggunakan fungsi yg lain;
        // $('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val());


        // cara lebih flexible=mudah ditentukan;
        // ajax menggunakan loading
        // $.get();
        // data = menggantikan ajax.responeText
        $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data){

            //innerHTML = html(data)  
            $('#container').html(data);

            // non aktikan loader

            $('.loader').hide();

        });


    });



});