# User Management System

A Symfony project created on October 21, 2017, 6:59 pm.
My first time learning PHP! It was quite a struggle just setting up mysql and getting it connected.

I got considerable insights from this repo:

https://github.com/andreafiori/symfony-3-todo-list

Thank you, kind stranger! ᕕ( ᐛ )ᕗ

## Features
You can:
* Add users 
* Edit users
* Delete users
* Add groups
* Delete groups if empty
* View members in groups

You cannot:
* Add users to the group via the UI ((´д｀)) - more on why lower down

## Instructions

1. Clone the repository in any directory
2. Establish a database connection with: `php bin/console doctrine:database:create` command in the repo
3. Update the database with existing doctrine entities: `php bin/console doctrine:schema:update --force`
4. Start up the server: `php bin/console server:run`
5. Go to http://localhost:8000 and confirm that the website is up and running!

## Aside & Future Todo
I don't know why this website doesn't render the buttons as they should :T 
It's ugly and I don't like it, but an hour of searching turned up nothing useful.

Regarding adding users to the group, I fiddled around for 2 hours trying to make a nice list of users not in the group and giving checkboxes for easy addition. I created an array to pass into a Form to generate a checklist of sorts, but I could not find a way to pass in an array into a FormType. 

It seems like you can embed a collection of forms: https://symfony.com/doc/current/form/form_collections.html

I initially thought this was out of scope for what I wanted and didn't investigate, but it might be what I need.

Another idea I have is to create a separate page with listings of non members of a group, and creating another controller function to add to the group if clicked on the user interface. 

