# codac-pff

this is the project readme
# First time installation guide
```shell
git clone https://github.com/YenByNigao/codac-pff.git
cd codac-pff
cd ap_hero
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php server:run
```

# Contributing
Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are greatly appreciated.

- Fork the Project
- Create your Feature Branch (git checkout -b feature/AmazingFeature)
- Commit your Changes (git commit -m 'Add some AmazingFeature')
- Push to the Branch (git push origin feature/AmazingFeature)
- Open a Pull Request