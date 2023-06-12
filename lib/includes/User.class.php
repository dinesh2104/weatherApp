<?php

use function PHPSTORM_META\type;

class User
{

    public static function Register($username, $email, $password, $confirmPassword)
    {
        if ($password != $confirmPassword) {
            throw new Exception("Password Mismatched");
        }
        PlayFabSettings::$titleId = get_config('TitleId');
        $request = (object)[
            "titleId" => PlayFabSettings::$titleId,
            "Email" => $email,
            "Password" => $password,
            "Username" => $username,
            "DisplayName" => $username,
            "InfoRequestParameters" => ["GetPlayerProfile" => true]
        ];

        try {
            $response = PlayFabClientAPI::RegisterPlayFabUser(PlayFabSettings::$titleId, $request);

            $response_code = explode(",", $response)[0];
            $response_code = explode(":", $response_code)[1];
            if ($response_code == 200) {
                return "New User Registered Successfully!!!";
            } else if ($response_code == 400) {
                $error = explode(",", $response)[4];
                throw new Exception(explode("}", $error)[0]);
            }   // ...
            // Return the necessary data to continue the user session
            return $response;
        } catch (Exception $ex) {
            // Handle login errors
            return 'Registration failed: ' . explode(":", $ex->getMessage())[1];
            return null;
        }
    }

    public static function login($email, $password)
    {
        PlayFabSettings::$titleId = get_config('TitleId');


        $request = (object)[
            "titleId" => PlayFabSettings::$titleId,
            "Email" => $email,
            "Password" => $password
        ];

        try {
            $response = PlayFabClientAPI::LoginWithEmailAddress(PlayFabSettings::$titleId, $request);
            // Login successful, retrieve the PlayFab ID or other necessary data
            //print_r($response);

            $response = explode(",", $response);
            //print_r($response);
            $response_code = explode(":", $response[0])[1];

            if ($response_code != 200) {
                return explode(":", explode("}", $response[4])[0])[1];
            }

            $session_token = explode(":", $response[2])[2];
            //print_r("Session:token:=>" . $session_token);
            $entity_token = explode(":", $response[9])[2];
            //print_r("\nEntityToken=>" . $entity_token);
            $playFabId = explode(":", $response[3])[1];

            Session::set("SessionToken", str_replace("\"", "", $session_token));
            Session::set("entity_token", str_replace("\"", "", $entity_token));
            // ...
            Session::set('playFabId', str_replace("\"", "", $playFabId));

            // Return the necessary data to continue the user session
            return "success";
        } catch (Exception $ex) {
            // Handle login errors
            return 'Login failed: ' . $ex->getMessage();
            return null;
        }
    }

    public static function getUsername()
    {
        $ses = Session::get('SessionToken');
        $req = (object)[];
        $res = PlayFabClientApi::GetAccountInfo(get_config('TitleId'), $ses, $req);
        $res = json_decode($res, true);
        return $res['data']['AccountInfo']['Username'];
    }
}
