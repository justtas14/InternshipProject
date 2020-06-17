<?php

namespace App\Http\Controllers;

use App\Category;
use App\Dish;
use App\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function generalInfo() {
        $allCategories = DB::select('SELECT * FROM categories');
        $variations = DB::select('SELECT * FROM variations');

        return response()->json(
            [
                'allCategories' => $allCategories,
                'variations' => $variations
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

    public function addProduct(Request $request) {
        $user = auth('api')->user();
        if (!$user->isAdministrator()) {
            return response()->json(
                [
                    'You are not admin!'
                ],
                403
            );
        }
        $data = $request->all();
        $title = $data['title'];
        $price = $data['price'];
        if (!is_numeric($price) || $price > 999) {
            return response()->json(
                [
                    'error' => 'Price must be number or its too large!',
                ],
                200
            );
        }
        $description = $data['description'];
        $image = $data['image'];
        $categoriesChecked = json_decode($data['categoriesChecked'], true);
        $variationsChecked = json_decode($data['variationsChecked'], true);


        $filename = 'profile_picture-' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('images/dishes', $filename);

        $dish = new Dish();
        $dish->name = $title;
        $dish->price = $price;
        $dish->description = $description;
        $dish->profile_picture = $filename;
        $dish->save();

        $selectedCategories = [];
        $selectedVariations = [];

        foreach ($categoriesChecked as $key => $value) {
            if ($value['val']) {
                $category = Category::find($key+1);
                array_push($selectedCategories, $category);
            }
        }
        foreach ($variationsChecked as $key => $value) {
            if ($value['val']) {
                $variation = Variation::find($key+1);
                array_push($selectedVariations, $variation);
            }
        }
        foreach ($selectedCategories as $key => $value) {
            $dish->categories()->attach(
                $value->id
            );
        }
        foreach ($selectedVariations as $key => $value) {
            $dish->variations()->attach(
                $value->id
            );
        }
        return response()->json(
            [
            ],
            200
        );
    }

    public function deleteProduct(Request $request) {
        $user = auth('api')->user();
        if (!$user->isAdministrator()) {
            return response()->json(
                [
                    'You are not admin!'
                ],
                403
            );
        }
        $data = $request->all();
        $productId = $data['id'];

        $dish = Dish::find($productId);

        $oldProfilePicture = $dish->profile_picture;
        if ($oldProfilePicture !== 'dish.png') {
            Storage::delete('images/dishes/'.$oldProfilePicture);
        }

        $dish->delete();

        return response()->json(
            [],
            200
        );
    }

    public function editProduct(Request $request) {
        $user = auth('api')->user();

        if (!$user->isAdministrator()) {
            return response()->json(
                [
                    'You are not admin!'
                ],
                403
            );
        }
        $data = $request->all();

        $id = $data['id'];
        $title = $data['title'];
        $price = $data['price'];
        if (!is_numeric($price) || $price > 999) {
            return response()->json(
                [
                    'error' => 'Price must be number or its too large!',
                ],
                200
            );
        }
        $description = $data['description'];
        $image = $data['image'];
        $categoriesChecked = json_decode($data['categoriesChecked'], true);
        $variationsChecked = json_decode($data['variationsChecked'], true);

        $filename = 'profile_picture-' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('images/dishes', $filename);


        $dish = Dish::find($id);

        $oldProfilePicture = $dish->profile_picture;
        if ($oldProfilePicture !== 'dish.png') {
            Storage::delete('images/dishes/'.$oldProfilePicture);
        }

        $dish->name = $title;
        $dish->price = $price;
        $dish->description = $description;
        $dish->profile_picture = $filename;
        $dish->save();

        $selectedCategories = [];
        $selectedVariations = [];

        foreach ($categoriesChecked as $key => $value) {
            if ($value['val']) {
                $category = Category::find($key+1);
                array_push($selectedCategories, $category);
            }
        }
        foreach ($variationsChecked as $key => $value) {
            if ($value['val']) {
                $variation = Variation::find($key+1);
                array_push($selectedVariations, $variation);
            }
        }


        $newIds = [];
        foreach ($selectedCategories as $key => $value) {
            array_push($newIds, $value->id);
        }
        $dish->categories()->sync($newIds);

        $newIds = [];
        foreach ($selectedVariations as $key => $value) {
            array_push($newIds, $value->id);
        }
        $dish->variations()->sync($newIds);

        return response()->json(
            [
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
