<div class="container header">
    <ul class="nav nav-tabs">
        <li class="{{ Request::is($user->username) ? 'active' : '' }}"><a href="/{{$user->username}}">หน้าหลัก</a></li>
        <li class="{{ Request::is($user->username.'/close') ? 'active' : '' }}"><a href="/{{$user->username}}/close">กระดานที่ปิดแล้ว</a></li>
    </ul>
</div>