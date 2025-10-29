document.getElementById('formDaftar').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Reset alert
    const alertBox = document.getElementById('alertBox');
    alertBox.className = 'alert';
    alertBox.textContent = '';
    
    // Get form data
    const namaLengkap = document.getElementById('namaLengkap').value.trim();
    const email = document.getElementById('email').value.trim();
    const tanggalLahir = document.getElementById('tanggalLahir').value;
    const jenisKelamin = document.querySelector('input[name="jenisKelamin"]:checked');
    const agama = document.getElementById('agama').value;
    const alamat = document.getElementById('alamat').value.trim();
    const jurusan = document.getElementById('jurusan').value;
    const nilaiRapor = document.getElementById('nilaiRapor').value;
    
    // Validation
    if (!namaLengkap) {
        showAlert('Nama lengkap harus diisi!', 'error');
        return;
    }
    
    if (!email) {
        showAlert('Email harus diisi!', 'error');
        return;
    }
    
    if (!validateEmail(email)) {
        showAlert('Format email tidak valid!', 'error');
        return;
    }
    
    if (!tanggalLahir) {
        showAlert('Tanggal lahir harus diisi!', 'error');
        return;
    }
    
    if (!jenisKelamin) {
        showAlert('Jenis kelamin harus dipilih!', 'error');
        return;
    }
    
    if (!agama) {
        showAlert('Agama harus dipilih!', 'error');
        return;
    }
    
    if (!alamat) {
        showAlert('Alamat harus diisi!', 'error');
        return;
    }
    
    if (!jurusan) {
        showAlert('Jurusan harus dipilih!', 'error');
        return;
    }
    
    if (!nilaiRapor) {
        showAlert('Nilai rapor harus diisi!', 'error');
        return;
    }
    
    const nilai = parseFloat(nilaiRapor);
    if (nilai < 0 || nilai > 100) {
        showAlert('Nilai rapor harus antara 0.00 - 100.00!', 'error');
        return;
    }
    
    // Prepare data
    const formData = new FormData();
    formData.append('namaLengkap', namaLengkap);
    formData.append('email', email);
    formData.append('tanggalLahir', tanggalLahir);
    formData.append('jenisKelamin', jenisKelamin.value);
    formData.append('agama', agama);
    formData.append('alamat', alamat);
    formData.append('jurusan', jurusan);
    formData.append('nilaiRapor', nilai);
    
    // Send AJAX request
    fetch('api/create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reset form
            document.getElementById('formDaftar').reset();
            
            // Show success message
            showAlert(data.message, 'success');
            document.getElementById('successMessage').classList.add('show');
            
            // Scroll to success message
            document.getElementById('successMessage').scrollIntoView({ behavior: 'smooth' });
        } else {
            showAlert(data.message || 'Terjadi kesalahan saat mendaftar!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan koneksi. Silakan coba lagi.', 'error');
    });
});

function showAlert(message, type) {
    const alertBox = document.getElementById('alertBox');
    alertBox.textContent = message;
    alertBox.className = 'alert alert-' + type + ' show';
    
    // Scroll to alert
    alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}