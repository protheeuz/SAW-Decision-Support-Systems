<?php
use yii\helpers\Html;
use app\models\Alternative;
use app\models\Criteria;

/* @var $this yii\web\View */
/* @var $totalAlternatives int */
/* @var $totalCriterias int */
/* @var $totalPreferences int */
/* @var $role string */

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
                    <h4>Total Preferensi</h4>
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?= $totalPreferences ?></h3>
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
                    <h4>Grafik Total</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM fully loaded and parsed");

        var ctx = document.getElementById('myChart').getContext('2d');
        console.log(ctx); // Check if ctx is properly initialized

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Alternatif', 'Total Kriteria', 'Total Preferensi'],
                datasets: [{
                    label: 'Jumlah',
                    data: [<?= $totalAlternatives ?>, <?= $totalCriterias ?>, <?= $totalPreferences ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        console.log("Chart initialized");
    });
</script>