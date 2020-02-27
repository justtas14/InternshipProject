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
    public function generalInfo() {
        $allCategories = DB::select('SELECT * FROM categories');

        return response()->json(
            [
                'allCategories' => $allCategories,
            ],
            200
        );
    }


    /**
     * @param int $page
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function productsFilter($page = 1, Request $request) {
        $productsPerPage = Config::get('constants.globalValues.productsPerPage');
        $searchParams = $request->all();
        $searchTitleFilter = $searchParams['searchTitleFilter'];
        $categoriesFilterArr = null;
        if (array_key_exists('categoriesFilter', $searchParams) &&
            $searchParams['categoriesFilter'] !== null &&
            sizeof($searchParams['categoriesFilter']) > 0) {
            $categoriesFilterArr = [];
            foreach ($searchParams['categoriesFilter'] as $key => $item) {
                array_push($categoriesFilterArr, json_decode($item)->name);
            }
        }
        $dishes = $this->getFilteredByTitleDishes($searchTitleFilter);
        $dishesArray = [];
        foreach ($dishes as $key => $dish) {
            $dishPropertiesArray = get_object_vars($dish);
            $dishPropertiesArray['categories'] = $this->getDishCategories($dish);
            $dishPropertiesArray['variations'] = $this->getDishVariations($dish);
            $dishCategoriesNameArray = [];
            foreach ($dishPropertiesArray['categories'] as $item) {
                array_push($dishCategoriesNameArray, $item->name);
            }
            if ($this->checkIfDishHasSelectedCategories($dishCategoriesNameArray, $categoriesFilterArr)
                || $categoriesFilterArr === null) {
                array_push($dishesArray, $dishPropertiesArray);
            }
        }

        $dishesCount = count($dishesArray);

        $pagesCount = $this->getNumberOfPages($dishesCount, $productsPerPage);
        if (!is_numeric($page)) {
            return response()->json([
                'error' => 'Page doesnt exist'
            ], 404);
        }
        $page = intval($page);
        if ($pagesCount < 1) {
            $pagesCount++;
        }
        if ($page < 1 || $page > $pagesCount) {
            return response()->json([
                'error' => 'Page '.$page.' doesnt exist'
            ], 404);
        }
        $offset = (($page - 1)  * $productsPerPage);
        $dishesToDisplay = array_slice($dishesArray, $offset, $productsPerPage);

        return response()->json(
            [
                'dishes' => $dishesToDisplay,
                'dishesCount' => $dishesCount,
                'pagesCount' => $pagesCount
            ],
            206
        );

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

    private function checkIfDishHasSelectedCategories($currentDishCategories, $selectedDishCategories) {
        if ($selectedDishCategories) {
            $intersectedArraySize = sizeof(array_intersect($currentDishCategories, $selectedDishCategories));
            return $intersectedArraySize === sizeof($selectedDishCategories);
        }
        return true;
    }
    /**
     * @param $titleSearchFilter
     * @return array
     */
    private function getFilteredByTitleDishes($titleSearchFilter) {
        $titleSearchFilter = $titleSearchFilter ? $titleSearchFilter : '';
        return DB::select(
            'SELECT * FROM dishes WHERE name LIKE :titleFilter',
            ['titleFilter' => '%'.$titleSearchFilter.'%']
        );
        //DB::select('SELECT * from dishes LEFT JOIN (SELECT name, dish_id FROM categories LEFT JOIN category_dish ON category_dish.category_id = categories.id) as categoryList ON dishes.id = categoryList.dish_id')
    }

    private function getDishCategories($dish) {
        return DB::select(
            'SELECT name, iconName FROM categories LEFT JOIN category_dish ON category_dish.category_id = categories.id
                WHERE category_dish.dish_id = :id',
            ['id' => $dish->id]);
    }

    private function getDishVariations($dish) {
        return DB::select(
            'SELECT name, increased_amount FROM variations LEFT JOIN dish_variation ON dish_variation.variation_id = variations.id
                WHERE dish_variation.dish_id = :id',
            ['id' => $dish->id]);
    }

    private function getNumberOfPages($dishesCount, $numberPerPages) {
        return ceil($dishesCount / intval($numberPerPages));
    }
}
