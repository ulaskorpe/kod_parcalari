<?php

/** * OrangeTech Soft Taxi & Mietwagen Verwaltungssystem
 *
 * @package   Premium
 * @author    OrangeTech Soft <support@orangetechsoft.at>
 * @link      http://www.orangetechsoft.at/
 * @copyright 2017 OrangeTech Soft
 */
namespace App\Http\Controllers\Common\Datatable;

use App\Helpers\PrivateFileHelper\PrivateFileHelper;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DriverCompany;
use App\Models\Expense;
use App\Models\Log\DriverStateChangeLog;
use App\Models\RoleUser;
use App\Models\UserWorkTemplate;
use Carbon\Carbon;
use Enum\OperatorLogTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DatatableController extends Controller
{
    //Datatable component general contoller
    public function main(Request $request)
    {
        $model = $request->modelname;
        $table = $request->tablename;
        $function = $request->functionname;
        $page_count = $request->pagecount;
        $order_by = $request->orderby;
        $asc_desc = $request->ascdesc;
        $keyword_query = $request->keyword_query;
        $params_json = $request->params_json;
        $model = new $model;
        $data = $this->$function($model, $table, $page_count, $order_by, $asc_desc, $keyword_query, $params_json);

        return \Response::json($data, 200);
    }

    private function Personal(Model $model, $table = null, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query = null, $params_json = null)
    {
        $params = json_decode($params_json);

        $userArray = RoleUser::where('role_id', '=', $params->role_id)->pluck('user_id')->toArray();


        if ($params->template_show == \Enum\ShowTemplates::PERSONAL_WITH_WORK_TEMPLATE) {
            $users_with_template = UserWorkTemplate::distinct()->pluck('user_id')->toArray();
            $userArray = array_intersect($users_with_template, $userArray);
        } elseif ($params->template_show == \Enum\ShowTemplates::PERSONAL_WITHOUT_WORK_TEMPLATE) {
            $users_with_template = UserWorkTemplate::distinct()->pluck('user_id')->toArray();
            $userArray = array_diff($userArray, $users_with_template);
        }


        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->whereIn('users.id', $userArray)
                ->select("users.id", "users.name", "users.last_name", "users.email", "users.gsm_phone")
                ->paginate($page_count);
        } else {
            if ($order_by != null)
                $data = $model::select("users.id", "users.name", "users.last_name", "users.email", "users.gsm_phone")
                    ->whereIn('users.id', $userArray)
                    ->orderBy($order_by, $asc_desc)->paginate($page_count);
            else
                $data = $model::select("users.id", "users.name", "users.last_name", "users.email", "users.gsm_phone")
                    ->whereIn('users.id', $userArray)
                    ->paginate($page_count);
        }

        return $data;
    }

    private function Persons(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query = null, $params_json = null)
    {
        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)->join('users', "users.id", "=", $table . ".user_id")
                ->select($table . ".id", "users.name", "users.last_name", "users.email", "users.gsm_phone")
                ->paginate($page_count);
        } else {
            if ($order_by != null)
                $data = $model::join('users', "users.id", "=", $table . ".user_id")
                    ->select($table . ".id", "users.name", "users.last_name", "users.email", "users.gsm_phone")
                    ->orderBy($order_by, $asc_desc)->paginate($page_count);
            else
                $data = $model::join('users', "users.id", "=", $table . ".user_id")
                    ->select($table . ".id", "users.name", "users.last_name", "users.email", "users.gsm_phone")
                    ->paginate($page_count);
        }

        return $data;
    }

    private function Clients(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query = null, $params_json = null)
    {

        $order_by = ($order_by != null) ? $order_by : "full_name";
        $asc_desc = ($asc_desc != null)?$asc_desc:"asc";
        $keyword_query =($keyword_query!=null)?$keyword_query:"";


        /*      $data = $model::search((string)$keyword_query)->join('users', "users.id", "=", $table . ".user_id")
                  ->select($table . ".id",
                      DB::raw("CONCAT(users.name,' ',users.last_name)  AS full_name"),
                      DB::raw("IF (clients.default_company_id>0,(SELECT company_name FROM client_companies WHERE client_companies.id=clients.default_company_id),'') as company_name")
                      , "users.email", "users.gsm_phone" ,"users.gender")
                  ->orderBy($order_by, $asc_desc)
                  ->paginate($page_count);*/

        $data = Client::search((string)$keyword_query)
            ->join('users', "users.id", "=", $table . ".user_id")
            ->join('clients_companies','clients_companies.client_id',"=",$table.".id")
            ->join('client_companies','clients_companies.client_company_id','=','client_companies.id')
            ->select($table . ".id",
                DB::raw("CONCAT(users.name,' ',users.last_name)  AS full_name"),
                DB::raw("GROUP_CONCAT(client_companies.company_name separator \" / \") as company_name")
                , "users.email", "users.gsm_phone" ,"users.gender")
            ->groupBy("clients_companies.client_id")
            ->orderBy($order_by, $asc_desc)
            ->paginate($page_count);


        return $data;
    }

    private function ClientsClients(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query = null, $params_json = null)
    {

        $client=Client::where('user_id','=',\Auth::id())->first();
        $order_by = ($order_by != null) ? $order_by : "full_name";
        $asc_desc = ($asc_desc != null)?$asc_desc:"asc";
        $keyword_query =($keyword_query!=null)?$keyword_query:"";

        $data = Client::search((string)$keyword_query)
            ->AssignedClients($client->id)->with('companies.clientCompany')
            ->join('users', "users.id", "=", $table . ".user_id")
            ->join('clients_companies','clients_companies.client_id',"=",$table.".id")
            ->join('client_companies','clients_companies.client_company_id','=','client_companies.id')
            ->select($table . ".id",
                DB::raw("CONCAT(users.name,' ',users.last_name)  AS full_name"),
                DB::raw("GROUP_CONCAT(client_companies.company_name separator \" / \") as company_name")
                , "users.email", "users.gsm_phone" ,"users.gender")
            ->groupBy("clients_companies.client_id")
            ->orderBy($order_by, $asc_desc)
            ->paginate($page_count);
        return $data;

    }

    private function UserFiles( Model $model, $table,$page_count = 10, $order_by = null, $asc_desc = null, $keyword_query = null, $params_json = null ){
        $privateFileHelper = new PrivateFileHelper();
        $link = '<a href="' . $privateFileHelper->makeUrl('#expensedocument#') . '" target="_blank"><i class="icon-outbox"></i><span></span></a>';
        $SQLreplace1 = "REPLACE('" . $link . "', '#expensedocument#',user_files.file)";

        $params=json_decode($params_json);
        $order_by = ($order_by != null) ? $order_by : "id";
        $asc_desc = ($asc_desc != null)?$asc_desc:"desc";
        $keyword_query =($keyword_query!=null)?$keyword_query:"";
        $data = $model::search((string)$keyword_query)

            ->select('user_files.description','user_files.date','user_files.id'
                , DB::raw($SQLreplace1 . " as document")

            )
            ->where('user_id','=',$params->user_id)
            ->orderBy($order_by, $asc_desc)
            ->paginate($page_count);
        return $data;
    }

    private function Drivers(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $keyword_query=(!empty($keyword_query) && $keyword_query != "")?$keyword_query:"";
        $order_by=($order_by != null)?$order_by:"users.name";
        $asc_desc=($asc_desc != null)?$asc_desc:"asc";
        $data = $model::search((string)$keyword_query)->join('users', "users.id", "=", $table . ".user_id")
            ->join('driver_companies', "driver_companies.id", "=", $table . ".driver_company_id")
            ->select('drivers.id', 'users.name', 'users.email', 'users.last_name', 'users.gsm_phone', 'driver_companies.name as companyname')
            ->orderBy($order_by, $asc_desc)
            ->paginate($page_count);
        return $data;
    }

    private function DriversForDriverCompany(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $driver_company= DriverCompany::where('user_id','=',Auth::user()->id)->first();
        $keyword_query=(!empty($keyword_query) && $keyword_query != "")?$keyword_query:"";
        $order_by=($order_by != null)?$order_by:"users.name";
        $asc_desc=($asc_desc != null)?$asc_desc:"asc";
            $data = $model::search((string)$keyword_query)->join('users', "users.id", "=", $table . ".user_id")
                ->where('drivers.driver_company_id','=',$driver_company->id)
                ->join('driver_companies', "driver_companies.id", "=", $table . ".driver_company_id")
                ->select('drivers.id', 'users.name', 'users.email', 'users.last_name', 'users.gsm_phone', 'driver_companies.name as companyname')
                ->orderBy($order_by, $asc_desc)
                ->paginate($page_count);

        return $data;
    }

    private function ClientCompanies(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {

        $keyword_query=(!empty($keyword_query) && $keyword_query != "")?$keyword_query:"";
        $order_by=($order_by != null)?$order_by:$table.".company_name";
        $asc_desc=($asc_desc != null)?$asc_desc:"asc";
       /// if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->select($table . '.id', 'client_companies.company_name', 'client_companies.company_email', 'client_companies.phone_number1')
                ->orderBy($order_by, $asc_desc)
                ->paginate($page_count);
  /*      } else {
            if ($order_by != null)
                $data = $model::select($table . '.id', 'client_companies.company_name', 'client_companies.company_email', 'client_companies.phone_number1')
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);
            else
                $data = $model::select($table . '.id', 'client_companies.company_name', 'client_companies.company_email', 'client_companies.phone_number1')
                    ->paginate($page_count);
        }*/
        return $data;
    }

    private function DriverCompanies(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {

        $keyword_query=(!empty($keyword_query) && $keyword_query != "")?$keyword_query:"";
        $order_by=($order_by != null)?$order_by:$table.".name";
        $asc_desc=($asc_desc != null)?$asc_desc:"asc";

      //  if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->join('users', "users.id", "=", $table . ".user_id")

                ->select($table . '.id', 'driver_companies.name as companyname', 'users.email', 'driver_companies.phone_number1 as phone'
                    //'users.gsm_phone as phone'
                   ///DB::raw('IF(driver_companies.phone_number1  ),driver_companies.phone_number1,users.gsm_phone) as phone')
                    , DB::raw("CONCAT(users.name,' ',users.last_name)  AS contact_name"
                    ,DB::raw("CONCAT(users.email,' ',driver_companies.email) as emaixl")
                    ))
                ->orderBy($order_by, $asc_desc)
                ->paginate($page_count);
      /*  } else {
            if ($order_by != null)
                $data = $model:: join('users', "users.id", "=", $table . ".user_id")
                    ->select($table . '.id', 'driver_companies.name as companyname', 'driver_companies.email', 'driver_companies.phone_number1', DB::raw("CONCAT(users.name,' ',users.last_name)  AS contact_name"))
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);
            else
                $data = $model::join('users', "users.id", "=", $table . ".user_id")
                    ->select($table . '.id', 'driver_companies.name as companyname', 'driver_companies.email', 'driver_companies.phone_number1', DB::raw("CONCAT(users.name,' ',users.last_name)  AS contact_name"))
                    ->paginate($page_count);
        }*/
        return $data;
    }

    private function Expenses(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {

        $privateFileHelper = new PrivateFileHelper();

        $_model = $model:: join('drivers', "drivers.id", "=", $table . ".driver_id")->with('user')
            ->leftJoin('driver_companies', "driver_companies.id", "=", $table . ".driver_company_id")
            ->leftJoin('vehicles', "vehicles.id", "=", $table . ".vehicle_id")
            ->leftJoin('tank_cards', "tank_cards.id", "=", $table . ".tank_card_id")
            ->leftJoin('expenses_types', "expenses_types.id", "=", $table . ".expense_type_id")
            ->leftJoin('users', "users.id", "=", $table . ".creator_id");

        $link = '<a href="' . $privateFileHelper->makeUrl('#expensedocument#') . '" target="_blank"><i class="icon-outbox"></i><span></span></a>';
        $SQLreplace1 = "REPLACE('" . $link . "', '#expensedocument#',expenses.expense_document)";

        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->join('drivers', "drivers.id", "=", $table . ".driver_id")->with('user')
                ->leftJoin('driver_companies', "driver_companies.id", "=", $table . ".driver_company_id")
                ->leftJoin('vehicles', "vehicles.id", "=", $table . ".vehicle_id")
                ->leftJoin('tank_cards', "tank_cards.id", "=", $table . ".tank_card_id")
                ->leftJoin('expenses_types', "tank_cards.id", "=", $table . ".expense_type_id")
                ->leftJoin('users', "users.id", "=", $table . ".creator_id")
                ->select($table . '.id'
                    , 'expenses.amount'
                    , 'expenses_types.type_name'
                    , "expenses.expense_title"
                    , 'driver_companies.name as companyname'
                    , 'vehicles.plate'
                    , DB::raw($SQLreplace1 . " as expense_document")
                    , DB::raw('DATE_FORMAT(expenses.date, "%d-%m-%Y") as date')
                    , DB::raw("CONCAT(users.name,' ',users.last_name)  AS last_updatedby"))
                ->paginate($page_count);
        } else {
            if ($order_by != null)
                $data = $_model->select($table . '.id'
                    , 'expenses.amount'
                    , "expenses.expense_title"
                    , 'expenses_types.type_name'
                    , 'driver_companies.name as companyname'
                    , 'vehicles.plate'
                    , DB::raw($SQLreplace1 . " as expense_document")
                    , DB::raw('DATE_FORMAT(expenses.date, "%d-%m-%Y") as date')
                    , DB::raw("CONCAT(users.name,' ',users.last_name)  AS last_updatedby"))
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);

            else
                $data = $_model->select($table . '.id'
                    , 'expenses.amount'
                    , "expenses.expense_title"
                    , 'expenses_types.type_name'
                    , 'driver_companies.name as companyname'
                    , 'vehicles.plate'
                    , DB::raw($SQLreplace1 . " as expense_document")
                    , DB::raw('DATE_FORMAT(expenses.date, "%d-%m-%Y") as date')
                    , DB::raw("CONCAT(users.name,' ',users.last_name)  AS last_updatedby"))
                    ->paginate($page_count);
        }
        return $data;

    }

    private function DriverCompanyExpenses(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {

        $privateFileHelper = new PrivateFileHelper();
        $driver_company=DriverCompany::where('user_id','=',Auth::id())->first();
        $keyword_query=(!empty($keyword_query) && $keyword_query != "")?$keyword_query:"";
        $link = '<a href="' . $privateFileHelper->makeUrl('#expensedocument#') . '" target="_blank"><i class="icon-outbox"></i><span></span></a>';
        $SQLreplace1 = "REPLACE('" . $link . "', '#expensedocument#',expenses.expense_document)";
        $order_by=($order_by != null)?$order_by:"expenses.date";
        $asc_desc=($asc_desc!=null)?$asc_desc:"desc";

        $data = $model::search((string)$keyword_query)

            ->where('expenses.driver_company_id','=',$driver_company->id)
            ->join('drivers', "drivers.id", "=", $table . ".driver_id")
            ->join('users', "users.id", "=", "drivers.user_id")
            ->leftJoin('driver_companies', "driver_companies.id", "=", $table . ".driver_company_id")
            ->leftJoin('vehicles', "vehicles.id", "=", $table . ".vehicle_id")
            ->leftJoin('tank_cards', "tank_cards.id", "=", $table . ".tank_card_id")
            ->leftJoin('expenses_types', "expenses_types.id", "=", $table . ".expense_type_id")


        ->select($table . '.id'
        , 'expenses.amount'
        , 'expenses_types.type_name'
        , "expenses.expense_title"
        , 'driver_companies.name as companyname'
        , 'vehicles.plate'
        , DB::raw($SQLreplace1 . " as expense_document")
        , DB::raw('DATE_FORMAT(expenses.date, "%d-%m-%Y") as date')
        , DB::raw("CONCAT(users.name,' ',users.last_name)  AS driver_name"))
            ->orderBy($order_by, $asc_desc)
            ->paginate($page_count);
        return $data;
       }

    private function DataTable(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->paginate($page_count);
        } else {
            if ($order_by != null)
                $data = $model:: orderBy($order_by, $asc_desc)
                    ->paginate($page_count);
            else
                $data = $model::paginate($page_count);
        }
        return $data;
    }

    private function ClientInvoices(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $params = json_decode($params_json);
        $paid_span = '<span class="tag tag-default tag-success tag-md">Paid</span>';
        $overdue_span = '<span class="tag tag-default tag-danger tag-sm">Overdue by #days# days </span>';

        $email_sent = '<span class="tag tag-default tag-success tag-sm">Sent at #sentat#</span>';
        $email_notsent = '<span class="tag tag-default tag-warning tag-md">Not Sent</span>';

        $email_replace = "REPLACE('" . $email_sent . "', '#sentat#',DATE_FORMAT(invoices.sent_at, '%d-%m-%Y'))";
        $overdue_replace = "REPLACE('" . $overdue_span . "', '#days#',DATEDIFF( NOW(),invoices.due_date))";

        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->join('invoice_items', 'invoice_items.invoice_id', 'invoices.id')
                ->leftJoin('clients', 'clients.id', 'invoice_items.client_id')
                ->join('users', 'users.id', 'clients.user_id')
                ->where('clients.id', '=', $params->client_id)
                ->select("invoices.id", "invoices.invoice_number"
                    , \DB::raw('DATE_FORMAT(invoices.invoice_date, "%d-%m-%Y") as invoice_date')
                    , \DB::raw('DATE_FORMAT(invoices.due_date, "%d-%m-%Y") as due_date')
                    , "invoices.invoice_amount"
                    , \DB::raw("IF(invoices.is_sent=0,$email_replace,'$email_notsent') as is_sent ")
                    , \DB::raw("IF(invoices.is_paid=0,$overdue_replace,'$paid_span') as is_paid "))
                ->paginate($page_count);
        } else {
            if ($order_by != null)
                $data = $model::join('invoice_items', 'invoice_items.invoice_id', 'invoices.id')
                    ->leftJoin('clients', 'clients.id', 'invoice_items.client_id')
                    ->join('users', 'users.id', 'clients.user_id')
                    ->where('clients.id', '=', $params->client_id)
                    ->select("invoices.id", "invoices.invoice_number"
                        , \DB::raw('DATE_FORMAT(invoices.invoice_date, "%d-%m-%Y") as invoice_date')
                        , \DB::raw('DATE_FORMAT(invoices.due_date, "%d-%m-%Y") as due_date')
                        , "invoices.invoice_amount"
                        , \DB::raw("IF(invoices.is_sent=0,$email_replace,'$email_notsent') as is_sent ")
                        , \DB::raw("IF(invoices.is_paid=0,$overdue_replace,'$paid_span') as is_paid "))
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);

            else
                $data = $model::join('invoice_items', 'invoice_items.invoice_id', 'invoices.id')
                    ->leftJoin('clients', 'clients.id', 'invoice_items.client_id')
                    ->join('users', 'users.id', 'clients.user_id')
                    ->where('clients.id', '=', $params->client_id)
                    ->select("invoices.id", "invoices.invoice_number"
                        , \DB::raw('DATE_FORMAT(invoices.invoice_date, "%d-%m-%Y") as invoice_date')
                        , \DB::raw('DATE_FORMAT(invoices.due_date, "%d-%m-%Y") as due_date')
                        , "invoices.invoice_amount"
                        , \DB::raw("IF(invoices.is_sent=0,$email_replace,'$email_notsent') as is_sent ")
                        , \DB::raw("IF(invoices.is_paid=0,$overdue_replace,'$paid_span') as is_paid "))
                    ->paginate($page_count);
        }
        return $data;
    }

    private function ClientOrders(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $params = json_decode($params_json);

        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->join("invoice_items", "invoice_items.order_id", $table . ".id")
                ->join("invoices", "invoices.id", "invoice_items.invoice_id")
                ->join("jobs", "jobs.order_id", $table . ".id")
                ->join("packages", "packages.id", $table . ".package_id")
                ->leftJoin("drivers", "drivers.id", "jobs.driver_id")
                ->leftJoin("users", "users.id", "drivers.user_id")
                ->where('orders.client_id', '=', $params->client_id)
                ->select(\DB::raw("CONCAT(users.name,' ',users.last_name) AS driver_name"), "packages.name", "invoices.invoice_amount",
                    DB::raw('DATE_FORMAT(orders.start_time, "%d-%m-%Y") as start_time'))
                ->paginate($page_count);
        } else {
            if ($order_by != null)
                $data = $model:: join("invoice_items", "invoice_items.order_id", $table . ".id")
                    ->join("invoices", "invoices.id", "invoice_items.invoice_id")
                    ->join("jobs", "jobs.order_id", $table . ".id")
                    ->join("packages", "packages.id", $table . ".package_id")
                    ->leftJoin("drivers", "drivers.id", "jobs.driver_id")
                    ->leftJoin("users", "users.id", "drivers.user_id")
                    ->where('orders.client_id', '=', $params->client_id)
                    ->select(\DB::raw("CONCAT(users.name,' ',users.last_name) AS driver_name"), "packages.name", "invoices.invoice_amount", DB::raw('DATE_FORMAT(orders.start_time, "%d-%m-%Y") as start_time'))
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);

            else
                $data = $model::join("invoice_items", "invoice_items.order_id", $table . ".id")
                    ->join("invoices", "invoices.id", "invoice_items.invoice_id")
                    ->join("jobs", "jobs.order_id", $table . ".id")
                    ->join("packages", "packages.id", $table . ".package_id")
                    ->leftJoin("drivers", "drivers.id", "jobs.driver_id")
                    ->leftJoin("users", "users.id", "drivers.user_id")
                    ->where('orders.client_id', '=', $params->client_id)
                    ->select(\DB::raw("CONCAT(users.name,' ',users.last_name) AS driver_name"), "packages.name", "invoices.invoice_amount", DB::raw('DATE_FORMAT(orders.start_time, "%d-%m-%Y") as start_time'))
                    ->paginate($page_count);

        }
        return $data;

    }

    private function DriverOrders(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $params = json_decode($params_json);

        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->join("invoice_items", "invoice_items.order_id", $table . ".id")
                ->join("invoices", "invoices.id", "invoice_items.invoice_id")
                ->join("jobs", "jobs.order_id", $table . ".id")
                ->join("packages", "packages.id", $table . ".package_id")
                ->join("clients", "clients.id", "orders.client_id")
                ->join("users", "users.id", "clients.user_id")
                ->where('jobs.driver_id', '=', $params->driver_id)
                ->select(\DB::raw("CONCAT(users.name,' ',users.last_name) AS client_name")
                    , "packages.name", "invoices.invoice_amount"
                    , DB::raw('DATE_FORMAT(orders.start_time, "%d-%m-%Y %H:%i:%s") as start_time')
                    , DB::raw('DATE_FORMAT(orders.complated_at, "%d-%m-%Y %H:%i:%s") as complated_at'))
                ->paginate($page_count);
        } else {
            if ($order_by != null)
                $data = $model:: join("invoice_items", "invoice_items.order_id", $table . ".id")
                    ->join("invoices", "invoices.id", "invoice_items.invoice_id")
                    ->join("jobs", "jobs.order_id", $table . ".id")
                    ->join("packages", "packages.id", $table . ".package_id")
                    ->join("clients", "clients.id", "orders.client_id")
                    ->join("users", "users.id", "clients.user_id")
                    ->where('jobs.driver_id', '=', $params->driver_id)
                    ->select(\DB::raw("CONCAT(users.name,' ',users.last_name) AS client_name")
                        , "packages.name", "invoices.invoice_amount"
                        , DB::raw('DATE_FORMAT(orders.start_time, "%d-%m-%Y %H:%i:%s") as start_time')
                        , DB::raw('DATE_FORMAT(orders.complated_at, "%d-%m-%Y %H:%i:%s") as complated_at'))
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);

            else
                $data = $model::join("invoice_items", "invoice_items.order_id", $table . ".id")
                    ->join("invoices", "invoices.id", "invoice_items.invoice_id")
                    ->join("jobs", "jobs.order_id", $table . ".id")
                    ->join("packages", "packages.id", $table . ".package_id")
                    ->join("clients", "clients.id", "orders.client_id")
                    ->join("users", "users.id", "clients.user_id")
                    ->where('jobs.driver_id', '=', $params->driver_id)
                    ->select(\DB::raw("CONCAT(users.name,' ',users.last_name) AS client_name")
                        , "packages.name", "invoices.invoice_amount"
                        , DB::raw('DATE_FORMAT(orders.start_time, "%d-%m-%Y %H:%i:%s") as start_time')
                        , DB::raw('DATE_FORMAT(orders.complated_at, "%d-%m-%Y %H:%i:%s") as complated_at'))
                    ->paginate($page_count);

        }
        return $data;

    }

    private function DriverPunishments(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $params = json_decode($params_json);

        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->join("driver_punishment_reasons", "driver_punishment_reasons.id", "=", "driver_punishments.punishment_reason_id")
                ->where("driver_punishments.driver_id", "=", $params->driver_id)
                ->select("punishment_reason"
                    , "punishment_score"
                    , "driver_punishments.punishment_amount"
                    , DB::raw('DATE_FORMAT(driver_punishments.created_at, "%d-%m-%Y")  as created_at'))
                ->paginate($page_count);
        } else {
            if ($order_by != null){
                $data = $model::join("driver_punishment_reasons", "driver_punishment_reasons.id", "=", "driver_punishments.punishment_reason_id")
                    ->where("driver_punishments.driver_id", "=", $params->driver_id)
                    ->orderBy($order_by, $asc_desc)
                    ->select("punishment_reason"
                        , "punishment_score"
                        , "driver_punishments.punishment_amount"
                        , DB::raw('DATE_FORMAT(driver_punishments.created_at, "%d-%m-%Y")  as created_at'))
                    ->paginate($page_count);
            }
               else{
                   $data = $model::join("driver_punishment_reasons", "driver_punishment_reasons.id", "=", "driver_punishments.punishment_reason_id")
                       ->where("driver_punishments.driver_id", "=", $params->driver_id)
                       ->select("punishment_reason"
                           , "punishment_score"
                           , "driver_punishments.punishment_amount"
                           , DB::raw('DATE_FORMAT(driver_punishments.created_at, "%d-%m-%Y")  as created'))
                       ->paginate($page_count);
               }


        }

        return $data;
    }

    private function ClientOperatorLogs(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $params = json_decode($params_json);

        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query)
                ->join("clients", "clients.id", $table . ".client_id")
                ->leftJoin("users", "users.id", $table . ".created_by")
                ->where($table . ".client_id", '=', $params->client_id)
                ->select(DB::raw("CONCAT(users.name,' ',users.last_name) AS operator_name")
                    , DB::raw("(CASE WHEN operator_logs.operator_log_type_id=" . OperatorLogTypes::Note . " THEN 'Note' "
                        . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Action . " THEN 'Action' "
                        . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Issue . " THEN 'Issue' "
                        . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Warning . " THEN 'Warning' ELSE '' END) as operator_log_type")
                    , "operator_logs.operator_log"
                    , DB::raw('DATE_FORMAT(operator_logs.created_at, "%d-%m-%Y  %H:%i:%s") as log_date'))
                ->paginate($page_count);
        } else {
            if ($order_by != null)
                $data = $model::join("clients", "clients.id", $table . ".client_id")
                    ->leftJoin("users", "users.id", $table . ".created_by")
                    ->where($table . ".client_id", '=', $params->client_id)
                    ->select(DB::raw("CONCAT(users.name,' ',users.last_name) AS operator_name")
                        , DB::raw("(CASE WHEN operator_logs.operator_log_type_id=" . OperatorLogTypes::Note . " THEN 'Note' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Action . " THEN 'Action' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Issue . " THEN 'Issue' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Warning . " THEN 'Warning' ELSE '' END) as operator_log_type")
                        , "operator_logs.operator_log"
                        , DB::raw('DATE_FORMAT(operator_logs.created_at, "%d-%m-%Y  %H:%i:%s") as log_date'))
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);

            else
                $data = $model::join("clients", "clients.id", $table . ".client_id")
                    ->leftJoin("users", "users.id", $table . ".created_by")
                    ->where($table . ".client_id", '=', $params->client_id)
                    ->select(DB::raw("CONCAT(users.name,' ',users.last_name) AS operator_name")
                        , DB::raw("(CASE WHEN operator_logs.operator_log_type_id=" . OperatorLogTypes::Note . " THEN 'Note' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Action . " THEN 'Action' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Issue . " THEN 'Issue' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Warning . " THEN 'Warning' ELSE '' END) as operator_log_type")
                        , "operator_logs.operator_log"
                        , DB::raw('DATE_FORMAT(operator_logs.created_at, "%d-%m-%Y  %H:%i:%s") as log_date'))
                    ->orderBy("operator_logs.created_at", "desc")
                    ->paginate($page_count);

        }
        return $data;

    }

    private function ShowExpensesForDriver(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $params=json_decode($params_json);
        $privateFileHelper = new PrivateFileHelper();
        $link = '<a href="' . $privateFileHelper->makeUrl('#expensedocument#') . '" target="_blank"><i class="icon-outbox"></i><span></span></a>';
        $SQLreplace1 = "REPLACE('" . $link . "', '#expensedocument#',expenses.expense_document)";
        $keyword_query=(!empty($keyword_query) && $keyword_query != "")?$keyword_query:"";
        $order_by=(!empty($order_by))?$order_by:"expenses.date";
        $asc_desc=(!empty($asc_desc))?$asc_desc:"desc";
        $start_at=$params->start_at." 00:00.00";
        $end_at=$params->end_at." 23:59.59";
        $data = $model::search((string)$keyword_query)
            ->join('drivers', "drivers.id", "=", $table . ".driver_id")->with('user')
            ->leftJoin('driver_companies', "driver_companies.id", "=", $table . ".driver_company_id")
            ->leftJoin('vehicles', "vehicles.id", "=", $table . ".vehicle_id")
            ->leftJoin('tank_cards', "tank_cards.id", "=", $table . ".tank_card_id")
            ->leftJoin('expenses_types', "expenses_types.id", "=", $table . ".expense_type_id")
            ->leftJoin('users', "users.id", "=", $table . ".creator_id")

            ->where('expenses.driver_id','=',$params->driver_id)
            ->where('expenses.driver_company_id','=',$params->driver_company_id)
            ->where('expenses.date','>=',$start_at)
            ->where('expenses.date','<=',$end_at)
             ->select($table . '.id'
        , 'expenses.amount'
        , 'expenses_types.type_name'
        , "expenses.expense_title"
        , 'driver_companies.name as companyname'
        , 'vehicles.plate'
        , DB::raw($SQLreplace1 . " as expense_document")
        , DB::raw('DATE_FORMAT(expenses.date, "%d-%m-%Y") as date')
        , DB::raw("CONCAT(users.name,' ',users.last_name)  AS last_updatedby"))
            ->orderBy($order_by, $asc_desc)
        ->paginate($page_count);

        //$data=Expense::all();
        return $data;

    }

    private function ShowOrdersForDriver(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $params=json_decode($params_json);
        $keyword_query=(!empty($keyword_query) && $keyword_query != "")?$keyword_query:"";
        $order_by=(!empty($order_by))?$order_by:"orders.start_time";
        $asc_desc=(!empty($asc_desc))?$asc_desc:"desc";
        $start_at=$params->start_at." 00:00.00";
        $end_at=$params->end_at." 23:59.59";
            $data = $model::search((string)$keyword_query)
                ->join("invoice_items", "invoice_items.order_id", $table . ".id")
                ->join("invoices", "invoices.id", "invoice_items.invoice_id")
                ->join("jobs", "jobs.order_id", $table . ".id")
                ->join("clients","orders.client_id","clients.id")
                ->join("packages", "packages.id", $table . ".package_id")
                ->leftJoin("drivers", "drivers.id", "jobs.driver_id")
                ->leftJoin("users", "users.id", "clients.user_id")
                ->where('jobs.driver_id','=',$params->driver_id)
                ->where('orders.start_time','>=',$start_at)
                ->where('orders.start_time','<=',$end_at)
                ->select(
                    $table.".id",

                    \DB::raw("CONCAT(users.name,' ',users.last_name) AS client_name"), "packages.name", "invoices.invoice_amount",
                    DB::raw('DATE_FORMAT(orders.start_time, "%d-%m-%Y") as start_time'))
                ->orderBy($order_by, $asc_desc)
                ->paginate($page_count);
        return $data;
    }

    private function Recourses(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null){


        $keyword_query=(!empty($keyword_query) && $keyword_query != "")?$keyword_query:"";
        $order_by=(!empty($order_by))?$order_by:$table.".id";
        $asc_desc=(!empty($asc_desc))?$asc_desc:"desc";

        $data = $model::search((string)$keyword_query)
            ->join("vehicle_models", "vehicle_models.id", $table . ".vehicle_model")
            ->join("vehicle_brands", "vehicle_models.vehicle_brand_id", "vehicle_brands.id")
            ->select(
                $table.".id",
                \DB::raw("CONCAT(".$table.".name,' ',".$table.".surname) AS name"),$table.".email",$table.".phone",$table.".company_name",
                 \DB::raw("CONCAT(vehicle_brands.name,' ',vehicle_models.name) as vehicle"),$table.".plate as vehicle_plate"
                )
            ->orderBy($order_by, $asc_desc)
            ->paginate($page_count);
        return $data;

    }
}