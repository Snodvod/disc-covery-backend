<?php

namespace App\Console\Commands;

use App\SocialAccount;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class refreshToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh spotify token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $socials = SocialAccount::where('platform', 'spotify')->get();

        foreach ($socials as $social) {
            $token = $social->refresh_token;

            $postfields = 'grant_type=refresh_token' .
                            '&refresh_token='.$token;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Basic ' . \base64_encode(env('SPOTIFY_ID') . ':' . env('SPOTIFY_SECRET')),
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

            $result = json_decode(curl_exec($curl), true);
            curl_close($curl);

            $this->info(json_encode($result));
            $social->token = $result['access_token'];
            $social->save();

        }
    }
}
