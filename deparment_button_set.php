<a href="{{ route('manager.department.edit', $user->id) }}"
   class="btn btn-float btn-orange btn-sm">
    <i class="icon-ios-person"></i>
    <span></span>
</a>

<a href="{{ route('manager.department.vacation', $user->id) }}"
   class="btn btn-float btn-green btn-sm">
    <i class="icon-android-sunny"></i>
    <span></span>
</a>

<a href="{{route('manager.department.workweekly', $user->id) }}"
   class="btn btn-float btn-blue btn-sm">
    <i class="icon-zoom-out"></i>

    <span></span>
</a>

<a href="{{ route('department.workTemplate', $user->id) }}"
   class="btn btn-float btn-brown btn-sm">
    <i class="icon-table3"></i>

    <span></span>
</a>