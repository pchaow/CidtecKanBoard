<div class="container header">
    <ul class="nav nav-tabs">
        <li role="presentation"
            class="{{ Request::is($board->user->username.'/'.$board->name) ? 'active' : '' }}"
        ><a href="/{{$board->user->username}}/{{$board->name}}">กระดาน</a></li>
        <li role="presentation"
            class="{{ Request::is($board->user->username.'/'.$board->name.'/edit') ? 'active' : '' }}"
        ><a href="/{{$board->user->username}}/{{$board->name}}/edit">แก้ไขกระดาน</a></li>
    </ul>
</div>