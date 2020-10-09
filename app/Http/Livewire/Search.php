<?php
/**
 * Search.php
 *
 * PHP version 7
 * 
 * @category Component
 * @package  Livewire
 * @author   irfan mehmood <irfmehmood@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://movies.digitalcook.co.uk
 */


namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

/**
 * Search
 *
 * PHP version 7
 * 
 * @category Component
 * @package  Livewire
 * @author   irfan mehmood <irfmehmood@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://movies.digitalcook.co.uk
 */
class Search extends Component
{
    public $search = '';

    /**
     * Render action.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $apikey = config('services.tmdb.apikey');
        $this->searchEndpoint = config('services.tmdb.searchEndpoint');
        
        $searchResults = [];

        /**
         * Only search if string is more than 2 characters
         */
        if (strlen($this->search) >= 2) {
            $searchResults = Http::get(
                $this->searchEndpoint 
                . $this->search
                . "&api_key=$apikey"
            )->json()['results'];
        }

        //dump($searchResults);

        return view(
            'livewire.search', [
            'searchResults' => collect($searchResults)->take(7),
            ]
        );
    }
}
