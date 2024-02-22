<?php

namespace App\Http\Controllers;

use App\Models\CodeEditor;
use Illuminate\Http\Request;

class CEcontroller extends Controller
{
    //
    public function geteditor(){
        return view('ce.editor');
    }
    public function SaveContent(Request $req){
        $isError = true;
        if (empty(trim($req->code))) {
            return ['isError'=>$isError];
        }
        $code = CodeEditor::create([
            'code'=>$req->code
        ]);
        if($code->save()){
            return ['isError'=>false,'id'=>$code->id];
        }else{
            return    ['isError'=>$isError];
        }

       

        
    }
    public function ShowCode(int $id){
        $code = CodeEditor::where('id',$id)->first();

        if(!$code){
            return "no found";
        }

        return view('ce.show',['code'=>$code->code]);
    }
}
