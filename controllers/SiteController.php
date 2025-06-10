<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\RecoveryForm;
use app\models\RegistrationForm;
use app\models\User;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;
use Yii;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'controllers' => [
                            'site',
                        ],
                        'actions' => [
                            'index',
                        ]
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'controllers' => [
                            'site'
                        ],
                        'actions' => [
                            'login',
                            'register',
                            'index',
                            'recovery',
                            'reset-password',
                        ]
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Login action.
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        $this->layout = 'blank';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $redirectUrl = Yii::$app->request->get('redirect');

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect($redirectUrl ?: Yii::$app->homeUrl);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Register action.
     * @return Response|string
     */
    public function actionRegister(): Response|string
    {
        $this->layout = 'blank';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            $user = User::findByUsername($model->email);

            if ($user) {
                Yii::$app->user->login($user, 30 * 60);
            }
            return $this->redirect('/');
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Recovery action.
     * @return Response|string
     */
    public function actionRecovery(): Response|string
    {
        $this->layout = 'blank';

        $success = Yii::$app->request->get('success');

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RecoveryForm();
        $model->setScenario(RecoveryForm::SCENARIO_REQUEST);
        if ($model->load(Yii::$app->request->post()) && $model->sendRecoveryMessage()) {
            return $this->redirect('/recovery/?success=1');
        }

        return $this->render('recovery', [
            'model' => $model,
            'success' => $success
        ]);
    }

    /**
     * Reset password action.
     * @return Response|string
     */
    public function actionResetPassword($hash): Response|string
    {
        $this->layout = 'blank';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = User::find()->where(['recovery_token' => $hash])
            ->andWhere(['>=', 'recovery_sent_at', new Expression('NOW() - INTERVAL 1 DAY')])
            ->one();

        $tokenFailure = false;


        if (!$user) {
            $tokenFailure = true;
        }

        $model = new RecoveryForm();
        $model->setScenario(RecoveryForm::SCENARIO_RESET);
        if ($model->load(Yii::$app->request->post()) && $model->resetPassword($user)) {
            return $this->redirect('/login/?password-reset=1');
        }

        return $this->render('reset-password', [
            'model' => $model,
            'tokenFailure' => $tokenFailure
        ]);
    }


    /**
     * Logout action.
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
