document.addEventListener("DOMContentLoaded", () => {

    // ============================================
    // DESIGN SYSTEM - Laskar Cilik Redesign
    // ============================================

    const PALETTE = {
    blue: "#94D9FF",       // lingkaran biru
    purple: "#C69EF1",     // kotak ungu
    green: "#C9F99C",      // lingkaran hijau
    yellow: "#FFE677",     // segitiga kuning
    peach: "#F7D0BE",      // lingkaran peach
    pink: "#F09AA8",       // alas pink

    blueBg: "rgba(148,217,255,0.18)",
    purpleBg: "rgba(198,158,241,0.18)",
    greenBg: "rgba(201,249,156,0.18)",
    yellowBg: "rgba(255,230,119,0.18)",
    peachBg: "rgba(247,208,190,0.18)",
    pinkBg: "rgba(240,154,168,0.18)",

    text: "#64748B",
    border: "#ECEEF8",
    gridColor: "rgba(198,158,241,0.08)"
};

    // Global Chart.js defaults
    Chart.defaults.font.family = "'Nunito', sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = PALETTE.text;

    Chart.defaults.plugins.legend.labels.padding        = 18;
    Chart.defaults.plugins.legend.labels.usePointStyle  = true;
    Chart.defaults.plugins.legend.labels.pointStyleWidth = 8;
    Chart.defaults.plugins.legend.labels.font = {
        family: "'Nunito', sans-serif",
        size:   12,
        weight: "600",
    };

    Chart.defaults.plugins.tooltip.backgroundColor = "#2D3142";
    Chart.defaults.plugins.tooltip.titleFont       = { family: "'Nunito', sans-serif", size: 12, weight: "700" };
    Chart.defaults.plugins.tooltip.bodyFont        = { family: "'Nunito', sans-serif", size: 12 };
    Chart.defaults.plugins.tooltip.padding         = 10;
    Chart.defaults.plugins.tooltip.cornerRadius    = 10;
    Chart.defaults.plugins.tooltip.displayColors   = true;
    Chart.defaults.plugins.tooltip.boxPadding      = 4;

    // Shared scale options (reused across bar/line charts)
    const sharedScaleX = {
        grid:  { color: PALETTE.gridColor, drawBorder: false },
        ticks: { color: PALETTE.text, font: { family: "'Nunito', sans-serif", size: 11, weight: "600" } },
        border:{ dash: [4, 4], display: false },
    };

    const sharedScaleY = {
        beginAtZero: true,
        ticks: {
            precision: 0,
            color: PALETTE.text,
            font: { family: "'Nunito', sans-serif", size: 11, weight: "600" },
        },
        grid:  { color: PALETTE.gridColor, drawBorder: false },
        border:{ dash: [4, 4], display: false },
    };

    // ============================================
    // 1. PERKEMBANGAN SISWA — Line Chart
    // ============================================
    if (window.chartPerkembanganSiswaData && document.getElementById("chartPerkembanganSiswa")) {
        const ds = window.chartPerkembanganSiswaData.datasets[0];
         ds.borderColor = PALETTE.purple;
         ds.backgroundColor = PALETTE.purpleBg;
         ds.pointBackgroundColor = PALETTE.purple;
        ds.pointBorderColor   = "#ffffff";
        ds.pointBorderWidth   = 2;
        ds.pointRadius        = 5;
        ds.pointHoverRadius   = 7;
        ds.tension            = 0.4;
        ds.fill               = true;
        ds.borderWidth        = 2.5;

        new Chart(document.getElementById("chartPerkembanganSiswa"), {
            type: "line",
            data: window.chartPerkembanganSiswaData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    x: sharedScaleX,
                    y: sharedScaleY,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `  ${ctx.parsed.y} siswa`,
                        },
                    },
                },
            },
        });
    }

    // ============================================
    // 2. DISTRIBUSI SISWA PER KELAS — Pie Chart
    // ============================================
    if (window.chartDistribusiKelasData && document.getElementById("chartDistribusiKelas")) {
       window.chartDistribusiKelasData.datasets[0].backgroundColor = [
    PALETTE.blue,
    PALETTE.purple,
    PALETTE.green,
    PALETTE.yellow,
    PALETTE.peach,
    PALETTE.pink,
];
        window.chartDistribusiKelasData.datasets[0].borderColor   = "#ffffff";
        window.chartDistribusiKelasData.datasets[0].borderWidth   = 3;
        window.chartDistribusiKelasData.datasets[0].hoverOffset   = 6;

        new Chart(document.getElementById("chartDistribusiKelas"), {
            type: "pie",
            data: window.chartDistribusiKelasData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: { padding: 16 },
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `  ${ctx.label}: ${ctx.parsed} siswa`,
                        },
                    },
                },
            },
        });
    }

    // ============================================
    // 3. DISTRIBUSI GENDER — Doughnut Chart
    // ============================================
    if (window.chartGenderData && document.getElementById("chartGender")) {
        window.chartGenderData.datasets[0].backgroundColor = [
    PALETTE.blue,
    PALETTE.pink,
];
        window.chartGenderData.datasets[0].borderColor   = "#ffffff";
        window.chartGenderData.datasets[0].borderWidth   = 3;
        window.chartGenderData.datasets[0].hoverOffset   = 6;

        new Chart(document.getElementById("chartGender"), {
            type: "doughnut",
            data: window.chartGenderData,
            options: {
                cutout: "68%",
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: { padding: 16 },
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `  ${ctx.label}: ${ctx.parsed} siswa`,
                        },
                    },
                },
            },
        });
    }

    // ============================================
    // 4. STATUS SISWA — Bar Chart
    // ============================================
    if (window.chartStatusSiswaData && document.getElementById("chartStatus")) {
        window.chartStatusSiswaData.datasets[0].backgroundColor = [
    PALETTE.green,   // Aktif
    PALETTE.blue,    // Lulus
    PALETTE.yellow,  // Pindah
    PALETTE.pink,    // Keluar
];
        window.chartStatusSiswaData.datasets[0].borderRadius    = 8;
        window.chartStatusSiswaData.datasets[0].borderSkipped   = false;
        window.chartStatusSiswaData.datasets[0].borderWidth     = 0;
        window.chartStatusSiswaData.datasets[0].hoverBackgroundColor = [
    "#B7F26F",
    "#6ECFFF",
    "#FFD83A",
    "#EB6F84",
];

        new Chart(document.getElementById("chartStatus"), {
            type: "bar",
            data: window.chartStatusSiswaData,
            options: {
                responsive: true,
                scales: {
                    x: sharedScaleX,
                    y: { ...sharedScaleY },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `  ${ctx.parsed.y} siswa`,
                        },
                    },
                },
            },
        });
    }

    // ============================================
    // 5. PERKEMBANGAN GURU — Line Chart
    // ============================================
    if (window.chartPerkembanganGuruData && document.getElementById("chartPerkembanganGuru")) {
        const ds = window.chartPerkembanganGuruData.datasets[0];
       ds.borderColor = PALETTE.blue;
    ds.backgroundColor = PALETTE.blueBg;
    ds.pointBackgroundColor = PALETTE.blue;
        ds.pointBorderColor   = "#ffffff";
        ds.pointBorderWidth   = 2;
        ds.pointRadius        = 5;
        ds.pointHoverRadius   = 7;
        ds.tension            = 0.4;
        ds.fill               = true;
        ds.borderWidth        = 2.5;

        new Chart(document.getElementById("chartPerkembanganGuru"), {
            type: "line",
            data: window.chartPerkembanganGuruData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    x: sharedScaleX,
                    y: sharedScaleY,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `  ${ctx.parsed.y} guru`,
                        },
                    },
                },
            },
        });
    }

    // ============================================
    // 6. STATUS AKUN GURU — Bar Chart
    // ============================================
    if (window.chartStatusGuruData && document.getElementById("chartStatusGuru")) {
       window.chartStatusGuruData.datasets[0].backgroundColor = [
    PALETTE.green,
    PALETTE.pink,
];
        window.chartStatusGuruData.datasets[0].borderRadius  = 8;
        window.chartStatusGuruData.datasets[0].borderSkipped = false;
        window.chartStatusGuruData.datasets[0].borderWidth   = 0;

        new Chart(document.getElementById("chartStatusGuru"), {
            type: "bar",
            data: window.chartStatusGuruData,
            options: {
                responsive: true,
                scales: {
                    x: sharedScaleX,
                    y: { ...sharedScaleY },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `  ${ctx.parsed.y} guru`,
                        },
                    },
                },
            },
        });
    }

});
