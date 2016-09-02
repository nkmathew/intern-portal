<?php
namespace app\controllers;

use app\models\Logbook;
use app\models\Profile;
use app\models\User;
use app\models\SignupLinks;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\ProfileForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Carbon\Carbon;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'send-signup-links' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Renders a view depending on whether it was requested with pjax or via a
     * normal link visit
     *
     * @inheritdoc
     */
    public function renderPjax($view, $params = [])
    {
        if (Yii::$app->request->isAjax) {
            return parent::renderPartial($view, $params);
        } else {
            return parent::render($view, $params);
        }
    }


    /**
     * Displays progress page
     *
     * @return mixed
     */
    public function actionProgress()
    {
        $loggedInEmail = Yii::$app->user->identity->email;
        $profile = Profile::findByEmail($loggedInEmail);
        $start = $profile->start_date;
        $duration = $profile->duration;
        $startDate = Carbon::parse($start);
        $endDate = $startDate->copy()->addWeek($duration);
        $totalDays = $startDate->diffInDays($endDate, false);
        $daysLeft = Carbon::now()->diffInDays($endDate, false);
        $weeksLeft = Carbon::now()->diffInWeeks($endDate, false);
        $daysCompleted = $startDate->diffInDays(Carbon::now(), false);
        $weeksCompleted = ceil($daysCompleted/$totalDays*$duration);
        $weekdays = $startDate->diffInWeekdays($endDate, false);

        $entries = Logbook::findBySql("SELECT entry_for FROM logbook WHERE author = '$loggedInEmail'")->all();
        if (isset($_GET['list-entry-dates'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $entryDates = [];
            foreach ($entries as $entry) {
                array_push($entryDates, $entry->entry_for);
            }
            return $entryDates;
        } else {
            return $this->renderPartial('progress', [
                'duration' => $duration,
                'startDate' => $start,
                'endDate' => $endDate,
                'daysLeft' => $daysLeft,
                'daysCompleted' => $daysCompleted,
                'weeksLeft' => $weeksLeft,
                'totalDays' => $totalDays,
                'weeksCompleted' => $weeksCompleted,
                'weekdays' => $weekdays,
                'datesWithEntries' => count($entries),
            ]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // We don't have any other content to show a guest visiting the homepage
        // so redirect to login form
        if (Yii::$app->user->isGuest) {
            $this->redirect('/site/login');
        } else {
            return $this->renderPjax('index');
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderPjax('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays profile page for the logged in user
     *
     * @return mixed
     */
    public function actionProfile($renderPartial=null)
    {
        $model = new ProfileForm();

        // Ajax form validation is done here
        if (Yii::$app->request->post('ajax') == 'profile-form') {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        // Save the sent profile details
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->updateProfile()) {
                if (!Yii::$app->request->isAjax) {
                    return $this->goHome();
                } else {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return "{msg: 'success'}";
                }
            }
        }

        // Get profile record for current user
        $profile = Profile::findByEmail(Yii::$app->user->identity->email);
        $model->firstName = $profile->firstname;
        $model->email = $profile->email;
        $model->surname = $profile->surname;
        $model->sex = $profile->sex;
        $model->regNumber = $profile->reg_number;
        $model->startDate = $profile->start_date;
        if ($renderPartial) {
            return $this->renderPartial('profile', [
                'model' => $model,
                'profile' => $profile,
            ]);
        } else {
            return $this->render('profile', [
                'model' => $model,
                'profile' => $profile,
            ]);
        }
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->renderPjax('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->renderPjax('about');
    }

    /**
     * Lists all the signup invites generated for a specific student. The content
     * will be displayed in a modal in the coordinator console
     *
     * @return mixed
     */
    public function actionListInvitesByUser()
    {
        $email = Yii::$app->request->get('email');
        return $this->renderPartial('listInvitesByUser', [
             'email' => $email
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup_token && !SignupLinks::find()->where(['signup_token' => $model->signup_token])) {
                return $this->render('error', [
                    'name' => 'Unknown Signup Token',
                    'message' => "We don't recognize that signup token. Sorry :("
                ]);
            }
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    // Invalidate all tokens associated with the email
                    SignupLinks::updateAll(['token_disabled' => 1], "email = '$model->email'");
                    // Initialize profile table
                    $profile = new Profile();
                    $profile->email = $model->email;
                    $profile->surname = '';
                    $profile->firstname = '';
                    $profile->sex = '';
                    $profile->last_updated = time();
                    $ret = $profile->save();
                    return $this->goHome();
                }
            }
        }

        return $this->renderPjax('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->renderPjax('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() &&
            $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    /**
     * Emails the interns with the supplied email addresses with signup invite links
     *
     */
    public function actionSendSignupLinks()
    {
        $emailList = json_decode(Yii::$app->request->post('email-list'));
        if (!count($emailList)) {
            return;
        }
        $userRole = Yii::$app->user->identity->role;
        if ($userRole == 'supervisor') {
            $role = 'intern';
        } else if ($userRole == 'superuser') {
            $role = 'supervisor';
        }
        for ($i = 0; $i < count($emailList); $i++) {
            $email = $emailList[$i];
            if (User::findByEmail($email)) {
                continue;
            }
            $signupLink = new SignupLinks();
            $signupLink->email = $email;
            $signupLink->date_sent = time();
            $signupLink->inviter = Yii::$app->user->identity->email;
            $signupLink->role = $role;
            $signupLink->generateSignupToken();
            $mailStatus = Yii::$app->mailer->compose(
                ['html' => 'signupLink-html', 'text' => 'signupLink-text'],
                ['signupLink' => $signupLink]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' admin'])
            ->setTo($email)
            ->setSubject('Signup link for ' . Yii::$app->name)
            ->send();
            if ($mailStatus) {
                $signupLink->insert();
            }
        }
    }

    /**
     * Generates a signup form when a signup link is clicked/followed
     *
     * @return string
     */
    public function actionLinkSignup() {
        $token = Yii::$app->request->get('signup_token');
        $signupLink = new SignupLinks();
        $email = $signupLink::findOne(['signup_token' => $token]);

        if (!Yii::$app->user->isGuest) {
            return $this->render('error', ['name' => 'Link signup error',
                'message' => "Can't signup while there's an active session. " . Yii::$app->user->identity->email .
                    " is still logged in"
            ]);
        }

        if ($email) {
            // Token found. Invalidate the others associated with the user about to signup
            $model = new SignupForm();
            return $this->renderPjax('linkSignup', [
                'model' => $model,
                'email' => $email->email,
                'signup_token' => $token,
            ]);
        } else {
           return $this->render('error', [
               'name' => 'Unknown Signup Token',
               'message' => "We don't recognize that signup token. Sorry :("
           ]);
        }
    }

    public function actionListSentInvites() {
        return $this->renderPartial('sentInvites');
    }

    public function actionPreview() {
        return $this->render('preview');
    }

    public function actionShowLogbook() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $action = Yii::$app->request->get('action');
        $entryDate = Yii::$app->request->get('entryDate');
        if ($entryDate) {
            $logbook = Logbook::findOne(['entry_for' => $entryDate]);
            if ($action == 'save') {
                // Save or update the entry for the specified date
                $postData           = Yii::$app->request->post();
                if ($logbook) {
                    $logbook->updated = $postData['updated'];
                } else {
                    $logbook = new Logbook();
                    $logbook->created = $postData['created'];
                    $logbook->updated = $postData['updated'];
                }
                $logbook->entry_for = $postData['entry_for'];
                $logbook->entry     = $postData['entry'];
                $logbook->author    = Yii::$app->user->identity->email;
                $retVal             = $logbook->save();
                if ($retVal) {
                    return ['status' => 'Success'];
                } else {
                    return ['status' => 'Failed to save the record ' . $retVal];
                }
            } elseif ($action == 'delete') {
                if ($logbook) {
                    if ($logbook->delete()) {
                        $entryDate = Carbon::parse($entryDate)->format('l jS F Y');
                        return [
                            'status' => 'success',
                            'message' => "Entry for <strong>$entryDate</strong> deleted successfully"
                        ];
                    } else {
                        return [
                            'status' => 'error',
                            'message' => "Problem deleting entry for $entryDate"
                        ];
                    }
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Entry does not exist'
                    ];
                }
            } else {
                // Display logbook entry for the specified date
                return $logbook ? $logbook : new Logbook();
            }
        } else {
            // Show today's entry by default
            $dateToday = date('Y-m-d');
            $logbook = Logbook::findOne(['entry_for' => $dateToday]);
            $logbook = $logbook ? $logbook : new Logbook();
            return $logbook;
        }
    }

    /**
     * Displays the full logbook a week at a time
     *
     */
    public function actionPreviewLogbook() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $week = Yii::$app->request->get('week');
        $week = intval($week);
        // return $week;
        $loggedInEmail = Yii::$app->user->identity->email;
        $profile = Profile::findByEmail($loggedInEmail);
        $duration = $profile->duration + 1;
        $week = ($week + $duration) % $duration;
        $startDate = Profile::findOne(['email' => $loggedInEmail])->start_date;
        $startDate = Carbon::parse($startDate);
        $start = $startDate->copy()->startOfWeek()->addWeeks($week);
        $end = $startDate->copy()->endOfWeek()->addWeeks($week);

        $entryList = Logbook::findBySql("
        SELECT * from
        Logbook WHERE entry_for >= '$start'
                AND entry_for <= '$end'
                AND author = '$loggedInEmail'
        ORDER BY `entry_for`")->all();
        return [
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d'), // jS F Y
            'week' => $week,
            'entryList' => $entryList,
        ];
    }

    /**
     * Returns profile information as JSON
     *
     * @return null|static
     */
    public function actionFetchProfile() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $loggedInEmail = Yii::$app->user->identity->email;
        $profile = Profile::findByEmail($loggedInEmail);
        return $profile;
    }

    /**
     * Fetches user by email
     */
    public function actionFetchUser() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findByEmail(Yii::$app->request->get('email'));
        return $user ? $user : [];
    }

    /**
     * Deletes user by email
     */
    public function actionDeleteUser() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findByEmail(Yii::$app->request->post('email'));
        $user->getProfile()->delete();
        return $user->delete();
    }
}
