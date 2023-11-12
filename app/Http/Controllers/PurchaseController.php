<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Cost;
use App\Models\Purchase;
use App\Models\Type;


class PurchaseController extends Controller
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
 */
    public function index(Request $request)
    {
        //リレーションを事前に取得
        $purchases = Purchase::with('item'); 

        //検索フォームからキーワードを取得
        $search = $request->input('search');

        //検索条件を追加
        if (!empty($search)) {
            $purchases->where(function($query) use ($search) {
                $query->whereHas('item', function ($query) use ($search) {
                    $query->where('item_code', 'like', "%{$search}%")
                        ->orWhere('item_name', 'like', "%{$search}%");
                });
            })
                ->orWhere('purchase_date', 'like', "%{$search}%") ;
        }
    
        //最近の更新日から順に表示 
        $purchases = $purchases->orderBy('updated_at','desc')
        ->paginate(10)
        ->withQueryString();

        return view('purchase.purchaseIndex', compact('purchases'));
    }

/**
 * 検索画面表示
 * 
 */
    public function showSearch(Request $request)
    {
    return view('purchase.purchaseSearch');
    }

/**
 * 検索結果表示
 */
    public function searchResult(Request $request)
    {
        //検索フォームからキーワードを取得
        $search = $request->input('search');

        //検索条件を追加
        if (!empty($search))
        {
            //検索に該当するレコードを取得して商品コード順に表示する
            $items = Item::with('type')->where('item_code', 'like', "%{$search}%")
            ->orWhere('item_name', 'like', "%{$search}%")
            ->orderBy('item_code', 'asc') // 品番全体を昇順にソート
            ->paginate(10)->withQueryString();

                //キーワードは入力された。itemsDBにはtableが存在する。しかし該当する結果がなかった場合
                if ($items->isEmpty()) {
                    return view('purchase.purchaseSearchResult');
                }

            return view('purchase.purchaseSearchResult', compact('items'));

        }else{
            //キーワードが空の場合
            return redirect()->route('purchases.search');
        }
    }


/**
* 登録画面表示
*/
    public function create($id)
    {
        //DBからレコードを取得
        $item = Item::with('cost','supplier')->findOrFail($id);
        //プルダウンの表示用
        $suppliers = Supplier::All();

        return view('purchase.purchaseAdd',compact('item','suppliers'));
    }


/**
* 登録処理実行
*/
    public function store(Request $request,$id)
    {
        $item = Item::with('cost','supplier')->findOrFail($id);

        //バリデーションチェック
        $validate = [  
            'purchase_price' => 'required|numeric',
            'purchase_date' => 'required|max:20',
            'purchase_quantity' => 'required|numeric',
            'staff' => 'nullable|max:20',
            'comment' => 'nullable|max:500',
        ];
        //バリデーションエラーメッセージ
        $errors = [
            'purchase_price.required' => '必須項目です。',
            'purchase_price.numeric' => '数字を入力してください。',
            'purchase_date.required' => '必須項目です。',
            'purchase_date.max' => '20文字以内で入力してください。',
            'purchase_quantity.required' => '必須項目です。',
            'purchase_quantity.numeric' => '数字を入力してください。',
            'staff.max' => '20文字以内で入力してください。',
            'comment.max' => '500文字以内で入力してください。',
        ];
        //定義に沿ってバリデーションを実行
        $request->validate($validate , $errors);
    
        //バリエーションエラーがなければDBに保存
        $purchase = new Purchase([
            'user_id' => Auth::id(),
            'item_id' => $id,
            'purchase_price' => $request->input('purchase_price'),
            'purchase_date' => $request->input('purchase_date'),
            'purchase_quantity' => $request->input('purchase_quantity'),
            'staff'=> '未設定',
            'comment'=> $request->input('comment'),
        ]);
        $purchase->save();

        //在庫数を更新
        $item = Item::find($id)->increment('stock', $request->input('purchase_quantity'));

        return redirect()->route('purchases.index')->with('flash_message', '仕入実績が登録されました。');
    }

/**
* 詳細画面表示
*/
    public function detail($id)
    {
        $purchase = purchase::with('item')->find($id);

        return view('purchase.purchaseDetail',compact('purchase'));
    }

/**
* 編集画面表示
*/
    public function edit($id)
    {
        $purchase = purchase::with('item')->find($id);

        // プルダウンの表示用
        $suppliers = Supplier::All();

        return view('purchase.purchaseEdit',compact('purchase','suppliers'));
    }

/**
* 編集後の更新処理実行
*/
    public function update(Request $request,$id)
    {  
        //DBから編集前のレコードを取得
        $purchase = Purchase::with('item')->find($id);
        //プルダウンの表示用
        $suppliers = Supplier::All();       

        if($purchase->item->id)
        {
        //在庫数を更新（編集で発生した差のみ) 
        $purchase-> item -> increment('stock', $request->purchase_quantity-$purchase->purchase_quantity);

        //バリデーションチェック
        $validate = [  
            'purchase_price' => 'required|numeric',
            'purchase_date' => 'required|max:20',
            'purchase_quantity' => 'required|numeric',
            'staff' => 'nullable|max:50',
            'comment' => 'nullable|max:500',
        ];
         //バリデーションエラーメッセージ
         $errors = [
            'purchase_price.required' => '必須項目です。',
            'purchase_price.numeric' => '数字を入力してください。',
            'purchase_date.required' => '必須項目です。',
            'purchase_date.max' => '20文字以内で入力してください。',
            'purchase_quantity.required' => '必須項目です。',
            'purchase_quantity.numeric' => '数字を入力してください。',
            'staff.max' => '50文字以内で入力してください。',
            'comment.max' => '500文字以内で入力してください。',
            ];
    
        //定義に沿ってバリデーションを実行
         $request->validate($validate , $errors);

        //編集内容を登録
        $purchase->update([
            'user_id' => Auth::id(),
            'purchase_price' => $request->purchase_price,
            'purchase_date' => $request->purchase_date,
            'purchase_quantity' => $request->purchase_quantity,
            'staff' => '未設定',
            'comment' => $request->comment,
        ]);
  
        return redirect('/purchases')->with('flash_message', '仕入情報が更新されました。');
        }
        else{
            return redirect('/purchases')->with('flash_message','商品が存在しません。更新できません。');
        }
    }  

/**
 * 複製画面表示
 */
    public function clone($id)
    {
        // DBから該当するレコードを取得
        $purchase = Purchase::findOrFail($id);
    
        return view('purchase.purchaseCopy', compact('purchase'));
    }

/**
 * 複製登録処理を実行
 */
    public function cloneCreate(Request $request,$id)
    {
        // DBから該当するレコードを取得
        $purchase = Purchase::with('item')->find($id);

        // プルダウンの表示用
        $suppliers = Supplier::get();    

        //バリデーションチェック
        $validate = [  
            'purchase_price' => 'required|numeric',
            'purchase_date' => 'required|max:20',
            'purchase_quantity' => 'required|numeric',
            'staff' => 'nullable|max:20',
            'comment' => 'nullable|max:500',
            
        ];
        // バリデーションエラーメッセージ
        $errors = [
            'purchase_price.required' => '必須項目です。',
            'purchase_price.numeric' => '数字を入力してください。',
            'purchase_date.required' => '必須項目です。',
            'purchase_date.max' => '20文字以内で入力してください。',
            'purchase_quantity.required' => '必須項目です。',
            'purchase_quantity.numeric' => '数字を入力してください。',
            'staff.max' => '20文字以内で入力してください。',
            'comment.max' => '500文字以内で入力してください。',
        ];

        //定義に沿ってバリデーションを実行
        $request->validate($validate , $errors);
    
        //バリエーションエラーがなければDBに保存
        $purchase = new Purchase([
            'user_id' => Auth::id(),
            'item_id' => $purchase->item_id,
            'purchase_price' => $request->input('purchase_price'),
            'purchase_date' => $request->input('purchase_date'),
            'purchase_quantity' => $request->input('purchase_quantity'),
            'staff'=> '未設定',
            'comment'=> $request->input('comment'),
        ]);
        $purchase->save();

        //在庫数を更新
        $purchase->item->increment('stock', $request->input('purchase_quantity'));

        return redirect()->route('purchases.index')->with('flash_message', '複製から商品が登録されました。');
    }




/**
 * 削除処理を実行
 */
    public function destroy($id)
    {
        // DBから該当するレコードを取得
        $purchase = Purchase::with('item')->find($id);

        if($purchase->item->id)
        {
            // 在庫数を更新（削除の前に行う)
            $purchase->item ->decrement('stock', $purchase->purchase_quantity);
            // レコードを削除
            $purchase->delete();

            return redirect('/purchases')->with('flash_message', '仕入情報が削除されました。');
        }else{
            return redirect('/purchases')->with('flash_message','商品が存在しません。削除できません。');
        }
    }
}



