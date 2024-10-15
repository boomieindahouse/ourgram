# Ourgram

This project is a basic web application designed to replicate some of Instagram's core features. It is developed using the AltoRouter framework for PHP routing on the backend, with MySQL handling the database management.

## Features

- User Authentication: Users can register, log in, and log out.
- Profile Management: Users can update their profile information and profile picture.
- Post Creation: Users can create new posts with images and captions.
- Post Viewing: Users can view their own posts as well as posts from other users.
- Follow System: Users can follow and unfollow others to see their posts in their feed.
- Likes and Comments: Users can like and comment on posts.
- Real-time Notifications: Users will receive notifications for likes, comments, and follows.

### Installation

- Install Composer: Download and install Composer by following the instructions at Composer's official website.
- Install AltoRouter: Run the following command in the root directory of your project to install AltoRouter:<br />
`composer require altorouter/altorouter`

### Starting the Project

- To start the project, run the following command in the root directory:<br />
`php -S localhost:8080`

### MySQL Configuration:<br />
`$servername = "localhost";`<br />
`$username = "root";`<br />
`$password = "12345678";`

