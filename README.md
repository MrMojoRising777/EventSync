<p align="center">
  <img src="https://github.com/MrMojoRising777/eindwerkBackEnd/assets/81364395/7b0305e3-367a-4e33-8e69-d3016d600078" width="50%">
</p>

[![en](https://img.shields.io/badge/lang-en-red.svg)](https://github.com/MrMojoRising777/EventSync/blob/main/README.md)
[![nl](https://img.shields.io/badge/lang-nl-green.svg)](https://github.com/MrMojoRising777/EventSync/blob/main/README.nl.md)

## Welcome to EventSync! 

EventSync is a web application that makes event planning a breeze. If you've ever found it challenging to coordinate schedules for group events or vacations, EventSync is here to streamline that process.

## 📑 Overview

EventSync's mission is to simplify event planning and coordination. We provide a platform where users can create events, input their availability, and generate a recommended timetable based on overlapping availabilities. With our intuitive and user-friendly interface, we aim to deliver an efficient and enjoyable event scheduling experience.

## ✨ Features

- **Event Creation:** Define the specifics such as date, time, location, and description of your events.
- **Friend System:** Connect with friends and invite them to your events for seamless group planning.
- **Availability Submission:** Submit your availability in a simple and hassle-free manner.
- **Availability Analysis:** Let EventSync work its magic to find the best time slots that work for everyone.
- **OpenMaps Integration:** Take advantage of our OpenMaps integration for location selection, providing map visualization and detailed location information.
- **Mail Functionality:** Stay in the loop with our mail functionality, which sends event updates, invitations, and reminders directly to your inbox.

## 💻 Installation

Deploying and running EventSync on your local machine is as simple as following these steps:

1. Clone this repository to your local machine using `git clone`.
2. Run `composer install` in the project directory to install all the necessary dependencies.
3. Set up your local environment by copying `.env.example` to `.env` and modifying the settings according to your local environment.
4. Run `php artisan migrate` to set up your databases.
5. Generate an application key with `php artisan key:generate`.
6. Finally, launch the application with `php artisan serve`. By default, the application will be hosted at `http://127.0.0.1:8000`.

## 🔧 Technical Requirements

For successful deployment and operation, EventSync requires the following:

- **Git:** Git is necessary for cloning the repository to your local machine.
  
- **Composer:** The PHP package manager Composer is required for installing all necessary dependencies.

- **PHP Environment:** Since the project uses Laravel (a PHP framework), a compatible PHP environment is necessary. Make sure you have PHP 7.3 or later versions installed on your machine.

- **Database System:** You will need a database system to handle data storage. Laravel supports a variety of databases such as MySQL, PostgreSQL, SQLite, and SQL Server.

- **Web Server:** An HTTP server software capable of hosting static files (e.g., Apache, Nginx) is required to serve your Laravel application. Laravel also includes a built-in server for development purposes.

- **Supported Browsers:** Latest versions of popular web browsers (Chrome, Firefox, Safari, Edge).

- **Internet Connectivity:** An internet connection is required to fully utilize the OpenMaps integration and the mail functionality.

Please note that this assumes your local machine is equipped with a suitable operating system such as Linux, macOS, or Windows, and that the machine has sufficient hardware capacity to handle the above software.

## 🚀 Usage

After EventSync is successfully deployed, access it using the URL associated with your server. The application provides a straightforward and intuitive interface that allows you to create events, invite participants, submit availabilities, and generate optimal schedules based on participants' availabilities.

Stay in the loop with our mail functionality that sends event updates, invitations, and reminders directly to your inbox.

**Please note: EventSync is developed for educational purposes.**

---

<p align="center">Thank you for visiting EventSync! Happy planning! 🎉</p>