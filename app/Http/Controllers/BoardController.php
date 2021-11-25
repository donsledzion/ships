<?php

namespace App\Http\Controllers;

use App\Dtos\Battlefield\ShipDto;
use App\Events\PlayerMoved;
use App\Exceptions\InvalidShipException;
use App\Models\board;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use function PHPUnit\Framework\throwException;

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
     * @param  \App\Models\Board  $board
     * @return JsonResponse
     */
    public function show(Board $board):JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'fields' => json_decode($board->fields)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board  $board
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
     * @param  \App\Models\Board  $board
     *
     */
    public function update(Request $request, board $board)
    {
        try {
            DB::beginTransaction();
            $boardToUpdate = Board::find($board->id);
            $boardToUpdate->fields = $request->fields;
            $shipsIntegrityCheck = true;

            error_log("====================================================");
            error_log("CREATING AND VALIDATING SHIPS");
            $four_master = json_decode($request->four_master,TRUE);
            $four_masterDto = new ShipDto($four_master['fields']);
            if(!$four_masterDto->validateIntegrity()){
                $shipsIntegrityCheck = false;
                error_log("FOUR-MASTER - BŁĄD WALIDACJI");
            }
            $three_masters = json_decode($request->three_master,TRUE);
            $two_masters = json_decode($request->two_master,TRUE);
            $one_masters = json_decode($request->one_master,TRUE);

            foreach($four_master["fields"] as $field) {
                /*error_log($field["x"]."".$field["y"]);
                error_log((ord($field["x"])-64)."".$field["y"]);*/
                $boardToUpdate->setCell($field["x"],$field["y"],"@");
                }

            foreach ($three_masters as $three_master) {
                $three_masterDto = new ShipDto($three_master['fields']);
                if(!$three_masterDto->validateIntegrity()){
                    $shipsIntegrityCheck = false;
                    error_log("THREE-MASTER - BŁĄD WALIDACJI");
                }
                foreach ($three_master["fields"] as $field) {
                    /*error_log($field["x"]. "" . $field["y"]);*/
                    $boardToUpdate->setCell($field["x"], $field["y"], "@");
                }
            }
            foreach ($two_masters as $two_master) {
                $two_masterDto = new ShipDto($two_master['fields']);
                if(!$two_masterDto->validateIntegrity()){
                    $shipsIntegrityCheck = false;
                    error_log("TWO-MASTER - BŁĄD WALIDACJI");
                }
                foreach ($two_master["fields"] as $field) {
                    /*error_log($field["x"]. "" . $field["y"]);*/
                    $boardToUpdate->setCell($field["x"] , $field["y"], "@");
                }
            }
            foreach ($one_masters as $one_master) {
                $one_masterDto = new ShipDto($one_master['fields']);
                if(!$one_masterDto->validateIntegrity()){$shipsIntegrityCheck = false;

                    $shipsIntegrityCheck = false;
                    error_log("ONE-MASTER - BŁĄD WALIDACJI");
                }
                foreach ($one_master["fields"] as $field) {
                    /*error_log($field["x"]. "" . $field["y"]);*/
                    $boardToUpdate->setCell($field["x"] , $field["y"], "@");
                }
            }

            if(!$shipsIntegrityCheck){
                DB::rollBack();
                $message = __('exceptions.invalid_ship');
                throw new InvalidShipException($message);
            }

            error_log("====================================================");
            $boardToUpdate->initialized = true;
            $boardToUpdate->save();
            $boardToUpdate->table->reportReady();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'pomyślnie utworzono planszę',
                'board' => $boardToUpdate
            ]);
        } catch(\Exception $e){
            DB::rollBack();
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
            if($board['table']->isCompleted()){
                return response()->json([
                    'status' => 'fail',
                    'message' => __('errors.board_completed')
                ]);
            }
            if(Auth::id()!==$board->table->current_player){
                return response()->json([
                    'status' => 'fail',
                    'message' => __('errors.not_your_turn')
                ]);
            }
            if(Auth::id()==$board->user->id){
                return response()->json([
                    'status' => 'fail',
                    'message' => __('errors.your_board')
                ]);
            }


            $status = 'fail';
            $result = 'none';
            $message = '';

            $cell = $board->getCell($column,$row);
            if($cell=="#" || $cell=="*"){
                $message = "To pole już było obstrzelane!";
            } else if($cell=="@"){
                $board->setCell($column,$row,"#");
                $message = "Trafiony!";
                $result = 'hit';
                if($board->checkIfSunk($column,$row)){
                    $message.= " ZATOPIONY";
                    $result = 'sunk';
                    if($board->checkIfCompleted()){
                        $message.= " ZWYCIĘŹA ".User::find(Auth::id())->name;
                    }
                }
                $status = 'success';
            } else {
                $board->setCell($column,$row,"*");
                $status = 'success';
                $result = 'missed';
                $message = "Pudło!";
                $board->table->switchPlayers();
            }


            event(new PlayerMoved($message,$board,$column, $row, $result));

            return response()->json([
                'status' => $status,
                'result' => $result,
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
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(board $board)
    {
        //
    }
}
