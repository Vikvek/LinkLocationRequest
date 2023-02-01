# LinkToLocation
Send user link that requests current location, links expire after 15 minutes

Functions:
1. Index.php has list of all created codes (Need to create login function so users can only see their own created links) and link to check users location from map
2. create_link.php makes random unique link what you can send to other user
3. find.php gives user warning that if they click accept, location will be taken
4. show_location.php gets user location and after code is working correctly redirects to kiitos.php


Known bugs:
- If user doesnt give consent for page to get location, script wont run correctly and shows only white page at show_location and freezes. Also it wont count page as opened
- $_SESSION['username'] is not utilized because login form doesnt exist (Easy to fix)
- Because script cant get username it wont save code_creator value to database


