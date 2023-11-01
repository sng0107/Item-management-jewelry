<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Models\Type;
use App\Models\Item;

class TypeController extends Controller
{
 
/**
 * Create a new controller instance.
 *
 * @return void
 */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


/**
 * 一覧表示
 * 
 */
    public function typeIndex(Request $request)
    {
        // DBから該当するレコードを取得
        $types = Type::query(); 

        // 検索フォームからキーワードを取得
        $search = $request->input('search');

        // 検索条件を追加
        if (!empty($search))
        {
            $types->where('type_code', 'like', "%{$search}%")
            ->orWhere('type_name', 'like', "%{$search}%");
        }

        //アイテムコード順に表示
        $types = $types->orderBy('type_code', 'asc')->paginate(10)->withQueryString();

        return view('category.typeIndex', compact('types'));
    }


/**
 * 登録画面表示
 * 
 */
    public function showTypeAdd()
    {
        return view('category.typeAdd');
    }

    
/**
 * 登録処理実行
 * 
 */
    public function typeAdd(Request $request)
    {

        
        //バリデーションチェック
        $validate = [  
            'type_code'=> 'required|size:5|unique:types,type_code',
            'type_name'=> 'required|max:20|unique:types,type_name',
            
        ];
        // バリデーションエラーメッセージ
        $errors = [
            'type_code.unique' => 'このアイテムコードは既に登録されています。',
            'type_code.required' => '必須項目です。',
            'type_code.size' => '5桁で入力してください。',
            'type_name.unique' => 'このアイテム名は既に登録されています。',
            'type_name.required' => '必須項目です。',
            'type_name.max' =>  '20文字以内で入力してください。',
        ];

        // 定義に沿ってバリデーションを実行
        $request->validate($validate , $errors);
         
        // バリエーションエラーがなければDBに保存
        $type = new Type([
            'type_code' => $request->input('type_code'),
            'type_name' => $request->input('type_name'),
        ]);

        $type->save();

        return redirect()->route('categories.typeIndex',compact('type'))->with('flash_message', 'アイテムが登録されました');
    }

/**
 * 編集画面表示
 * 
 */
    public function showTypeEdit($id)
    {
        // DBから該当するレコードを取得
        $type = Type::findOrFail($id);

        return view('category.typeEdit',compact('type'));
}

/**
 * 編集処理実行
 * 
 */
    public function typeUpdate(Request $request,$id)
    {
        // DBから編集前のレコードを取得
        $type = Type::findOrFail($id);

        // バリデーションチェック
        $validate = [  
            'type_code'=> 'required|size:5|unique:types,type_code,'.$id,
            'type_name'=> 'required|max:20|unique:types,type_name,'.$id,
        ];
        $errors = [
            'type_code.unique' => 'このアイテムコードは既に登録されています。',
            'type_code.required' => '必須項目です。',
            'type_code.size' => '5桁で入力してください。',
            'type_name.unique' => 'このアイテム名は既に登録されています。',
            'type_name.required' => '必須項目です。',
            'type_name.max' =>  '20文字以内で入力してください。',
        ];

        // 定義に沿ってバリデーションを実行
        $request->validate($validate , $errors);
        
        // バリエーションエラーがなければDBに保存
        $type -> update ([
            $type->type_name = $request->type_name,
        ]);

        return redirect()->route('categories.typeIndex')->with('flash_message', 'アイテムが更新されました。');
    }

/**
 * 削除処理実行
 * 
 */
    public function typeDestroy($id)
    {
        // DBから該当するレコードを取得
        $type = Type::find($id);
        $item = Item::Where('type_id',$type->id)->get();
             
        if(!isset($item))
        {
        // レコードを削除
        $type->delete();
        
        return redirect()->route('categories.typeIndex')->with('flash_message', 'アイテムが削除されました。');
        }else{

            return redirect()->route('categories.typeIndex')->with('flash_message',  '他のデータで使用されています。削除出来ません。');
        }

    }


}
