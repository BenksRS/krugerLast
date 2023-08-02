<?php

use Modules\Alacrity\Services\AlacrityService;

if (!function_exists('alacrity_service')) {

    /**
     * @return AlacrityService
     */
    function alacrity_service()
    {
        return new alacrityService();
    }

}


if (!function_exists('send_wpp')) {

    /**
     * @return send_wpp
     */
    function send_wpp($message,$to,$mentions='')
    {
        switch ($to){
            case 'sched':
//                $send_to='15619071569-1536333633@g.us';
                $send_to='120363141026576175@g.us';
                break;
            case 'new':
                $send_to='19545314091-1618419237@g.us';
//                $send_to='120363162797306222@g.us';
                break;
            case 'tech':
                $send_to='15619071569-1536333633@g.us';
                break;
            case 'alert':
                $send_to='19545314091-1618419237@g.us';
                break;
            default:
                $send_to='120363141026576175@g.us';
                break;
        }
        $params=array(
            'token' => 'y1kdxgx3lqfgrsms',
            'to' => $send_to,
            'body' => $message,
            'priority' => '10',
            'referenceId' => '',
            'msgId' => '',
            'mentions' => $mentions
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance49836/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

    }

}