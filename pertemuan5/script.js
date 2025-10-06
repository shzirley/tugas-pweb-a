// === FORM MAHASISWA ===
const formMahasiswa = document.getElementById("formMahasiswa");
if (formMahasiswa) {
    formMahasiswa.addEventListener("submit", function(e) {
        e.preventDefault();

        const nama = document.getElementById("nama").value;
        const nrp = document.getElementById("nrp").value;
        const matkul = document.getElementById("matkul").value;
        const dosen = document.getElementById("dosen").value;

        if (!nama || !nrp || !matkul || !dosen) {
            alert("Harap isi semua kolom terlebih dahulu!");
            return;
        }

        alert(
            `Pendaftaran Berhasil!\n\n` +
            `Nama Mahasiswa: ${nama}\n` +
            `NRP: ${nrp}\n` +
            `Mata Kuliah: ${matkul}\n` +
            `Dosen: ${dosen}`
        );

        formMahasiswa.reset();
    });
}

// === FORM PRODUK ===
const formProduk = document.getElementById("formProduk");
if (formProduk) {
    formProduk.addEventListener("submit", function(e) {
        e.preventDefault();

        const jenisProduk = document.getElementById("jenisProduk").value;
        const pilihMerk = document.getElementById("pilihMerk").value;

        if (!jenisProduk || !pilihMerk) {
            alert("Harap pilih semua opsi terlebih dahulu!");
            return;
        }

        alert(
            `Produk berhasil dikirim!\n\n` +
            `Jenis Produk: ${jenisProduk}\n` +
            `Merek: ${pilihMerk}`
        );

        formProduk.reset();
    });
}
