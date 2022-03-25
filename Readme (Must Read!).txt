The video time was getting lengthy, therefore I was not able to show the full working of the prompt time functionality as the api request was after 10 second interval. You can view the working on the following lines:

1.cronJob.php (check whether to prompt the user or not and updates the table in database)
2.global.php (line 415 ) cronJob runs after a specific interval.
3.home.php (line 18) if database table entry is to prompt then the alert is shown to user with the name of the board in which he has to enter his input.