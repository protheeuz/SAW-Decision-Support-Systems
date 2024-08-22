<?php

use yii\helpers\Html;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $totalAlternatives int */
/* @var $totalCriterias int */
/* @var $totalSubCriterias int */
/* @var $role string */
/* @var $chartData array */
/* @var $criteriaChartData array */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/Chart.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/pages/ui-chartjs.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>
<div class="page-heading">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="alert alert-success">
                Halo, Selamat datang <?= Html::encode($role) ?>
            </div>
        </div>
        <div class="col-12 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Total Alternatif</h4>
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?= $totalAlternatives ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Total Kriteria</h4>
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?= $totalCriterias ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Total Sub-Kriteria</h4>
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?= $totalSubCriterias ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sistem Penilaian Karyawan PT. Jakarta Propertindo</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p class="card-text">
                            Metode Simple Additive Weighting (SAW) sering juga dikenal istilah metode penjumlahan terbobot.
                            Konsep dasar metode SAW adalah mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif
                            pada semua atribut (Fishburn 1967). SAW dapat dianggap sebagai cara yang paling mudah dan intuitif
                            untuk menangani masalah Multiple Criteria Decision-Making MCDM, karena fungsi linear additive dapat
                            mewakili preferensi pembuat keputusan (Decision-Making, DM). Hal tersebut dapat dibenarkan, namun,
                            hanya ketika asumsi preference independence (Keeney & Raiffa 1976) atau preference separability (Gorman 1968)
                            terpenuhi.
                        </p>
                        <hr>
                        <p class="card-text">
                            Langkah Penyelesaian Simple Additive Weighting (SAW) adalah sebagai berikut:
                        </p>
                        <ol type="1">
                            <li>Menentukan kriteria-kriteria yang akan dijadikan acuan dalam pengambilan keputusan, yaitu Ci</li>
                            <li>Menentukan rating kecocokan setiap alternatif pada setiap kriteria (X).</li>
                            <li>Membuat matriks keputusan berdasarkan kriteria (Ci), kemudian melakukan normalisasi matriks berdasarkan
                                persamaan yang disesuaikan dengan jenis atribut (atribut keuntungan ataupun atribut biaya) sehingga
                                diperoleh matriks ternormalisasi R.</li>
                            <li>Hasil akhir diperoleh dari proses perankingan yaitu penjumlahan dari perkalian matriks ternormalisasi R
                                dengan vektor bobot sehingga diperoleh nilai terbesar yang dipilih sebagai alternatif terbaik
                                (Ai) sebagai solusi.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Tingkatan Skor Alternatif</h4>
                    <!-- Tambahkan Dropdown untuk Memilih Alternatif -->
                    <select id="alternativeSelect" class="form-control">
                        <option value="">Pilih Alternatif</option>
                        <?php foreach ($chartData as $data): ?>
                            <option value="<?= Html::encode($data['alternative_name']) ?>"><?= Html::encode($data['alternative_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="scoreChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Peningkatan Nilai Penilaian Alternatif</h4>
                </div>
                <div class="card-body">
                    <canvas id="improvementChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Per Kriteria</h4>
                </div>
                <div class="card-body">
                    <canvas id="criteriaChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12" id="alternativeChartCard" style="display: none;">
            <div class="card">
                <div class="card-header">
                    <h4>Alternatif Tertinggi untuk Kriteria: <span id="selectedCriteria"></span></h4>
                </div>
                <div class="card-body">
                    <canvas id="alternativeChart"></canvas>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM fully loaded and parsed");

        var chartData = <?= json_encode($chartData) ?>;
        var criteriaChartData = <?= json_encode($criteriaChartData) ?>;

        // Group data by alternative
        var groupedData = chartData.reduce(function(acc, current) {
            if (!acc[current.alternative_name]) {
                acc[current.alternative_name] = [];
            }
            acc[current.alternative_name].push(current);
            return acc;
        }, {});

        // Fungsi untuk membuat dataset grafik dari groupedData
        function createDatasets(groupedData, allYears) {
            var datasets = [];
            for (var alternative in groupedData) {
                datasets.push({
                    label: alternative,
                    data: allYears.map(function(year) {
                        var entry = groupedData[alternative].find(function(item) {
                            return item.year === year;
                        });
                        return entry ? entry.score : 0;
                    }),
                    backgroundColor: getRandomColor(),
                    borderColor: getRandomColor(),
                    borderWidth: 1
                });
            }
            return datasets;
        }

        // Mendapatkan semua tahun yang ada dalam data
        var allYears = [...new Set(chartData.map(data => data.year))];

        // Grafik Bar untuk Tingkatan Skor Alternatif per Tahun
        var ctx = document.getElementById('scoreChart').getContext('2d');
        var scoreChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: allYears,
                datasets: createDatasets(groupedData, allYears)
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: 'rgba(54, 162, 235, 1)'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        // Event listener for the dropdown
        document.getElementById('alternativeSelect').addEventListener('change', function() {
            var selectedAlternative = this.value;

            if (selectedAlternative) {
                var filteredData = groupedData[selectedAlternative] || [];

                var datasets = [{
                    label: selectedAlternative,
                    data: allYears.map(function(year) {
                        var entry = filteredData.find(function(item) {
                            return item.year === year;
                        });
                        return entry ? entry.score : 0;
                    }),
                    backgroundColor: getRandomColor(),
                    borderColor: getRandomColor(),
                    borderWidth: 1
                }];

                scoreChart.data.datasets = datasets;
            } else {
                // Tampilkan semua data jika tidak ada alternatif yang dipilih
                scoreChart.data.datasets = createDatasets(groupedData, allYears);
            }

            scoreChart.update();
        });

        // Fungsi untuk menghasilkan warna acak
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Grafik Line untuk Peningkatan Nilai Penilaian Alternatif
        var improvementCtx = document.getElementById('improvementChart').getContext('2d');
        var lineLabels = [...new Set(chartData.map(data => data.year))];
        var lineDatasets = [...new Set(chartData.map(data => data.alternative_name))].map(label => {
            return {
                label: label,
                data: lineLabels.map(year => {
                    var entry = chartData.find(data => data.alternative_name === label && data.year === year);
                    return entry ? entry.score : 0;
                }),
                fill: false,
                borderColor: getRandomColor(),
                tension: 0.1
            };
        });

        var improvementChart = new Chart(improvementCtx, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: lineDatasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: 'rgba(54, 162, 235, 1)'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        // Grafik Bar untuk Kriteria
        var criteriaCtx = document.getElementById('criteriaChart').getContext('2d');
        var criteriaLabels = criteriaChartData.map(data => data.criteria_name);
        var criteriaScores = criteriaChartData.map(data => data.score);

        var criteriaChart = new Chart(criteriaCtx, {
            type: 'bar',
            data: {
                labels: criteriaLabels,
                datasets: [{
                    label: 'Skor Kriteria',
                    data: criteriaScores,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: getRandomColor(),
                    borderWidth: 1
                }]
            },
            options: {
                onClick: function(evt) {
                    var activePoints = criteriaChart.getElementsAtEventForMode(evt, 'nearest', {
                        intersect: true
                    }, true);
                    if (activePoints.length > 0) {
                        var index = activePoints[0].index;
                        var selectedCriteria = criteriaLabels[index];
                        displayAlternativeChart(selectedCriteria);
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        var alternativeChart; // Declare the variable for alternativeChart globally

        // Menampilkan nama alternatif tertinggi untuk kriteria yang dipilih
        function displayAlternativeChart(criteriaName) {
            var alternativeChartCard = document.getElementById('alternativeChartCard');
            var selectedCriteriaSpan = document.getElementById('selectedCriteria');
            var alternativeCtx = document.getElementById('alternativeChart').getContext('2d');

            selectedCriteriaSpan.textContent = criteriaName;
            alternativeChartCard.style.display = 'block';

            fetch('<?= \yii\helpers\Url::to(['site/top-alternative']) ?>?criteria=' + encodeURIComponent(criteriaName))
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        // Filter out entries with null alternative_name
                        data = data.filter(item => item.alternative_name !== null);

                        // Group data by alternative name
                        var groupedData = data.reduce(function(acc, current) {
                            if (!acc[current.alternative_name]) {
                                acc[current.alternative_name] = [];
                            }
                            acc[current.alternative_name].push(current);
                            return acc;
                        }, {});

                        var barLabels = [...new Set(data.map(item => item.year))];
                        var barDatasets = Object.keys(groupedData).map(function(alternative) {
                            return {
                                label: alternative,
                                data: barLabels.map(function(year) {
                                    var entry = groupedData[alternative].find(item => item.year == year);
                                    return entry ? entry.score : 0;
                                }),
                                backgroundColor: getRandomColor(),
                                borderColor: getRandomColor(),
                                borderWidth: 1
                            };
                        });

                        if (alternativeChart) {
                            alternativeChart.destroy(); // Destroy existing chart before creating a new one
                        }

                        alternativeChart = new Chart(alternativeCtx, {
                            type: 'bar',
                            data: {
                                labels: barLabels,
                                datasets: barDatasets
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 10
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        labels: {
                                            color: '#333'
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        console.log("No data received for criteria: " + criteriaName);
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        console.log("Charts initialized");
    });
</script>