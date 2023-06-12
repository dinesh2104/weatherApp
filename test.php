<pre>
<?php

include "./lib/load.php";

$res = User::Register("dinesh", "dhineshs2011@gmail.com", "dinesh", "dinesh");

print_r($res);

// $res1 = User::login("dineshsdk56@gmail.com", "dinesh");

// print_r($res1);

//print_r(UserSession::Authorize(Session::get('entity_token')));

//print_r(UserSession::Authorize(Session::get('SessionToken')));

// $entity = "NHxFdUZHQmpHR1hNL0VkdUw4emNZK3VERTFEV0RoNk84Y1h4VzRCWmRDVFRVPXx7ImkiOiIyMDIzLTA2LTEyVDA2OjAxOjU0WiIsImlkcCI6IlBsYXlGYWIiLCJlIjoiMjAyMy0wNi0xM1QwNjowMTo1NFoiLCJmaSI6IjIwMjMtMDYtMTJUMDY6MDE6NTRaIiwidGlkIjoiNkIxS3E5Ym1tRGsiLCJpZGkiOiJFMTA3MzM4NDFCM0ZCMzg3IiwiaCI6IjdEOTJGQ0U4MzRCRUUzOTIiLCJlYyI6InRpdGxlX3BsYXllcl9hY2NvdW50IUQyOTFCNTJBMDhDOTExNkYvRDkyMjYvRTEwNzMzODQxQjNGQjM4Ny80ODlFMEFENjI2Mzc3OTg1LyIsImVpIjoiNDg5RTBBRDYyNjM3Nzk4NSIsImV0IjoidGl0bGVfcGxheWVyX2FjY291bnQifQ==";

// print_r(UserSession::Authorize());
?>
</pre>