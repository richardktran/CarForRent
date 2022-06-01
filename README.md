# 🥇About the project

**The car for rent project** is built to help people who want to rent a car to travel, picnic, or do whatever. As a
person who wants to rent a car, they just find the car they want and make a contract online with the owner of this car.

**The** **car for rent project** is written by PHP and MySQL from scratch in 3 weeks. With the instruction of **Mr. Bang
Dinh** and **Mr. Tinh Le**, this project becomes a mini MVC framework from the beginning with a lot of things that all
frameworks have such as Router, Controller, View, Model, Service, Repository, Middleware, Access control list, and
Validator. Besides that, this project integrates with the S3 service of AWS Cloud to store files or images.

# 🎉 Getting started

## Setup Environment

- Follow this article to install Nginx in Ubuntu
  20.04: [Click here](https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-20-04)
- Create an account to use the S3 service in AWS.

## Usage

- Clone project to local:

    ```bash
    git clone https://github.com/richardktran/carForRent.git
    ```

- Make a copy of the file `.env.example` and rename it to `.env`
- Edit all the parameters in `.env` corresponding to your environment
- Install Xdebug to generate test coverage:

    ```bash
    sudo apt-get install php-xdebug
    sudo apt-get install php-simplexml
    ```

- Install all necessary packages, and dependencies by using composer:

    ```bash
    composer install
    ```

- Run the project and enjoy!
