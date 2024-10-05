<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class ManagementController extends Controller
{
    public function management(){
        $users = User::RoleSearch(2)->paginate(10);
        return view('management', compact('users'));
    }

    public function delete(Request $request){
        User::find($request['user_id'])->delete();
        return redirect('/management')->with('messages', 'ユーザを削除しました。');
    }

    public function send(Request $request){
         //メール送信に使うインスタンスを生成
        $request->validate([
            'subject' => ['required'],
            'message' => ['required'],
        ]);
        $data = $request->all();
        $send_email = new SendEmail($data);

		// メール送信
        Mail::send( $send_email );

	    // 送信成功か確認
		if (count(Mail::failures()) > 0) {
            $message = 'メール送信に失敗しました';

			// 元の画面に戻る
            return back()->withErrors($messages);
        }
        else{
            $messages = 'メールを送信しました';

            // 別のページに遷移する
            return redirect('/management')->with('messages', $messages);
        }
    }
}
