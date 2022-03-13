#README


#to run the application in dev mode:

#run in terminal

php artisan migrate  (to generate all migration data)

#after that, a default user with login: admin@admin.com and password 1234 will be created.

#to run application

php artisan run serve --port=80

#(dont forget to configure .env file, to match your environment configuration)

npm run watch  (to compile vue.js assets, in dev mode)


#How to execute tests:

#1. In the project root directory, run the command: vendor/bin/phpunit (to run all tests)

OR

#2. vendor/bin/phpunit --filter name_of_method_to_test (to run specific test)


Available Tests:

#1 - Check, If the migration witch added user with email 'admin@admin.com' was correctly inserted after initial migration
# run on terminal, in project root directory

vendor/bin/phpunit --filter check_if_user_admin_is_correctly_inserted

#2 - Check if path is being redirected to /login , after trying to access "/" path.
# run on terminal, in project root directory

vendor/bin/phpunit --filter check_if_page_redirected_to_login

#Executing Browsing Tests

# Run on root project directory the following command:

php artisan dusk

Available Test:

#1. Check if Login Function is Working.

php artisan dusk --filter check_if_login_function_is_working()

#APPLICATION USAGE

After login, we have 2 options in the front application:
Show Orders and Create Order.

in addition we have some endpoints that can accept some requests:

/orders/agregated (GET): This return agregated by OrderCode findAll 

/orders/update-custom (PATCH,PUT): Update route using body with attributes 
OrderId, OrderCode, OrderDate, TotalAmountWithoutDiscount ,TotalAmountWithDiscount

/orders/update-custom2 (PATCH,PUT): Update route using body with attributes 
id, code, date, total, discount

/orders/update-custom3 (PATCH,PUT): Update route using body with attributes 
id, code, date, totalAmount, totalAmountWithDiscount.

Enjoy it testing.




