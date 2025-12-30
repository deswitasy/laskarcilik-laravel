document.addEventListener("DOMContentLoaded", () => {

    const COLORS = {
        blue: "#36A2EB",
        pink: "#FF6384",
        green: "#28a745",
        red: "#dc3545",
        yellow: "#FFCE56",
        purple: "#9966FF",
        teal: "#4BC0C0"
    };

    // PERKEMBANGAN SISWA
    if (window.chartPerkembanganSiswaData) {
        new Chart(document.getElementById("chartPerkembanganSiswa"), {
            type: "line",
            data: window.chartPerkembanganSiswaData,
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    // DISTRIBUSI KELAS
    if (window.chartDistribusiKelasData) {
        window.chartDistribusiKelasData.datasets[0].backgroundColor = [
            COLORS.blue, COLORS.pink, COLORS.yellow, COLORS.teal, COLORS.purple
        ];

        new Chart(document.getElementById("chartDistribusiKelas"), {
            type: "pie",
            data: window.chartDistribusiKelasData
        });
    }

    // GENDER SISWA
    if (window.chartGenderData) {
        window.chartGenderData.datasets[0].backgroundColor = [
            COLORS.blue, COLORS.pink
        ];

        new Chart(document.getElementById("chartGender"), {
            type: "doughnut",
            data: window.chartGenderData,
            options: { cutout: "70%" }
        });
    }
    // STATUS SISWA
    if (window.chartStatusSiswaData) {
        window.chartStatusSiswaData.datasets[0].backgroundColor = [
            COLORS.green, COLORS.red
        ];

        new Chart(document.getElementById("chartStatus"), {
            type: "bar",
            data: window.chartStatusSiswaData,
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    // PERKEMBANGAN GURU
    if (window.chartPerkembanganGuruData) {
        new Chart(document.getElementById("chartPerkembanganGuru"), {
            type: "line",
            data: window.chartPerkembanganGuruData,
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    // STATUS GURU (HIJAU / MERAH)
    if (window.chartStatusGuruData) {
        window.chartStatusGuruData.datasets[0].backgroundColor = [
            COLORS.green, // aktif
            COLORS.red    // nonaktif
        ];

        new Chart(document.getElementById("chartStatusGuru"), {
            type: "bar",
            data: window.chartStatusGuruData,
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

});
