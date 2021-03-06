<?php
namespace app\controllers;

use app\models\AssociationLinks;
use app\models\Associations;
use app\models\CoordinatorReviews;
use app\models\Logbook;
use app\models\Profile;
use app\models\Config;
use app\models\SupervisorProfile;
use app\models\SupervisorProfileForm;
use app\models\SupervisorReviews;
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
     * Returns an object representing the currently logged in user
     *
     * @return null | \app\models\User
     */
    private function getUser() {
        return User::findByEmail(Yii::$app->user->identity->email);
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
        $weeksCompleted = ceil($daysCompleted / $totalDays * $duration);
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
    public function actionSupervisorProfile()
    {
        $model = new SupervisorProfileForm();

        // Ajax form validation is done here
        if (Yii::$app->request->post('ajax') == 'supervisorprofile-form') {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $res = $model->updateProfile();
            if ($res) {
                if (!Yii::$app->request->isAjax) {
                    return $this->goHome();
                } else {
                    Yii::$app->response->format = Response::FORMAT_JSON;

                    return "{msg: 'success'}";
                }
            }
        }

        // Get profile record for current user
        $profile = SupervisorProfile::findByEmail(Yii::$app->user->identity->email);
        $model->email = $profile->email;
        $model->sex = $profile->sex;
        $model->surname = $profile->surname;
        $model->firstname = $profile->firstname;
        $model->id_number = $profile->id_number;
        $model->company_name = $profile->company_name;
        $model->company_address = $profile->company_address;
        $model->work_position = $profile->work_position;
        $model->phone_number = $profile->phone_number;

        return $this->renderPartial('supervisor/supervisorProfile', [
            'model' => $model,
        ]);
    }


    /**
     * Displays profile page for the logged in user
     *
     * @return mixed
     */
    public function actionProfile($renderPartial = null)
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
                    if ($user->role == 'supervisor' || $user->role == 'superuser') {
                        $profile = new SupervisorProfile();
                        $profile->last_updated = date('Y-m-d H:i:s');
                    } else {
                        $profile = new Profile();
                        $profile->last_updated = time();
                    }
                    // Initialize supervisor config table
                    if ($user->role = 'supervisor') {
                        $config = new Config();
                        $config->supervisor = $user->email;
                        $config->save();
                    }
                    $profile->email = $model->email;
                    $profile->surname = '';
                    $profile->firstname = '';
                    $profile->sex = '';
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
            $model->resetPassword()
        ) {
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
        if ($userRole == 'coordinator' || $userRole == 'supervisor') {
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
    public function actionLinkSignup()
    {
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
                'role' => $email->role
            ]);
        } else {
            return $this->render('error', [
                'name' => 'Unknown Signup Token',
                'message' => "We don't recognize that signup token. Sorry :("
            ]);
        }
    }

    public function actionListSentInvites()
    {
        return $this->renderPartial('sentInvites');
    }

    public function actionPreview()
    {
        return $this->render('preview');
    }

    public function actionShowLogbook()
    {
        $thisUser = $this->getUser();
        $config = null;
        $assoc = $thisUser->associations0;
        if ($assoc && $assoc->supervisor) {
            // Intern has been associated with a supervisor
            $config = $assoc->supervisor0->config;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $action = Yii::$app->request->get('action');
        $entryDate = Yii::$app->request->get('entryDate');
        if ($entryDate) {
            $logbook = Logbook::findOne(['entry_for' => $entryDate]);
            if ($action == 'save') {
                // Save or update the entry for the specified date
                $postData = Yii::$app->request->post();
                $isToday = Carbon::parse($postData['entry_for'])->isToday();
                if ($logbook) {
                    if (!$isToday && $config && !$config->can_modify_later) {
                        return ['error' => 'Late modifications have been disallowed by your supervisor'];
                    }
                    $logbook->updated = $postData['updated'];
                } else {
                    if (!$isToday && $config && !$config->can_add_later) {
                        return ['error' => 'Missed entries can not be added at a later date as per your supervisor'];
                    }
                    $logbook = new Logbook();
                    $logbook->created = $postData['created'];
                    $logbook->updated = $postData['updated'];
                }
                $logbook->entry_for = $postData['entry_for'];
                $logbook->entry = $postData['entry'];
                $logbook->author = $thisUser->email;
                if ($config) {
                    $start = Carbon::parse($config->starting_hour);
                    $close = Carbon::parse($config->closing_hour);
                    $time = Carbon::parse(Yii::$app->request->post('localTime'));
                    if ($time < $start || $time > $close) {
                        return ['error' => 'You cannot make edits outside working hours'];
                    }
                    $retVal = $logbook->save();
                } else {
                    $retVal = $logbook->save();
                }
                if ($retVal) {
                    return ['message' => 'Success'];
                } else {
                    return ['error' => 'Failed to save the record ' . $retVal];
                }
            } elseif ($action == 'delete') {
                if ($logbook) {
                    if ($logbook->delete()) {
                        $entryDate = Carbon::parse($entryDate)->format('l jS F Y');

                        return [
                            'message' => "Entry for <strong>$entryDate</strong> deleted successfully"
                        ];
                    } else {
                        return [
                            'error' => "Problem deleting entry for $entryDate"
                        ];
                    }
                } else {
                    return [
                        'error' => 'Entry does not exist'
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
    public function actionPreviewLogbook()
    {
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
    public function actionFetchProfile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $loggedInEmail = Yii::$app->user->identity->email;
        $profile = Profile::findByEmail($loggedInEmail);

        return $profile;
    }

    /**
     * Fetches user by email
     */
    public function actionFetchUser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findByEmail(Yii::$app->request->get('email'));

        return $user ? $user : [];
    }

    /**
     * Deletes user by email
     */
    public function actionDeleteUser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $email = Yii::$app->request->post('email');
        $user = User::findByEmail($email);
        AssociationLinks::deleteAll(['intern' => $email]);
        Associations::deleteAll(['intern' => $email]);
        Associations::updateAll(['supervisor' => null], "supervisor = '$email'");
        AssociationLinks::deleteAll(['supervisor' => $email]);
        SignupLinks::deleteAll(['inviter' => $email]);
        SignupLinks::deleteAll(['email' => $email]);
        Associations::updateAll(['coordinator' => null], "coordinator = '$email'");
        SignupLinks::deleteAll(['email' => $email]);
        Logbook::deleteAll(['author' => $email]);
        Config::deleteAll(['supervisor' => $email]);

        $SQL = "
        UPDATE logbook AS logb
        INNER JOIN coordinator_reviews AS coord ON coord.id = logb.coordinator_review SET coordinator_review = NULL
        WHERE coord.id = logb.coordinator_review AND reviewer=':email'
        ";
        if ($user->role != 'intern') {
            $command = Yii::$app->db->createCommand($SQL, ['email' => $email]);
            $command->execute();
        }

        $SQL = "
        UPDATE logbook AS logb
        INNER JOIN supervisor_reviews AS super ON super.id = logb.supervisor_review SET supervisor_review = NULL
        WHERE super.id = logb.supervisor_review AND reviewer=':email'
        ";
        if ($user->role != 'intern') {
            $command = Yii::$app->db->createCommand($SQL, ['email' => $email]);
            $command->execute();
        }

        CoordinatorReviews::deleteAll(['reviewer' => $email]);
        SupervisorReviews::deleteAll(['reviewer' => $email]);
        if ($user->role == 'intern') {
            Profile::deleteAll(['email' => $email]);
        } else {
            SupervisorProfile::deleteAll(['email' => $email]);
        }

        return $user->delete();
    }

    /**
     * Change a supervisor's role to that of a coordinator enabling
     * him/her to view everyone's logbook
     */
    public function actionSupervisorToCoordinator()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $email = Yii::$app->request->post('email');
        $user = User::findByEmail(Yii::$app->request->post('email'));
        if ($user) {
            if ($user->role == 'supervisor') {
                $user->role = 'coordinator';
                if ($user->save()) {
                    return [
                        'message' => 'Role changed to coordinator successfully'
                    ];
                } else {
                    return [
                        'error' => 'Error in changing role to coordinator'
                    ];
                }
            } else {
                return [
                    'error' => "User with email <strong>$email</strong> is not a supervisor"
                ];
            }
        } else {
            return [
                'error' => 'User with email not found',
            ];
        }
    }

    /**
     * @return string
     */
    public function actionOverview() {
        return $this->render('overview');
    }

    /**
     * Exports the whole logbook as a pdf
     *
     * The entries are taken in order of their dates to be the way
     * the final logbook will look like since someone is not allowed to
     * make late entries if he/she misses a day
     *
     */
    public function actionExportLogbook()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;

        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 8);
        $tbl = $this->actionLogbookTable(false);
        $pdf->writeHTML($tbl, true, false, false, false, '');
        $pdf->Output('Internship_Logbook.pdf', 'I');
    }

    /**
     * Returns all logbook entries week-wise
     *
     * @param bool|null $asJSON
     * @param null $author
     * @return array|string
     */
    public function actionEntriesByWeek($asJSON = true, $author) {
        $user = User::findByEmail($author);
        if (!$user) {
            return [];
        }
        if ($user->role != 'intern') {
            return [];
        }

        $entries = $user->logbooks;
        $entryByWeek = [];
        $week = 0;
        foreach ($entries as $x => $value) {
            if (!isset($entryByWeek[$week])) {
                $entryByWeek[$week] = [];
            }
            array_push($entryByWeek[$week], $value);
            if (($x+1) % 5 == 0) {
                $week++;
            }
        }
        if ($asJSON) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $entryByWeek;
        } else {
            return $entryByWeek;
        }
    }

    /**
     * Renders the logbook entries as a html table
     *
     * @return string
     */
    public function actionLogbookTable() {
        $weekNum = Yii::$app->request->get('week');
        $author = Yii::$app->request->get('email');
        $entryByWeek = $this->actionEntriesByWeek(false, $author);
        $weekNum = intval($weekNum);
        if ($weekNum <= 0) {
            $weekNum = 1;
        } else if ($weekNum > count($entryByWeek)) {
            $weekNum = count($entryByWeek);
        }

        if (count($entryByWeek) == 0) {
            $entryList = [];
        } else {
            $entryList =  $entryByWeek[$weekNum-1];
        }
        return $this->renderPartial('logbookPdf', [
            'entryList' => $entryList,
            'weekNumber' => $weekNum
        ]);
    }

    /**
     * Supervisor/coordinator logbook reviews
     */
    public function actionReviews() {
        return $this->renderPartial('supervisor/supervisorReviews');
    }

    /**
     * Send a link to the intern's email requesting access to his/her logbook
     * in order to review it
     */
    public function actionAssociationLink() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $email = Yii::$app->request->post('email');
        $assocLink = new AssociationLinks();
        $assocLink->intern = $email;
        $assocLink->is_disabled = 0;
        $assocLink->date_sent = date('Y-m-d H:i:s');
        $assocLink->supervisor = $this->getUser()->email;
        $assocLink->generateToken();
        // return $assocLink;
        $mailStatus = Yii::$app->mailer->compose(
            ['html' => 'associationLink-html', 'text' => 'associationLink-text'],
            ['assocLink' => $assocLink]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' admin'])
            ->setTo($email)
            ->setSubject('Signup link for ' . Yii::$app->name)
            ->send();
        if ($mailStatus) {
            $assocLink->insert();
            return [
                'message' => 'Association link sent successfully'
            ];
        } else {
            return [
                'error' => 'Error in sending association link email'
            ];
        }
    }

    /**
     * Handle intern's response to an association link from a supervisor/coordinator
     *
     */
    public function actionAcceptAssociation() {
        $reponse = Yii::$app->request->post('response');
        $token = Yii::$app->request->get('assoc_token');
        $assocLink = AssociationLinks::findOne(['token' => $token, 'is_disabled' => 0]);
        if (!$assocLink) {
            return $this->render('error', [
                'name' => 'Error in intern association',
                'message' => "Sorry, could not find a valid corresponding association token"
            ]);
        }
        if ($reponse == '1') {
            $association = Associations::findOne(['intern' => $this->getUser()->email]);
            if (!$association) {
                $association = new Associations();
            }
            $association->intern = $assocLink->intern;
            if ($assocLink->supervisor0->role0->role_name == 'supervisor') {
                $association->supervisor = $assocLink->supervisor;
            } else {
                $association->coordinator = $assocLink->supervisor;
            }
            if ($association->save()) {
                AssociationLinks::updateAll(['is_disabled' => 1], "supervisor = '$assocLink->supervisor'");
                $fullName = $assocLink->supervisor0->supervisorprofile->fullName();
                $email = $assocLink->supervisor0->supervisorprofile->email;
                Yii::$app->session->setFlash('success', "<strong>$fullName ($email)</strong> is now your supervisor");
            }
        } else if ($assocLink) {
            return $this->render('supervisor/acceptAssociation', [
                'assocLink' => $assocLink
            ]);
        }
        header('Location: /');
        exit();
    }

    /**
     * Fetches the review with the specified and renders it in a form
     */
    public function actionFetchReview() {
        // Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->get('id');
        $email = Yii::$app->request->get('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->renderAjax('error', [
                'name' => 'Bad arguments',
                'message' => "Invalid email '$email' supplied"
            ]);
        }
        if (isset($_GET['superv'])) {
            $review = SupervisorReviews::findOne(['id' => $id]);
            $review = $review ? $review : new SupervisorReviews();
            $role = 'supervisor';
        } else {
            $review = CoordinatorReviews::findOne(['id' => $id]);
            $review = $review ? $review : new CoordinatorReviews();
            $role = 'coordinator';
        }

        return $this->renderPartial('supervisor/reviewsForm', [
            'model' => $review,
            'role' => $role,
            'internEmail' => $email,
            'thisUser' => $this->getUser(),
            'dateRange' => Yii::$app->request->get('dateRange')
        ]);
    }

    /**
     * Save/updated a review for a certain week
     */
    public function actionSaveReview() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user = $this->getUser();
        // return ($user->role != 'coordinator' && $user->role != 'supervisor');
        if ($user->role != 'coordinator' && $user->role != 'supervisor') {
            return ['error' => 'Only a verified supervisor or coordinator can do that'];
        }

        $type = Yii::$app->request->post('type');
        $internEmail = Yii::$app->request->post('internEmail');
        $id = intval(Yii::$app->request->post('id'));
        $id = $id ? $id : -1;

        if (isset($user->associations0[$internEmail])) {
            return [
                'error' => "Intern with email ($internEmail) is not under your supervision"
            ];
        }

        $reviewer = $user->email;
        if ($type == 'supervisor') {
            $model = SupervisorReviews::findOne(['id' => $id]);
            $model = $model ? $model : new SupervisorReviews();
            if ($user->role != 'supervisor') {
                return [
                    'error' => "You can't make that review as a supervisor, your role is that of a coordinator"
                ];
            }
        } else {
            $model = CoordinatorReviews::findOne(['id' => $id]);
            $model = $model ? $model : new CoordinatorReviews();
            if ($user->role != 'coordinator') {
                return [
                    'error' => "You can't make that review as a coordinator, your role is that of a supervisor"
                ];
            }
        }

        $className = explode('\\', get_class($model));
        $model->created = date('Y-m-d H:i:s');
        $model->reviewer = $reviewer;
        $model->review = $_POST[end($className)]['review'];

        if ($model->validate()) {
            $ret = $model->save();
            if ($ret) {
                $name = $type . '_review';
                $dateRange = Yii::$app->request->post('dateRange');
                $dateRange = explode('|', $dateRange);
                $rows = Logbook::updateAll(
                    [$name => $model->id],
                    "entry_for BETWEEN '$dateRange[0]' AND '$dateRange[1]' AND author = '$internEmail'");
                return [
                    'data' => $rows,
                    'message' => 'Review saved successfully'
                ];
            } else {
                return [
                    'error' => 'Could not save review'
                ];
            }
        }
    }

    /**
     * Render intern review page
     */
    public function actionReviewIntern() {
        if (isset($_GET['intern'])) {
            $intern = $_GET['intern'];
        } else if ($this->getUser()->role == 'intern') {
            // Show the overview/reviews for the currently logged in user if the user
            // is an intern
            $intern = $this->getUser()->email;
        }
        $entryByWeek = $this->actionEntriesByWeek(false, $intern);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('supervisor/reviewIntern', [
                'entries' => $entryByWeek,
                'intern' => User::findByEmail($intern),
            ]);
        } else {
            return $this->renderPartial('supervisor/reviewIntern', [
                'entries' => $entryByWeek,
                'intern' => User::findByEmail($intern),
            ]);
        }
    }

    /**
     * Saves configuration settings for a workplace/intern
     *
     * @return string|void
     */
    public function actionConfigForm()
    {
        $thisUser = $this->getUser();
        if ($thisUser->role != 'supervisor') {
            return $this->render('error', [
                'name' => 'Error',
                'message' => 'You are not a supervisor. Only supervisors can change configuration settings'
            ]);
        }

        $model = Config::findOne(['supervisor' => $thisUser->email]);
        if (!$model) {
            $model = new Config();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($thisUser->email != $model->supervisor) {
                    return $this->render('error', [
                        'name' => 'Error',
                        'message' => "Detected attempt to change another supervisor's configuration"
                    ]);
                } else {
                    $ret = $model->save();
                    if ($ret) {
                        Yii::$app->session->setFlash('success',
                            'Settings saved successfully');
                    } else {
                        Yii::$app->session->setFlash('success', 'Problem encountered when trying to save your configuration');
                    }
                }
            } else {
                Yii::$app->session->setFlash('success', 'Data validation failed');
            }
            return $this->goBack();
        } else {

            return $this->renderPartial('supervisor/configForm', [
                'model' => $model,
                'email' => $thisUser->email
            ]);
        }
    }
}
