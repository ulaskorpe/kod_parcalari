@if(isset($button_function_suffix))

{{$button_function_suffix}}

    @if(isset($canload))
        @permission($canload)
        <a href='javascript:loadElement_{{$button_function_suffix}}($id$)' class='btn btn-float btn-sm btn-info'>
            <i class='icon-eye'></i><span></span>
        </a>
        @endpermission
    @endif



    @role('manager')
    <a href='javascript:loadElement_{{$button_function_suffix}}($id$)' class='btn btn-float btn-sm btn-info'>
        <i class='icon-eye'></i><span></span>
    </a>
    <a href='javascript:loadActivity_{{$button_function_suffix}}($id$)'   class='btn btn-float btn-sm btn-outline-indigo'> <i class='icon-android-list'></i><span></span></a>
    @endrole
    @else

    @if(isset($canload))
        @permission($canload)
        <a href='javascript:loadElement($id$)' class='btn btn-float btn-sm btn-info'>
            <i class='icon-eye'></i><span></span>
        </a>
        @endpermission
    @endif



    @role('manager')
    <a href='javascript:loadElement($id$)' class='btn btn-float btn-sm btn-info'>
        <i class='icon-eye'></i><span></span>
    </a>
    <a href='javascript:loadActivity($id$)'   class='btn btn-float btn-sm btn-outline-indigo'> <i class='icon-android-list'></i><span></span></a>
    @endrole
    @endif

