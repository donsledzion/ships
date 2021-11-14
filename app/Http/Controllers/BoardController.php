<?php

namespace App\Http\Controllers;

use App\Models\board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('boards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\board  $board
     * @return JsonResponse
     */
    public function show(board $board):JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'fields' => json_decode($board->fields)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\board  $board
     * @return View
     */
    public function edit(board $board)
    {
        $user_id = Auth::id();
        $board_owner = $board->user;
        if($user_id == $board_owner->id) {
            return view('boards.edit', [
                'board' => $board
            ]);
        } else {
            return view('error',[
                'message' => __('errors.not_allowed')
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\board  $board
     * @return JsonResponse
     */
    public function update(Request $request, board $board)
    {
        try {
            $boardToUpdate = Board::find($board->id);
            $boardToUpdate->fields = $request->fields;

            error_log("====================================================");
            error_log("SHIPS");
            error_log("Four master:");
            $four_master = json_decode($request->four_master,TRUE);
            $three_masters = json_decode($request->three_master,TRUE);
            $two_masters = json_decode($request->two_master,TRUE);
            $one_masters = json_decode($request->one_master,TRUE);
            error_log("ping -1 ");
            foreach($four_master["fields"] as $field) {
                error_log($field["x"]."".$field["y"]);
                $boardToUpdate->setCell($field["x"],$field["y"],"@");
                }
            error_log("ping -2 ");
            foreach ($three_masters as $three_master) {
                foreach ($three_master["fields"] as $field) {
                    error_log($field["x"]. "" . $field["y"]);
                    $boardToUpdate->setCell($field["x"], $field["y"], "@");
                }
            }
            foreach ($two_masters as $two_master) {
                foreach ($two_master["fields"] as $field) {
                    error_log($field["x"]. "" . $field["y"]);
                    $boardToUpdate->setCell($field["x"] , $field["y"], "@");
                }
            }
            foreach ($one_masters as $one_master) {
                foreach ($one_master["fields"] as $field) {
                    error_log($field["x"]. "" . $field["y"]);
                    $boardToUpdate->setCell($field["x"] , $field["y"], "@");
                }
            }

            error_log("====================================================");
            $boardToUpdate->initialized = true;
            $boardToUpdate->save();
            return response()->json([
                'status' => 'success',
                'message' => 'pomyślnie zaktualizowano planszę',
                'board' => $boardToUpdate
            ]);
        } catch(\Exception $e){
            error_log("============================================================");
            error_log("============================= E R R O R ====================");
            error_log("============================================================");
            error_log($e->getMessage());
            error_log("============================================================");
            return response()->json([
                'status' => 'fail',
                'message' => 'wystąpił błąd! '.$e->getMessage()
            ]);
        }
    }


    public function shot(Board $board, string $column, int $row){
        try{
            $status = 'fail';
            $message = '';

            $cell = $board->getCell($column,$row);
            if($cell=="#" || $cell=="*"){
                $message = "To pole już było obstrzelane!";
            } else if($cell=="@"){
                $board->setCell($column,$row,"#");
                $status = 'success';
                $message = "Trafiony!";
            } else {
                $board->setCell($column,$row,"*");
                $status = 'success';
                $message = "Pudło!";
            }


            return response()->json([
                'status' => $status,
                'message' => $message
            ]);

        } catch(\Exception $e){
            return response()->json([
               'status' => 'error',
               'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(board $board)
    {
        //
    }
}
