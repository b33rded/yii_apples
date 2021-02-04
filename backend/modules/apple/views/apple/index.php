<?php

use common\models\AppleStatus;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Яблоки';

$this->params['breadcrumbs'][] = Yii::t('app', $this->title);

CrudAsset::register($this);
?>

<div class="apple-index">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <div id="ajaxCrudDatatable">

        <p>
            <?= Html::a(
                'Создать',
                Url::to([
                    'generate',
                ]),
                [
                    'id' => 'grid-apple-generate-btn',
                    'class' => 'btn btn-success btn-lg',
                    'role' => 'modal-remote'
                ]);
            ?>
        </p>

        <?= GridView::widget([
            'id' => 'apple-grid',
            'pjax' => true,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'color',
                    'width' => '12em',
                    'format' => 'raw',
                    'contentOptions' => function ($model) {
                        $color = $model->color ? $model->color : '';
                        return ['style' => "background-color:" . $color];
                    }
                ],

                [
                    'class' => DataColumn::class,
                    'attribute' => 'status_id',
                    'width' => '20em',
                    'value' => 'status.name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map(
                        AppleStatus::exceptRotten()->all(),
                        'id',
                        'name'
                    ),
                    'filterWidgetOptions' => [
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ],
                    'filterInputOptions' => ['placeholder' => 'Выбрать'],
                ],
                [
                    'attribute' => 'date_created',
                    'format' => ['date', 'php:d.m.Y, H:i'],
                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => ([
                        'attribute' => 'date_created',
                        'pluginOptions' => [
                            'format' => 'yyyy-m-d',

                        ],
                    ])
                ],

                'integrity',

                [
                    'attribute' => 'apple_status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $drop = new DateTime($model->date_drop);
                        $now = new DateTime();
                        $interval = $now->diff($drop);

                        $text = "Лежит на земле:<br/>
                       {$interval->h} ч, {$interval->i} мин, {$interval->s} сек";

                        return $model->date_drop ? $text : 'Зреет на дереве';
                    }
                ],
                [
                    'attribute' => 'apple_id',
                    'width' => '10%',
                    'label' => false,
                    'filter' => false,
                    'format' => 'raw',
                    'value' => function ($apple) {
                        if ($apple->status_id == AppleStatus::getIdByCode(AppleStatus::ON_GROUND)) {
                            return Html::a('Откусить', ['bite', 'id' => $apple->id],
                                [
                                    'role' => 'modal-remote',
                                    'title' => 'СЬесть яблоко ' . $apple->id,
                                    'data-toggle' => 'tooltip',
                                    'class' => 'btn btn-success b-btn-action',
                                    'style' => 'width: 100%; margin-bottom:.5em',
                                ]);
                        }

                        $ripOff = Html::a(
                            'Сорвать',
                            Url::to([
                                'rip-off',
                                'id' => $apple->id
                            ]),
                            [
                                'id' => 'grid-apple-ripoff-btn',
                                'class' => 'btn btn-primary b-btn-action',
                                'style' => 'width: 100%; margin-bottom:.5em',
                            ]
                        );

                        $ripAndBite = Html::a(
                            'Сорвать и откусить',
                            Url::to([
                                'rip-n-bite',
                                'id' => $apple->id
                            ]),
                            [
                                'id' => 'grid-apple-ripnbite-btn',
                                'class' => 'btn btn-info b-btn-action',
                                'style' => 'width: 100%; margin-bottom:.5em',
                                'role' => 'modal-remote',
                                'title' => 'Яблоко ' . $apple->id,


                            ]
                        );

                        return $ripOff . '</br>' . $ripAndBite;
                    },
                ],

            ],
        ]); ?>
    </div>

</div>


<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
]);
Modal::end();
?>



