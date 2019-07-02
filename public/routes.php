<?php
$routesRegistrator = \Router\Registrator::getInstance();

//INDEX ROUTES
$routesRegistrator->map("GET","[index@index]","/","indexPage");

//USER ROUTES
$routesRegistrator->map("POST","[user@userRegistration]","users/register","userRegistration");
$routesRegistrator->map("POST", "[user@userLogin]", "users/login", "userLogin");
$routesRegistrator->map("GET", "[user@userLogout]", "users/logout", "userLogout");
$routesRegistrator->map("POST", "[user@edit]", "users/edit", "userEdit");
$routesRegistrator->map("POST", "[user@checkUserExists]", "users/alreadyExists", "userExists");
$routesRegistrator->map("GET", "[user@userData]","users/info", "userInfo");

//ACCOUNT ROUTES
$routesRegistrator->map("POST", "[account@regAccount]", "accounts/register", "accountRegistration");
$routesRegistrator->map("GET", "[account@allUserAccounts]", "accounts/all", "allAccounts");
$routesRegistrator->map("POST", "[account@edit]", "accounts/edit", "accountEdit");
$routesRegistrator->map("POST", "[account@deleteAccount", "accounts/delete", "deleteAccount");
$routesRegistrator->map("POST", "[account@accountInfo]", "accounts/info", "accountInfo");

//BUDGETS ROUTES
$routesRegistrator->map("POST", "[budget@registerBudget]", "budgets/register", "budgetRegister");
$routesRegistrator->map("GET", "[budget@listAllBudgets]", "budgets/all", "budgetListing");
$routesRegistrator->map("POST", "[budget@deleteBudget]", "budgets/delete", "budgetDelete");

//RECORDS ROUTES
$routesRegistrator->map("POST","[record@recordRegistration]", "records/register", "registerRecord");
$routesRegistrator->map("GET", "[record@listRecords]", "records/list", "listRecords");
$routesRegistrator->map("POST@GET", "[record@getSumTotal]", "records/totalSum", "recordsTotalSum");
$routesRegistrator->map("POST@GET", "[record@chartExpenses]", "records/expenses", "recordExpenses");
$routesRegistrator->map("GET", "[record@listLastFiveRecords]", "records/lastFiveRecords", "lastFiveRecords");
$routesRegistrator->map("GET", "[record@listIncomesAndExpense]", "records/incomesAndExpenses", "listIncomeAndExpense");
$routesRegistrator->map("POST@GET", "[record@radarDiagramExpenses]", "records/radar-expenses", "radarExpenses");
$routesRegistrator->map("POST", "[record@averageIncomeInfo]", "records/averageIncome", "averageIncome");
$routesRegistrator->map("POST", "[record@averageExpenseInfo]", "records/averageExpense", "averageExpense");

//CATEGORIES ROUTES
$routesRegistrator->map("POST", "[category@regCategory]", "category/register", "registerCategory");
$routesRegistrator->map("GET", "[category@allUserCategories]", "category/all", "allCategories");

//ERROR PAGES ROUTES
$routesRegistrator->map("GET", "[index@error404]", "error/404", "pageNotFoundError");
$routesRegistrator->map("GET", "[index@error500]", "error/500", "serverError");
$routesRegistrator->map("GET", "[index@error503]", "error/503", "serviceError");
$routesRegistrator->map("GET", "[index@unhandledError]", "error/503", "unhandledError");