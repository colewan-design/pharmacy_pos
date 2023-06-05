<?php
/**
 * Created by PhpStorm.
 * User: khimf
 * Date: 1/28/2021
 * Time: 3:01 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\category;
use App\department;
use App\Http\Resources\category as categoryResource;
use App\Http\Resources\categoryCollection;
use DB;

class categoryController extends Controller
{
    public function getCategory()
    {
        $Category_to_Department =  DB::table('categories')
                                    ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                                    ->where('categories.categoryIsDeleted', '!=' , 'Y')
                                    ->get()->toArray();

        return $Category_to_Department;
    }

    public function createCategory(Request $request)
    {
        // validate request
        $this->validate($request, [
            'categoryName' => 'required',
        ]);
        $category = category::create([
            'departmentId' => $request->departmentId,
            'categoryName' => $request->categoryName,
            'categoryDescription' => $request->categoryDescription,
            'categoryStyle' => $request->categoryStyle,
            'categoryUse' => 'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
        return $category;
    }
    public function editCategory(Request $request)
    {
        // validate request
        $this->validate($request, [
            'categoryName' => 'required',
        ]);

        $data = [
            'departmentId' => $request->departmentId,
            'categoryName' => $request->categoryName,
            'categoryDescription' => $request->categoryDescription,
            'categoryStyle' => $request->categoryStyle,
            'categoryUse' => $request->categoryUse,
            'updated_at' => now(),
        ];
      
        // check if category has active menu items..
        if($request->categoryUse == 'N') {
            $checkItems = category::where('categoryId', $request->categoryId)
                ->with('item')
                ->first();
            if(count($checkItems->item) > 0) {
                foreach($checkItems->item as $item) {
                    if($item->itemUse == 'Y') {
                        return 'false';
                    }
                }   
            }
        }

        $category = category::where('categoryId', $request->categoryId)->update($data);
        return $category;
    }

    public function deleteCategory(Request $request)
    {
        $data = [
            'categoryIsDeleted' => 'Y',
        ];

        $checkItems = category::where('categoryId', $request->categoryId)
            ->with('item')
            ->first();
        
        if(!is_null($checkItems)) {
            // check if category still in use..
            if($checkItems->categoryUse == 'Y') {
                return 'false';
            }

            // check if category has active menu items..
            if(count($checkItems->item) > 0) {
                foreach($checkItems->item as $item) {
                    if($item->itemUse == 'Y' || $item->itemIsDeleted == 'N') {
                        return 'false';
                    }
                }   
            }
        }
    
        $category = category::where('categoryId', $request->categoryId)->update($data);
        return $category;
    }

    public function getCategoryDepartment() {
        return department::all();
    }

}
