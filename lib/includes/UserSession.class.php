<?php

class UserSession
{
    public static function Authorize()
    {
        $request = (object)[];
        $secret_key = get_config('secret_key');
        $titleId = get_config("TitleId");
        $res = PlayFabAuthenticationApi::GetEntityToken($titleId, null, null, $secret_key, $request);
        $res = explode(",", $res)[2];
        $res = explode(":", $res)[2];
        $res = str_replace("\"", "", $res);

        $request = (object)[
            'EntityToken' => Session::get("entity_token")
        ];

        $result = PlayFabAuthenticationApi::ValidateEntityToken($titleId, $res, $request);
        $result = explode(",", $result);
        $player_id = explode(":", $result[4])[1];
        $player_id = str_replace("\"", "", $player_id);
        if ($player_id == Session::get('playFabId')) {
            return true;
        } else {
            //Todo: logout
            return false;
        }

        return explode("}", $result[4])[0];
    }

    public static function ensureLogin()
    {
        if (!empty(Session::get('entity_token'))) {
            if (UserSession::Authorize() == true) {
                return true;
            }
        }
        return false;
    }
}
