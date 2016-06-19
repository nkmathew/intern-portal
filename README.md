[![Project wip: Work In Progress][wip-svg]][wip-link]

---

### Intern Management System (IMS)

A system that automates the internship process essentially doing away with the
need for a logbook for keeping track of progress enabling a supervisor and
coordinator to monitor student progress easily.

### TODO/Features

+ Design simple logo
+ Should support login for three types of users:
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
+ Personalized greeting when pass reset is requested i.e refer to them by name
  instead of by their email
+ Login with google accounts since student emails are managed by gmail
+ Records login attempts
+ Ability to search within your log

### Installation Steps

+ Ensure you have a web server with `php >=5.4.0` installed
+ Clone this repo
+ Install dependencies with composer: `composer install --prefer-dist`
+ Create the database:
```sql
CREATE DATABASE `intern_system` /*!40100 COLLATE 'utf8mb4_unicode_ci' */
```
+ Create tables by running `yii migrate`
+ Run a server with `yii serve` while still in the root folder or with
  `php -S localhost:8080` if in the `web` folder
+ Refer to `tests/README.md` for information on running test suites


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
