        @php
            $deps = App\Helpers\CacheHelper\Cache::run(new App\Helpers\CacheHelper\Functions\DepartmentFunc());
            @endphp



<?


class DepartmentFunc extends CacheFunc {

    protected function execute() {

        $departments= Role::Departments()->get();

        return $departments;
    }

    public function key() {

        return 'departmentList';
    }

    public function time() {

        return 6000;
    }
}


///////role -> model

class Role extends EntrustRole
{
    use EntrustUserTrait,SearchableTrait;

    protected $searchable = [

        'columns' => [
            'roles.name' => 10,
        ]

    ];

    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }

    public function scopeDepartments(Builder $query)
    {
        return $query->where('is_department', '=', '1');
    }

    public function hasTodo(){
        return $this->has_todo;
    }

}


?>            