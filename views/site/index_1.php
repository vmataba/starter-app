<?php
$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use app\models\User;
use app\models\FinancialRequest;
use app\models\Employee;
use app\models\Retirement;
use app\assets\tools\Tool;
?>              
<!-- OVERVIEW -->
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">General Overview</h3>
        <p class="panel-subtitle">Period: <?= Tool::getFormattedDate(date('Y-m-d H:i:s'), false) ?></p>
    </div>
    <div class="panel-body">
        <div class="row">

            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-money"></i></span>
                    <p>
                        <span class="number"><?= number_format(FinancialRequest::count()) ?></span>
                        <span class="title">
                            <a href="<?= Url::to(['financial-request/index']) ?>">Financial Requests</a>
                        </span>
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-bar-chart"></i></span>
                    <p>
                        <span class="number"><?= number_format(Retirement::count()) ?></span>
                        <span class="title">Retirements</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-sitemap"></i></span>
                    <p>
                        <span class="number"><?= number_format(Employee::count()) ?></span>
                        <span class="title">
                            <a href="<?= Url::to(['employee/index']) ?>">Employees</a>
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-users"></i></span>
                    <p>
                        <span class="number"><?= number_format(User::count()) ?></span>
                        <span class="title">
                            <a href="<?= Url::to(['user/index']) ?>">
                                System Users
                            </a>
                        </span>
                    </p>
                </div>
            </div>



        </div>
        <div class="row" hidden="">
            <div class="col-md-12">
                <?=
                Highcharts::widget([
                    'options' => [
                        'chart' => [
                            'type' => 'pie'
                        ],
                        'title' => ['text' => 'Cash Requisitions'],
                        'xAxis' => [
                            'categories' => ['Cash Requisition']
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'Fruit eaten']
                        ],
                        'series' => [
                            ['name' => 'Jane', 'data' => [100],'color' => 'green'],
                            ['name' => 'John', 'data' => [5], 'color' => 'red']
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<!-- END OVERVIEW -->
<div class="row">
    <div class="col-md-12">
        <!-- RECENT PURCHASES -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Recent Financial Requests</h3>
                <div class="right">
                    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                    <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                </div>
            </div>
            <div class="panel-body no-padding">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Date &amp; Time</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $count = 1; ?>

                        <?php foreach (FinancialRequest::getRecentFinancialRequest() as $request): ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $request->getEmployee()->getFullName() ?></td>
                                <td><?= number_format($request->amount, 2) ?></td>
                                <td><?= Tool::getFormattedDate($request->requested_at, false) ?></td>
                                <td><span><?= $request->getStyledStatus() ?></span></td>
                                <td>
                                    <a href="<?= Url::to(['/financial-request/view','id' => $request->id])?>">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $count++ ?>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> All the time</span></div>
                    <div class="col-md-6 text-right"><a href="<?= Url::to(['financial-request/index']) ?>" class="btn btn-primary">View All Requests</a></div>
                </div>
            </div>
        </div>
        <!-- END RECENT PURCHASES -->
    </div>
</div>



<script>
    /*
     $(function ()
     {
     
     var data, options;
     
     // headline charts
     data = {
     labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
     series: [
     [23, 29, 24, 40, 25, 24, 35],
     [14, 25, 18, 34, 29, 38, 44],
     ]
     };
     
     options = {
     height: 300,
     showArea: true,
     showLine: false,
     showPoint: false,
     fullWidth: true,
     axisX: {
     showGrid: false
     },
     lineSmooth: false,
     };
     
     new Chartist.Line('#headline-chart', data, options);
     
     
     // visits trend charts
     data = {
     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
     series: [{
     name: 'series-real',
     data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
     }, {
     name: 'series-projection',
     data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
     }]
     };
     
     options = {
     fullWidth: true,
     lineSmooth: false,
     height: "270px",
     low: 0,
     high: 'auto',
     series: {
     'series-projection': {
     showArea: true,
     showPoint: false,
     showLine: false
     },
     },
     axisX: {
     showGrid: false,
     
     },
     axisY: {
     showGrid: false,
     onlyInteger: true,
     offset: 0,
     },
     chartPadding: {
     left: 20,
     right: 20
     }
     };
     
     new Chartist.Line('#visits-trends-chart', data, options);
     
     
     // visits chart
     data = {
     labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
     series: [
     [6384, 6342, 5437, 2764, 3958, 5068, 7654]
     ]
     };
     
     options = {
     height: 300,
     axisX: {
     showGrid: false
     },
     };
     
     new Chartist.Bar('#visits-chart', data, options);
     
     
     // real-time pie chart
     var sysLoad = $('#system-load').easyPieChart({
     size: 130,
     barColor: function (percent) {
     return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
     },
     trackColor: 'rgba(245, 245, 245, 0.8)',
     scaleColor: false,
     lineWidth: 5,
     lineCap: "square",
     animate: 800
     });
     
     var updateInterval = 3000; // in milliseconds
     
     setInterval(function () {
     var randomVal;
     randomVal = getRandomInt(0, 100);
     
     sysLoad.data('easyPieChart').update(randomVal);
     sysLoad.find('.percent').text(randomVal);
     }, updateInterval);
     
     function getRandomInt(min, max) {
     return Math.floor(Math.random() * (max - min + 1)) + min;
     }
     
     });*/
</script>