# codac-pff

[TOC]

# Titles and internal titles
Ap'Hero is a websitre project written in symfony.

# Introduction - the project's aim

Ap'Hero is a Proof Of Concept of a eCommerce in Symfony4 without using cyllius.

# Technologies & dependencies


# Launch

## Download
```shell
git clone https://github.com/YenByNigao/codac-pff.git
```
## Installation
```shell
cd codac-pff
cd ap_hero
composer install
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



###GFM task list

- [x] GFM task list 1
- [x] GFM task list 2
- [ ] GFM task list 3
    - [ ] GFM task list 3-1
    - [ ] GFM task list 3-2
    - [ ] GFM task list 3-3
- [ ] GFM task list 4
    - [ ] GFM task list 4-1
    - [ ] GFM task list 4-2



```flow
st=>start: Login
op=>operation: Login operation
cond=>condition: Successful Yes or No?
e=>end: To admin

st->op->cond
cond(yes)->e
cond(no)->op
```

###Sequence Diagram
                    
```seq
Andrew->China: Says Hello 
Note right of China: China thinks\nabout it 
China-->Andrew: How are you? 
Andrew->>China: I am good thanks!
```

###End