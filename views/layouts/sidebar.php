<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <img src="<?= Url::to('@web/images/jakpro.png') ?>" alt="Jakpro Logo" style="height: 100px; margin-bottom: 10px;">
                    <!-- <a href="<?= Url::to(['/site/index']) ?>">SAW</a> -->
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item">
                    <a href="<?= Url::to(['/site/index']) ?>" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                        <span>Data</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item">
                            <a href="<?= Url::to(['/alternative/index']) ?>">Alternatif</a>
                        </li>
                        <li class="submenu-item">
                            <a href="<?= Url::to(['/criteria/index']) ?>">Bobot &amp; Kriteria</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="<?= Url::to(['/matrix/index']) ?>" class='sidebar-link'>
                        <i class="bi bi-pentagon-fill"></i>
                        <span>Matrik</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="<?= Url::to(['/preference/index']) ?>" class='sidebar-link'>
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Nilai Preferensi</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="<?= Url::to(['/site/logout']) ?>" class='sidebar-link'>
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>