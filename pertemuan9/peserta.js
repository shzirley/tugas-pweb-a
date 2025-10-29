let currentData = [];

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadData();
    
    // Sort change event
    document.getElementById('sortBy').addEventListener('change', function() {
        sortAndRenderData();
    });
});

// Load data from server
function loadData() {
    fetch('api/read.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentData = data.data;
                sortAndRenderData();
            } else {
                showNoData();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tableBody').innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #e74c3c;">
                        Gagal memuat data. Silakan refresh halaman.
                    </td>
                </tr>
            `;
        });
}

// Sort and render data
function sortAndRenderData() {
    const sortBy = document.getElementById('sortBy').value;
    
    let sortedData = [...currentData];
    
    switch(sortBy) {
        case 'tanggal_daftar_desc':
            sortedData.sort((a, b) => new Date(b.tanggal_daftar) - new Date(a.tanggal_daftar));
            break;
        case 'tanggal_daftar_asc':
            sortedData.sort((a, b) => new Date(a.tanggal_daftar) - new Date(b.tanggal_daftar));
            break;
        case 'nama_asc':
            sortedData.sort((a, b) => a.nama_lengkap.localeCompare(b.nama_lengkap));
            break;
        case 'nama_desc':
            sortedData.sort((a, b) => b.nama_lengkap.localeCompare(a.nama_lengkap));
            break;
        case 'nilai_desc':
            sortedData.sort((a, b) => parseFloat(b.nilai_rapor) - parseFloat(a.nilai_rapor));
            break;
        case 'nilai_asc':
            sortedData.sort((a, b) => parseFloat(a.nilai_rapor) - parseFloat(b.nilai_rapor));
            break;
    }
    
    renderTable(sortedData);
}

// Render table
function renderTable(data) {
    const tbody = document.getElementById('tableBody');
    
    if (data.length === 0) {
        showNoData();
        return;
    }
    
    let html = '';
    data.forEach((item, index) => {
        const tanggal = new Date(item.tanggal_daftar);
        const tanggalFormatted = tanggal.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        html += `
            <tr>
                <td>${index + 1}</td>
                <td>${escapeHtml(item.nama_lengkap)}</td>
                <td>${tanggalFormatted}</td>
                <td>${escapeHtml(item.jenis_kelamin)}</td>
                <td>${escapeHtml(item.jurusan)}</td>
                <td>${parseFloat(item.nilai_rapor).toFixed(2)}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="editPeserta(${item.id})" title="Edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
                        <button class="btn-icon btn-delete" onclick="deletePeserta(${item.id}, '${escapeHtml(item.nama_lengkap)}')" title="Hapus">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

// Show no data message
function showNoData() {
    document.getElementById('tableBody').innerHTML = `
        <tr>
            <td colspan="7" style="text-align: center; padding: 40px;">
                Belum ada peserta yang terdaftar
            </td>
        </tr>
    `;
}

// Edit peserta
function editPeserta(id) {
    const peserta = currentData.find(item => item.id === id);
    if (!peserta) return;
    
    // Fill form
    document.getElementById('editId').value = peserta.id;
    document.getElementById('editNamaLengkap').value = peserta.nama_lengkap;
    document.getElementById('editEmail').value = peserta.email;
    document.getElementById('editTanggalLahir').value = peserta.tanggal_lahir;
    
    if (peserta.jenis_kelamin === 'Laki-laki') {
        document.getElementById('editLakiLaki').checked = true;
    } else {
        document.getElementById('editPerempuan').checked = true;
    }
    
    document.getElementById('editAgama').value = peserta.agama;
    document.getElementById('editAlamat').value = peserta.alamat;
    document.getElementById('editJurusan').value = peserta.jurusan;
    document.getElementById('editNilaiRapor').value = peserta.nilai_rapor;
    
    // Show modal
    document.getElementById('editModal').classList.add('show');
}

// Close edit modal
function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
}

// Handle edit form submit
document.getElementById('formEdit').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Validation
    const namaLengkap = formData.get('namaLengkap').trim();
    const email = formData.get('email').trim();
    const jenisKelamin = formData.get('jenisKelamin');
    const nilaiRapor = formData.get('nilaiRapor');
    
    if (!namaLengkap || !email || !jenisKelamin || !nilaiRapor) {
        showAlert('Semua field harus diisi!', 'error');
        return;
    }
    
    const nilai = parseFloat(nilaiRapor);
    if (nilai < 0 || nilai > 100) {
        showAlert('Nilai rapor harus antara 0.00 - 100.00!', 'error');
        return;
    }
    
    // Send AJAX request
    fetch('api/update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            closeEditModal();
            loadData();
        } else {
            showAlert(data.message || 'Gagal mengupdate data!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan koneksi!', 'error');
    });
});

// Delete peserta
function deletePeserta(id, nama) {
    if (!confirm(`Apakah Anda yakin ingin menghapus data ${nama}?`)) {
        return;
    }
    
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('api/delete.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            loadData();
        } else {
            showAlert(data.message || 'Gagal menghapus data!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan koneksi!', 'error');
    });
}

// Show alert
function showAlert(message, type) {
    const alertBox = document.getElementById('alertBox');
    alertBox.textContent = message;
    alertBox.className = 'alert alert-' + type + ' show';
    
    alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    
    setTimeout(() => {
        alertBox.classList.remove('show');
    }, 5000);
}

// Escape HTML
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target === modal) {
        closeEditModal();
    }
}