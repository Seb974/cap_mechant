# CODAC-EndTrainingProject
 <a href="https://img.shields.io/github/languages/count/YenByNigao/codac-pff" alt='toto' />  <a href="https://img.shields.io/github/languages/top/YenByNigao/codac-pff">  <a href="https://img.shields.io/github/repo-size/YenByNigao/codac-pff"> <a href="https://img.shields.io/github/v/tag/YenByNigao/codac-pff"> <a href="https://img.shields.io/website?url=https%3A%2F%2Fwww.clikeat.re"> <a href="https://img.shields.io/github/commit-activity/w/YenByNigao/codac-pff">  <a href="https://img.shields.io/github/last-commit/YenByNigao/codac-pff">  <a href="https://img.shields.io/github/contributors/YenByNigao/codac-pff">

[TOC]

# Titles and internal titles
Ap'Hero is a project written in symfony.

# Introduction - the project's aim

Ap'Hero is a Proof Of Concept of a eCommerce in Symfony4 without using cyllius.

# Technologies & dependencies


# Launch

## Download
Start by downloading or cloning the project files on GitHub
```shell
git clone https://github.com/YenByNigao/codac-pff.git
```
## First Start
Before you can start the servers, it is essential to install the dependencies and the database
### Dependencies
```shell
cd codac-pff
cd ap_hero
composer install
```
### Database
Please, update `ap_hero\.env` file with your MariaDB credientials in order to initiate database.
```shell
cd codac-pff
cd ap_hero
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
## Running the project
```shell
php server:run
```


# Illustrations

# Scope of functionalities

# Examples of use

# Project status
Work in progress.

# Sources

# Contributing
Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are greatly appreciated.

- Fork the Project
- Create your Feature Branch (git checkout -b feature/AmazingFeature)
- Commit your Changes (git commit -m 'Add some AmazingFeature')
- Push to the Branch (git push origin feature/AmazingFeature)
- Open a Pull Request



> The overriding design goal for Markdown's
> formatting syntax is to make it as readable
> as possible. The idea is that a
> Markdown-formatted document should be
> publishable as-is, as plain text, without
> looking like it's been marked up with tags
> or formatting instructions.



#After Project ToDoList

- [ ] GFM task list 1
- [ ] GFM task list 2
- [ ] GFM task list 3
    - [ ] GFM task list 3-1
    - [ ] GFM task list 3-2
    - [ ] GFM task list 3-3
- [ ] GFM task list 4
    - [ ] GFM task list 4-1
    - [ ] GFM task list 4-2
