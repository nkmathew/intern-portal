[![Project wip: Work In Progress][wip-svg]][wip-link]

---

### Intern Portal

A system that automates the internship process essentially doing away with the
need for a logbook for keeping track of progress enabling a supervisor and
coordinator to monitor student progress easily.

Was an exercise for my internship/industrial attachment. It's not very practical and
far from complete but was a fun thing to work on daily. Will probably never touch it
again once my internship is up

### Installation Steps

+ Ensure you have a web server with `php >=5.4.0` installed
+ Clone this repo
+ Install dependencies with composer: `composer install --prefer-dist`
+ Create the database:
```sql
CREATE DATABASE `intern_system` /*!40100 COLLATE 'utf8mb4_unicode_ci' */
```
+ Create tables by running `yii migrate`
+ Head over to http://ckeditor.com/builder and use the `ckeditor/build-config.js` to
  create a custom build of ckeditor after which you'll extract the contents to the
  `ckeditor` folder
+ Populate the courses table by running `courses-data.sql` in the root folder
+ Default password for superuser/admin account is **test123**
+ Run a server with `yii serve` while still in the root folder or with
  `php -S localhost:8080` if in the `web` folder
+ Refer to `tests/README.md` for information on running test suites

### How it works : abridged version
The system is supposed to be installed an institution. An admin/superuser account is
installed by default who will be responsible for sending singup links to supervisors
who will then be able to send invite links for interns to signup. The admin is also
responsible for changing the role of a supervisor to that of a coordinator. The
coordinator and supervisor will then associate themselves with an intern through an
association link sent to the intern's email. The intern accepts it after which the
supervisor and coordinator will be able to make reviews to the logbook entries made
by the intern

### TODO/Features

+ Should support login for four types of users:
  - Admin
    Responsible for creating signup invite links for supervisors and coordinators
    and general administration:
    + Defining working hours outside which entries will not be accepted
    + Whether missed days due to late entries should result in increased internship
      days
    + Whether old entries should be editable etc etc.
  - Coordinators
    - The teacher/lecturer in who does supervision of all the interns from a certain
      class and does an on site assessment of the student interns in their
      placements
  - Supervisors
    - The person who monitors student progress in his/her place of work
  - Intern
    - The student doing the industrial attachment
+ Coordinator:
  + Has to key in list of students on internship
  + Support import from csv file, created by the class rep maybe
  + Should be able to see the progress of all the students in the class doing the
    internship
  + System has an option for sending mass emails to all the students with links that
    enable them to signup to the system and changing their loggin details
  + Gets notified when an intern under his supervision updates his/her profile e.g
    changes his name
  + Should show the coordinator list of students whose student email adresses never
    received the signup invite links
+ Supervisor
  + Has access to progress data of all the interns under his/her supervision
  + Should allow option for defining whether the intern does work on weekends
  + Decides the number of weeks the intern is supposed to be on internship. The
    minimum should be at least 8 weeks required by all institutions
  + Fills details on the industry/office/firm the intern works in including:
    - The physical location of the firm
    - The department
    - The room name/number each of the interns under his supervision will work in
    - General description of the workplace and what they do
    - Working hours(start and departure date)
    - Give's weekly report on the progress of the intern
  + Should have a form that enables the supervisor to note down the students
    progress during the internship
  + Gets notified when an intern under his supervision updates his/her profile e.g
    changes his name
+ Intern
  + Fills logbook daily
  + Should show the intern his/her progess including:
    - The number of days he's done
    - The number of hours completed in general taking into account the working hours
      defined by the supervisor
    - The number of days left to complete the 8/12 weeks set
  + Signs up in the system only on invite from the email sent by the coordinator to
    the school email address.
  + System should support reset of lost passwords
  + Show a calendar showing the number of days completed and days left

### Enhancements
+ Long emails should be ellipsified/truncated with the full address being displayed
  on hover
+ Login with google accounts since student emails are managed by gmail
+ Records login attempts
+ Ability to search within your log
+ Add gravatar support
+ Logout link should be in a dropdown with the dropbdown showing the truncated
  email, the avatar
+ Track user logins, record their ips and times maybe show in an account activity
  tab
+ Show the Course Name when you hover over the registration number
+ Email sender should keep track of the response from sending each email
+ Copy the styling used in Feedreader newsletters
+ Listen to onhashchange to react to tab urls like http://intern.jkuat.dev/#tab-invite
+ A coordinator should be shown a different looking profile form from a student
+ Copy penzu's email layout
+ Internship start date should not be a one-time permanent change to cater for
  mistakes. Instead the coordinator should be notified when the intern sets his/her
  start date and maybe the number of times the start date has been changed to
  monitor people who are trying to misuse the system
+ Add list of provinces and districts
+ The entry editor should like Penzu's with ruled lines like a textbook
+ Show entry preview when mouse hovers over date for some seconds the way
  stackoverflow shows tag description on hover
+ Disable button until there's an actual change??
+ Ability to export the whole logbook as a printable pdf with supervisor remarks and
  student logs all in one
+ Ability to view diffs when entries are updated??
+ Prompt user to save before leaving and show an icon that shows that the entry is
  unsaved
+ Capture Ctrl+S keypress
+ Throw error when no date is specified
+ Clicking on the tabs should change the title of the tab
+ Stop running sql queries to fetch logbook entries and profiles for the logged in
  user. Use instead ActiveQuery methods available through the User model since they
  are connected through a foreign key

### Directory Structure

     assets/             contains assets definition
     commands/           contains console commands (controllers)
     config/             contains application configurations
     controllers/        contains Web controller classes
     mail/               contains view files for e-mails
     migrations/         contains database migrations
     models/             contains model classes
     runtime/            contains files generated during runtime
     tests/              contains various tests for the basic application
     vendor/             contains dependent 3rd-party packages
     views/              contains view files for the Web application
     web/                contains the entry script and Web resources
     widgets/            contains frontend widgets

[0]: https://github.com/yiisoft/yii2-app-basic
[wip-link]: http://www.repostatus.org/#wip
[wip-svg]: http://www.repostatus.org/badges/latest/wip.svg
