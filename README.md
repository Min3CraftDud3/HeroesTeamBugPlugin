HeroesTeamBugPlugin
===================

Plugin + Web Interface for Atherys Heroes Team

The files to use are located in the "out" folder.
HTB.jar = plugin.
look.php + image files are for web interface. You will need to edit the look.php file and add your MySQL information.

Modify MySQL info in db_const.php

Permissions required for heroes team members: HTB.CanReceiveReports

How it works:

* Player on the server uses command /report <bug report>.
* Server sends the report along with player UUID and name to a MySQL database.
* Website reads from database and displays playername and bug reports.

Any more questions, look at source or ask :)