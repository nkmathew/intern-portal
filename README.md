[![Project wip: Work In Progress][wip-svg]][wip-link]

---

###  Intern Management System (IMS)

A system that automates the internship process essentially doing away with the
need for a logbook for keeping track of progress enabling a supervisor and
coordinator to monitor student progress easily.

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
