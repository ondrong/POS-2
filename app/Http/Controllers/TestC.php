<?php
namespace App\Http\Controllers;
use App\Category;

use Illuminate\Http\Request;
use DB;
use Session;
use Excel;

// Temp Fucntion for testing Purose
function s($str){ echo '<pre>';  print_r($str);  echo '</pre>'; }

class TestC extends Controller
{
    public function test(){
        echo 'Test@test'.'<br>';

        $this->upload_seeder(); // $this->get_file_list_from_dir();
        // $this->tables();
        // $this->get_table_data($table="items");
        // $this->table_data();

    } ## test() 
    

    public function upload_seeder() {

        $seeder_files = glob(public_path("factories\*.csv"));

        foreach($seeder_files as $file) {
            Session::put('TEMP_T',pathinfo($file)['filename']);

            Excel::load( $file ,function($reader) {
                foreach ($reader->toArray() as $key => $row) {
                    if(!empty($row)) {
                        // s($row);
                        $temp_t = Session::get('TEMP_T');
                        DB::table($temp_t)->insert($row);
                    }
                }#foreach
            }); # excelMethod

        } #foreach

        Session::forget('TEMP_T');
    } ## upload_dump(Request $request)


    public function get_file_list_from_dir(){
        // get_file_list_from_dir
        // s(glob(public_path("factories\*.csv")));

    } ## get_file_list_from_dir()

    public function index(){
        echo "Test Controller";
    } ## index()

    public function tables(){
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table){
            echo $table->Tables_in_pos;
            echo '<br>';
        }
    } ## tables();

    public function get_table_data($table="items"){
        return DB::table($table)->get();
    } ## get_table_data($table_name)

    public function table_data(){
        $tables = DB::select('SHOW TABLES');

        foreach($tables as $table){
            echo $table->Tables_in_pos;
            echo '<br>';
            echo DB::table($table->Tables_in_pos)->get();
            echo '<hr>';
        }
    } ## table_data()

    

    // public function index(){}
    // public function create(){}
    // public function store(Request $request){}
    // public function show($id){}
    // public function edit($id){}
    // public function update(Request $request, $id){}
    // public function destroy($id){}

}