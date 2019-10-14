<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加（モデルTaskを使う）

class TasksController extends Controller
{
    // getでmessages/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $tasks = Task::all(); // Modelの一覧取得
        
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
        
        $task = new Task;   //タスク作成
        $task ->content = $request->content;    //入力内容をcontentへ
        $task->status = $request->status;
        $task->save();  //タスク保存
        
        return redirect('/');   //indexへリダイレクト
    }

    // getでmessages/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $task = Task::find($id);  //そのidのタスクを検索
        
        return view('tasks.show',[
            'task' => $task,
            ]);
    }

    // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $task = Task::find($id);
        
        return view('tasks.edit',[
            'task' => $task,
            ]);
    }

   // putまたはpatchでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
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

    // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        
        return redirect('/');
    }
}
