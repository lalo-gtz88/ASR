<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MadelineTrait;

class TelegramSessionController extends Controller
{
    private $madelineProto;

    public function __invoke ()
    {
        // $settings['app_info']['api_id'] = '##';
        // $settings['app_info']['api_hash'] = '####';


        // $MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);

        // $MadelineProto->start();

        // $me = $MadelineProto->getSelf();

        // if (!$me['bot']) {

        //     $sendMessage =  $this->madelineProto->messages->sendMessage([
        //         'peer' => '@mansourcodes',
        //         'message' => "Hi! <3"
        //     ]);

        // }


        $settings = [];
        $settings['app_info']['api_id'] = '22741365';
        $settings['app_info']['api_hash'] = '09870e27af845846073a27d847940fb7';
        $this->madelineProto = new \danog\MadelineProto\API('session.madeline', $settings);
        $this->madelineProto->async(true);
        return $this->madelineProto->loop(function () {
           
            $this->madelineProto->start();

            $me = $this->madelineProto->getSelf();
    
            
            if (!$me['bot']) {
    
                $sendMessage =  $this->madelineProto->messages->sendMessage([
                    'peer' => '@Patty_Linda',
                    'message' => "Hi! <3"
                ]);
    
            }
        });
    }
}
