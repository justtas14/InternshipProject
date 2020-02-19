<?php

namespace App\Http\Controllers;

use App\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function generalInfo($page = 1) {
        $productsPerPage = Config::get('constants.globalValues.productsPerPage');
        $dishesCount = DB::select('SELECT COUNT(id) as dishesCount FROM dishes');
        $pagesCount = $this->getNumberOfPages($dishesCount, $productsPerPage);
        if (!is_numeric($page)) {
            return response()->json([
                'error' => 'Page doesnt exist'
            ], 404);
        }
        $page = intval($page);
        if ($page < 1 || $page > $pagesCount) {
            return response()->json([
                'error' => 'Page '.$page.' doesnt exist'
            ], 404);
        }
        $offset = ($page - 1)  * $productsPerPage;
        $dishes = DB::select('SELECT * FROM dishes LIMIT :limit OFFSET :offset', [$productsPerPage, $offset]);
        $dishesArray = [];
        foreach ($dishes as $key => $dish) {
            $dishPropertiesArray = get_object_vars($dish);
            $dishPropertiesArray['categories'] = $this->getDishCategories($dish);
            array_push($dishesArray, $dishPropertiesArray);
        }
        $allCategories = DB::select('SELECT * FROM categories');

        return response()->json(
            [
                'dishes' => $dishesArray,
                'allCategories' => $allCategories,
                'dishesCount' => $dishesCount,
                'pagesCount' => $pagesCount
            ],
            206
        );
    }


    public function productsFilter(Request $request) {

    }

    /**
     * @param Dish $dish
     * @return \Illuminate\Http\JsonResponse
     */
    public function productInfo(Dish $dish) {
        $dishPropertiesArray = $dish->getOriginal();
        $dishPropertiesArray['categories'] = $this->getDishCategories($dish);
        $dishPropertiesArray['variations'] = $this->getDishVariations($dish);

        return response()->json(
            [
                'dish' => $dishPropertiesArray,
            ],
            200
        );
    }

    private function getDishCategories($dish) {
        return DB::select(
            'SELECT name FROM categories LEFT JOIN category_dish ON category_dish.category_id = categories.id
                WHERE category_dish.dish_id = :id',
            ['id' => $dish->id]);
    }

    private function getDishVariations($dish) {
        return DB::select(
            'SELECT name FROM variations LEFT JOIN dish_variation ON dish_variation.variation_id = variations.id
                WHERE dish_variation.dish_id = :id',
            ['id' => $dish->id]);
    }

    private function getNumberOfPages($dishesCount, $numberPerPages) {
        return floor(get_object_vars($dishesCount[0])['dishesCount'] / $numberPerPages);
    }
}
