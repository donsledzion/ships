<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Table;
use App\Models\User;
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
        return view('tables.index',[
            'boards' => $boards
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $users = User::where('id','<>',Auth::id())->get();

        return View('tables.create',[
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     */
    public function store(Request $request)
    {
        try {
            $fields = [
                'A' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'B' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'C' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'D' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'E' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'F' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'G' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'H' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'I' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'J' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],

            ];
            $table = Table::create();
            $table->boards()->create([
                'user_id' => Auth::id(),
                'fields' => json_encode($fields)
            ]);
            $table->boards()->create([
                'user_id' => $request->opponent,
                'fields' => json_encode($fields)
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
            return redirect('/error/'.__('statuses.create.table.fail'));
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
