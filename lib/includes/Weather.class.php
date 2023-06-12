<?php


class Weather
{

    public static function getDetails()
    {
        $request = (object)[];
        $res = PlayFabAuthenticationApi::GetEntityToken(get_config('TitleId'), Session::get('entity_token'), null, null, $request);

        $result = explode(",", $res);
        $entity_id = str_replace("\"", "", explode(":", $result[4])[2]);
        $entity_type = str_replace("\"", "", explode(":", $result[5])[1]);

        $res = explode(",", $res)[2];
        $res = explode(":", $res)[2];
        $entity_token = str_replace("\"", "", $res);

        $curl = curl_init();

        $data = array(
            'Entity' => array(
                'Id' => $entity_id,
                'Type' => $entity_type,
            ),
        );

        // Convert the data to JSON format
        $jsonData = json_encode($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://d9226.playfabapi.com/Object/GetObjects',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'X-EntityToken:' . $entity_token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response);
        return $data->data->Objects->Location_History->DataObject;
    }

    public static function setData($key, $location)
    {
        $request = (object)[];
        $res = PlayFabAuthenticationApi::GetEntityToken(get_config('TitleId'), Session::get('entity_token'), null, null, $request);

        $result = explode(",", $res);
        $entity_id = str_replace("\"", "", explode(":", $result[4])[2]);
        $entity_type = str_replace("\"", "", explode(":", $result[5])[1]);
        $res = explode(",", $res)[2];

        $res = explode(":", $res)[2];
        $res = str_replace("\"", "", $res);

        $prev_data = (array)Weather::getDetails();

        $prev_data[$key] = $location;

        $data = array(
            'Entity' => array(
                'Id' => $entity_id,
                'Type' => $entity_type,
            ),
            'Objects' => array(
                array(
                    'ObjectName' => 'Location_History',
                    'DataObject' => $prev_data,
                ),
            ),
        );

        // Convert the data to JSON format
        $jsonData = json_encode($data);
        $curl = curl_init();


        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://d9226.playfabapi.com/Object/SetObjects',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'X-EntityToken:' . $res,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
