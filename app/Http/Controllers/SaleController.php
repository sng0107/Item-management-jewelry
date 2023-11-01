<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Type;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
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
 * 一覧画面表示
 * 
 */
public function index(Request $request){

    // リレーションを事前に取得
    $sales = Sale::with('item');
 
    // 検索フォームからキーワードを取得
    $search = $request->input('search');

    if (!empty($search)) {
        $sales->where(function($query) use ($search) {
            $query->whereHas('item', function ($query) use ($search) {
                $query->where('item_code', 'like', "%{$search}%")
                    ->orWhere('item_name', 'like', "%{$search}%");
            })
            ->orWhere('sale_date', 'like', "%{$search}%")
            ->orWhere('customer', 'like', "%{$search}%");
        });
    }

    // 最近の販売日から順に表示
    $sales = $sales->orderBy('sale_date', 'desc')->paginate(10)->withQueryString();
     
    return view('sale.salesIndex', compact('sales'));
 }


/**
 * 検索画面表示
 * 
 */
public function showSearch(Request $request)
{
  return view('sale.salesItemSearch');
}


/**
 * 検索結果表示
 * 
 */
public function searchResult(Request $request)
{
    // 検索フォームからキーワードを取得
    $search = $request->input('search');

    // 検索条件を追加
    if (!empty($search))
    {
        //検索に該当するレコードを取得して商品コード順に表示する
        $items = Item::with('type')->where('item_code', 'like', "%{$search}%")
        ->orWhere('item_name', 'like', "%{$search}%")
        ->orderByRaw('CAST(item_code as SIGNED) ASC')->paginate(10)->withQueryString();

            // キーワードは入力された。itemsDBにはtableが存在する。しかし該当する結果がなかった場合
            if ($items->isEmpty()) {
                return view('sale.salesSearchResult');
            }
        
        return view('sale.salesSearchResult', compact('items'));

    }else
    {
        // キーワードが空の場合
        return redirect()->route('sales.search');
    }
      
}


/**
* 登録画面表示

*/
public function create($id)
{
    // DBから該当するレコードを取得
    $item = Item::findOrFail($id);

    return view('sale.salesAdd',compact('item'));
}


/**
* 登録処理実行

*/
public function store(Request $request,$id)
{
    // dd($request->ALL());
    //バリデーションチェック
    $validate = [  
        'sale_price' => 'required|numeric',
        'sale_date' => 'required',
        'sale_quantity' => 'required|numeric',
        'customer' => 'nullable|max:20',
        'staff' => 'nullable|max:20',
        'comment' => 'nullable|max:500',
    ];
     // バリデーションエラーメッセージ
     $errors = [
        'sale_price.required' => '必須項目です。',
        'sale_price.numeric' => '数字をご入力ください。',
        'sale_date.required' => '必須項目です。',
        'sale_quantity.required' => '必須項目です。',
        'sale_quantity.numeric' => '数字をご入力ください。',
        'customer.max' => '20文字以内です。',
        'staff.max' => '20文字以内です。',
        'comment.max' => '500文字以内です。',
    ];

  
    // 定義に沿ってバリデーションを実行
     $request->validate($validate , $errors);
  
    //  dd($request->ALL());

    // バリエーションエラーがなければDBに保存
    $sale = new Sale([
        'user_id' => Auth::id(),
        'item_id' => $id,
        'sale_price' => $request->input('sale_price'),
        'sale_date' => $request->input('sale_date'),
        'sale_quantity' => $request->input('sale_quantity'),
        'customer'=> $request->input('customer'),
        'staff'=> '未設定',
        'comment'=> $request->input('comment'),
    ]);

    $sale->save();

    // 在庫数を更新
    $item = Item::find($id)->decrement('stock', $request->input('sale_quantity'));

    return redirect()->route('sales.index')->with('flash_message', '販売実績が登録されました。');
}


/**
* 詳細画面表示
*
*/
public function detail($id)
{
    // DBから該当するレコードを取得
    $sale = Sale::with('item')->find($id);

    return view('sale.salesDetail',compact('sale'));

}

/**
* 編集画面表示
*
*/
public function edit($id)
{
    // DBから該当するレコードを取得
    $sale = Sale::with('item')->find($id);

    return view('sale.salesEdit',compact('sale'));

}

/**
* 編集後の更新処理実行
*
*/
public function update(Request $request,$id)
    {  
        // DBから編集前のレコードを取得
        $sale = Sale::with('item')->find($id);

        if($sale->item->id)
        {
            // 在庫数を更新（編集で発生した差のみ) 
            $sale->item ->decrement('stock', $request->sale_quantity - $sale->sale_quantity);
        
            //バリデーションチェック
            $validate = [  
                'sale_price' => 'required|numeric',
                'sale_date' => 'required',
                'sale_quantity' => 'required|numeric',
                'customer' => 'nullable',
                'staff' => 'nullable|max:20',
                'comment' => 'nullable|max:500',
            ];
            // バリデーションエラーメッセージ
            $errors = [
                'sale_price.required' => '必須項目です。',
                'sale_price.numeric' => '数字をご入力ください。',
                'sale_date.required' => '必須項目です。',
                'sale_quantity.required' => '必須項目です。',
                'sale_quantity.numeric' => '数字をご入力ください。',
                'customer.max' => '20文字以内です。',
                'staff.max' => '20文字以内です。',
                'comment.max' => '500文字以内です。',
            ];
        
            // 定義に沿ってバリデーションを実行
            $request->validate($validate , $errors);

            // バリエーションエラーがなければDBに保存
            $sale->update([
                'user_id' => Auth::id(),
                'sale_price' => $request->sale_price,
                'sale_date' => $request->sale_date,
                'sale_quantity' => $request->sale_quantity,
                'customer' => $request->customer,
                'staff' => '未設定',
                'comment' => $request->comment,
            ]);

            return redirect('/sales')->with('flash_message','販売情報を更新しました。');
        }
        else{
            return redirect('/sales')->with('flash_message','商品が存在しません。更新できません。');
        }
    }


/**
 * 複製画面表示
 * 
 */
public function clone($id)
{
    // DBから該当するレコードを取得
    $sale = Sale::findOrFail($id);
    
    return view('sale.salesCopy', compact('sale'));
}


/**
 * 複製登録処理を実行
 */
public function cloneCreate(Request $request,$id)
{
    // DBから該当するレコードを取得
    $sale = Sale::find($id);

    //バリデーションチェック
    $validate = [  
        'sale_price' => 'required|numeric',
        'sale_date' => 'required',
        'sale_quantity' => 'required|numeric',
        'customer' => 'nullable',
        'staff' => 'nullable|max:20',
        'comment' => 'nullable|max:500',
    ];
    // バリデーションエラーメッセージ
    $errors = [
        'sale_price.required' => '必須項目です。',
        'sale_price.numeric' => '数字をご入力ください。',
        'sale_date.required' => '必須項目です。',
        'sale_quantity.required' => '必須項目です。',
        'sale_quantity.numeric' => '数字をご入力ください。',
        'customer.max' => '20文字以内です。',
        'staff.max' => '20文字以内です。',
        'comment.max' => '500文字以内です。',
    ];
    
    // 定義に沿ってバリデーションを実行
    $request->validate($validate , $errors);

    // バリエーションエラーがなければDBに保存
    $sale = new Sale([
        'user_id' => Auth::id(),
        'item_id' => $sale->item_id,
        'sale_price' => $request->input('sale_price'),
        'sale_date' => $request->input('sale_date'),
        'sale_quantity' => $request->input('sale_quantity'),
        'customer'=> $request->input('customer'),
        'staff'=> '未設定',
        'comment'=> $request->input('comment'),
    ]);

    $sale->save();

    // 在庫数を更新
    $sale->item->decrement('stock', $request->input('sale_quantity'));

    return redirect()->route('sales.index')->with('flash_message', '複製から商品が登録されました。');
}




/**
* ランキング画面表示
*
*/
public function rank(Request $request)
{
    // アイテムテーブルからすべての品番を取得
    $itemCount = Item::count();

    // ランキング作成
    $totalSales = Sale::with('item')->select('item_id', DB::raw('SUM(sale_quantity) as total_sales'))
    ->groupBy('item_id')
    ->orderBy('total_sales', 'desc');


    // 検索フォームからキーワードを取得
    $search = $request->input('search');

    if (!empty($search)) {
        $totalSales->where(function($query) use ($search) {
            $query->whereHas('item', function ($query) use ($search) {
                $query->where('item_code', 'like', "%{$search}%")
                    ->orWhere('item_name', 'like', "%{$search}%");
            });
        });
    }

    // ページネーションを適用
    //$totalSales = $totalSales->paginate(10)->withQueryString();
    $totalSales = $totalSales->get();

    return view('sale.salesRank',compact('totalSales','itemCount'));

}



/**
 * 削除処理実行
 * 
 */
public function destroy($id){

    // DBから該当するレコードを取得
    $sale = Sale::with('item')->find($id);

    if($sale->item->id)
    {
        // 在庫数を更新（削除の前に行う)
        $sale->item ->increment('stock', $sale->sale_quantity);

        // レコードを削除
        $sale->delete();

        return redirect('/sales')->with('flash_messae', '販売情報を削除しました。');
            }else{

        return redirect('/sales')->with('flash_messae', '商品が存在しません。削除できません。');
 
    }
}


}