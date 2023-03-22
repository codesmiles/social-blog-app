# Social Blog App API

This is an app built with PHP/Laravel. It is a social blog app where users can create posts, comment on posts, like posts, follow other users, and more.

## Installation

1. Clone the repo
2. Run `composer install`
3. Run `npm install`

## Usage

1. Run `php artisan serve`
2. Visit `http://localhost:8000`

## API Endpoints

### Authentication

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| POST | /api/register | Register a new user |
| POST | /api/login | Login a user |
| POST | /api/user/logout | Logout a user |

### USER

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| GET | /api/user/search | Search for registered user |
| GET | /api/user/profile | show User profile |

### USER FRIENDS

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| POST | /api/user/search-friend | search for registered friends |
| POST | /api/user/add-friend/{friend_id} | Add a registered single friend |
| GET | /api/user/show-user-friends | Show the list of all added friends |
| GET | /api/user/show-user-single-friend/{firend_id} | show a single friend to your friend list |
| DELETE | /api/delete-frienf/{id} | remove friend from the friend list |

### USER FRIEND POSTS

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| GET | /api/user/{friend_id}/show-friend-posts | show all the post of your friend from your friend list |
| GET | /api/user/{firend_id}/show-single-friend-pos/{pos_id} | show a post of a single friend from your friend list |

### User Posts

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| POST | /api/user/create-post | Create a single post |
| GET | /api/user/show-posts | Show all  user posts |
| GET | /api/user/show-single-post/{post_id} | show a single post |
| POST | /api/user/edit-single-post/{post_id} | Update a post |
| DELETE | /api/user/delete-single-post/{post_id} | Delete a post |

### Comments

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| POST | /api/comment/save/{post_id} | Create a new comment for a post |

## Endpoints to be added

- forget password
- reset password
- likes and dislikes
- search
- notifications
- profile/profile picture/cover picture
- user settings
- user privacy
- comment endpoints
