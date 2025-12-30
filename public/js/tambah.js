document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('studentForm');
   
    form.addEventListener('submit', function(e) {
    e.preventDefault();
   
    // Ambil data dari input form
    const formData = {
        id: Date.now(),
        nama: document.getElementById('namaLengkap').options[document.getElementById('namaLengkap').selectedIndex].text,
        kelas: document.getElementById('kelas').value,
        semester: document.getElementById('semester').value,
        tahunAjaran: document.getElementById('tahunAjaran').value,
        tanggalPencatatan: new Date().toLocaleDateString('id-ID'),
        nilaiAgama: document.getElementById('nilaiAgama').value,
        deskripsiAgama: document.getElementById('deskripsiAgama').value,
        nilaiJatiDiri: document.getElementById('nilaiJatiDiri').value,
        deskripsiJatiDiri: document.getElementById('deskripsiJatiDiri').value,
        nilaiSTEM: document.getElementById('nilaiSTEM').value,
        deskripsiSTEM: document.getElementById('deskripsiSTEM').value,
        nilaiPancasila: document.getElementById('nilaiPancasila').value,
        deskripsiPancasila: document.getElementById('deskripsiPancasila').value
    };

    // Ambil data lama dari localStorage (kalau ada)
    let daftarCatatan = JSON.parse(localStorage.getItem('daftarCatatan')) || [];

    // Tambahkan data baru
    daftarCatatan.push(formData);

    // Simpan kembali ke localStorage
    localStorage.setItem('daftarCatatan', JSON.stringify(daftarCatatan));

    // Tampilkan notifikasi dan arahkan ke daftarCatatan
    alert('Data berhasil disimpan!');
    
    // Beri jeda sedikit agar alert selesai dulu
    setTimeout(() => {
        window.location.href = "daftarCatatan.html";
    }, 100);
});

    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                alert('Logout berhasil!');
            }
        });
    }

    const backBtn = document.getElementById('backBtn');
    if (backBtn) {
        backBtn.addEventListener('click', function() {
            window.history.back();
        });
    }
   
    const tahunInput = document.getElementById('tahunAjaran');
    tahunInput.addEventListener('blur', function() {
        let val = this.value.replace(/\D/g, '');
        if (val.length >= 4) {
            const y1 = val.substring(0, 4);
            const y2 = val.length >= 8 ? val.substring(4, 8) : parseInt(y1) + 1;
            this.value = `${y1}/${y2}`;
        }
    });
   
    const semesterInput = document.getElementById('semester');
    semesterInput.addEventListener('input', function() {
        if (this.value < 1) this.value = 1;
        if (this.value > 2) this.value = 2;
    });
});