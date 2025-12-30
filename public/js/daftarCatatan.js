document.addEventListener('DOMContentLoaded', function() {
    const siswaSelect = document.getElementById('id_siswa');
    const kelasDisplay = document.getElementById('kelas_display');
    
    if (siswaSelect && kelasDisplay) {
        siswaSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const kelas = selectedOption.getAttribute('data-kelas');
            kelasDisplay.value = kelas || '';
        });

        if (siswaSelect.value) {
            siswaSelect.dispatchEvent(new Event('change'));
        }
    }

    const tahunInput = document.getElementById('tahun_ajaran');
    if (tahunInput) {
        tahunInput.addEventListener('blur', function() {
            let val = this.value.replace(/\D/g, '');
            if (val.length >= 4) {
                const y1 = val.substring(0, 4);
                const y2 = val.length >= 8 ? val.substring(4, 8) : parseInt(y1) + 1;
                this.value = `${y1}/${y2}`;
            }
        });
    }

    const semesterInput = document.getElementById('semester');
    if (semesterInput) {
        semesterInput.addEventListener('input', function() {
            if (this.value < 1) this.value = 1;
            if (this.value > 2) this.value = 2;
        });
    }

});