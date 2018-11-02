<ul id="home-sidebar" class="list-group list-group-flush">
    <li class="list-group-item list-group-item-action @if($selected == 'passwd')  @endif "><a href="#"><i class="iconfont icon-user-1"></i> 个人中心</a></li>
    <li class="list-group-item list-group-item-action @if($selected == 'passwd') selected @endif "><a href="{{route('index.user.passwd')}}"><i class="iconfont icon-kttx"></i> 修改密码</a></li>
    <li class="list-group-item list-group-item-action"><a href="{{route('index.user.passwd')}}"><i class="iconfont icon-shoucang"></i> 收藏</a></li>
</ul>
