<?php

/**
 * MovieController.php
 *
 * PHP version 7
 * 
 * @category MovieController
 * @package  Movies
 * @author   irfan mehmood <irfmehmood@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://movies.digitalcook.co.uk
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

/**
 * MovieController
 *
 * PHP version 7
 * 
 * @category MovieController
 * @package  Movies
 * @author   irfan mehmood <irfmehmood@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://movies.digitalcook.co.uk
 */

class MovieController extends Controller
{
    protected $apiKey;
    protected $moviesEndpoint;
    protected $genere;

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
        $this->moviesEndpoint = config('services.tmdb.moviesEndpoint');
        $genreEndpoint = config('services.tmdb.genreEndpoint');

        /**
         * No need to process after this
         */
        if ($this->apiKey === null) {
            dd("Api key is missing in .env");
        }
        
        /**
         * We need to populate $genre for all the api calls, so do it here
         * Make our Api calls for movies genres
         */
        $this->genre = Http::get($genreEndpoint."?api_key=".$this->apiKey)
            ->json()['genres'];
    }

    /**
     * Popular action.
     *
     * @return \Illuminate\View\View
     */
    public function popular() 
    {
        /**
         * Make our Api calls for popular movies
         */
        $movies = Http::get($this->moviesEndpoint."popular?api_key=".$this->apiKey)
        ->json()['results'];
        
        return view(
            'movie.movies', [
            'tile' => 'Popular Movies',
            'movies' => $movies,
            'genres' => $this->genre            
            ]
        );
    }

    /**
     * Top rated action.
     *
     * @return \Illuminate\View\View
     */
    public function toprated() 
    {
        /**
         * Make our Api calls for top rated movies
         */
        $movies = Http::get($this->moviesEndpoint."top_rated?api_key=".$this->apiKey)
            ->json()['results'];
        
        return view(
            'movie.movies', [
            'tile' => 'Top Rated Movies',
            'genres' => $this->genre,
            'movies' => $movies
            ]
        );
    }

    /**
     * Upcoming action.
     *
     * @return \Illuminate\View\View
     */
    public function upcoming() 
    {
        /**
         * Make our Api calls for upcoming movies
         */
        $movies = Http::get($this->moviesEndpoint."upcoming?api_key=".$this->apiKey)
            ->json()['results'];
        
        return view(
            'movie.movies', [
            'tile' => 'Upcoming Movies',
            'genres' => $this->genre,
            'movies' => $movies
            ]
        );
    }

    /**
     * Playing action.
     *
     * @return \Illuminate\View\View
     */
    public function playing() 
    {
        /**
         * Make our Api calls for Now Playing movies
         */
        $movies = Http::get(
            $this->moviesEndpoint."now_playing?api_key=".$this->apiKey
        )->json()['results'];
        
        return view(
            'movie.movies', [
            'tile' => 'Now Playing',
            'genres' => $this->genre,
            'movies' => $movies
            ]
        );
    }

    /**
     * Show movie action.
     * 
     * @param $id The movie id
     * 
     * @return \Illuminate\View\View
     */
    public function show($id) 
    {
        /** 
         * Url options 
         * */
        $options = 'append_to_response=credits,videos,images,crew';

        /** 
         * Final Url 
         * */
        $url = $this->moviesEndpoint.$id."?" .$options;

        /**
         * Make our Api calls for single movie
         */
        $movie = Http::get($url."&api_key=".$this->apiKey)->json();

        /**
         * For any reason movie is not found , we return to previous page
         */
        if (isset($movie['success']) && $movie['success'] === false) { 
            return redirect()->back();
        }

        /** 
         * String to store genere 
         */
        $generes = '';
        if (isset($movie['genres'])) :
            foreach ($movie['genres'] as $genere):
                $generes .= $genere['name'] . ', ';
            endforeach;
        endif;
        $generes = rtrim($generes, ', ');

        return view(
            'movie.show', [
            'movie' => $movie,
            'generes' => $generes
            ]
        );
    }
}
