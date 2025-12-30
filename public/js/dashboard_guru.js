document.addEventListener("DOMContentLoaded", function () {

    // Ambil canvas
    let weeklyCanvas = document.getElementById('weeklyChart');
    let growthCanvas = document.getElementById('growthChart');
    let genderCanvas = document.getElementById('genderChart');

    // Ambil data dari HTML dataset
    let catatanData = JSON.parse(weeklyCanvas.dataset.catatan);
    let growthLabels = JSON.parse(growthCanvas.dataset.labels);
    let growthData = JSON.parse(growthCanvas.dataset.values);
    let genderData = JSON.parse(genderCanvas.dataset.gender);

    // Chart 1: Bar mingguan
    new Chart(weeklyCanvas, {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
            datasets: [{
                label: 'Catatan Mingguan',
                data: catatanData,
                backgroundColor: '#46b3ff'
            }]
        }
    });

    // Chart 2: Line siswa / tahun
    new Chart(growthCanvas, {
        type: 'line',
        data: {
            labels: growthLabels,
            datasets: [{
                label: 'Pertumbuhan Siswa',
                data: growthData,
                borderColor: '#0078ff',
                borderWidth: 2
            }]
        }
    });

    // Chart 3: Gender siswa
    new Chart(genderCanvas, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [genderData.lakiLaki, genderData.perempuan],
                backgroundColor: ['#0078ff', '#ff2f7a']
            }]
        }
    });

});
