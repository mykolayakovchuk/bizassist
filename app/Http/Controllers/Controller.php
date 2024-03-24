<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**Функция передачи ответа от БД при внесении методом Eloquent->save() OR update()
     * 
     * @input boolean
     * @return json (status)
     */
    public function dbAnswer($eloquentReturn){
        if($eloquentReturn === true){
            return json_encode(["status"=>"success"]);
        } elseif ($eloquentReturn === false){
            return json_encode(["status"=>"failed to add data to database"]);
        } else {
            return json_encode($eloquentReturn);
        }
    }

        /**Функция передачи ответа от БД при внесении транзакции
     * 
     * @input boolean
     * @return json (status)
     */
    public function dbTransactionAnswer($transactionReturn){
        return json_encode($transactionReturn);
    }

}
