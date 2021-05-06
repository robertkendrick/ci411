
Installation

For the brave:
1. Unzip the archive file into the ROOT (top level) directory of your application.
2. Edit app/Config/Generators.php and add the following as last entry in the $views array:
	'make:migrationplus' => 'App\Views\migration\migration4_tpl.php',

OR

1. Unzip the archive to a <temp> folder.
2. Create a folder called Commands inside your app folder.
3. Copy file migrationplus.php from <temp>/app/commands to the app/Commands folder.
4. Create a folder called migration inside the app/Views folder.
5. copy file migration4_tpl.php from <temp>/app/Views/migration to the app/Views/migration folder.
6. Edit app/Config/Generators.php and add the following as last entry in the $views array:
	'make:migrationplus' => 'App\Views\migration\migration4_tpl.php',

There are 3 ways to use this command:
1. using prompting or
2. using options on the command line or
3. using a combination of 1 and 2.

To familiarise yourself I suggest you use prompting first. 
This entails just typing 'php spark make:migrationplus' on the command line.
You will be prompted for the migration class name. The class name can be anything, it will
not affect what is written to the database. But I suggest something meaningful like
create_users for a migration file that will create a users table.
This will result in a Pascal case class name called CreateUsers and a filename called
<timestamp>_CreateUsers.php. Doing this means you will have a good idea what the migration file
does just by looking at its name, rather than just using a random name.
Other suggestions would be:
	add_name_users	(to make a migration file that adds a name column to the users table)
	remove_name_users (to make a migration file that removes the name column from the users table)

Remember these class names are for your benefit only. They do not generate any database code.
That comes next.

The next prompt will be:
	What migration action are you performing? (create, add or remove)?: 

Enter 'create' for creating a new table, 'add' to add a new column to an existing table 
or 'remove' to remove an existing column from an existing table

The next prompt will be:
	Name the database table?:

Enter the name of the database table you are performing the action on.

Now comes the stage where table columns are defined/specified.
For creating a new table the prompt will be:
	Enter the column names, types and sizes (sizes optional) Eg. id:id name:varchar:25 created:datetime:

Format is: column_name1:type:size column_name2:type:size column_name3:type:size ......
You must enter column name and type, size is optional and will be defaulted depending on type.


For adding/removing columns the prompt will be:
	Enter the column name, type and size (size is optional) that you are adding or removing Eg. name:varchar:25:

Format is: column_name:type:size
You must enter column name and type, size is optional and will be defaulted depending on type.

If you define a column with type 'id' it will become the primary key for the table and auto_increment.

The command then terminates with the creation of the migration file:
	File created: APPPATH\Database\Migrations\<timestamp>_<classname>.php

There is nothing to stop you editing this file and altering it to suit your needs before running the
actual migration with:
	php spark migrate

Read the CodeIgniter 4 User Guide - Migration section for useful information on the migration process.

Special column types can be:
	id 		(converts to int:9 primary_key auto_increment)
	number 	(converts to int:9)
	string 	(converts to varchar:255)






