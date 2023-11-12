<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use App\Models\Item;


class SupplierController extends Controller
{
   
/**
 * Create a new controller instance.
 *
 * @return void
 */
    public function __construct()
    {
        $this->middleware('auth');
    }


/**
 * 一覧表示
 */
    public function supplierIndex(Request $request)
    {
        //DBからレコードを取得
        $suppliers = Supplier::query(); 

        //検索フォームからキーワードを取得
        $search = $request->input('search');

        //検索条件を追加
        if (!empty($search))
        {
            $suppliers->where('supplier_code', 'like', "%{$search}%")
            ->orWhere('supplier_name', 'like', "%{$search}%");
        }

        //仕入先コード順に表示
        $suppliers = $suppliers->orderBy('supplier_code', 'asc')->paginate(10)->withQueryString();

        return view('category.supplierIndex', compact('suppliers'));
    }

/**
 * 登録画面表示
 */
    public function showSupplierAdd()
    {
        return view('category.supplierAdd');
    }

/**
* 登録処理実行
* 
*/
    public function supplierAdd(Request $request)
    {
        //バリデーションチェック
        $validate = [  
            'supplier_code'=> 'required|size:5|unique:suppliers,supplier_code',
            'supplier_name'=> 'required|max:20|unique:suppliers,supplier_name',
        ];
        //バリデーションエラーメッセージ
        $errors = [
            'supplier_code.unique' => 'この仕入先コードは既に登録されています。',
            'supplier_code.required' => '必須項目です。',
            'supplier_code.size' => '5桁で入力してください。',
            'supplier_name.unique' => 'この仕入先名は既に登録されています。',
            'supplier_name.required' => '必須項目です。',
            'supplier_name.max' => '20文字以内で入力してください。',
        ];
        //定義に沿ってバリデーションを実行
        $request->validate($validate , $errors);
        
        //バリエーションエラーがなければDBに保存
        $supplier = new Supplier([
            'user_id' => Auth::id(),
            'supplier_code' => $request->input('supplier_code'),
            'supplier_name' => $request->input('supplier_name'),
        ]);
        $supplier->save();

        return redirect()->route('categories.supplierIndex',compact('supplier'))->with('flash_message', '仕入先が登録されました。');
    }

/**
* 編集画面表示
*/
    public function showSupplierEdit($id)
    {
        $supplier = Supplier::findOrFail($id);

    return view('category.supplierEdit',compact('supplier'));
    }

/**
* 編集処理実行
*/
    public function supplierUpdate(Request $request,$id)
    {
        //DBから編集前のレコードを取得
        $supplier = Supplier::findOrFail($id);

        //バリデーションチェック
        $validate = [  
            'supplier_code'=> 'required|size:5|unique:suppliers,supplier_code,'.$id,
            'supplier_name'=> 'required|max:20|unique:suppliers,supplier_name,'.$id,
        ];
        //バリデーションエラーメッセージ
        $errors = [
            'supplier_code.unique' => 'この仕入先コードは既に登録されています。',
            'supplier_code.required' => '必須項目です。',
            'supplier_code.size' => '5桁で入力してください。',
            'supplier_name.unique' => 'この仕入先名は既に登録されています。',
            'supplier_name.required' => '必須項目です。',
            'supplier_name.max' => '20文字以内で入力してください。',
        ];
        //定義に沿ってバリデーションを実行
        $request->validate($validate , $errors);
        
        //バリエーションエラーがなければDBに保存
        $supplier -> update ([
            $supplier->supplier_name = $request->supplier_name,
        ]);

        return redirect()->route('categories.supplierIndex')->with('flash_message', '仕入先が更新されました。');
    }

/**
* 情報を削除
*/
    public function supplierDestroy($id)
    {
        //DBから該当するレコードを取得
        $supplier = Supplier::find($id);
        $item = Item::Where('supplier',$supplier->supplier_code)->get();

        if(!isset($item))
        {    
        //レコードを削除
        $supplier->delete();

        return redirect()->route('categories.supplierIndex')->with('flash_message', '仕入先が削除されました。');
        }else{

            return redirect()->route('categories.supplierIndex')->with('flash_message', '他のデータで使用されています。削除出来ません。');
        }
    }
}






