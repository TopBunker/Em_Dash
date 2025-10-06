<p align="center"><a href="https://www.rightsolutions.pro" target="_blank">EM-DASH</a></p>

### About Em-Dash

Em-Dash is an ongoing project to develop a streamlined, easy-to-use platform for creators to showcase their work via customizable single-page apps. 

The project began as a personal résumé and portfolio site, built with Laravel 12 (PHP), Livewire v3 (frontend-backend interactivity) and Alpine.js to demonstrate practical full-stack capabilities. 


### Key Features

:closed_lock_with_key: Secure résumé access with optional password protection\
:file_folder: Dynamic content management through Livewire components\
:incoming_envelope: Integrated contact form with document upload support\
:jigsaw: Modular and extensible architecture (ready for future dashboard features)\
:recycle: Built with clean, scalable code following Laravel best practices\


### Portfolio Context

This repository is part of my professional portfolio as a full-stack web developer on a long-term path toward systems engineering. The intent is for this project to reflect my systems-thinking approach, viewing web applications as integrated ecosystems where frontend experience, backend logic, performance, and scalability work together as one system. 

The project highlights my ability to:

+ Build modula, scalable codebases that can evolve into larger systems. 
+ Connect multiple layers of development seamlessly. 
+ Consider user flow, maintainability, and data integrity as part of one cohesive design. 
+ Bridge creativity, logic and structure -- the foundation of a systems engineering mindset. 

My goal is to continue refining this architecture into a platform where portfolio and résumé managment can evolve dynamically and demonstrate how thoughtful system design should simplify and empower user experiences.


### Tech Stack

| Layer             | Technology |
| ---               | --- |
| Backend           | Laravel 12 (PHP 8+) |
| Frontend          | Livewire v3, Alpine.js |
| Styling           | Tailwind CSS |
| Version Control   | Git + GitHub |
| Deployment        | Git-based CI/CD |


### Future Development

This project is currently a personal prototype, but upcoming milestones include:

+ User authentication an ddashboard for portfolio customization. 
+ Message inbox with filtering and analytics. 
+ Portfolio templates with drag-and-drop section managment. 
+ Public porfolio hosting for registered users.


### Future Development

1. Clone the repository:

```
git clone https://github.com/TopBunker/Em_Dash.git
cd Em-Dash
```

2. Install dependencies:

```
composer install
npm install 
npm run build
```

3. Copy and set up your environment file:

```
cp .env.example .env
php artisan key:generate
```

4. Set up database then run migrations and seed database with test data defined in factories:

```
php artisan migrate:fresh --seed
```

5. Run server:

```
npm run dev && npm run build
composer run dev
```

### License

Licensed under CC BY-NC 4.0 — © 2025 Jordane Delahaye.
Shared for portfolio and educational purposes. You’re welcome to explore, learn from, or adapt this project for non-commercial purposes with attribution.


