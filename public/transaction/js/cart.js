// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0, // Mengatur jumlah digit desimal minimum menjadi 0
    }).format(amount);
}



// Menampilkan Alert
function swal(title, text, icon) {
    Swal.fire(title, text, icon);
}

// Menampilkan Alert dengan konfirmasi
function swalWithConfirm(title, text, icon) {
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
    });
}

// Menghitung subtotal
function updateSubtotal(rowElement) {
    var harga = parseFloat(
        rowElement.find(".harga").text().replace(/[^\d]/g, "")
    );
    var qty = parseInt(rowElement.find(".qty").val());

    if (isNaN(harga) || isNaN(qty)) {
        rowElement.find(".subtotal").text(formatCurrency(0));
    } else {
        var subtotal = Math.floor(harga) * qty; // Menggunakan Math.floor() untuk membulatkan harga
        rowElement.find(".subtotal").text(formatCurrency(subtotal));
    }

    updateGrandTotal();
}

// Menghitung kembalian
function hitungKembalian() {
    var grandTotal = parseInt($('input[name="grandtotal"]').val());
    var inputBayar = parseInt($("#inputBayar").val());
    var btnSimpan = $("#btnSimpan");

    if (isNaN(inputBayar) || inputBayar < grandTotal) {
        $("#kembalian").val("0");
        $("#kembalianHidden").val("0");
        btnSimpan.prop("disabled", true);
        btnSimpan.css("cursor", "not-allowed");
    } else {
        var kembalian = inputBayar - grandTotal;
        $("#kembalian").val(formatCurrency(kembalian));
        $("#kembalianHidden").val(kembalian);
        btnSimpan.prop("disabled", false);
        btnSimpan.css("cursor", "pointer");
    }
}


// Event listener untuk input pembayaran
$("#inputBayar").on("input", function () {
    hitungKembalian();
});



// Menghitung grand total
function updateGrandTotal() {
    var grandTotal = 0;
    $(".subtotal").each(function () {
        var subtotal = parseInt($(this).text().replace(/[^\d]/g, ""));
        if (!isNaN(subtotal)) {
            grandTotal += subtotal;
        }
    });

    $("#grandTotal").text("GRAND TOTAL: " + formatCurrency(grandTotal));
    $('input[name="grandtotal"]').val(grandTotal);
}

// Menampilkan alert konfirmasi saat tombol delete-row di klik
$("#tbodyTransaksi").on("click", ".delete-row", function () {
    var rowElement = $(this).closest("tr");
    var productName = rowElement.find("td:nth-child(2)").text();

    // Tampilkan alert konfirmasi
    if (confirm("Anda yakin ingin menghapus produk ?")) {
        // Hapus baris transaksi dari tabel
        rowElement.remove();

        // Perbarui nomor pada baris tabel
        nomorBaru();

        // Perbarui grand total
        updateGrandTotal();

        alert("Produk berhasil dihapus");
    }
});



// Menambahkan produk ke tabel transaksi saat tombol Add di klik
$("#btnAdd").on("click", function() {
    var selectedOption = $("#input_kode option:selected");
    var nm_barang_hide = selectedOption.text();
    var harga = parseInt(selectedOption.attr("data-harga"));
    var qty = parseInt($("#qty_head").val());

    if (qty === 0 || isNaN(qty)) {
        $("#qty_head").focus();
        swal("Gagal", "Qty tidak boleh kosong atau bukan angka!", "error");
    } else if (nm_barang_hide === "") {
        swal("Gagal", "Data barang tidak ada!", "error");
    } else {
        var newRow =
            "<tr>" +
            "<td class='no'></td>" +
            "<td>" +
            nm_barang_hide +
            "</td>" +
            "<td class='harga'>" +
            formatCurrency(harga) +
            "</td>" +
            "<td><input type='number' class='qty' value='" +
            qty +
            "'></td>" +
            "<td class='subtotal'>" +
            formatCurrency(harga * qty) +
            "</td>" +
            '<td><button class="btn btn-danger btn-sm delete-row">Hapus</button></td>' +
            "</tr>";

        $("#tbodyTransaksi").append(newRow);

        $(".no").each(function(index) {
            $(this).text(index + 1);
        });

        updateGrandTotal();
        kosongkanHeader();

        // Update subtotal for the new row
        updateSubtotal($("#tbodyTransaksi tr:last"));
    }
});

// Fungsi batal untuk menghapus seluruh transaksi
$("#btnBatal").on("click", function () {
    // Tampilkan konfirmasi menggunakan alert biasa
    var confirmation = confirm("Anda yakin ingin membatalkan transaksi?");

    if (confirmation) {
        // Hapus semua baris transaksi pada tabel
        $("#tbodyTransaksi").empty();

        // Kosongkan header dan grand total
        kosongkanHeader();
        updateGrandTotal();

        // Tampilkan pesan sukses menggunakan alert biasa
        alert("Transaksi berhasil dibatalkan");
    }
});



$(document).ready(function () {
    $("#input_kode").select2();

    $("#qty_head").on("input", function () {
        updateSubtotal($(this).closest("tr"));
    });

    $("#input_kode").on("change", function () {
        updateProductData();
    });

    // Inisialisasi
    getNoInvoice();
    setInterval(getDateTime, 1000);
});

// Mendapatkan tanggal sekarang
function getDateTime() {
    let now = new Date();
    let year = now.getFullYear();
    let month = now.getMonth() + 1;
    let day = now.getDate();
    let hour = now.getHours();
    let minute = now.getMinutes();
    let second = now.getSeconds();

    if (month.toString().length == 1) {
        month = "0" + month;
    }
    if (day.toString().length == 1) {
        day = "0" + day;
    }
    if (hour.toString().length == 1) {
        hour = "0" + hour;
    }
    if (minute.toString().length == 1) {
        minute = "0" + minute;
    }
    if (second.toString().length == 1) {
        second = "0" + second;
    }
    let dateTime =
        day +
        "/" +
        month +
        "/" +
        year +
        " " +
        hour +
        ":" +
        minute +
        ":" +
        second;

    $("#td_tanggal").html(dateTime);

    $('input[name="tanggal"]').val(dateTime);
}

// Membuat random string untuk no invoice
function getNoInvoice() {
    let r = Math.random().toString(36).substring(4);
    let upR = "TRX" + r.toUpperCase();
    $("#strong_no_invoice").html(upR);
    $('input[name="no_invoice"]').val(upR);
    return upR;
}

// Memperbarui nomor pada baris tabel baru
function nomorBaru() {
    let no = 1;
    $("#tblTransaksi tbody tr").each(function () {
        $(this).find(".no").text(no);
        no++;
    });
}

// Memperbarui data produk
function updateProductData() {
    var selectedOption = $("#input_kode option:selected");
    var nm_barang_hide = selectedOption.text();
    var harga = selectedOption.attr("data-harga");
    var qty = parseInt($("#qty_head").val());

    if (selectedOption.val() !== "" && !isNaN(qty)) {
        var subtotal = harga * qty;

        $("#harga_head").val(harga);
        $("#subtotal_head").val(subtotal);
        $("#harga_head_tampil").val(formatCurrency(harga));
        $("#subtotal_head_tampil").val(formatCurrency(subtotal));

        $("#qty_head").prop("disabled", false);
        $("#btnAdd").prop("disabled", false);
        $("#btnAdd, #qty_head").css({
            cursor: "grab",
        });

        // Update subtotal for the selected product
        var selectedRowElement = $("#tbodyTransaksi tr:last");
        updateSubtotal(selectedRowElement);

    } // kosongkanHeader() dihapus dari sini
}

// Menghapus header transaksi
function kosongkanHeader() {
    $("#input_kode").val("").focus();
    $(
        "#id_barang_head, #stok_head, #qty_head, #harga_head, #harga_head_tampil, #subtotal_head, #subtotal_head_tampil"
    )
        .val("")
        .prop("disabled", true);
    $("#btnAdd").prop("disabled", true);
    $("#btnAdd, #qty_head").css({
        cursor: "not-allowed",
    });

    // Set nilai default 1 pada input #qty_head
    $("#qty_head").val("1");

    updateGrandTotal();
}






