<div class="container{{$fluid or ''}} header">
    <ul class="nav nav-tabs">
        <li class="{{ Request::is($board->user->username.'/'.$board->name) ? 'active' : '' }}">
            <a href="/{{$board->user->username}}/{{$board->name}}">กระดาน</a>
        </li>
        <li class="{{ Request::is($board->user->username.'/'.$board->name.'/edit') ? 'active' : '' }}">
            <a href="/{{$board->user->username}}/{{$board->name}}/edit">แก้ไขกระดาน</a>
        </li>
        <li class="{{ Request::is($board->user->username.'/'.$board->name.'/lanes') ? 'active' : '' }}">
            <a href="/{{$board->user->username}}/{{$board->name}}/lanes">ปรับกระดาน</a>
        </li>
        <li class="{{ Request::is($board->user->username.'/'.$board->name.'/members') ? 'active' : '' }}">
            <a href="/{{$board->user->username}}/{{$board->name}}/members">สมาชิก</a>
        </li>
    </ul>
</div>