document.addEventListener("DOMContentLoaded", () => {

    // ============================================
    // DESIGN SYSTEM — Laskar Cilik (Guru)
    // Palette: pastel kindergarten cheerful
    // ============================================
    const PALETTE = {
        blue:   "#94D9FF",
        purple: "#C69EF1",
        green:  "#C9F99C",
        yellow: "#FFE677",
        peach:  "#F7D0BE",
        pink:   "#F09AA8",

        blueBg:   "rgba(148,217,255,0.18)",
        purpleBg: "rgba(198,158,241,0.18)",
        greenBg:  "rgba(201,249,156,0.18)",
        yellowBg: "rgba(255,230,119,0.18)",
        peachBg:  "rgba(247,208,190,0.18)",
        pinkBg:   "rgba(240,154,168,0.18)",

        text:      "#64748B",
        gridColor: "rgba(198,158,241,0.08)",
    };

    // Global Chart.js defaults
    Chart.defaults.font.family = "'Nunito', sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = PALETTE.text;

    Chart.defaults.plugins.legend.labels.padding         = 18;
    Chart.defaults.plugins.legend.labels.usePointStyle   = true;
    Chart.defaults.plugins.legend.labels.pointStyleWidth = 8;
    Chart.defaults.plugins.legend.labels.font = {
        family: "'Nunito', sans-serif", size: 12, weight: "600"
    };

    Chart.defaults.plugins.tooltip.backgroundColor = "#2D3142";
    Chart.defaults.plugins.tooltip.titleFont = { family: "'Nunito', sans-serif", size: 12, weight: "700" };
    Chart.defaults.plugins.tooltip.bodyFont  = { family: "'Nunito', sans-serif", size: 12 };
    Chart.defaults.plugins.tooltip.padding      = 10;
    Chart.defaults.plugins.tooltip.cornerRadius = 10;
    Chart.defaults.plugins.tooltip.displayColors = true;
    Chart.defaults.plugins.tooltip.boxPadding   = 4;

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
    // 1. CATATAN MINGGUAN — Bar Chart
    // ============================================
    if (window.chartCatatanMingguanData && document.getElementById("chartCatatanMingguan")) {
        const ds = window.chartCatatanMingguanData.datasets[0];
        ds.backgroundColor = [
            PALETTE.purple, PALETTE.blue, PALETTE.green,
            PALETTE.yellow, PALETTE.peach,
        ];
        ds.borderRadius  = 8;
        ds.borderSkipped = false;
        ds.borderWidth   = 0;
        ds.hoverBackgroundColor = [
            "#B89DE8", "#6ECFFF", "#B7F26F", "#FFD83A", "#EFBFA8",
        ];

        new Chart(document.getElementById("chartCatatanMingguan"), {
            type: "bar",
            data: window.chartCatatanMingguanData,
            options: {
                responsive: true,
                scales: { x: sharedScaleX, y: sharedScaleY },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: (ctx) => `  ${ctx.parsed.y} catatan` }
                    },
                },
            },
        });
    }

    // ============================================
    // 2. PERKEMBANGAN SISWA — Line Chart
    // ============================================
    if (window.chartPerkembanganSiswaData && document.getElementById("chartPerkembanganSiswa")) {
        const ds = window.chartPerkembanganSiswaData.datasets[0];
        ds.borderColor        = PALETTE.purple;
        ds.backgroundColor    = PALETTE.purpleBg;
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
                scales: { x: sharedScaleX, y: sharedScaleY },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: (ctx) => `  ${ctx.parsed.y} siswa` }
                    },
                },
            },
        });
    }

    // ============================================
    // 3. GENDER SISWA — Doughnut
    // ============================================
    if (window.chartGenderSiswaData && document.getElementById("chartGenderSiswa")) {
        const ds = window.chartGenderSiswaData.datasets[0];
        ds.backgroundColor = [PALETTE.blue, PALETTE.pink];
        ds.borderColor     = "#ffffff";
        ds.borderWidth     = 3;
        ds.hoverOffset     = 6;

        new Chart(document.getElementById("chartGenderSiswa"), {
            type: "doughnut",
            data: window.chartGenderSiswaData,
            options: {
                cutout: "68%",
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: { padding: 16 },
                    },
                    tooltip: {
                        callbacks: { label: (ctx) => `  ${ctx.label}: ${ctx.parsed} siswa` }
                    },
                },
            },
        });
    }

    // ============================================
    // 4. KATEGORI CATATAN — Pie Chart
    // ============================================
    if (window.chartKategoriData && document.getElementById("chartKategori")) {
        const ds = window.chartKategoriData.datasets[0];
        ds.backgroundColor = [
            PALETTE.blue, PALETTE.pink, PALETTE.yellow, PALETTE.green,
        ];
        ds.borderColor = "#ffffff";
        ds.borderWidth = 3;
        ds.hoverOffset = 6;

        new Chart(document.getElementById("chartKategori"), {
            type: "pie",
            data: window.chartKategoriData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: { padding: 16 },
                    },
                    tooltip: {
                        callbacks: { label: (ctx) => `  ${ctx.label}: ${ctx.parsed} catatan` }
                    },
                },
            },
        });
    }

});