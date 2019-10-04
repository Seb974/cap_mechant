# CODAC-EndTrainingProject
 <img src="https://img.shields.io/github/languages/count/YenByNigao/codac-pff" /> <img src="https://img.shields.io/github/languages/top/YenByNigao/codac-pff" /> <img src="https://img.shields.io/github/repo-size/YenByNigao/codac-pff" /> <img src="https://img.shields.io/github/v/tag/YenByNigao/codac-pff" /> <img src="https://img.shields.io/website?url=https%3A%2F%2Fwww.clikeat.re" /> <img src="https://img.shields.io/github/commit-activity/w/YenByNigao/codac-pff" />  <img src="https://img.shields.io/github/last-commit/YenByNigao/codac-pff" /> <img src="https://img.shields.io/github/contributors/YenByNigao/codac-pff" />

---

# The project's aim

Ap'Hero is a project written in symfony. Ap'Hero is a Proof Of Concept of a eCommerce in Symfony4 without using cyllius.

---

# Technologies & dependencies

- ## Download
Start by downloading or cloning the project files on GitHub
```shell
git clone https://github.com/YenByNigao/codac-pff.git
```
Before you can start the servers, it is essential to install the dependencies and the database
- ## Dependencies
```shell
cd codac-pff
cd ap_hero
composer install
```
- ## Database
Please, update `ap_hero\.env` file with your MariaDB credientials in order to initiate database.
```
DATABASE_URL=mysql://root:root@127.0.0.1:1234/azerty
```
Then you can create the database and associated tables.
```shell
cd codac-pff
cd ap_hero
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
- ## Running the project
```shell
php bin/console server:run
```
You will have an output like this on your terminal
> [OK] Server listening on http://127.0.0.1:8000
> // Quit the server with CONTROL-C.
- ## Autorun Script
An autorun script is available at repository root.
```shell
#!/bin/bash
cd ap_hero
composer install
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console server:start
php bin/console server:dump
```
---

# Illustrations
---

# Scope of functionalities
---

# Examples of use
---

# Project status
Work in progress.

---

# Sources
---

# Contributing
Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are greatly appreciated.

- Fork the Project
- Create your Feature Branch (git checkout -b feature/AmazingFeature)
- Commit your Changes (git commit -m 'Add some AmazingFeature')
- Push to the Branch (git push origin feature/AmazingFeature)
- Open a Pull Request

---

# After Project ToDoList

- [ ] GFM task list 1
- [ ] GFM task list 2
- [ ] GFM task list 3
    - [ ] GFM task list 3-1
    - [ ] GFM task list 3-2
    - [ ] GFM task list 3-3
- [ ] GFM task list 4
    - [ ] GFM task list 4-1
    - [ ] GFM task list 4-2


PATH=/opt/plesk/php/7.3/bin/:$PATH
echo $PATH
