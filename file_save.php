
<?php
return view("themes.robust.test",["model"=>\App\Helpers\FileHelper\PrivateFileHelper::makeUrl(\App\Models\Expense::latest()->first()->expense_document)]);
namespace App\Http\Controllers\Api\Driver\Expense;


use App\Models\Driver;
use App\Models\Expense;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    public function getexpenses(Request $request)
    {
        $Driver = Driver::whereUserId(\Auth::id())->first();
        return $Driver->expenses()->with(["type", "tankcard"])->paginate(10);
    }

    public function getexpenseparameters(Request $request)
    {
        $Driver = Driver::whereUserId(\Auth::id())->first();

        return response()->json([
            "expense_types" => ExpenseType::all(),
            "tank_cards" => $Driver->tankcards()->with(["company"])->get()
        ]);
    }

    public function addexpense(Request $request)
    {

        $Driver = Driver::whereUserId(\Auth::id())->first();

        $Expense = new Expense();
        $Expense->driver_id = $Driver->id;
        $Expense->amount = $request->input("amount");
        $Expense->vehicle_id = $Driver->vehicle_id;
        $Expense->creator_id = $Driver->id;
        $Expense->driver_company_id = $Driver->driver_company_id;
        $Expense->tank_card_id = $request->input("tank_card_id") ? $request->input("tank_card_id") : 0;
//        $Expense->expense_title = $request->input("expense_title");
        $Expense->expense_description = $request->input("expense_description");
        $Expense->expense_type_id = $request->input("expense_type_id");
        $Expense->date = $request->input("date");
        if (isset($request["my_files"]) && is_array($request["my_files"]))
            foreach ($request["my_files"] as $file) {

                $path = storage_path("user-files/driver/" . $Driver->id . "/");
                $filename = "EXPENSE_" . $file->getClientOriginalName();
                $file->move($path, $filename);
                $Expense->expense_document = $path . $filename;
            }

        $Expense->save();
        return response("", 200);
    }
}