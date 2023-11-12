<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cost;
use App\Models\Item;
use App\Models\User;
use App\Models\Supplier;


class CostController extends Controller
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
    public function costIndex(Request $request)
    {
        //リレーションを事前に取得
        $costs = Cost::with('item','supplier'); 

        //検索フォームからキーワードを取得
        $search = $request->input('search');

        //検索条件を追加
        if (!empty($search)) {
            $costs->where(function($query) use ($search)
            {
                $query->whereHas('item', function ($query) use ($search) {
                    $query->where('item_code', 'like', "%{$search}%")
                        ->orWhere('item_name', 'like', "%{$search}%");
                });
            });
        }
        //商品コード順に表示(古い品番順)
        $costs = $costs
            ->select('costs.*') //コストテーブルのすべてのカラムを選択
            ->join('items', 'costs.item_id', '=', 'items.id')
            ->orderBy('items.item_code', 'asc') //アイテムテーブルのカラムで並び替え
            ->paginate(10)
            ->withQueryString();
    
        return view('cost.costIndex', compact('costs'));
    }

/**
 * 一覧画面表示(原価率が高い順)
 */
    public function costRateDesc(Request $request)
    {
        //リレーションを事前に取得
        $costs = Cost::with('item'); 

        //原価率が高い順に表示
        $costs = $costs->orderBy('cost_rate' ,'desc')->paginate(10)->withQueryString();
        
        return view('cost.costIndex', compact('costs'));
    }

/**
 * 詳細画面表示
 */
    public function showDtail($id)
    {
        //DBから該当するレコードを取得
        $cost = Cost::with('item','supplier','user')->findOrFail($id);        
        return view('cost.costDetail',compact('cost'));
    }

/**
 * 編集画面表示
 */
    public function costEdit($id)
    {
        //DBから該当するレコードを取得
        $cost = Cost::with('item','supplier')->findOrFail($id);
        return view('cost.costEdit',compact('cost'));
        }

/**
 * 編集後の更新処理実行
 */
    public function costUpdate(Request $request ,$id)
    {
        //DBから編集前のレコードを取得
        $cost = Cost::findOrFail($id);

        //バリデーションチェック
        $validate = [
            'metal_cost' => 'nullable|numeric',
            'chain_cost'=> 'nullable|numeric',
            'parts_cost' =>  'nullable|numeric',
            'stone_cost' => 'nullable|numeric',
            'rocessing_cost' => 'nullable|numeric',
            'other_cost' => 'nullable|numeric',
            'total_cost' => 'nullable|numeric',
            'cost_rate' => 'nullable|numeric',
            'comment' => 'max:500'
        ];
        //バリデーションエラーメッセージ
        $errors = [
            'metal_cost.numeric' => '数字をご入力ください。',
            'chain_cost.numeric'=>  '数字をご入力ください。',
            'parts_cost.numeric' =>   '数字をご入力ください。',
            'stone_cost.numeric' =>  '数字をご入力ください。',
            'rocessing_cost.numeric' =>  '数字をご入力ください。',
            'other_cost.numeric' => '数字をご入力ください。',
            'total_cost.numeric' => '数字をご入力ください。',
            'cost_rate.numeric' => '数字をご入力ください。',
            'comment.max' => '500文字以内です。' 
        ];

        //定義に沿ってバリデーションを実行
        $request->validate($validate , $errors);

        //編集内容を登録
        $cost->update([
            $cost->user_id = Auth::id(),
            $cost->metal_cost = $request->metal_cost,
            $cost->chain_cost = $request->chain_cost,
            $cost->parts_cost = $request->parts_cost,
            $cost->stone_cost = $request->stone_cost,
            $cost->processing_cost = $request->processing_cost,
            $cost->other_cost = $request->other_cost,
            $cost->total_cost = $request->total_cost,
            $cost->cost_rate = $request->cost_rate,
            $cost->comment = $request->comment,
        ]);
        return redirect()->route('costs.costIndex')->with('flash_message','仕入単価が更新されました。');
    }

/**
 * 削除処理を実行
 */
    public function costDestroy($id)
    {
        // DBから該当するレコードを取得
        $cost = Cost::find($id);
        $item = Item::where('item_code', $cost->item_code)->first();
        $sale = Sale::where('item_code', $cost->item_code)->first();
        $purchase = purchase::where('item_code', $cost->item_code)->first();
        
        if(!empty($sale) || !empty($purchase) )
        {
            return redirect('/costs')->with('flash_message', '他のデータで使用されています。削除出来ません。');
        }else{
            //レコードを削除
            $cost->delete();
            
            return redirect()->route('items.edit', ['id' => $item->id])->with('flash_message','コストが削除されました。商品も削除してください。');
        };
    }
}