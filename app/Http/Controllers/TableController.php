<?php

namespace App\Http\Controllers;

use App\Events\ChatMessage;
use App\Models\Board;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $user = User::find(Auth::id());
        $boards = $user->boards;
        $tables = collect();
        foreach($boards as $board){
            $tables->push($board->table);
        }
        return view('tables.index',[
            'tables' => $tables
        ]);
    }


    public function current(){
        $iddle_max = Carbon::now()->subMinutes(10)->format('Y-m-d H:i:s');
        $tables = Table::where('updated_at','>=',$iddle_max)->where('winner',null)->orWhere('current_player',null)->get();
        return view('tables.index',[
            'tables' => $tables,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Redirector
     */
    public function create()
    {
        $table = Table::create();

        $table->boards()->create([
            'user_id' => Auth::id(),
            'fields' => Board::freshField(),
        ]);
        return redirect(route('table.show',[$table->id]));
        /*$users = User::where('id','<>',Auth::id())->orderBy('last_activity','desc')->get();

        return View('tables.create',[
            'users' => $users
        ]);*/
    }

    public function join(Table $table){
        if(($table->board1())&&($table->board2())){
            return redirect(route('error','chyba ci się coś pojebało'));
        }
        $table->boards()->create([
            'user_id' => Auth::id(),
            'fields' => Board::freshField(),
        ]);
        $board = Board::where('user_id',Auth::id())->where('table_id',$table->id)->first();
        return redirect(route('board.edit',$board->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     */
    public function store(Request $request)
    {
        try {
            $table = Table::create();
            $table->boards()->create([
                'user_id' => Auth::id(),
                'fields' => Board::freshField(),
            ]);
            $table->boards()->create([
                'user_id' => $request->opponent,
                'fields' => Board::freshField(),
            ]);
            /*return response()->json([
                'status' => 'success',
                'message' => __('statuses.create.table.success'),
            ]);*/
            $myBoard = $table->boards()->where('user_id',Auth::id())->first();
            return redirect()->route('board.edit',$myBoard->id);
        } catch(\Exception $e){
            error_log("Error! ".$e->getMessage() );
            /*return response()->json([
                'status' => 'fail',
                'message' => __('statuses.create.table.fail'),
                'error' => $e->getMessage()
            ]);*/
            return redirect('/error/'.__('statuses.create.table.fail').$e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return View
     */
    public function show(Table $table)
    {
        return view('tables.show',[
            'table' => $table,
        ]);
    }

    public function lobby(Table $table)
    {
        return view('tables.lobby',[
            'table' => $table,
        ]);
    }

    public function chat(Request $request, Table $table){
        try {
            $author = Auth::user()->name;
            $message = $request->message;
            event(new ChatMessage($author, $message, $table));
            return response()->json([
                'status' => 'success',
                'message' => __('message.chat_message_sent')
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => __('message.chat_message_error').", ".$e->getMessage()
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        //
    }
}
