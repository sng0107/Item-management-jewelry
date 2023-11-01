<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserController extends Controller
{

/**
 * 一覧表示
 * 
 */
    public function userIndex(Request $request)
    {
        //権限を配列にする
        $roles = [
            0 => '利用者',
            1 => '管理者',
        ];

        // DBからレコードを取得
        $users = User::query(); 

        // 検索フォームからキーワードを取得
        $search = $request->input('search');

        // 検索条件を追加
        if (!empty($search))
        {
            $users->where('staff_number', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%");
        }

        //$users = $users->paginate(10);
        //社員番号順に表示
        $users = $users->orderBy('staff_number', 'asc')->paginate(10)->withQueryString();
        
        return view('user.userIndex',compact('users','roles'));
    }

/**
 * 編集画面表示
 * 
 */
    public function userShowEdit($id)
    {
        $roles = [
            0 => '利用者',
            1 => '管理者',
        ];

        $user = User::findOrFail($id);

        return view('user.userEdit', compact('user','roles'));
    }

/**
 * 編集後の更新処理実行
 * 
 */
    public function userUpdate(Request $request,$id)
    {
        // DBから編集前のレコードを取得
        $user = User::findOrFail($id);

        //dd($request->all());

        //バリデーションチェック
        $validate = [  
            'staff_number'=> 'required|size:5', //必ず5文字
            'name' => 'required|max:100',
            'email'=> 'required|max:255|unique:users,email,'. $id, // 自身のメールアドレスを除外
            'role' => 'required',
        ];
        // バリデーションエラーメッセージ
        $errors = [
            'staff_number.required' => 'この社員番号は既に登録されています。',
            'staff_number.size' => '5桁で入力してください。',
            'staff_number.required' => '必須項目です。',
            'name.required' => '必須項目です。',
            'name.max' => '100文字以内で入力してください。',
            'email.required' => '必須項目です。',
            'email.max' => '255文字以内で入力してください。',
            'role.required' => '必須項目です。',
        ];

        // 定義に沿ってバリデーションを実行
        $request->validate($validate , $errors);
        
        // dd($request->all());

        // バリエーションエラーがなければDBに保存
        $user->update([
        'staff_number' => $request->staff_number,
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        ]);
        

        return redirect('/users')->with('flash_message','アカウント情報が更新されました。');

    }

/**
 * 削除処理を実行
 * 
 */
    public function userDestroy($id)
    {
        // DBから該当するレコードを取得
        $user = USer::find($id);
        // レコードを削除
        $user->delete();
        // 削除したら一覧画面にリダイレクト
        return redirect('/users')->with('flash_message','アカウント情報が削除されました。');
    }

}
