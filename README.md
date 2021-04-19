# MODULAR WEBSITE
Hello, friend!
This is a PHP/Javascript website with a working forum, mini-game and a shop.

## Introduction (aka bla bla bla section :3)
This is my school project, it was a requirement in order to get my degree.

Instructions were clear:
    - A minimum "30 hours" of work into the project.
    - It has to be fully operational.
    - Challenging, which I admit, I went a bit overboard..

With those instructions in mind, I set myself into a path of self-discovery (There's no other word to describe this experience). I never coded before this project, much less something of this size, the project started the 7th of February of 2020 and finished the 6th of May of 2020. I was coding like crazy, 12 hours a day minimum (what some people might call it "getting in the zone") which added up to over 1000 hours to it, and thats lowballing it. 


It was a really fun project and an academic one, I've wanted to do this since I discovered the website "median-xl.com" and "pathofexile.com", and decided to do one myself (hence the use of some diablo and poe images, that can be removed if needed due to any copyright infringments(not the intention to do any harm here!)). Also, profile pic skull was made by me, hope you guys like that one.

Ok, lets continue with what you are here for..

## Installation guide
1) Download the project
2) You will need a web server (I use wamp for this)
3) Go to your database page (adminer/phpmyadmin in my case)
4) Import the "phplogin.sql" into your database (it will throw an error when importing, due to an event that you will have to import next manuall)
5) Import the "sqlevent" file (what this event does is, it periodically checks if the user has performed any action in the past x minutes, if not, it gets logged off from the website)
6) Go to your localhost and boom! You in!


## Directory structures
I wanted to make a modular website, each part of it will load separately, for example: if you login the website, the only part that is downloading/requesting is that tiny part of the website (which I called module, thinking it was an appropriate term), the rest of the website does not request/download/change until it's requested to the HTTP server.

In the root directory, we have the index.php, the api.php, the public folder and the assets folder. It was called "public" because, in my head, I thought this structure as "I will have public stuff, and then private stuff, in case I have to hide important things". 

index.php: contains the skeleton of the website, basic html with a session_start(), some includes and the classic <head>css, scripts, etc</head>. The body will contain the "controller.php", the one in charge of selecting what's being requested/shown on screen.

api.php: It's a really basic api to transmit data from the game to the database. 

assets: This folder contains all the visual stuff, style.css, images folder for profiles, websites, etc. When an user registers an account and uploads an image to their profile, it will be stored here.

public: Here's our main directory, all the files will be sorted into 4 categories (header, nav, main and footer). Each represents a portion of the website, or "module".

The most important, the one that makes all this thing work, is Modular-Website/public/main/private/functionLibrary.php. This massive file is the brain of the operation, and I tried my best to keep it organized and with good comments (at least, at the time they were, whenever I see my code now I feel the urge to refactor everything, OOF).

Inside Modular-Website/public/main/private/adm/ you will find all the functions and logic for the admin panel, since there are 3 types of users, each with their own privileges (in the db they have "rank" 0 to 2, admin, moderator, normal user).

I could keep going on and on about every tiny functionallity that this project can offer, but it's better if you just check it yourself! Just download it, import the db and mess with the actual website!

## Notes
Keep in mind that this project was done prior any coding experience/knowledge, then I went and dive in this insane and immense project (which led me to believe that I could be a software engineer one day). There were some bugs, which many got patched long ago, but some remained. Like, you can open the console and cheat the score of the mini-game, access the api (probably my fault) and change your score, forum exploits with html. Also, I tried to the best of my ability to give the forum/db some security, but it's probably not good enough to meet any standard. 

I will try to clean it once I have a break from college, but I can't promise anything!

Thanks for reading and have a nice day :)
Somnus.



