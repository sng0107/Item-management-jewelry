<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Cost;
use App\Models\Type;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\Purchase;



class ItemController extends Controller
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
 * 一覧画面を表示
 * 
 */
    public function index(Request $request)
    {
        // リレーションを事前に取得
        $items = Item::with('cost'); 

        // 検索フォームからキーワードを取得
        $search = $request->input('search');

        // 検索条件を追加
        if (!empty($search))
        {
            $items->where('item_code', 'like', "%{$search}%")
            ->orWhere('item_name', 'like', "%{$search}%");

        }

        // 商品コード順に表示(古い品番順)
        $items = $items->orderBy('item_code', 'asc')  // 品番全体を昇順にソート
        ->paginate(5)
        ->withQueryString();
    
        return view('item.itemIndex', compact('items'));
    }


/**
 * 登録画面を表示
 * 
 */
    public function create()
    {
        // DBからレコードを取得（プルダウンに表示させるため）
        $types = Type::all();
        $suppliers = Supplier::all();

        return view('item.itemAdd',compact('types','suppliers'));
    }

    
/**
 * 新規登録処理を実行
 */
    public function store(Request $request)
    {
      
        //バリデーションチェック
        $validate = [  
            'item_code'=> 'required|max:20|unique:items,item_code,',
            'item_name' => 'required|max:50',
            'img'=> 'nullable|max:50|mimes:jpg,jpeg,png,gif', // max:50は最大50KBまでという意味
            'retail_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'material' => 'required|max:100',
            'spec' => 'required|max:100',
            'sales_period' => 'required|max:30',
            'supplier' => 'required',
            'comment' => 'nullable|max:500',
        ];
         // バリデーションエラーメッセージ
         $errors = [
            'item_code.unique' => 'この商品コードは既に存在します。',
            'item_code.required' => '必須項目です。',
            'item_code.max' => '20文字以内です。',
            'item_name.required' => '必須項目です。',
            'item_name.max' => '50文字以内です。',
            'img.max' => '画像の容量は50KB以内です。',
            'img.mimes' => '画像の種類はjpg,jpeg,png,gifのみです。',
            'retail_price.required' => '必須項目です。',
            'retail_price.numeric' => '数字をご入力ください。',
            'stoc.required' => '必須項目です。',
            'stoc.numeric' => '数字をご入力ください。',
            'material.required' => '必須項目です。',
            'material.max' => '100文字以内です。',
            'spec.required' => '必須項目です。',
            'spec.max' => '100文字以内です。',
            'sales_period.required' => '必須項目です。',
            'sales_period.max' => '30文字以内です。',
            'comment.max' => '500文字以内です。',
        ];

        // 定義に沿ってバリデーションを実行
         $request->validate($validate , $errors);

        // リクエストに画像データがあった場合にその画像を保存
        $encoded_image=null;
        if ($request->hasFile('img')) {
            $image = file_get_contents($request->img);
            $encoded_image = base64_encode($image);
        }

        // バリエーションエラーがなければDBに保存
        $item = new Item([
            'user_id' => Auth::id(),
            'type_id' => $request->input('item_type'),
            'supplier_id' => $request->input('supplier'),
            'item_code' => $request->input('item_code'),
            'item_name' => $request->input('item_name'),
            'img' =>  $encoded_image,
            'retail_price'=> $request->input('retail_price'),
            'stock' => $request->input('stock'),
            'material' => $request->input('material'),
            'spec'=> $request->input('spec'),
            'sales_period'=> $request->input('sales_period'),
            'comment'=> $request->input('comment'),
        ]);

        $item->save();
    
        // 同時に仕入情報もDBに初期値で保存してテーブルを作成しておく
        $cost = new Cost([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'metal_cost' =>'0',
            'chain_cost' =>'0',
            'parts_cost' =>'0',
            'stone_cost' =>'0',
            'processing_cost' =>'0',
            'other_cost' =>'0',
            'total_cost' =>'0',
            'cost_rate' =>'0',
            
        ]);

        $cost->save();

        return redirect()->route('items.index')->with('flash_message', '商品が登録されました。');
    }

/**
 * 詳細画面表示
 * 
 */ 
    public function showDetail($id)
    {
        // DBから該当するレコードを取得
        $item = Item::find($id);
        
        return view('item.itemDetail', compact('item'));
    }


/**
 * 編集画面表示
 * 
 */
    public function edit($id)
    {
        // DBから該当するレコードを取得
        $item = Item::findOrFail($id);
    
        // ルダウンの表示用
        $types = Type::all();
        $suppliers = Supplier::all();
        
        return view('item.itemEdit', compact('item','types','suppliers'));
    }

/**
 * 編集処理実行
 * 
 */ 
    public function update(Request $request,$id)
    {  
        // DBから編集前のレコードを取得
        $item = Item::findOrFail($id);

        //バリデーションチェック
        $request->validate([
            'item_code'=> 'required|max:20|unique:items,item_code,'. $id, // 選択中の商品コードを除外
            'item_name' => 'required|max:50',
            'img'=> 'nullable|max:50|mimes:jpg,jpeg,png,gif', // max:50は最大50KBまでという意味
            'retail_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'material' => 'required|max:100',
            'spec' => 'required|max:100',
            'sales_period' => 'required|max:30',
            'comment' => 'nullable|max:500',
        ],
         // バリデーションエラーメッセージ
         [
            'item_code.unique' => 'この商品コードは既に存在します。',
            'item_code.required' => '必須項目です。',
            'item_code.max' => '20文字以内です。',
            'item_name.required' => '必須項目です。',
            'item_name.max' => '50文字以内です。',
            'img.max' => '画像の容量は50KB以内です。',
            'img.mimes' => '画像の種類はjpg,jpeg,png,gifのみです。',
            'retail_price.required' => '必須項目です。',
            'retail_price.numeric' => '数字をご入力ください。',
            'stoc.required' => '必須項目です。',
            'stoc.numeric' => '数字をご入力ください。',
            'material.required' => '必須項目です。',
            'material.max' => '100文字以内です。',
            'spec.required' => '必須項目です。',
            'spec.max' => '100文字以内です。',
            'sales_period.required' => '必須項目です。',
            'sales_period.max' => '30文字以内です。',
            'comment.max' => '500文字以内です。',
         ]);


        // 更新情報に画像データがあった場合
        $encoded_image=null;
        if ($request->hasFile('img')) {
            $image = file_get_contents($request->img);
            $encoded_image = base64_encode($image);

            // 編集内容を登録
            $item->update([
                'user_id' => Auth::id(),
                'type_id' => $request->type_id,
                'supplier_id' => $request->supplier_id,
                'item_code' => $request->item_code,
                'item_name' => $request->item_name,
                'img' =>  $encoded_image,
                'retail_price'=> $request->retail_price,
                'stock' => $request->stock,
                'material' => $request->material,
                'spec' => $request->spec,
                'sales_period' => $request->sales_period,
                'comment' => $request->comment,
            ]);
        }else{
            $item->update([
                'user_id' => Auth::id(),
                'type_id' => $request->type_id,
                'supplier_id' => $request->supplier_id,
                'item_code' => $request->item_code,
                'item_name' => $request->item_name,
                'img' => $item->img, // 既存の画像データをそのまま使う
                'retail_price' => $request->retail_price,
                'stock' => $request->stock,
                'material' => $request->material,
                'spec' => $request->spec,
                'sales_period' => $request->sales_period,
                'comment' => $request->comment,
            ]);

        }         
        return redirect('/items')->with('flash_message', '商品情報が更新されました。');
    }  
        


/**
 * 複製画面表示
 * 
 */
public function clone($id)
{
    // DBから該当するレコードを取得
    $item = Item::findOrFail($id);

    // プルダウン表示用
    $types = Type::all();
    $suppliers = Supplier::all();
    
    return view('item.itemCopy', compact('item','types' ,'suppliers'));
}


/**
 * 複製登録処理を実行
 */
public function cloneCreate(Request $request)
{
    
    //バリデーションチェック
    $validate = [  
        'item_code'=> 'required|max:20|unique:items,item_code,',
        'item_name' => 'required|max:50',
        'img'=> 'nullable|max:50|mimes:jpg,jpeg,png,gif', // max:50は最大50KBまでという意味
        'retail_price' => 'required|numeric',
        'stock' => 'required|numeric',
        'material' => 'required|max:100',
        'spec' => 'required|max:100',
        'sales_period' => 'required|max:30',
        'comment' => 'nullable|max:500',
    ];
     // バリデーションエラーメッセージ
     $errors = [
        'item_code.unique' => 'この商品コードは既に存在します。',
        'item_code.required' => '必須項目です。',
        'item_code.max' => '20文字以内です。',
        'item_name.required' => '必須項目です。',
        'item_name.max' => '50文字以内です。',
        'img.max' => '画像の容量は50KB以内です。',
        'img.mimes' => '画像の種類はjpg,jpeg,png,gifのみです。',
        'retail_price.required' => '必須項目です。',
        'retail_price.numeric' => '数字をご入力ください。',
        'stoc.required' => '必須項目です。',
        'stoc.numeric' => '数字をご入力ください。',
        'material.required' => '必須項目です。',
        'material.max' => '100文字以内です。',
        'spec.required' => '必須項目です。',
        'spec.max' => '100文字以内です。',
        'sales_period.required' => '必須項目です。',
        'sales_period.max' => '30文字以内です。',
        'comment.max' => '500文字以内です。',
    ];

    // 定義に沿ってバリデーションを実行
     $request->validate($validate , $errors);

    // リクエストに画像データがあった場合にその画像を保存
    $encoded_image=null;
    if ($request->hasFile('img')) {
        $image = file_get_contents($request->img);
        $encoded_image = base64_encode($image);
    }


    // バリエーションエラーがなければ新しいテーブルとしてDBに保存
    $newItem = new Item([
        'user_id' => Auth::id(),
        'type_id' => $request->input('type_id'),
        'supplier_id' => $request->input('supplier_id'),
        'item_code' => $request->input('item_code'),
        'item_name' => $request->input('item_name'),
        'img' =>  $encoded_image,
        'retail_price'=> $request->input('retail_price'),
        'stock' => $request->input('stock'),
        'material' => $request->input('material'),
        'spec'=> $request->input('spec'),
        'sales_period'=> $request->input('sales_period'),
        'comment'=> $request->input('comment'),
    ]);

    $newItem->save();

    // 同時に仕入情報もDBに初期値で保存してテーブルを作成しておく
    $newCost = new Cost([
        'item_id' => $newItem->id,
        'user_id' => Auth::id(),
        'metal_cost' =>'0',
        'chain_cost' =>'0',
        'parts_cost' =>'0',
        'stone_cost' =>'0',
        'processing_cost' =>'0',
        'other_cost' =>'0',
        'total_cost' =>'0',
        'cost_rate' =>'0',
        
    ]);
    $newCost->save();


    return redirect()->route('items.index')->with('flash_message', '複製から商品が登録されました。');
}

/**
 * 削除処理を実行
 * 
 */
public function destroy($id)
{
    // DBから該当するレコードを取得
    $item = Item::with('sales','purchases','cost')->find($id);
   
    if( ($item->sales->isNotEmpty() || $item->purchases->isNotEmpty() ))
    {
        return redirect('/items')->with('flash_message', '他のデータで使用されています。削除出来ません。');
    }
    elseif($item->cost)
    {
        return redirect('/items')->with('flash_message', 'コストデータを先に削除してください。');
    }
    else{
        // レコードを削除
        $item->delete();
        return redirect('/items')->with('flash_message', '商品情報が削除されました。');
       
    }
}




}