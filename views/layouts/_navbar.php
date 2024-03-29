<?php

use yii\helpers\Url;
use app\models\User;
?>         
<div class="brand">
    <a href="<?= Yii::$app->homeUrl ?>"><img src="images/loan.png" alt="Klorofil Logo" class="pull-left" style="width: 30px; height: 30px; display: none"></a>
</div>
<div class="container-fluid">
    <div class="navbar-btn">
        <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
    </div>

    <div id="navbar-menu">
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown" style="display: none">
                <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                    <i class="lnr lnr-alarm"></i>
                    <span class="badge bg-danger">5</span>
                </a>
                <ul class="dropdown-menu notifications">
                    <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
                    <li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
                    <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
                    <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
                    <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
                    <li><a href="#" class="more">See all notifications</a></li>
                </ul>
            </li>
            <li class="dropdown" style="display: none">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Basic Use</a></li>
                    <li><a href="#">Working With Data</a></li>
                    <li><a href="#">Security</a></li>
                    <li><a href="#">Troubleshooting</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?= User::findOne(Yii::$app->user->id)->photo ?>" class="img img-circle" alt="User Image" style="width: 35px; height: 35px"> <span><?= Yii::$app->session->get('user')->getFullName() ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="<?= Url::to(['user/my-profile', 'id' => Yii::$app->user->id]) ?>"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
<!--                    <li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
                    <li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>-->
                    <li><a href="<?= Url::to(['site/log-me-out']) ?>"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                </ul>
            </li>
            <!-- <li>
                    <a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
            </li> -->
        </ul>
    </div>
</div>