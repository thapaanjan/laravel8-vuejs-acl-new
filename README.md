# laravel8-vuejs-acl-new
Technology used to build this project:
	1. Laravel 8
	2. Vue.js
	3. Chart.js (vue-chart)
	4. Bootstrap
 
What does this project contains?

1. Role based admin user login and dashboard.
2. Default admin login credentials
    -> Email : superadmin@test.com 
    -> Password : 123456
3. Admin Forgot Password features using laravel default settings.
4. Can `create/edit/delete` -> team/admin, roles, resources.
    1. Default role is `Super Admin`, any roles can be added. e.g. admin, developer, moderator, manager etc...
    2. Resources are list of menus. Each admin users can have resources assigned to them and only those assigned resources can be accessed. If admin users try to access any other        resources which are not assigned to them it will return them 401! Unauthorized page.
    3. Permisson -> Each admin users can be given permission like add, update, delete, manage_permission
       3.1.`Note` : Manage Permission is for managing the admin users permission and don't assign this permission to every users, assign it to only selected and trusty admin user😃  

5. Contains chart in home page, that shows the admin users count based on role. Types of chart used as follows:
	5.1. Chart component are present inside `resources\js\components\charts` folder.
    5.2. Doughnut Chart
    5.3. Bar Chart
    5.4. Pie Chart
    5.5. Chart is created using data from API and it is implemented in two ways.
      1. API is directly called inside chart component.
      2. API data is passed to chart component using props from Home Page component.
     
6. Contains default migration and seeder file
 
# Follow the steps to install and run the project.
 
# Clone the project.

install npm dependencies
# npm install
Run migration to create tables in the selected database.
# php artisan:migrate
Run seeder to insert default tables values.
# php artisan db:seed
To watch for any changes in JS/CSS
# npm run watch
Run the laravel/php server
# php artisan serve

add below variabe to .env file
# SERVER_PORT=4444
# SERVER_HOST=localhost
