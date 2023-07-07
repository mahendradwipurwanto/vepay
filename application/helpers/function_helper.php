<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH.'third_party/gump-validation/gump.class.php';

if (!function_exists('convertToBase64')) {
    function convertToBase64($path)
    {
        // $path = FCPATH.$path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}

if (!function_exists('ej')) {
    function ej($params)
    {
        echo json_encode($params);

        exit;
    }
}

if (!function_exists('time_ago')) {
    function time_ago($datetime, $full = false)
    {

        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';

    }
}

if (!function_exists('sendMail')) {
    function sendMail($email, $subject, $message)
    {
        $_ci = &get_instance();
        $_ci->load->library('mailer');

        $mail = [
            'to' => $email,
            'subject' => $subject,
            'message' => $message
        ];

        if ($_ci->mailer->send($mail) == true) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('sendMailTest')) {
    function sendMailTest($email, $subject, $message)
    {
        $_ci = &get_instance();
        $_ci->load->library('mailer');

        $mail = [
            'to' => $email,
            'subject' => $subject,
            'message' => $message
        ];

        return $_ci->mailer->sendTest($mail);
    }
}
    
if (!function_exists('penalty_remaining')) {
    function penalty_remaining($datetime, $full = false)
    {
        // $datetime = date(" Y - m - d H : i : s ", time()+120);
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'i' => 'Menit ',
            's' => 'Detik ',
        ];
        $a = null;
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v;
                $a .= $v;
            } else {
                unset($string[$k]);
            }
        }
        return $a;
    }
}

if (!function_exists('arrToObj')) {
    function arrToObj($data) {
    if (gettype($data) == 'array')
        return (object)array_map("arrToObj", $data);
    else
        return $data;
    }
}

if (!function_exists('createPermalink')) {
    function createPermalink($string){
        
		$permalink = null;

		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		$word = preg_replace("/[^a-zA-Z0-9]+/", "-", $string);
		$word = strtolower($word);
        
		// generate permalink kursus
        $uniqid = "";

        for ($i = 1; $i <= 4; $i++) {
            $uniqid .= $chars[mt_rand(0, strlen($chars) - 1)];
            $permalink = strtolower($word . '-' . $uniqid);
        }

        return $permalink;
    }
}

if (!function_exists('createCode')) {
    function createCode($string){
        $string = preg_replace('/[^a-z]/i', '', $string);

        $vocal = ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " "];
        $scrap = str_replace($vocal, "", $string);
        $begin = substr($scrap, 0, 5);
        $uniqid = strtoupper($begin);

        // CREATE KODE
        $code = $uniqid . "-" . substr(md5(time()), 0, 6);


        return $code;
    }
}

if(!function_exists('base64ToImage')){

    function base64ToImage($path, $base64){   
        try {
            $image_parts = explode(';base64,', $base64);
            $image_type_aux = explode('image/', $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $namaFile = uniqid().'.'.$image_type;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file = $path.$namaFile;
            file_put_contents($file, $image_base64);

            return [
                'status' => true,
                'data' => $namaFile,
                'url' => $file,
            ];

        } catch (\Throwable $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}


if(!function_exists('discordmsg')){
    function discordmsg($msg) {

        $webhook = "https://discord.com/api/webhooks/1126750424347709521/Vth1gyj3NhM5DkToFT-KhmHPMniiQo67wmUwhEfLzUm2Olz0CRNMgcHfFUZqiARPfXqX";
        $timestamp = date("c", strtotime("now"));
        $msg = json_encode([
            "username" => "Vepay ".date("Y"),

            "tts" => false,

            "embeds" => [
                [
                    // Title
                    "title" => "Discord listener",

                    // Embed Type, do not change.
                    "type" => "rich",

                    // Description
                    "description" => $msg != "" ? "``` {$msg} ```" : 'No Data to send',

                    // Timestamp, only ISO8601
                    "timestamp" => $timestamp,

                    // Left border color, in HEX
                    "color" => hexdec("3366ff"),
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        if($webhook != "") {
            $ch = curl_init( $webhook );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt( $ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $msg);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
 
            $response = curl_exec( $ch );
            // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
            echo $response;
            curl_close( $ch );
        }
    }
}

if(!function_exists('deleteFile')){
    function deleteFile($file_path) {
        if(file_exists($file_path)){
            unlink($file_path);
        }
    }
}

if(!function_exists('generateRandomString')){
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if(!function_exists('validate')){
    function validate($data, $validasi, $custom = [])
    {
        if (!empty($custom)) {
            $validasiData = array_merge($validasi, $custom);
        } else {
            $validasiData = $validasi;
        }
        $lang = 'en';
        $gump = new GUMP($lang);
        $validate = $gump->is_valid($data, $validasiData);

        if (true === $validate) {
            return [
                'status' => true
            ];
        }

        return [
            'status' => false,
            'data' => $validate
        ];
    }
}

if(!function_exists('base64ToImage')){
    function base64ToImage($path, $base64)
    {   
        $image_parts = explode(';base64,', $base64);
        $image_type_aux = explode('image/', $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $namaFile = uniqid().'.'.$image_type;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file = $path.$namaFile;
        file_put_contents($file, $image_base64);

        return [
            'status' => true,
            'data' => $namaFile,
            'url' => $file,
        ];
    }
}