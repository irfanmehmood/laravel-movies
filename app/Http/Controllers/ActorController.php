<?php

/**
 * ActorController.php
 *
 * PHP version 7
 * 
 * @category ActorController
 * @package  Movies
 * @author   irfan mehmood <irfmehmood@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://movies.digitalcook.co.uk
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * ActorController
 *
 * PHP version 7
 * 
 * @category ActorController
 * @package  Movies
 * @author   irfan mehmood <irfmehmood@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://movies.digitalcook.co.uk
 */

class ActorController extends Controller
{
    protected $apiKey;
    protected $baseUrl;

    /**
     * Constructor action.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() 
    {
        /**
         * Get tmdb api settings from config
         */
        $this->apiKey = config('services.tmdb.apikey');
        $this->personEndpoint = config('services.tmdb.personEndpoint');

        /**
         * No need to process after this
         */
        if ($this->apiKey === null) {
            dd("Api key is missing in .env");
        }
    }

    /**
     * Show movie action.
     * 
     * @param $id The actor id
     * 
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        /**
         * Person
         */
        $actor = Http::get(
            $this->personEndpoint
            .$id
            .'?api_key='
            .$this->apiKey
        )->json();

        /**
         * Social
         */
        $social = Http::get(
            $this->personEndpoint
            .$id
            .'/external_ids?api_key='
            .$this->apiKey
        )->json();

        /**
         * Credits
         */
        $credits = Http::get(
            $this->personEndpoint
            .$id
            .'/combined_credits?api_key='
            .$this->apiKey
        )->json();

        //dump($credits);
        
        return view(
            'actor.show', [
            'actor' => $actor,
            'social' => $social,
            'credits' => $credits
            ]
        );
    }

}
