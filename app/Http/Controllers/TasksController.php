<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加（モデルTaskを使う）

class TasksController extends Controller
{
    // getでmessages/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $tasks = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks; // ログイン中Userの投稿を取得
        }
        
        return view('tasks.index',[
            'tasks' =>$tasks,
            ]);
    }

    // getでmessages/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;   //新しいインスタンス作成
        
        return view('tasks.create',[
            'task' => $task,
            ]);
    }

    // postでmessages/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        //バリデーション
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);
        
        return redirect('/');   //indexへリダイレクト
    }

    // getでmessages/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $task = Task::find($id);  //そのidのタスクを検索
        
        // ユーザーの投稿であればshow画面表示
        if (\Auth::id() === $task->user_id) {
                return view('tasks.show',[
                    'task' => $task,
                ]);
            }
        else {
            return redirect('/');
        }
    }

    // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $task = Task::find($id);
        
        // ユーザーの投稿であればedit画面表示
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit',[
                'task' => $task,
                ]);
        }
        else {
            return redirect('/');
        }
    }

   // putまたはpatchでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        
        // UserID一致の場合に更新
        if (\Auth::id() === $task->user_id) {
            //バリデーション
            $this->validate($request, [
                'content' => 'required|max:191',
                'status' => 'required|max:10',
            ]);
            
            $task =Task::find($id);
            $task->content = $request->content;
            $task->status = $request->status;
            $task->save();
            
            return redirect('/');
        }
    }

    // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');
    }
}
