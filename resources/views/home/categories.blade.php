<div class="col-md-2">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-list icon"></i>
            <span>Categories</span>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($categories as $category)
                    <li class="list-group-item pl-0" style="color:{{ 'category/'.$category->id == request()->path() ? 'green': '' }}">
                        <i class="fa fa-angle-right" style="font-size: 15px;"></i>
                        <a href="/category/{{$category->id}}" class="pl-1" style="color:{{ 'category/'.$category->id == request()->path() ? 'green': '' }}">{{$category->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
