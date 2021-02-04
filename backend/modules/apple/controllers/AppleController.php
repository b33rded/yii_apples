<?php

namespace backend\modules\apple\controllers;

use backend\models\forms\AppleBiteForm;
use backend\models\forms\AppleGenerateForm;
use backend\models\forms\AppleRipAndBiteForm;
use common\components\AppleManager;
use common\components\ErrorMessageParser;
use common\components\Utility;
use common\exceptions\ModelNotValidate;
use common\models\AppleStatus;
use Yii;
use common\models\Apple;
use common\models\search\AppleSearch;
use yii\db\Exception;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'rip-n-bite' => ['GET', 'POST'],
                    'bite' => ['GET', 'POST'],
                    'rip-off' => ['GET', 'POST']
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->searchExceptRotten(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGenerate()
    {
        $request = Yii::$app->request;

        $model = new AppleGenerateForm();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Создаем яблоки",
                    'content' => $this->renderAjax('_create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#apple-grid-pjax',
                    'title' => "Создание",
                    'content' => '<span class="text-success">Получилось!</span>',
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Создать еще', ['generate'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Создаем яблоки",
                    'content' => $this->renderAjax('_create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('_create', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionRipNBite($id)
    {
        $request = Yii::$app->request;
        $apple = $this->findModel($id);

        if($apple->status->code == AppleStatus::ROTTEN) {
            throw new UnauthorizedHttpException('Не надо кушать гнилые яблоки');
        }

        $model = new AppleRipAndBiteForm($apple);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Срываем и кусаем яблоко " . $id,
                    'content' => $this->renderAjax('_bite', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#apple-grid-pjax',
                    'title' => "Яблоко " . $id,
                    'content' => '<span class="text-success">Омномном</span>',
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Отскусить еще', ['bite', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Срываем и кусаем яблоко " . $id,
                    'content' => $this->renderAjax('_bite', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('_bite', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionBite($id)
    {
        $request = Yii::$app->request;
        $apple = $this->findModel($id);

        if($apple->status->code != AppleStatus::ON_GROUND) {
            throw new UnauthorizedHttpException('Нельзя кусать висящие на дереве или гнилые яблоки');
        }

        $model = new AppleBiteForm($apple);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Кусаем яблоко " . $id,
                    'content' => $this->renderAjax('_bite', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#apple-grid-pjax',
                    'title' => "Яблоко " . $id,
                    'content' => '<span class="text-success">Омномном</span>',
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Отскусить еще', ['bite', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Кусаем яблоко " . $id,
                    'content' => $this->renderAjax('_bite', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('_bite', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionRipOff($id)
    {
        $apple = $this->findModel($id);

        if($apple->status->code != AppleStatus::ON_TREE) {
            throw new UnauthorizedHttpException('Нельзя сорвать с дерева то, чего там нет');
        }

        try {
            AppleManager::ripOff($apple);

            Yii::$app->session->setFlash('success', "Яблоко {$apple->id} сорвано!");

        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id): Apple
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Apple not found');
    }
}
