<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ReportController extends Controller
{
    //тестовый метод
    public function test (Request $request){
        //return $request->firstName;
        return json_encode(["id_user"=>Auth::id()]);
    }

    /**
     * Внесение отчета от пользователя
     * @param  \Illuminate\Http\Request  $request
     * @return json (status)
     */
    public function store(Request $request){
        // Валидация запроса ...
        $request->validate([
            'description' => 'required|string|max:255',
            'body' => 'nullable|string'
        ]);
        // запись в БД ...
        $report = new Report;
        $report->user_id = Auth::id();
        $report->description = $request->description;
        $report->body = $request->body;
        $result = $report->save();
        return $this->dbAnswer($result);
    }

    /**
     * Редактирование отчета от пользователя
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return json (status)
     */
    public function edit(Request $request){
        // Валидация запроса ...
        $request->validate([
            'description' => 'required|string|max:255',
            'body' => 'nullable|string',
            'idReport' => 'exists:App\Models\Report,id',
        
        ]);

        // запись в БД ...
        $report = Report::find($request->idReport);
        if ($report->user_id != Auth::id()){
            return json_encode(["message"=>"this is not your report. editing prohibited"]);
        }
        //!eof
        $report->description = $request->description;
        $report->body = $request->body;
        $result = $report->save();
        return $this->dbAnswer($result);
    }
}
