<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yiister\gentelella\widgets\Menu;

$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>">
    <?php $this->beginBody(); ?>
    <div class="container body">

        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="/" class="site_title"><span>Project Apples</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <br/>

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <?=
                            Menu::widget(
                                [
                                    "items" => [
                                        [
                                            "label" => "Яблоки",
                                            "url" => "/apple/apple",
                                            "icon" => "table",
                                        ]
                                    ]
                                ]
                            );
                            ?>

                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <!-- <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div> -->
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>

                        </div>
                        <div class="navbar navbar-nav navbar-btn">
                            <a class="nav-item btn " href="/">Главная</a>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <?php if (!Yii::$app->user->isGuest): ?>
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <?= Yii::$app->user->identity->username ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">

                                    <li>
                                        <?= Html::a('<i class="fa fa-sign-out pull-right"></i>Выйти',
                                            ['//site/logout'],
                                            ['data-method' => 'post']);
                                        ?>
                                    </li>
                                </ul>
                            </li>
                            <?php endif ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="clearfix"></div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="float-sm-left">
                            <?= \yii\widgets\Breadcrumbs::widget([
                                'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                                'activeItemTemplate' => "<li class='active breadcrumb-item'>{link}</li>\n",
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]); ?>
                        </div>
                    </div>
                </div>
                <?= $content ?>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="clearfix">Project Apples</div>
            </footer>
            <!-- /footer content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
    <!-- /footer content -->
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>