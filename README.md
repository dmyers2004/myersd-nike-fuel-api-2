myersd-nike-fuel-api-2
======================

PHP class to interface with nike api

Simply get a Nike API V2 Token - Right now the only way is at developer.nike.com until they get there oAuth 2 service working

Include the file

include('nikeplusapi.php');

add your token from the Nike Developer Site
$token = ''; // Your Token

Create the Class
$np = new nikeplusapi($token);
	
Prep the Browser for print_r
echo '&lt;pre&gt;';

Sport will get your sports (see the nike API)
print_r($np->sport());

Activities returns all of your activities options include Page and the number of products (see the nike API)
print_r($np->activities());

(I spoke to Nike and they are aware that at this time pagination doesn't work - anything over page 0 returns nothing)

Get specifics on a Activity
print_r($np->activity(2095521418));

Get GPS data if available on a Activity
print_r($np->gps(2095521418));

[http://developer.nike.com](http://developer.nike.com)